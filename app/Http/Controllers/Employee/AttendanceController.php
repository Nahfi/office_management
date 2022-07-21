<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Repositories\Employee\AttendanceRepository;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * construct method
     */
    public $user, $attendanceRepository;
   
    public function __construct(AttendanceRepository $attendanceRepository)
    {
        $this->middleware(function($request,$next){
            $this->user = Auth::guard('employee')->User();
            return $next($request);
        });
        $this->attendanceRepository = $attendanceRepository;
       
    }
    /**
     * show all attendance request
     */
    public function index(){
        $attendanceLists = $this->attendanceRepository->index();
        return view('employee.pages.attendance.index',[
            'attendanceLists' => $attendanceLists
        ]);
    }

    /**
     * send attendance request
     */
    public function sendRequest(){
        $this->attendanceRepository->sendRequest();
        return back()->with('request_submit_success','Request Submit Success');
    }
}
