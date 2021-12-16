<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;

    protected $table = "machines";
    protected $fillable = ['plant_id','type','description','image'];

    private $rule = [
        'plant_id' => 'required',
        'type' => 'required',
        'description' => 'required',
        'image' => 'max:8192'
    ];

    public function MachineProblem(){
        return $this->hasMany(machineProblem::class,'machine_id');
    }
}
