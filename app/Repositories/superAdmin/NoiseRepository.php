<?php

namespace App\Repositories\superAdmin;

use App\Models\machineProblem;

class NoiseRepository
{
    protected $machineProblem;
    public function __construct(machineProblem $machineProblem)
    {
        $this->machineProblem = $machineProblem;
    }

    public function getMachineProblemBystatus($status)
    {
        return $this->machineProblem->where('confirmed', $status)->paginate(12);
    }

    public function getMachineProblemById($id)
    {
        return $this->machineProblem->find($id);
    }
}
