<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;
    public function createdBy(){
        return $this->belongsTo('App\Models\Admin','created_by','id');
    }
    /**
     * Get the user name who edit this employee
     */
    public function editedBy(){
        return $this->belongsTo('App\Models\Admin','edited_by','id');
    }

    /**
     * get all holiday date under this holiday month
     */
    public function holidayDetails(){
        return $this->hasMany('App\Models\HolidayDetails','holiday_id','id');
    }
}
