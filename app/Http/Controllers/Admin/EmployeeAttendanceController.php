<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\EmployeeAttendanceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeAttendanceController extends Controller
{
    /**
     * construct method
     */
    public $user, $employeeAttendanceRepository;
    public function __construct(EmployeeAttendanceRepository $employeeAttendanceRepository)
    {
        $this->middleware(function($request,$next){
            $this->user = Auth::guard('admin')->User();
            return $next($request);
        });
        $this->employeeAttendanceRepository = $employeeAttendanceRepository;
    }


    /**
     * show all attendance list
     */
    public function index(){
        if(is_null($this->user) || !$this->user->can('attendanceRequest.index')){
            abort(403,'Unauthorized access');
        }
        $attendanceLists = $this->employeeAttendanceRepository->index();
        return view('admin.pages.attendance.index',[
            'attendanceLists' => $attendanceLists
        ]);
    }


    /**
     * update status
     */
    public function statusUpdate(Request $request,$id){
        if(is_null($this->user) || !$this->user->can('attendanceRequest.update')){
            abort(403,'Unauthorized access');
        }
        $request->validate([
            'status' => 'required'
        ]);

        $this->employeeAttendanceRepository->statusUpdate($request,$id);
        return back()->with('attendance_status_updated','Attendance Status Updated Successfully');
    }
}
