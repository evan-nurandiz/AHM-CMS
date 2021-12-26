<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function welcome(){
        if (Auth::check()) {
            if(Auth::user()->hasRole('Admin')){
                return redirect()->route('admin.dashboard');
            }else{
                return redirect()->route('user.dashboard');
            }
        }else{
            return view('welcome');
        }
    }
}
