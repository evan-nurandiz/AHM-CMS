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
        $machines =  $this->machineRepository->getAllMachine();
        return view('user.machine',compact('machines'));
    }

    public function ShowMachineDetail($id){
        $machine = $this->machineRepository->getMachineById($id);
        $machineProblems = $this->machineProblemRepository->getMachineProblemByMachineId($id);
        return view('user.machine-detail', compact('machine','machineProblems'));
    }

    public function ShowMachineProblem($id, $problem_id){
        $machineProblem = $this->machineProblemRepository->getMachineProblemById($problem_id);
        $machine = $this->machineProblemRepository->getMachineProblemInfo($problem_id);
        return view('user.machine-problem',compact('machineProblem','machine'));
    }
}
