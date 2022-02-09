<?php

namespace App\Http\Controllers\head;

use App\Helpers\NotificationHelpers;
use App\Http\Controllers\Controller;
use App\Repositories\head\NoiseRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class NoiseController extends Controller
{

    protected $noiseRepository;

    public function __construct(NoiseRepository $noiseRepository)
    {
        $this->noiseRepository = $noiseRepository;
    }

    public function index($status)
    {
        $noises = $this->noiseRepository->getNoiseNeedRiview(Auth::user()->id, $status);

        $data = [
            'noises' => $noises,
            'status' => $status,
        ];

        return view('head.request-noise.index', compact('data'));
    }

    public function detail($noise_id)
    {
        $noise = $this->noiseRepository->getMachineProblemById($noise_id);

        $data = [
            'noise' => $noise
        ];

        return view('head.request-noise.show-noise', compact('data'));
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
            return redirect()->back()->with('success', 'Berhasil Mengubah Symtom Noise');
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors([
                'message' => 'Sorry, there was an error in your request. Please try again in a moment.',
            ]);
        }
    }

    public function confirmRevision($noise_id)
    {
        $noise = $this->noiseRepository->getMachineProblemById($noise_id);

        try {
            DB::beginTransaction();
            $noise->update(['confirmed' => 3]);
            NotificationHelpers::sendReviewNoise($noise['id']);
            DB::commit();
            return redirect()->back()->with('success', 'Selamat Revisi Berhasil Dikonfirmasi');
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors([
                'message' => 'Sorry, there was an error in your request. Please try again in a moment.',
            ]);
        }
    }
}
