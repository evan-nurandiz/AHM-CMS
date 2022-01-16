<?php

namespace App\Repositories\head;

use App\Models\machineProblem;


class NoiseRepository
{

    protected $machineProblem;
    public function __construct(machineProblem $machineProblem)
    {
        $this->machineProblem = $machineProblem;
    }

    public function getDashboardInfo()
    {
        $pending = count($this->machineProblem->where('confirmed', 0)->get());
        $in_revision = count($this->machineProblem->where('confirmed', 2)->get());
        $approved = count($this->machineProblem->where('confirmed', 1)->get());

        $data = [
            'pending' => $pending,
            'in_revision' => $in_revision,
            'approved' => $approved
        ];

        return $data;
    }
}
