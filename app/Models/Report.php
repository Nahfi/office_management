<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ReportDetail;
use Illuminate\Support\Facades\Auth;
class Report extends Model
{
    use HasFactory , SoftDeletes;
    protected $guarded = [

    ];

    /**
     * get all  report
     * @param $type , $id
     * @return  App\Models\Report;
     */
    public static function getReport($type,$id){
        if($type == 'deleted'){
            return Report::with(['employee','admin','reportDetails'])->where('employee_id',$id)->onlyTrashed()->latest()->get();
        }
        else{
            return Report::with(['employee','admin','reportDetails'])->where('status',$type)->where('employee_id',$id)->latest()->get();
        }
    }
    /**
     *  count all report
     *  @return int $count
     */
    public static function countReport($id){
       return count(Report::select('*')->where('employee_id',
       $id)->withTrashed()->get());
    }

    /**
     * get report details
     */
    public function reportDetails(){
        return $this->hasMany(ReportDetail::class,'report_id','id');
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