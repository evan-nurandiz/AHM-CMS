<?php

namespace App\Http\Controllers\superAdmin;

use App\Repositories\superAdmin\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index($role)
    {
        if ($role == 'all') {
            $users = $this->userRepository->getUserList();
        } else {
            $users = $this->userRepository->getUserListByRole($role);
        }

        $data = [
            'users' => $users,
            'role' => $role
        ];

        return view('super-admin.user', compact('data'));
    }

    public function create()
    {
        $headList = $this->userRepository->getHeadDivision();
        
        return view('super-admin.create', compact('headList'));
    }

    public function store(Request $request)
    {
        if ($request['password'] != $request['confirm-password']) {
            return redirect()->back()->withInput()->withErrors([
                'message' => 'Password Tidak Sama',
            ]);
        } else {
            $request['password'] =  Hash::make($request['password']);
        }

        if($request['role'] != 'Admin'){
            if($request['head_id'] == 0){
                $request['head_id'] = null;
            }
        }
       
        try {
            DB::beginTransaction();
            $this->userRepository->storeUser($request->except(['role', 'confirm-password']), $request['role']);
            DB::commit();
            return redirect()->back()->with('success', 'User Berhasil Dibuat');
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors([
                'message' => 'Sorry, there was an error in your request. Please try again in a moment.',
            ]);
        }
    }

    public function edit($user_id)
    {
        $headList = $this->userRepository->getHeadDivision();
        $user = $this->userRepository->getUserById($user_id);
        return view('super-admin.edit', compact('user','headList'));
    }

    public function update(Request $request, $user_id)
    {
        try {
            DB::beginTransaction();
            if ($request['password'] != null && $request['confirm-password'] != null) {
                if ($request['password'] == $request['confirm-password']) {
                    session()->flash('response', $this->userRepository->changeUserData($user_id, $request->except('confirm-password')));
                } else {
                    return redirect()->back();
                }
            } else {
                session()->flash('response', $this->userRepository->changeUserData($user_id, $request->except(['password', 'confirm-password'])));
            }
            DB::commit();
            return redirect()->back()->with('success', 'Berhasil Mengubah Data User');
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors([
                'message' => 'Sorry, there was an error in your request. Please try again in a moment.',
            ]);
        }
    }
}
