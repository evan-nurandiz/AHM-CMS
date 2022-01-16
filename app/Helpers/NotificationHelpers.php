<?php

namespace App\Helpers;

use App\Mail\RequestReviewNoise;
use App\Mail\ReviewNoise;
use Illuminate\Support\Facades\Mail;
use App\Models\machineProblem;

class NotificationHelpers
{

    public static function sendRequestReviewNoise($noise_id)
    {
        $noise = machineProblem::find($noise_id);

        $details = [
            'head_name' => $noise['AssignTo']['name'],
            'user_name' => $noise['RequestBy']['name'],
            'date_at' => date('d-m-Y', strtotime($noise['created_at']))
        ];

        Mail::to($noise['AssignTo']['email'])->send(new RequestReviewNoise($details));
    }

    public static function sendReviewNoise($noise_id)
    {
        $noise = machineProblem::find($noise_id);


        if ($noise['confirmed'] == 1) {
            $details = [
                'status' => 'confirmed',
                'head_name' => $noise['AssignTo']['name'],
                'user_name' => $noise['RequestBy']['name'],
                'date_at' => date('d-m-Y', strtotime($noise['created_at'])),
                'update_at' => date('d-m-Y', strtotime($noise['updated_at']))
            ];
        } else {
            $revision = $noise->Revision()->orderBy('created_at', 'desc')->first();
            $details = [
                'status' => 'revision',
                'revision' => $revision['description'],
                'head_name' => $noise['AssignTo']['name'],
                'user_name' => $noise['RequestBy']['name'],
                'date_at' => date('d-m-Y', strtotime($noise['created_at'])),
                'update_at' => date('d-m-Y', strtotime($noise['updated_at']))
            ];
        }



        Mail::to($noise['RequestBy']['email'])->send(new ReviewNoise($details));
    }
}
