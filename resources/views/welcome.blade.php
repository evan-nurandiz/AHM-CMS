<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>AHM - CMS</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="css/style.min.css" rel="stylesheet">
        <link href="css/custom.css" rel="stylesheet">
        <link rel="shortcut icon" href="logo.ico">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }

            .bg-base{
                background-color:#FF0000;
            }

            .side-login{
                height:100vh;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="row justify-content-center align-items-center">
            <div class="col-12 col-md-4 col-lg-5 d-none d-md-block d-lg-block bg-base side-login">
            </div>
            <div class="col-12 col-md-8 col-lg-7 py-5 py-lg-0">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-10 p-5">
                        <div class="row justify-content-center">
                            <div class="col-11 col-lg-8 mb-4">
                                <img src="/image/logo.png" alt="" class="w-100">
                            </div>
                        </div>
                        @if($errors->has('email'))
                            <div class="alert alert-danger" role="alert">
                                Email Salah
                            </div>
                        @endif
                        @if($errors->has('password'))
                            <div class="alert alert-danger" role="alert">
                                Password Salah
                            </div>
                        @endif
                        <form method="POST" action="{{ route('login') }}" class="mt-4">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control py-4 rounded" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email">
                            </div>
                            <div class="form-group mb-5">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control py-4 rounded" id="exampleInputPassword1" placeholder="Password" name="password">
                            </div>
                            <button type="submit" class="btn bg-base text-white w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
