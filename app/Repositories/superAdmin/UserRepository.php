<?php

namespace App\Repositories\superAdmin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserRepository
{

    protected $userRepository;
    public function __construct(User $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUserList()
    {
        return $this->userRepository->paginate(env('PER_PAGE'));
    }

    public function getUserListByRole($role)
    {
        return $this->userRepository->role($role)->paginate(env('PER_PAGE'));
    }

    public function getUserById($id)
    {
        return $this->userRepository->find($id);
    }

    public function storeUser($data, $role)
    {
        $user = $this->userRepository->create($data);
        $user->assignRole($role);
    }

    public function changeUserData($id, $data)
    {
        $user = $this->userRepository->find($id);
        if (array_key_exists('password', $data)) {
            $data['password'] = Hash::make($data['password']);
            $user->update($data);
            $user->assignRole($data['role']);
        } else {
            $user->update($data);
            $user->assignRole($data['role']);
        }
    }
}
