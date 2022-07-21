<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $guarded = [

    ];

    public function createdBy(){
        return $this->belongsTo(Admin::class,'created_by','id');
    }

    /**
     * Get the user name who edit this project
     */
    public function editedBy(){
        return $this->belongsTo(Admin::class,'edited_by','id');
    }

    /**
     * get customer for a project
     */
    public function customer(){
        return $this->belongsTo(User::class,'customer_id','id');
    }

    /**
     * get employee for a project
     */
    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id','id');
    }

    /**
     * get testing_employee for a project
     */
    public function tester(){
        return $this->belongsTo(Employee::class,'testing_employee_id','id');
    }


}