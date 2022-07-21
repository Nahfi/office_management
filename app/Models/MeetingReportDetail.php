<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingReportDetail extends Model
{
    use HasFactory;
    protected $guarded = [

    ];

    public function MeetingReport(){
        return $this->belongsTo(MeetingReport::class,'meeting_report_id','id');
    }
}
