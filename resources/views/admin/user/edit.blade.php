@extends('layouts.admin')

@section('style')
    <style>
        
    </style>
@endsection

@section('content')
	<main id="User">
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h4 class="mb-5">Edit User</h4>
                    <form action="{{route('admin.dashboard-user-update.action',[
                        'user' => $user['id']
                    ])}}" method="post">
                        @csrf
                        @method('patch')
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Name  <span id="required">*</span></label>
                            <input type="text" class="form-control" name="name" required value="{{$user['name']}}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address  <span id="required">*</span></label>
                            <input type="email" class="form-control" name="email" required value="{{$user['email']}}">
                        </div>
                        <div class="mb-3">
                            <label for="inputState">Role</label>
                            <select id="inputState" class="form-control" name="role" >
                                <option value="Admin" {{$user->getRoleNames()[0] == 'Admin' ? 'selected' : ''}}>Admin</option>
                                <option value="user" {{$user->getRoleNames()[0] == 'User' ? 'selected' : ''}}>User</option>
                            </select>
                        </div>
                        <h4 class="mt-5 mb-2 text-gray">Jika Ingin Mengganti Password</h4>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="exampleInputPassword1">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="confirm-password" id="exampleInputPassword1">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
	<main>
@endsection

@section('bottom')

@endsection
