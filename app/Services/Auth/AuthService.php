<?php

namespace App\Services\Auth;

use App\Exceptions\CreateModelException;
use App\Models\TemporaryToken;
use App\Notifications\ForgotPassword;
use App\Services\Auth\Dto\Credentials;
use App\Services\Auth\Dto\ProviderDto;
use App\Services\Auth\Dto\UserDto;
use App\Services\Auth\Enum\Profile;
use App\Services\Auth\Events\RegisterSuccess;
use App\Services\Auth\Exceptions\AuthLogicException;
use App\Services\Auth\Exceptions\InvalidPasswordException;
use App\Services\Auth\Exceptions\UserNotFoundException;
use App\Services\Auth\Interfaces\IAuthService;
use App\Services\Auth\Interfaces\IForgotRequest;
use App\Services\Auth\Interfaces\IProviderRepository;
use App\Services\Auth\Interfaces\ISocialAuthenticateRequest;
use App\Services\Auth\Interfaces\IUserModel;
use App\Services\Auth\Interfaces\IUserRepository;
use App\Services\Auth\Interfaces\IVerifyRequest;
use App\Services\Auth\Repositories\ProviderRepository;
use App\Services\Auth\Repositories\UserRepository;
use App\Services\Auth\ValueObjects\Password;
use DomainException;
use Exception;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

final class AuthService implements IAuthService
{
    public UserRepository $userRepository;
    public ProviderRepository $providerRepository;


    public function __construct(
        IUserRepository $userRepository,
        IProviderRepository $providerRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->providerRepository = $providerRepository;
    }

    public function logout()
    {
        $result = auth()->user()->currentAccessToken()->delete();

        return $result;
    }

    /**
     * @throws CreateModelException
     * @throws AuthLogicException
     * @throws Throwable
     */
    public function social(Enum\Provider $socialProvider, ISocialAuthenticateRequest $request)
    {
        try {
            $user = Socialite::driver($socialProvider->value)->userFromToken($request->getToken());
        } catch (Exception) {
            throw new AuthLogicException('invalid_request');
        }

        $providerDto = new ProviderDto(
            $user->id,
            $socialProvider
        );

        $provider = $this->providerRepository->findWhere([
            'identity' => $providerDto->identity,
            'provider' => $providerDto->provider
        ]);

        if (empty($provider)) {
            $email = $user->accessTokenResponseBody['email'] ?? null;
            $email = $email ?: $user->email;
            $userModel = $this->userRepository->getUserByEmail($email);
            if (!empty($userModel)) {
                throw new AuthLogicException('email_not_available');
            }
            $userDto = new UserDto(
                $user->name,
                $email,
                new Password($socialProvider->value . '@' . $user->id . time()),
            );
            $userDto->setType(Profile::Customer);
            $userModel = $this->createUser($userDto, $providerDto);
        } else {
            $userModel = $provider->user;
        }
        return $userModel;
    }

    /**
     * @throws AuthLogicException
     */
    public function forgot(IForgotRequest $request)
    {
        $userModel = $this->userRepository->getUserByEmail($request->getEmail());
        if (empty($userModel)) {
            throw new AuthLogicException('user_not_found');
        }
        $userModel->notify(new ForgotPassword);
    }
    /**
     * @throws AuthLogicException
     */
    public function reset(Credentials $credentials)
    {
        if (!$credentials->isPasswordConfirmed()) {
            throw new AuthLogicException('password_not_match');
        }
        $model = TemporaryToken::whereToken($credentials->g)->first();
        if ($model) {
            $model->user->password = $credentials->password->getPasswordHash();
            $model->user->salt = $credentials->password->getSalt();
            $model->user->save();
        } else {
            throw new AuthLogicException('expired_token');
        }
    }

    /**
     * @throws UserNotFoundException
     * @throws InvalidPasswordException
     * @throws AuthLogicException
     */
    public function login(Credentials $login): IUserModel
    {
        $userModel = $this->userRepository->getUserByEmail($login->email);
        if (empty($userModel)) {
            throw new UserNotFoundException();
        }
        if (!$userModel->hasVerifiedEmail()) {
            throw new AuthLogicException('user_not_verified');
        }

        $check = $login->password->isEquals($userModel->password);
        if (!$check) throw new InvalidPasswordException();

        return $userModel;
    }

    /**
     * @param UserDto $user
     * @param ProviderDto|null $provider
     * @return IUserModel
     * @throws AuthLogicException
     * @throws CreateModelException
     * @throws Throwable
     */
    public function register(UserDto $user, ProviderDto $provider = null): IUserModel
    {
        $credentials = new Credentials(
            password: $user->password,
            password_confirm: $user->password_confirm,
        );

        if (!$credentials->isPasswordConfirmed()) {
            throw new AuthLogicException('password_not_match');
        }
        $userModel = $this->userRepository->getUserByEmail($user->email);
        if (!empty($userModel)) {
            throw new AuthLogicException('email_not_available');
        }
        $this->createUser($user, $provider);
        RegisterSuccess::dispatch($this, $userModel);

        return $userModel;
    }

    /**
     * @throws AuthLogicException
     */
    public function verify(IVerifyRequest $request): bool
    {
        $token = TemporaryToken::where('token', $request->getToken())->first();
        if (empty($token)) {
            throw new AuthLogicException('invalid_verify_token');
        }
        $token->user->email_verified_at = now();
        $token->user->save();
        $token->delete();
        return true;
    }

    public function createAccessToken($user): array
    {
        $scopes = [
            'customer' => ['customer'],
            'salon' => ['manager'],
            'admin' => ['admin'],
        ];
        if (!isset($scopes[$user->type])) {
            throw new DomainException('undefined scopes for current user type');
        }

        $expires = now()->addMinutes()->diffInSeconds();
        return $this->createToken('access_token', $scopes[$user->type], $expires, $user);
    }

    public function createRefreshToken($user): array
    {
        $expires = now()->addDays(30)->diffInSeconds();
        return $this->createToken('refresh_token', ['refresh-token'], $expires, $user);
    }

    /**
     * @param string $name
     * @param array $abilities
     * @param int $expires
     * @param $user
     * @return array
     */
    private function createToken(string $name, array $abilities, int $expires, $user): array
    {
        $token = $user->createToken($name, $abilities)->plainTextToken;
        setcookie($name, $token, time()+$expires, "/", config('app.domain'), 0, 0);
        return [
            'token' => $token,
            'expires' => $expires
        ];
    }

    public function createTokens($user): array
    {
        return [
            'access_token' => $this->createAccessToken($user),
            'refresh_token' => $this->createRefreshToken($user)
        ];
    }

    /**
     * @throws CreateModelException
     * @throws Throwable
     */
    private function createUser(UserDto $user, ProviderDto $provider = null): IUserModel
    {
        DB::beginTransaction();
        try {
            $userModel = $this->userRepository->create([
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password->getPasswordHash(),
                'salt' => $user->password->getSalt(),
            ]);
            if ($provider) {
                $provider = $this->providerRepository->create((array) $provider);
                $provider->attach($userModel);
                $userModel->setRelation('provider', $provider);
            }
            DB::commit();
            return $userModel;
        } catch (Exception $e) {
            DB::rollBack();
            throw new CreateModelException($e);
        };
    }
}
