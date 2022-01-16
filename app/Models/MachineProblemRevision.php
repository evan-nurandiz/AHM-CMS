<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineProblemRevision extends Model
{
    use HasFactory;

    protected $table = "machine_problem_revisions";
    protected $fillable = ['request_by', 'noise_id', 'description', 'assign_to'];

    private $rule = [
        'request_by' => 'required',
        'noise_id' => 'required',
        'description' => 'required',
        'assign_to' => 'required',
    ];
}
