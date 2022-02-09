<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mehradsadeghi\FilterQueryString\FilterQueryString;

class machineProblem extends Model
{
    use HasFactory, FilterQueryString;

    protected $table = "machine_problems";
    protected $fillable = [
        'request_by',
        'machine_id',
        'code',
        'symton_noise',
        'causing_part',
        'area',
        'method',
        'at_gear',
        'vidio',
        'confirmed',
        'keterangan',
        'assign_to',
    ];

    protected $filters = [
        'sort',
        'like',
        'in'
    ];

    public static $rule = [
        'request_by' => 'required',
        'symton_noise' => 'required',
        'causing_part' => 'required',
        'code' => 'required',
        'method' => 'required',
        'vidio_temp' => 'required',
        'assign_to' => 'required'
    ];

    public function Machine()
    {
        return $this->belongsTo(Machine::class, 'machine_id', 'id');
    }

    public function MachineDetail()
    {
        return $this->hasOne(Machine::class, 'id', 'machine_id');
    }

    public function Revision()
    {
        return $this->hasMany(MachineProblemRevision::class, 'noise_id', 'id');
    }

    public function RequestBy()
    {
        return $this->hasOne(User::class, 'id', 'request_by');
    }

    public function AssignTo()
    {
        return $this->hasOne(User::class, 'id', 'assign_to');
    }
}
