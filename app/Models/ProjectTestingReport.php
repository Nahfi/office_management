<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTestingReport extends Model
{
    use HasFactory;
    protected $guarded = [

    ];

    /**
     * get project
     */
    public function project(){
        return $this->belongsTo(Project::class,'project_id','id');
    }
    /**
     * get testing employee
     */
    public function testingEmployee(){
        return $this->belongsTo(Employee::class,'employee_id','id');
    }
}