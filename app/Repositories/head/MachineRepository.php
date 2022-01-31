<?php

namespace App\Repositories\head;

use App\Models\machineProblem;
use App\Models\Machine;


class MachineRepository
{
    public function __construct(Machine $machine, machineProblem $machineProblem)
    {
        $this->machine = $machine;
        $this->machineProblem = $machineProblem;
    }

    public function getMachineByPlant($plant_number)
    {
        return $this->machine->where('plant_id', $plant_number)->paginate(12);
    }

    public function getMachineById($id)
    {
        return $this->machine->find($id);
    }


    public function getMachineProblemByMachineId($machine_id)
    {
        return $this->machineProblem->where('machine_id', $machine_id)->where('confirmed', 1)->with('MachineDetail')->filter()->paginate(env('PER_PAGE'));
    }

    public function getMachineProblemById($id){
        return $this->machineProblem->find($id);
    }
    
}
