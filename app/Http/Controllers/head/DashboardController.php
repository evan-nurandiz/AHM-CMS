<?php

namespace App\Http\Controllers\head;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\head\NoiseRepository;

class DashboardController extends Controller
{
    protected $noiseRepository;

    public function __construct(NoiseRepository $noiseRepository)
    {
        $this->noiseRepository = $noiseRepository;
    }

    public function index()
    {
        $data = $this->noiseRepository->getDashboardInfo();
        return view('head.dashboard', compact('data'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
