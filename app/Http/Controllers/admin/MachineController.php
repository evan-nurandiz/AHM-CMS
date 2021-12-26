<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\machineProblem;
use App\Helpers\ExtractJsonHelpers;
use App\Models\Helper;
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
        $machines =  $this->machineRepository->getMachineByPlantId($plant_number);
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
                Helper::uploadContent('image', 'image_temp','machine_image/','machines','image');   
            }

            DB::beginTransaction();
            $create = $this->machineRepository->storeMachine($request->except('image_temp'));
            DB::commit();
            return redirect()->route('admin.plant-machine-list',['plant_number' => $plant_number])->with('success','Berhasil Menambahkan Mesin');
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
    public function show($plant_id,$machine_id)
    {
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
    public function edit($plant_id,$machine_id)
    {
        $machine = $this->machineRepository->getMachineById($machine_id);

        $data = [
            'machine' => $machine,
            'plant_id' => $plant_id,
            'machine_id' => $machine_id
        ];

        return view('admin.plant.machine.machine-edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $plant_id, $machine_id)
    {
        $machine = $this->machineRepository->getMachineById($machine_id);
        try {
            if($request->hasFile('image_temp')){
                Storage::delete('/public/machine_image/' . $machine['image']);
                Helper::uploadContent('image', 'image_temp','machine_image/','machines','image');   
            }

            DB::beginTransaction();
            session()->flash('response', $this->machineRepository->updateMachine($machine_id, $request->all()));
            DB::commit();
            return redirect()->back()->with('success','Berhasil Mengubah Mesin');
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors([
                'message' => 'Sorry, there was an error in your request. Please try again in a moment.',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($plant_id,$machine_id)
    {
        try {
            DB::beginTransaction();
            $this->machineRepository->deleteMachine($machine_id);
            DB::commit();
            return redirect()->route('admin.plant-machine-list',[
                'plant_number' => $plant_id
            ])->with('success','Berhasil Menghapus Mesin');
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors([
                'message' => 'Sorry, there was an error in your request. Please try again in a moment.',
            ]);
        }
    }

    public function filter(Request $request,$plant_number,$machine_id){
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
