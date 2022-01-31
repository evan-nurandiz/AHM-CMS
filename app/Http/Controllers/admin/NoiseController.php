<?php

namespace App\Http\Controllers\admin;

use App\Models\Helper;
use App\Models\User;
use App\Models\machineProblem;
use App\Http\Controllers\Controller;
use App\Helpers\ExtractJsonHelpers;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Helpers\NotificationHelpers;
use Illuminate\Http\Request;
use App\Repositories\MachineRepository;
use App\Repositories\MachineProblemRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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
    public function create($plant_id, $machine_id)
    {
        $symton_noises = ExtractJsonHelpers::getSymtonNoise();
        $area = ExtractJsonHelpers::getArea();
        $methods = ExtractJsonHelpers::getMethodList();
        $at_gears = ExtractJsonHelpers::getAtgearPart();
        $machine = $this->machineRepository->getMachineById($machine_id);
        $head_department_list = User::role('Division Head')->get();

        $data = [
            'machine' => $machine,
            'symton_noises' => $symton_noises,
            'area' => $area,
            'methods' => $methods,
            'at_gears' => $at_gears,
            'plant_id' => $plant_id,
            'machine_id' => $machine_id,
            'head_department_list' => $head_department_list
        ];
        return view('admin.plant.machine.create-noise', compact('data'));
    }

    public function store(Request $request, $plant_id, $machine_id)
    {
        try {
            if($request->has('vidio_temp')){
                Helper::uploadContent('vidio', 'vidio_temp', 'machine_vidio/', 'machine_problems', 'vidio');
            }
            $request['machine_id'] = $machine_id;
            $request['request_by'] = Auth::user()->id;
            $method = implode(',',  $request['method']);
            $request['method'] = $method;

            DB::beginTransaction();
            $noise = $this->machineProblemRepository->storeMachineProblem($request->except(['vidio_temp']));
            NotificationHelpers::sendRequestReviewNoise($noise['id']);
            DB::commit();
            return redirect()->route('admin.plant-machine-detail', [
                'plant_number' => $plant_id,
                'machine_id' => $machine_id
            ])->with('success', 'Berhasil Menyimpan Noise Engine');
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors([
                'message' => 'Sorry, there was an error in your request. Please try again in a moment.',
            ]);
        }
    }

    public function show($machine_id, $plant_id, $noise_id)
    {
        $machineProblem = $this->machineProblemRepository->getMachineProblemById($noise_id);

        $machine = $this->machineProblemRepository->getMachineProblemInfo($noise_id);

        $data = [
            'machine_id' => $machine_id,
            'plant_id' => $plant_id,
            'noise_id' => $noise_id,
            'machineProblem' => $machineProblem,
            'machine' => $machine
        ];

        return view('admin.plant.machine.show-noise', compact('data'));
    }

    public function edit($machine_id, $plant_id, $noise_id)
    {
        $machine = $this->machineProblemRepository->getMachineProblemInfo($noise_id);
        $machineProblem = $this->machineProblemRepository->getMachineProblemById($noise_id);
        $symton_noises = ExtractJsonHelpers::getSymtonNoise();
        $area = ExtractJsonHelpers::getArea();
        $methods = ExtractJsonHelpers::getMethodList();
        $at_gears = ExtractJsonHelpers::getAtgearPart();
        $machineProblem['method'] = json_encode(explode(",", $machineProblem['method']));

        $data = [
            'machine' => $machine,
            'machine_id' => $machine_id,
            'plant_id' => $plant_id,
            'noise_id' => $noise_id,
            'symton_noises' => $symton_noises,
            'area' => $area,
            'methods' => $methods,
            'at_gears' => $at_gears,
            'machineProblem' => $machineProblem
        ];

        return view('admin.plant.machine.edit-noise', compact('data'));
    }

    public function update(Request $request, $machine_id, $plant_id, $noise_id)
    {
        try {
            $machineProblem = $this->machineProblemRepository->getMachineProblemById($noise_id);
            $method = implode(', ',  json_decode($request['method']));
            $request['method'] = $method;

            if ($request->hasFile('image_temp')) {
                Storage::delete('/public/machine_diagram/' . $machineProblem['diagram_image']);
                Helper::uploadContent('diagram_image', 'image_temp', 'machine_diagram/', 'machine_problems', 'diagram_image');
            }

            if ($request->hasFile('sound_temp')) {
                Storage::delete('/public/machine_sound/' . $machineProblem['sound']);
                Helper::uploadContent('sound', 'sound_temp', 'machine_sound/', 'machine_problems', 'sound');
            }

            DB::beginTransaction();
            session()->flash('response', $this->machineProblemRepository->updateMachineProblem($noise_id, $request->except(['sound_temp', 'image_temp', '_method'])));
            DB::commit();
            return redirect()->back()->with('success', 'Berhasil Mengubah Noise Engine');
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors([
                'message' => 'Sorry, there was an error in your request. Please try again in a moment.',
            ]);
        }
    }

    public function destroy($machine_id, $plant_id, $noise_id)
    {
        $machineProblem = $this->machineProblemRepository->getMachineProblemById($noise_id);
        Storage::delete('/public/machine_diagram/' . $machineProblem['diagram_image']);
        Storage::delete('/public/machine_sound/' . $machineProblem['sound']);
        $machineProblem->delete();
        return redirect()->route('admin.plant-machine-detail', [
            'plant_number' => $plant_id,
            'machine_id' => $machine_id
        ])->with('success', 'Berhasil Menghapus Noise Engine');
    }
}
