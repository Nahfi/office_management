<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Repositories\Admin\EmployeeLeaveRequestRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveRequestController extends Controller
{
    
    /**
     * Construct method
     */
    public $user,$employeeLeaveRequestRepository;
    public function __construct(EmployeeLeaveRequestRepository $employeeLeaveRequestRepository)
    {
        $this->middleware(function($request,$next){
            $this->user = Auth::guard('admin')->User();
            return $next($request);
        });
        $this->employeeLeaveRequestRepository = $employeeLeaveRequestRepository;
    }

     /**
      * show all leave request
      */
      public function index(){
        if(is_null($this->user) || !$this->user->can('leaveRequest.index')){
          abort(403,'Unauthorized access');
        }
          $leaveRequests = $this->employeeLeaveRequestRepository->index();
          return view('admin.pages.leave.leaveRequest.index',[
            'leaveRequests' => $leaveRequests
          ]);
      }

      /**
       * show a leave request
       */
      public function show($id){
        if(is_null($this->user) || !$this->user->can('leaveRequest.index')){
          abort(403,'Unauthorized access');
        }
          $leaveRequest = $this->employeeLeaveRequestRepository->show($id);
          return view('admin.pages.leave.leaveRequest.show',[
            'leaveRequest' => $leaveRequest
          ]);
      }

      /**
       * status update
       */
      public function statusUpdate(Request $request,$id){
        if(is_null($this->user) || !$this->user->can('leaveRequest.update')){
          abort(403,'Unauthorized access');
        }
        $request->validate([
            'status' => 'required'
        ]);
        $this->employeeLeaveRequestRepository->statusUpdate($request,$id);
        return back()->with('leave_reqeust_update_success','Leave Reqeust Updated Successfully');
      }
}
