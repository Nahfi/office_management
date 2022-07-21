<?php
namespace App\Repositories\Employee;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceRepository{

    /**
     * send new request
     */
    public function sendRequest(){


        $todayAttendance = Attendance::where('employee_id',Auth::guard('employee')->User()->id)->latest()->first();
        if($todayAttendance != null){
            $lastAttendanceDate = date('Y-m-d',strtotime($todayAttendance->date_time));
            $todayDate = date('Y-m-d',strtotime(Carbon::now()));

            if($todayDate == $lastAttendanceDate){
                return redirect()->route('employee.attendance.index')->with('attendance_already_submit','Your Attendance Already Submit');
            }
        }
        Attendance::insert([
            'employee_id' => Auth::guard('employee')->User()->id,
            'date_time' => Carbon::now(),
            'ip' => request()->getClientIp(),
            'created_at' => Carbon::now(),
        ]);
    }

    /**
     * show all attendance list
     */
    public function index(){
        return Attendance::with('admin')->where('employee_id',Auth::guard('employee')->User()->id)->orderBy('id','desc')->get();
    }
}