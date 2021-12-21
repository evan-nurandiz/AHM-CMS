<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mehradsadeghi\FilterQueryString\FilterQueryString;

class machineProblem extends Model
{
    use HasFactory, FilterQueryString;

    protected $table = "machine_problems";
    protected $fillable = ['machine_id','code','symton_noise','causing_part','breakdown_part','method','at_gear','diagram_image','sound'];

    protected $filters = [
        'sort',
        'like'
    ];
    

    private $rule = [
        'symton_noise' => 'required',
        'causing_part' => 'required',
        'code' => 'required',
        'method' => 'required',
        'image_temp' => 'required|max:8192',
        'sound_temp' => 'required|max:28192'
    ];

    public function Machine(){
        return $this->belongsTo(Machine::class, 'machine_id', 'id');
    }
}
