<?php

namespace App\Http\Controllers\admin;

use App\Models\Helper;
use App\Http\Controllers\Controller;
use App\Helpers\ExtractJsonHelpers;
use Illuminate\Http\Request;
use App\Repositories\MachineRepository;
use App\Repositories\MachineProblemRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

    public function store(Request $request, $plant_id, $machine_id){
        try {
            Helper::uploadContent('diagram_image', 'image_temp','machine_diagram/','machine_problems','diagram_image');
            Helper::uploadContent('sound', 'sound_temp','machine_sound/','machine_problems','sound');
            $request['machine_id'] = $machine_id;

            DB::beginTransaction();
            session()->flash('response', $this->machineProblemRepository->storeMachineProblem($request->except(['sound_temp','image_temp'])));
            DB::commit();
            return redirect()->route('admin.plant-machine-detail',[
                'plant_number' => $plant_id,
                'machine_id' => $machine_id
            ])->with('success','Berhasil Menyimpan Noise Mesin');
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors([
                'message' => 'Sorry, there was an error in your request. Please try again in a moment.',
            ]);
        }    
    }

    public function show($machine_id, $plant_id, $noise_id){
        $machineProblem = $this->machineProblemRepository->getMachineProblemById($noise_id);
        $machine = $this->machineProblemRepository->getMachineProblemInfo($noise_id);

        $data = [
            'machine_id' => $machine_id,
            'plant_id' => $plant_id,
            'noise_id' => $noise_id,
            'machineProblem' => $machineProblem,
            'machine' => $machine
        ];

        return view('admin.plant.machine.show-noise',compact('data'));
    }

    public function edit($machine_id, $plant_id, $noise_id){
        $machineProblem = $this->machineProblemRepository->getMachineProblemById($noise_id);
        $symton_noises = ExtractJsonHelpers::getSymtonNoise();
        $cause_parts = ExtractJsonHelpers::getCausingPart();
        $breakdown_parts = ExtractJsonHelpers::getBreakdownPart();
        $methods = ExtractJsonHelpers::getMethodList();
        $at_gears = ExtractJsonHelpers::getAtgearPart();

        $data = [
            'machine_id' => $machine_id,
            'plant_id' => $plant_id,
            'noise_id' => $noise_id,
            'symton_noises' => $symton_noises,
            'cause_parts' => $cause_parts,
            'breakdown_parts' => $breakdown_parts,
            'methods' => $methods,
            'at_gears' => $at_gears,
            'machineProblem' => $machineProblem
        ];

        return view('admin.plant.machine.edit-noise',compact('data'));
    }
    
    public function update(Request $request,$machine_id, $plant_id, $noise_id){
        try {
            $machineProblem = $this->machineProblemRepository->getMachineProblemById($noise_id);
            if($request->hasFile('image_temp')){
                Storage::delete('/public/machine_diagram/' . $machineProblem['diagram_image']);
                Helper::uploadContent('diagram_image', 'image_temp','machine_diagram/','machine_problems','diagram_image');   
            }

            if($request->hasFile('sound_temp')){
                Storage::delete('/public/machine_sound/' . $machineProblem['sound']);
                Helper::uploadContent('sound', 'sound_temp','machine_sound/','machine_problems','sound');
            }

            DB::beginTransaction();
            session()->flash('response', $this->machineProblemRepository->updateMachineProblem($noise_id,$request->except(['sound_temp','image_temp','_method'])));
            DB::commit();
            return redirect()->back()->with('success','Berhasil Mengubah Noise Mesin');
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors([
                'message' => 'Sorry, there was an error in your request. Please try again in a moment.',
            ]);
        }    
    }

    public function destroy(Request $request,$machine_id, $plant_id, $noise_id){
        $machineProblem = $this->machineProblemRepository->getMachineProblemById($noise_id);
        Storage::delete('/public/machine_diagram/' . $machineProblem['diagram_image']);
        Storage::delete('/public/machine_sound/' . $machineProblem['sound']);
        $machineProblem ->delete();
        return redirect()->route('admin.plant-machine-detail',[
            'plant_number' => $plant_id,
            'machine_id' => $machine_id
        ])->with('success','Berhasil Menghapus Noise Mesin');
    }

}
