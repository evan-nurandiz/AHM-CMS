<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserRepository
{

    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function CheckIfEmailExist($email)
    {
        return $this->user->where('email', $email)->first();
    }

    public function countAllUsers()
    {
        return $this->user->count();
    }

    public function getUserById($id)
    {
        return $this->user->find($id);
    }

    public function getByEmail($email)
    {
        return $this->user->where('email', $email)->first();
    }

    public function storeUser($data)
    {
        $user = $this->user->create($data);
        if ($data['role'] == 'admin') {
            $user->assignRole('Admin');
        } elseif ($data['role'] == 'user') {
            $user->assignRole('User');
        }
    }

    public function changeUserData($id, $data)
    {
        $user = $this->user->find($id);
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
