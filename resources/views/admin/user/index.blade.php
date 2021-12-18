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
                    <div class="d-flex justify-content-between">
                        <h3 class="box-title">List User</h3>
                        <a href="{{route('admin.dashboard-user-create')}}">
                            <button type="button" class="btn bg-base rounded text-white">Tambah User</button>
                        </a>
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
                                @foreach($users as $user)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$user['name']}}</td>
                                    <td>{{$user['email']}}</td>
                                    <td class="d-flex gap-2">
                                        <a href="{{route('admin.dashboard-user-edit',[
                                            'user' => $user['id']
                                        ])}}">
                                            <button type="button" class="btn btn-light">Edit</button>
                                        </a>
                                        <button type="button" class="btn btn-danger text-white">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
	<main>
@endsection

@section('bottom')

@endsection
