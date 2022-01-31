<?php

namespace App\Http\Controllers\admin;

use App\Models\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\admin\NoiseRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Helpers\NotificationHelpers;
use App\Helpers\ExtractJsonHelpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RequestNoiseController extends Controller
{
    protected $noiseRepository;

    public function __construct(NoiseRepository $noiseRepository)
    {
        $this->noiseRepository = $noiseRepository;
    }

    public function index($status)
    {
        $noises = $this->noiseRepository->getMachineProblemBystatus($status, Auth::user()->id);

        $data = [
            'noises' => $noises,
            'status' => $status
        ];

        return view('admin.request-noise.index', compact('data'));
    }

    public function show($status, $noise_id)
    {
        $noise = $this->noiseRepository->getNoiseById($noise_id);

        $data = [
            'status' => $status,
            'noise' => $noise
        ];

        return view('admin.request-noise.show-noise', compact('data'));
    }

    public function edit($status, $noise_id)
    {
        $noise = $this->noiseRepository->getNoiseById($noise_id);
        $symton_noises = ExtractJsonHelpers::getSymtonNoise();
        $area = ExtractJsonHelpers::getArea();
        $methods = ExtractJsonHelpers::getMethodList();
        $at_gears = ExtractJsonHelpers::getAtgearPart();
        $noise['method'] = json_encode(explode(",", $noise['method']));

        $data = [
            'symton_noises' => $symton_noises,
            'area' => $area,
            'methods' => $methods,
            'at_gears' => $at_gears,
            'status' => $status,
            'noise' => $noise
        ];

        return view('admin.request-noise.edit-noise', compact('data'));
    }

    public function update(Request $request, $status, $noise_id)
    {
        try {
            $noise = $this->noiseRepository->getNoiseById($noise_id);
            $method = implode(',',  $request['method']);
            $request['method'] = $method;

            if ($request->hasFile('vidio_temp')) {
                Storage::delete('/public/machine_vidio/' . $noise['vidio']);
                Helper::uploadContent('vidio', 'vidio_temp', 'machine_vidio/', 'machine_problems', 'vidio');
            }

            DB::beginTransaction();
            $noise->update($request->except(['vidio_temp', '_method']));
            DB::commit();
            return redirect()->back()->with('success', 'Berhasil Mengubah Noise Engine');
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors([
                'message' => 'Sorry, there was an error in your request. Please try again in a moment.',
            ]);
        }
    }

    public function revisionRequest($status, $noise_id)
    {
        try {
            $noise = $this->noiseRepository->getNoiseById($noise_id);

            DB::beginTransaction();
            $noise->update([
                'confirmed' => 0
            ]);

            NotificationHelpers::sendRevisionNoise($noise['id']);

            DB::commit();
            return redirect()->back()->with('success', 'Berhasil Mengajukan Revisi Noise');
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors([
                'message' => 'Sorry, there was an error in your request. Please try again in a moment.',
            ]);
        }
    }
}
