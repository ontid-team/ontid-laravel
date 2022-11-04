<?php

namespace App\Services\Auth\Repositories;

use App\Classes\Abstracts\AbstractRepository;
use App\Exceptions\CreateModelException;
use App\Services\Auth\Dto\Credentials;
use App\Services\Auth\Interfaces\IUserModel;
use App\Services\Auth\Interfaces\IUserRepository;


class UserRepository extends AbstractRepository implements IUserRepository
{

    public function getUserByEmail($email): ?IUserModel
    {
        return $this->where(['email' => $email])->first();
    }

    public function createUser()
    {

    }
    /**
     * @throws CreateModelException
     * @throws \Throwable
     */
//    public function create(UserValueObject $user)
//    {
//        DB::beginTransaction();
//
//        try {
//            $profile = new $user->profile->type();
//            if (isset($user->profile->phone)) $profile->phone = $user->profile->phone;
//            $profile->save();
//            $userModel = new User();
//            $userModel->email = $user->credentials->email;
//            $this->setPasswordToModel($userModel, $user->credentials);
//            $userModel->name = $user->name;
//            $userModel->profile_id = $profile->id;
//            $userModel->profile_type = $profile::class;
//            $userModel->save();
//            if ($user->provider) {
//                $provider = new Provider();
//                $provider->identity = $user->provider->identity;
//                $provider->provider = $user->provider->provider;
//                $provider->user()->associate($userModel);
//                $provider->save();
//            }
//            DB::commit();
//            return $userModel;
//        } catch (Exception $e) {
//            DB::rollBack();
//            throw new CreateModelException($e);
//        }
//    }

    public function setPasswordToModel(&$userModel, Credentials $credentials)
    {
        $userModel->password = $credentials->password->getPasswordHash();
        $userModel->salt = $credentials->password->getSalt();
    }
}
