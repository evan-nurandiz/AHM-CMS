<?php

namespace App\Http\Controllers\user;


use App\Helpers\ExtractJsonHelpers;
use App\Repositories\MachineRepository;
use App\Repositories\MachineProblemRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlantController extends Controller
{

    protected $machineRepository;
    protected $machineProblemRepository;

    public function __construct(MachineRepository $machineRepository, MachineProblemRepository $machineProblemRepository) 
    {
        $this->machineRepository = $machineRepository;
        $this->machineProblemRepository = $machineProblemRepository;
    }

    public function index(){
        $plants = ExtractJsonHelpers::getPlantList();
        return view('user.plant.index',compact('plants'));
    }

    public function detail($plant_number){
        return view('user.plant.detail',compact('plant_number'));
    }

    public function detailEngine($plant_number){
        return view('user.plant.detail-engine',compact('plant_number'));
    }

    public function machineList($plant_number){
        $machines =  $this->machineRepository->getAllMachine();
        return view('user.plant.machine.machine-list',compact('machines','plant_number'));
    }

    public function machineDetail($plant_number, $machine_id){
        $machine = $this->machineRepository->getMachineById($machine_id);
        $machineProblems = $this->machineProblemRepository->getMachineProblemByMachineId($machine_id);
        $symton_noises = ExtractJsonHelpers::getSymtonNoise();
        $area = ExtractJsonHelpers::getArea();
        $methods = ExtractJsonHelpers::getMethodList();

        $data = [
            'machine' => $machine,
            'machineProblems' => $machineProblems,
            'symptons_noises' => $symton_noises,
            'area' => $area,
            'method' => $methods,
            'plant_id' => $plant_number
        ];

        return view('user.plant.machine.machine-detail', compact('data'));
    }

    public function machineNoise($plant_number, $machine_id, $noise_id){
        $machineProblem = $this->machineProblemRepository->getMachineProblemById($noise_id);
        $machine = $this->machineProblemRepository->getMachineProblemInfo($noise_id);

        $data = [
            'machine_id' => $machine_id,
            'plant_id' => $plant_number,
            'noise_id' => $noise_id,
            'machineProblem' => $machineProblem,
            'machine' => $machine
        ];

        return view('user.plant.machine.noise-detail',compact('data'));
    }
    
    public function filterNoise(Request $request,$plant_number,$machine_id){
        $queryParams = '';

        if($request['code'] != null){
            $queryParams .= '&like=code,' . $request['code'];
        }

        if($request['symton_noise'] != null){ 
            $queryParams .= '&like=symton_noise,' . implode(', ',  $request['symton_noise']);
        }

        if($request['causing_part'] != null){
            $queryParams .= '&like=causing_part,' . $request['causing_part'];
        }

        if($request['area'] != null){
            $queryParams .= '&like=area,' . implode(', ',  $request['area']);
        }
        

        if($request['method'] != null){
            $queryParams .= '&like=method,' . implode(', ', $request['method']);
        }

        if($request['date'] != null){
            $queryParams .= '&sort=created_at,' . $request['date'];
        }

        $previousUrl = strtok(url()->previous(), '?');

        return redirect()->to(
            $previousUrl . '?' . $queryParams
        );
    }

}
