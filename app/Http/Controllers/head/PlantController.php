<?php

namespace App\Http\Controllers\head;

use App\Http\Controllers\Controller;
use App\Helpers\ExtractJsonHelpers;
use App\Repositories\head\MachineRepository;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    protected $machineRepository;

    public function __construct(MachineRepository $machineRepository)
    {
        $this->machineRepository = $machineRepository;
    }

    public function index()
    {
        $plants = ExtractJsonHelpers::getPlantList();
        return view('head.plant.index', compact('plants'));
    }

    public function detail($plant_number)
    {
        return view('head.plant.detail', compact('plant_number'));
    }

    public function engineDetail($plant_number)
    {
        return view('head.plant.detail-engine', compact('plant_number'));
    }

    public function engineNoise($plant_number)
    {
        $machines = $this->machineRepository->getMachineByPlant($plant_number);
        return view('head.plant.machine-list', compact('machines', 'plant_number'));
    }

    public function engineShow($plant_number, $machine_id)
    {
        $machine = $this->machineRepository->getMachineById($machine_id);
        $machineProblems = $this->machineRepository->getMachineProblemByMachineId($machine_id);
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

        return view('head.plant.machine-detail', compact('data'));
    }

    public function engineNoiseDetail($plant_number, $machine_id, $noise_id){
        $machineProblem = $this->machineRepository->getMachineProblemById($noise_id);
        $machine = $this->machineRepository->getMachineById($machine_id);

        $data = [
            'machine_id' => $machine_id,
            'plant_id' => $plant_number,
            'noise_id' => $noise_id,
            'machineProblem' => $machineProblem,
            'machine' => $machine
        ];

        return view('head.plant.show-noise', compact('data'));
    }

    public function filter(Request $request,  $plant_number, $machine_id){
        $queryParams = '';

        if ($request['code'] != null) {
            $queryParams .= '&like=code,' . $request['code'];
        }

        if ($request['symton_noise'] != null) {
            $queryParams .= '&like=symton_noise,' . implode(', ',  $request['symton_noise']);
        }

        if ($request['causing_part'] != null) {
            $queryParams .= '&like=causing_part,' . $request['causing_part'];
        }

        if ($request['area'] != null) {
            $queryParams .= '&like=area,' . implode(', ',  $request['area']);
        }


        if ($request['method'] != null) {
            $queryParams .= '&like=method,' . implode(', ', $request['method']);
        }

        if ($request['date'] != null) {
            $queryParams .= '&sort=created_at,' . $request['date'];
        }

        $previousUrl = strtok(url()->previous(), '?');

        return redirect()->to(
            $previousUrl . '?' . $queryParams
        );
    }
}
