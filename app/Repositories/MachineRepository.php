<?php

namespace App\Repositories;

use App\Models\Machine;
use Illuminate\Support\Facades\Storage;
use Exception;

class MachineRepository
{

    protected $machine;
    public function __construct(Machine $machine)
    {
        $this->machine = $machine;
    }

    public function getAllMachine(){
        return $this->machine->paginate(env('PER_PAGE'));
    }

    public function countAllMachine(){
        return $this->machine->count();
    }

    public function getMachineById($id){
        return $this->machine->find($id);
    }

    public function storeMachine($machine){
        return $this->machine->create($machine);
    }

    public function deleteMachine($machine_id){
        $machine =  $this->machine->find($machine_id);
        Storage::delete('/public/machine_image/' . $machine['image']);
        $machine->delete();
    }

}
