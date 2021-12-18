<?php

namespace App\Http\Controllers\user;


use App\Helpers\ExtractJsonHelpers;
use App\Repositories\MachineRepository;
use App\Repositories\MachineProblemRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    protected $machineRepository;
    protected $machineProblemRepository;

    public function __construct(MachineRepository $machineRepository, MachineProblemRepository $machineProblemRepository) 
    {
        $this->machineRepository = $machineRepository;
        $this->machineProblemRepository = $machineProblemRepository;
    }

    public function index(){
        $machines =  $this->machineRepository->countAllMachine();
        $plant = count(ExtractJsonHelpers::getPlantList());

        $data = [
            'machines' => $machines,
            'plant' => $plant,
        ];

        return view('user.dashboard',compact('data'));
    }

}
