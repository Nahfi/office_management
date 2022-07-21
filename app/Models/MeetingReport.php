<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
class MeetingReport extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [

    ];

    /**
     * get all  report
     * @param $type,$id
     * @return  App\Models\MeetingReport;
     */
    public static function getReport($type,$id){
        if($type == 'deleted'){
            return MeetingReport::with(['employee','admin','MeetingReportDetails'])->where('employee_id',$id)->onlyTrashed()->latest()->get();
        }
        else{
            return MeetingReport::with(['employee','admin','MeetingReportDetails'])->where('employee_id',$id)->where('status',$type)->latest()->get();
        }
    }
    /**
     *  count all report
     * @param int $id
     *  @return int $count
     */
    public static function countReport($id){
       return count(MeetingReport::select('*')->where('employee_id',$id)->withTrashed()->get());
    }

    /**
     * get report details
     */
    public function MeetingReportDetails(){
        return $this->hasMany(MeetingReportDetail::class,'meeting_report_id','id');
    }

    /**
     * get employee information who create report
     */
    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id','id');
    }

    /**
     * get admin information who approved report
     */
    public function admin (){
        return $this->belongsTo(Admin::class,'approved_by','id');
    }

}