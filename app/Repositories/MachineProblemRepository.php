<?php

namespace App\Repositories;

use App\Models\machineProblem;
use Illuminate\Support\Facades\Storage;
use Exception;

class MachineProblemRepository
{

    protected $machineProblem;
    public function __construct(machineProblem $machineProblem)
    {
        $this->machineProblem = $machineProblem;
    }

    public function getMachineProblemByMachineId($machine_id){
        return $this->machineProblem->where('machine_id',$machine_id)->paginate(env('PER_PAGE'));
    }

    public function getMachineProblemById($id){
        return $this->machineProblem->find($id);
    }

    public function getMachineProblemInfo($id){
        return $this->machineProblem->find($id)->Machine;
    }
    

}
