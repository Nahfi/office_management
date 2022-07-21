<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportDetail extends Model
{
    use HasFactory;
    protected $guarded = [

    ];

    public function report(){
        return $this->belongsTo(Report::class,'report_id','id');
    }
}