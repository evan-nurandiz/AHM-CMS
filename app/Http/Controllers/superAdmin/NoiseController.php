<?php

namespace App\Http\Controllers\superAdmin;

use App\Helpers\NotificationHelpers;
use App\Repositories\superAdmin\NoiseRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class NoiseController extends Controller
{
    protected $noiseRepository;

    public function __construct(NoiseRepository $noiseRepository)
    {
        $this->noiseRepository = $noiseRepository;
    }

    public function noise($status){
        $noises = $this->noiseRepository->getMachineProblemBystatus($status);

        $data = [
            'noises' => $noises,
            'status' => $status,
        ];

        return view('super-admin.noise',compact('data'));
    }

    public function detail($status,$noise_id){
        $noise = $this->noiseRepository->getMachineProblemById($noise_id);
        
        $data = [
            'noise' => $noise
        ];

        return view('super-admin.noise-detail', compact('data'));
    }

    public function postRevision(Request $request, $noise_id)
    {
        $noise = $this->noiseRepository->getMachineProblemById($noise_id);

        try {
            $request['request_by'] = Auth::user()->id;
            $request['assign_to'] = $noise['request_by'];
            $request['confirmed'] = 2;

            DB::beginTransaction();
            $noise->update($request->only('confirmed'));
            $noise = $noise->Revision()->create($request->all());
            NotificationHelpers::sendReviewNoise($noise['noise_id']);
            DB::commit();
            return redirect()->back()->with('success', 'Berhasil Mengirim Revisi');
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors([
                'message' => 'Sorry, there was an error in your request. Please try again in a moment.',
            ]);
        }
    }

    public function update($status,$noise_id){
        $noise = $this->noiseRepository->getMachineProblemById($noise_id);

        try {
            DB::beginTransaction();
            $noise->update(['confirmed' => 1]);
            DB::commit();
            return redirect()->back()->with('success', 'Selamat Noise Berhasil Di Publish');
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors([
                'message' => 'Sorry, there was an error in your request. Please try again in a moment.',
            ]);
        }
    }
}
