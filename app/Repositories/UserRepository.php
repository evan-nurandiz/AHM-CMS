<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Exception;

class UserRepository
{

    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function CheckIfEmailExist($email){
        return $this->user->where('email',$email)->first();
    }

    public function storeUser($data){
        $user = $this->user->create($data);
        $user->assignRole('User');
    }

}
