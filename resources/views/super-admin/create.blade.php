@extends('layouts.super-admin')

@section('style')
<style>

</style>
@endsection

@section('content')
<main id="User">
    <div class="row mb-xs-60">
        <div class="col-sm-12">
            <div class="white-box">
                <h4 class="mb-5">Tambah User Baru</h4>
                <form action="{{route('super-admin.user.store')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Name <span id="required">*</span></label>
                        <input type="text" class="form-control" name="name" required id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address <span id="required">*</span></label>
                        <input type="email" class="form-control" name="email" required id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" required class="form-label">Password <span id="required">*</span></label>
                        <input type="password" class="form-control" required name="password" id="exampleInputPassword1">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" required class="form-label">Confirm Password <span id="required">*</span></label>
                        <input type="password" class="form-control" required name="confirm-password" id="exampleInputPassword1">
                    </div>
                    <div class="mb-3">
                        <label for="inputState">Role <span id="required">*</span></label>
                        <select id="inputState" class="form-control" required name="role">
                            <option selected id="role-input">Choose</option>
                            <option value="Admin" id="role-input">Admin</option>
                            <option value="User" id="role-input">User</option>
                            <option value="Division Head" id="role-input">Divison Head</option>
                            <option value="Super Admin" id="role-input">Super Admin</option>
                        </select>
                    </div>
                    <div class="mb-3 d-none" id="super-visor-section">
                        <label for="super-visor">Super Visor<span id="required">*</span></label>
                        <select id="super-visor" class="form-control" name="head_id">
                            <option value="0" selected>Choose</option>
                            @foreach($headList as $headList)
                            <option value="{{$headList['id']}}">{{$headList['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <main>
@endsection

@section('bottom')
<script>
    const RoleInput = document.querySelector('#inputState')
    const RoleInputOptions = document.querySelectorAll('#inputState #role-input')

    RoleInputOptions.forEach((RoleInputOption,i) => {
        RoleInputOption.addEventListener('click',() => {
            if(RoleInput.value == 'Admin'){
                document.querySelector('#super-visor-section').classList.remove('d-none')
            }else{
                document.querySelector('#super-visor-section').classList.add('d-none')
            }
        })
    })
</script>
@endsection