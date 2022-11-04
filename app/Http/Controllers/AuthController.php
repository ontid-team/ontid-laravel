<?php

namespace App\Http\Controllers;

use App\Exceptions\CreateModelException;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\SocialRequest;
use App\Http\Requests\Auth\VerifyAccountRequest;
use App\Http\Resources\SuccessResource;
use App\Models\Customer;
use App\Models\User;
use App\Services\Auth\Dto\Credentials;
use App\Services\Auth\Dto\UserDto;
use App\Services\Auth\Enum\Profile;
use App\Services\Auth\Enum\Provider;
use App\Services\Auth\Exceptions\AuthLogicException;
use App\Services\Auth\Interfaces\IAuthService;
use App\Services\Auth\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use Throwable;

class AuthController extends Controller
{
    private IAuthService $authService;

    public function __construct(IAuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @throws CreateModelException
     * @throws AuthLogicException|Throwable
     */
    #[OA\Post(
        path: '/auth/social/{provider}',
        tags: ['auth'],
    )]
    #[OA\RequestBody(
        required: true,
        content: [
            new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(ref: '#/components/schemas/SocialRequest')
            )
        ]
    )]
    #[OA\Parameter(name: 'provider')]
    #[OA\Response(response: 200, description: 'provider: google, facebook, apple')]
    public function social(Provider $provider, SocialRequest $request): JsonResponse
    {
        $user = $this->authService->social($provider, $request);
        return $this->tokenResponse($user);
    }

    #[OA\Post(
        path: '/auth/login',
        tags: ['auth'],
    )]
    #[OA\RequestBody(
        required: true,
        content: [
            new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(ref: '#/components/schemas/LoginRequest')
            )
        ]
    )]
    #[OA\Response(response: 200, description: 'ok')]
    #[OA\Response(response: 422, description: 'error')]
    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = new Credentials(
            password: $request->password,
            email: $request->email
        );
        $user = $this->authService->login($credentials);
        return $this->tokenResponse($user);
    }

    #[OA\Post(
        path: '/auth/register/{type}',
        tags: ['auth'],
    )]
    #[OA\RequestBody(
        required: true,
        content: [
            new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(ref: '#/components/schemas/RegisterRequest')
            )
        ]
    )]
    #[OA\Parameter(name: 'type', description: 'salon, customer', in: 'path')]
    #[OA\Response(response: 200, description: 'ok')]
    /**
     * @param $type
     * @param RegisterRequest $request
     * @return UserResource
     * @throwxs PageNotFoundException
     */
    public function register($type, RegisterRequest $request): UserResource
    {
        $userDto = UserDto::fromRequest($request);
        $userDto->setType(Profile::from($type));
        $user = $this->authService->register(
            $userDto
        );
        return UserResource::make($user);
    }

    #[OA\Post(
        path: '/auth/forgot-password',
        tags: ['auth'],
    )]
    #[OA\RequestBody(
        required: true,
        content: [
            new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(ref: '#/components/schemas/ForgotPasswordRequest')
            )
        ]
    )]
    #[OA\Response(response: 200, description: 'ok')]
    public function forgotPassword(ForgotPasswordRequest $request): SuccessResource
    {
        $this->authService->forgot($request);
        return SuccessResource::make();
    }

    #[OA\Post(
        path: '/auth/reset-password',
        tags: ['auth'],
    )]
    #[OA\RequestBody(
        required: true,
        content: [
            new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(ref: '#/components/schemas/ResetPasswordRequest')
            )
        ]
    )]
    #[OA\Response(response: 200, description: 'ok')]
    public function resetPassword(ResetPasswordRequest $request): SuccessResource
    {
        $credentials = new Credentials(
            $request->password,
            $request->password_confirm,
        );
        $this->authService->reset($credentials);
        return SuccessResource::make();
    }

    private function tokenResponse(User $user): JsonResponse
    {
        if ($user->profile_type == Customer::class)  {
            $user->load('profile');
        }

        return response()->json([
            'user' => UserResource::make($user),
            'tokens' => $this->authService->createTokens($user)
        ]);
    }

    #[OA\Post(
        path: '/auth/logout',
        security: ['Bearer'],
        tags: ['auth']
    )]
    #[OA\Response(response: 200, description: 'ok')]
    public function logout(Request $request): SuccessResource
    {
        if ($request->user()) {
            $this->authService->logout();
        }
        return SuccessResource::make();

    }

    #[OA\Post(
        path: '/auth/verify',
        tags: ['auth'],
    )]
    #[OA\RequestBody(
        required: true,
        content: [
            new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(ref: '#/components/schemas/VerifyAccountRequest')
            )
        ]
    )]
    #[OA\Response(response: 200, description: 'ok')]
    public function verify(VerifyAccountRequest $request): SuccessResource
    {
        $this->authService->verify($request);
        return SuccessResource::make();
    }

    #[OA\Get(
        path: '/auth/refresh-token',
        security: ['Bearer'],
        tags: ['auth'],
    )]
    #[OA\Response(response: 200, description: 'ok')]
    public function refreshToken(Request $request): JsonResponse
    {
        $user = $request->user();
        if ($user->profile_type == Customer::class)  {
            $user->load('profile');
        }
        $tokens = $this->authService->createTokens($user);
        return response()->json($tokens);
    }
}
