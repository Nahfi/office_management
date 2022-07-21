<?php
namespace App\Repositories\Admin;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EmployeeAttendanceRepository{
    /**
     * show all attendance
     */
    public function index(){
        return Attendance::with(['employee','admin'])->orderBy('id','desc')->get();
    }

    /**
     * status update
     */
    public function statusUpdate($request,$id){

        $attendance = Attendance::where('id',$id)->first();
        if ($attendance->updated_at != null && $attendance->updated_at->addMinutes(5) < Carbon::now() ) {
            return redirect()->route('admin.attendance.index')->with('attendance_status_update_timeout','Attendance Permission Timeout!!!');
        }

        Attendance::where('id',$id)->update([
            'status' => $request->status,
            'approved_by' => Auth::guard('admin')->User()->id
        ]);
    }
}