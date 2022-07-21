<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingDay extends Model
{
    use HasFactory;

    /**
     * Get the user name who crated this employee
     */
    public function createdBy(){
        return $this->belongsTo('App\Models\Admin','created_by','id');
    }
    /**
     * Get the user name who edit this employee
     */
    public function editedBy(){
        return $this->belongsTo('App\Models\Admin','edited_by','id');
    }
}
