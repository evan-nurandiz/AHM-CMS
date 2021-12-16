<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ExtractJsonHelpers;
use App\Repositories\MachineRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    protected $machineRepository;

    public function __construct(MachineRepository $machineRepository)
    {
        $this->machineRepository = $machineRepository;
    }


    public function index(){
        $machines =  $this->machineRepository->countAllMachine();
        return view('admin.dashboard',compact('machines'));
    }

    public function addEngine(){
        $symton_noises = json_decode(file_get_contents(public_path('data/symton_noise.json')), true);
        $cause_parts = json_decode(file_get_contents(public_path('data/causing_part.json')), true);
        $breakdown_parts = json_decode(file_get_contents(public_path('data/breakdown_part.json')), true);
        $methods = json_decode(file_get_contents(public_path('data/method.json')), true);
        $at_gears = json_decode(file_get_contents(public_path('data/at_gear.json')), true);
        return view('admin.addEngineProblem',compact('symton_noises','cause_parts','breakdown_parts','methods','at_gears'));
    }

    public function createEngine(){
        return request();
    }
}
