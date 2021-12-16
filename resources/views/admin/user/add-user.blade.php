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
                    <h4 class="mb-5">Tambah User Baru</h4>
                    <form action="{{route('admin.dashboard-user-create.action')}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" required id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" class="form-control" name="email" required id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" required class="form-label">Password</label>
                            <input type="password" class="form-control" required name="password" id="exampleInputPassword1">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" required class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" required name="confirm-password" id="exampleInputPassword1">
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
