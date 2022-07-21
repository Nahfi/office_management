<?php
namespace App\Repositories\Employee;

use App\Models\EmployeeLeave;
use App\Models\EmployeeLeaveDetails;
use Illuminate\Support\Facades\Auth;

class LeaveRepository{
    /**
     * show all leave 
     */
    public function index(){
        return EmployeeLeave::where('employee_id',Auth::guard('employee')->User()->id)->get();
    }

    /**
     * show a specificed year leave
     */
    public function show($id){
        return EmployeeLeaveDetails::where('employee_leave_id',$id)->get();
    }
    
}