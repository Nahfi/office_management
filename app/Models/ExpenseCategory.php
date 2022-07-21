<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ExpenseCategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [
        
    ];
    public static function groupByStatusCount($status){
        $total = ExpenseCategory::where('status',$status)->count();
        return $total;
    }

    /**
     * Get the user name who create this category
     */
    public function createdBy(){
        return $this->belongsTo('App\Models\Admin','created_by','id');
    }
    /**
     * Get the user name who edit this category
     */
    public function editedBy(){
        return $this->belongsTo('App\Models\Admin','edited_by','id');
    }
}
