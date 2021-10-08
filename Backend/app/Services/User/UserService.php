<?php

namespace App\Services\User;

use App\Jobs\SendRegisterationMailJob;
use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Auth;


class UserService
{
    protected $userRepository;  

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser(array $user)
    {
        $user = $this->userRepository->create($user);
        $user->sendEmailVerificationNotification();
        $this->sendUserRegistrationEmail($user); 
        return $user;
    }

    public function updateUser($data)
    {
        $userId = Auth::id();
        
        if(!empty($data['thumbnail'])) {
        $data['thumbnail'] = $this->uploadToCloud($data['thumbnail']);
        }
        $data = array_filter($data);
        $this->userRepository->update($userId, $data);

        return $this->userRepository->find($userId);
    }

    public function updateUserPassword(int $userId, $data) {
        return $this->userRepository->update($userId, $data); 
    }

    public function verifyUser($userId, $request) {
        if(!$request->hasValidSignature()) {
            return formatResponse(401, 'Invalid or Expired Token', true, [
                'error' => 'Invalid or Expired Token'
            ]);
        }
        $user = $this->userRepository->find($userId);
        if($user) {
            $user->markEmailAsVerified();
            return formatResponse(200, 'Account Verified', true);
        }
        return $user;
    }

    public function getAllUsers() 
    {
        return $this->userRepository->all();
    }

    public function getUserById(int $userId)
    {
        return $this->userRepository->find($userId);
    }

    public function getUserQuery($column, $value)
    {
        return $this->userRepository->where($column, $value);
    }

    protected function uploadToCloud($image) {
        $upload = $image->storeOnCloudinary('Files');
        return $upload->getSecurePath();
    }

    private function sendUserRegistrationEmail(User $user)
    {
        dispatch(new SendRegisterationMailJob($user));
    }

}