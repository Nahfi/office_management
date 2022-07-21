<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeLeaveDetails extends Model
{
    use HasFactory;
    protected $guarded = [

    ];
    /**
     * Get the user name who add this item
     */
    public function createdBy(){
        return $this->belongsTo('App\Models\Admin','created_by','id');
    }
    /**
     * Get the user name who edit this item
     */
    public function editedBy(){
        return $this->belongsTo('App\Models\Admin','edited_by','id');
    }
    public function employee(){
        return $this->belongsTo('App\Models\Employee','employee_id','id');
    }
}
