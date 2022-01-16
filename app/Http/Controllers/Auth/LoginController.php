<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected $userRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            $remember = false;

            if (!$this->userRepository->getByEmail($credentials['email'])) {
                return back()->withInput()->withErrors([
                    'email' => 'Email Salah!',
                ]);
            }

            if (Auth::attempt($credentials, $remember)) {
                $request->session()->regenerate();
                session()->put('user', [
                    'id' => Auth::user()->id,
                    'email' => Auth::user()->email,
                    'name' => Auth::user()->name,
                    'role' => Auth::user()->getRoleNames()[0]
                ]);
                if (Auth::user()->hasRole('Admin')) {
                    return redirect()->route('admin.dashboard');
                } else if (Auth::user()->hasRole('User')) {
                    return redirect()->route('user.dashboard');
                } else if (Auth::user()->hasRole('Division Head')) {
                    return redirect()->route('head.dashboard');
                } else if (Auth::user()->hasRole('Super Admin')) {
                    return redirect()->route('super-admin.user.index', ['role' => 'all']);
                }
            }

            return back()->withInput()->withErrors([
                'password' => 'Password Salah !',
            ]);
        } catch (ModelNotFoundException $exception) {
            return redirect()->back()->withInput()->withErrors([
                'message' => 'Sorry, there was an error in your request. Please try again in a moment.',
            ]);
        }
    }
}
