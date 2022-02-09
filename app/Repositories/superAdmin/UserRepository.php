<?php

namespace App\Repositories\superAdmin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserRepository
{

    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUserList()
    {
        return $this->user->paginate(env('PER_PAGE'));
    }

    public function getUserListByRole($role)
    {
        return $this->user->role($role)->paginate(env('PER_PAGE'));
    }

    public function getUserById($id)
    {
        return $this->user->find($id);
    }

    public function storeUser($data, $role)
    {
        $user = $this->user->create($data);
        $user->assignRole($role);
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

    public function getHeadDivision(){
        $user = $this->user->role('Division Head')->get();
        return $user;
    }
}
