<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Helpers\ExtractJsonHelpers;
use Illuminate\Http\Request;
use App\Repositories\MachineRepository;
use App\Repositories\MachineProblemRepository;

class NoiseController extends Controller
{
    protected $machineRepository;
    protected $machineProblemRepository;

    public function __construct(MachineRepository $machineRepository, MachineProblemRepository $machineProblemRepository) 
    {
        $this->machineRepository = $machineRepository;
        $this->machineProblemRepository = $machineProblemRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($plant_id,$machine_id)
    {
        $symton_noises = ExtractJsonHelpers::getSymtonNoise();
        $cause_parts = ExtractJsonHelpers::getCausingPart();
        $breakdown_parts = ExtractJsonHelpers::getBreakdownPart();
        $methods = ExtractJsonHelpers::getMethodList();
        $at_gears = ExtractJsonHelpers::getAtgearPart();

        $data = [
            'symton_noises' => $symton_noises,
            'cause_parts' => $cause_parts,
            'breakdown_parts' => $breakdown_parts,
            'methods' => $methods,
            'at_gears' => $at_gears,
            'plant_id' => $plant_id,
            'machine_id' => $machine_id
        ];
        return view('admin.plant.machine.create-noise',compact('data'));
    }

}
