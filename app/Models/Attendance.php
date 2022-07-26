<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $guarded = [

    ];

    public function employee(){
        return $this->belongsTo('App\Models\Employee','employee_id','id');
    }

    public function admin(){
        return $this->belongsTo('App\Models\Admin','approved_by','id');
    }
}
