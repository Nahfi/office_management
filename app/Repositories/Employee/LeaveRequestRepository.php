<?php
namespace App\Repositories\Employee;

use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Auth;

class LeaveRequestRepository{
    /**
     * show all leave  request
     */
    public function index(){
        return LeaveRequest::where('employee_id',Auth::guard('employee')->User()->id)->get();
    }

    /**
     * show a specificed leave request details
     */
    public function show($id){
        return LeaveRequest::where('id',$id)->where('employee_id',Auth::guard('employee')->User()->id)->first();
    }
    /**
     * delete a specificed leave request
     */
    public function destroy($id){
        $leaveRequest = LeaveRequest::where('employee_id',Auth::guard('employee')->User()->id)->where('id',$id)->first();
        if($leaveRequest->status == 'Accept'){
            return redirect()->route('employee.leaveRequest.index')->with('leave_request_can_not_be_deleted','Request already accepted, so it can not be deleted.');
        }
        $leaveRequest->delete();
    }
    
}