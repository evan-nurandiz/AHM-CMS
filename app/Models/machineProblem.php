<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class machineProblem extends Model
{
    use HasFactory;

    protected $table = "machine_problems";
    protected $fillable = ['machine_id','symton_noise','causing_part','breakdown_part','method','at_gear','diagram_image','sound'];

    public function Machine(){
        return $this->belongsTo(Machine::class, 'machine_id', 'id');
    }
}
