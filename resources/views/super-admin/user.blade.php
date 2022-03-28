@extends('layouts.super-admin')

@section('style')
<style>
    p {
        margin: 0px;
    }
</style>
@endsection

@section('content')
<main id="User">
    <div class="row mb-xs-60">
        <div class="col-sm-12">
            <div class="white-box">
                <div class="d-flex justify-content-between">
                    <h3 class="box-title">List User</h3>
                    <a href="{{route('super-admin.user.create')}}">
                        <button type="button" class="btn bg-base rounded text-white">Tambah User</button>
                    </a>
                </div>
                <div class="row justify-content-center mx-0 my-4">
                    <div class="col-6 mb-2 text-center p-2" id="{{$data['role'] == 'User' ? 'active-menu' : ''}}">
                        <a href="{{route('super-admin.user.index',['role' => 'User'])}}">
                            <p class="{{$data['role'] == 'User' ? 'text-white' : 'text-black'}}">User</p>
                        </a>
                    </div>
                    <div class="col-6 mb-2 text-center p-2" id="{{$data['role'] == 'Admin' ? 'active-menu' : ''}}">
                        <a href="{{route('super-admin.user.index',['role' => 'Admin'])}}">
                            <p class="{{$data['role'] == 'Admin' ? 'text-white' : 'text-black'}}">Admin</p>
                        </a>
                    </div>
                    <div class="col-6 mb-2 text-center p-2" id="{{$data['role'] == 'Division Head' ? 'active-menu' : ''}}">
                        <a href="{{route('super-admin.user.index',['role' => 'Division Head'])}}">
                            <p class="{{$data['role'] == 'Division Head' ? 'text-white' : 'text-black'}}">Section Head</p>
                        </a>
                    </div>
                    <div class="col-6 mb-2 text-center p-2" id="{{$data['role'] == 'Super Admin' ? 'active-menu' : ''}}">
                        <a href="{{route('super-admin.user.index',['role' => 'Super Admin'])}}">
                            <p class="{{$data['role'] == 'Super Admin' ? 'text-white' : 'text-black'}}">Super Admin</p>
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table text-nowrap">
                        <thead>
                            <tr>
                                <th class="border-top-0">No</th>
                                <th class="border-top-0">name</th>
                                <th class="border-top-0">email</th>
                                <th class="border-top-0">action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['users'] as $user)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$user['name']}}</td>
                                <td>{{$user['email']}}</td>
                                <td class="d-flex gap-2">
                                    <a href="{{route('super-admin.user.edit',[
                                            'user_id' => $user['id']
                                        ])}}">
                                        <button type="button" class="btn btn-light">Edit</button>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex mt-4 justify-content-center">
                    {!! $data['users']->links() !!}
                </div>
            </div>
        </div>
    </div>
    <main>
        @endsection