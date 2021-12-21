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
        $plants = ExtractJsonHelpers::getPlantList();
        return view('admin.plant.index',compact('plants'));
    }
}
