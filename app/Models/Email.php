<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;
    protected $guarded = [

    ];

    /**
     *  get admin email sender information
     */
    public function sender(){
       return  $this->belongsTo(Admin::class,'form','id');
    }

    /**
     *  get admin email receiver information
     */
    public function receiver(){
       return  $this->belongsTo(Admin::class,'to','id');
    }

    /**
     *  get employee email sender information
     */
    public function EmployeeSender(){
       return  $this->belongsTo(Employee::class,'employee_form','id');
    }

    /**
     *  get employee email receiver information
     */
    public function EmployeeReceiver(){
       return  $this->belongsTo(Employee::class,'employee_to','id');
    }
// }
}