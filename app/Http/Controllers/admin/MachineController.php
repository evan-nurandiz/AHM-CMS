<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\machineProblem;
use App\Helpers\ExtractJsonHelpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Repositories\MachineRepository;
use App\Repositories\MachineProblemRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;

class MachineController extends Controller
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
    public function index($plant_number)
    {
        $machines =  $this->machineRepository->getAllMachine();
        return view('admin.plant.machine.machine-list',compact('machines','plant_number'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($plant_number)
    {
        return view('admin.plant.machine.machine-create',compact('plant_number'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $plant_number)
    {        
        try {
            if($request->hasFile('image_temp')){
                $image = $request->file('image_temp');
                $filename = $image->getClientOriginalName();
                $filenames = date('his').$filename;
                $image->storeAs('machine_image/',$filenames,'public');    
                $request['image'] = $filenames;
            }

            DB::beginTransaction();
            $create = $this->machineRepository->storeMachine($request->except('image_temp'));
            DB::commit();
            return redirect()->route('admin.plant-machine-list',['plant_number' => $plant_number]);
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors([
                'message' => 'Sorry, there was an error in your request. Please try again in a moment.',
            ]);
        }    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($plant_id,$id)
    {
        $machine = $this->machineRepository->getMachineById($id);
        $machineProblems = $this->machineProblemRepository->getMachineProblemByMachineId($id);

        $data = [
            'machine' => $machine,
            'machineProblems' => $machineProblems,
            'plant_id' => $plant_id
        ];

        return view('admin.plant.machine.machine-detail', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $machine = $this->machineRepository->getMachineById($id);
        return view('admin.machine-add', compact('machine'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $this->machineRepository->deleteMachine($id);
            DB::commit();
            return redirect()->route('admin.machine');
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors([
                'message' => 'Sorry, there was an error in your request. Please try again in a moment.',
            ]);
        }
    }

    public function AddMachineProblem($id){
        $symton_noises = ExtractJsonHelpers::getSymtonNoise();
        $cause_parts = ExtractJsonHelpers::getCausingPart();
        $breakdown_parts = ExtractJsonHelpers::getBreakdownPart();
        $methods = ExtractJsonHelpers::getMethodList();
        $at_gears = ExtractJsonHelpers::getAtgearPart();
        return view('admin.addEngineProblem',compact('symton_noises','cause_parts','breakdown_parts','methods','at_gears','id'));
    }

    public function StoreMachineProblem(Request $request, $id){
        $request->validate([
            'symton_noise' => 'required',
            'causing_part' => 'required',
            'method' => 'required',
            'image_temp' => 'required',
            'sound_temp' => 'required'
        ]);

        try {
            if($request->hasFile('image_temp')){
                $image = $request->file('image_temp');
                $filename = $image->getClientOriginalName();
                $filenames = date('his').$filename;
                $image->storeAs('machine_diagram/',$filenames,'public');    
                $request['diagram_image'] = $filenames;
            }

            if($request->hasFile('sound_temp')){
                $sound = $request->file('sound_temp');
                $soundname = $sound->getClientOriginalName();
                $soundname = date('his').$soundname;
                $sound->storeAs('machine_sound/',$soundname,'public');    
                $request['sound'] = $soundname;
            }

            $request['machine_id'] = $id;

            DB::beginTransaction();
            $create = machineProblem::create($request->except(['sound_temp','image_temp']));
            DB::commit();
            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors([
                'message' => 'Sorry, there was an error in your request. Please try again in a moment.',
            ]);
        }    
    }

    public function ShowMachineProblem($id){
        $machineProblem = $this->machineProblemRepository->getMachineProblemById($id);
        $machine = $this->machineProblemRepository->getMachineProblemInfo($id);
        return view('admin.machine-problem.show',compact('machineProblem','machine'));
    }

    public function EditMachineProblem($id){
        $machineProblem = $this->machineProblemRepository->getMachineProblemById($id);
        $symton_noises = ExtractJsonHelpers::getSymtonNoise();
        $cause_parts = ExtractJsonHelpers::getCausingPart();
        $breakdown_parts = ExtractJsonHelpers::getBreakdownPart();
        $methods = ExtractJsonHelpers::getMethodList();
        $at_gears = ExtractJsonHelpers::getAtgearPart();
        return view('admin.machine-problem.edit',compact('symton_noises','cause_parts','breakdown_parts','methods','at_gears','id','machineProblem'));
    }

    public function updateMachineProblem(Request $request, $id){
        try {
            $machineProblem = machineProblem::find($id);
            if($request->hasFile('image_temp')){
                $image = $request->file('image_temp');
                $filename = $image->getClientOriginalName();
                $filenames = date('his').$filename;
                $image->storeAs('machine_diagram/',$filenames,'public');    
                $request['diagram_image'] = $filenames;
                Storage::delete('/public/machine_diagram/' . $machineProblem['diagram_image']);
            }

            if($request->hasFile('sound_temp')){
                $sound = $request->file('sound_temp');
                $soundname = $sound->getClientOriginalName();
                $soundname = date('his').$soundname;
                $sound->storeAs('machine_sound/',$soundname,'public');    
                $request['sound'] = $soundname;
                Storage::delete('/public/machine_sound/' . $machineProblem['sound']);
            }

            DB::beginTransaction();
            $update = $machineProblem->update($request->except(['sound_temp','image_temp']));
            DB::commit();
            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors([
                'message' => 'Sorry, there was an error in your request. Please try again in a moment.',
            ]);
        }    
    }
}
