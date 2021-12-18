<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ExtractJsonHelpers;
use App\Repositories\MachineRepository;
use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    protected $machineRepository;
    protected $userRepository;

    public function __construct(MachineRepository $machineRepository, UserRepository $userRepository)
    {
        $this->machineRepository = $machineRepository;
        $this->userRepository = $userRepository;
    }


    public function index(){
        $machines =  $this->machineRepository->countAllMachine();
        $plant = count(json_decode(file_get_contents(public_path('data/plant_list.json')), true));
        $user = $this->userRepository->countAllUsers();

        $data = [
            'machines' => $machines,
            'plant' => $plant,
            'user' => $user
        ];
        
        return view('admin.dashboard',compact('data'));
    }
}
