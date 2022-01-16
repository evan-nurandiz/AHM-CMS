<?php

namespace App\Repositories\admin;

use App\Models\machineProblem;


class NoiseRepository
{

    protected $machineProblem;
    public function __construct(machineProblem $machineProblem)
    {
        $this->machineProblem = $machineProblem;
    }

    public function getMachineProblemBystatus($status, $user_id)
    {
        return $this->machineProblem->where('confirmed', $status)->where('request_by', $user_id)->paginate(12);
    }

    public function getNoiseById($noise_id)
    {
        return $this->machineProblem->find($noise_id);
    }
}
