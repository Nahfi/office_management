<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\EmployeeLeave;
use App\Models\EmployeeLeaveDetails;
use App\Models\LeaveRequest;
use App\Repositories\Admin\EmployeeLeaveRepository;
use App\Repositories\Employee\LeaveRequestRepository;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class EmployeeLeaveRequestController extends Controller
{
     /**
     * constract a method
     */
    public $user, $leaveRequestRepsitory;

    public function __construct(LeaveRequestRepository $leaveRequestRepsitory)
    {
        $this->middleware(function($request,$next){
            $this->user = Auth::guard('employee')->User();
            return $next($request);
        });
        $this->leaveRequestRepsitory = $leaveRequestRepsitory;

    }
    /**
     * show all employee leave list
     */
    public function index(){
        $leaveRequests = $this->leaveRequestRepsitory->index();
        return view('employee.pages.leave.request.index',[
            'leaveRequests' => $leaveRequests
        ]);
    }

    /**
     * show leave reqeuest details
     */
    public function show($id){
        $leaveRequest = $this->leaveRequestRepsitory->show($id);
        return view('employee.pages.leave.request.show',[
            'leaveRequest' => $leaveRequest
        ]);
    }

    /**
     * show a from for sending new leave request
     */
    public function create(){
        return view('employee.pages.leave.request.sendRequest');
    }

    /**
     * submit leave request form
     */
    public function store(Request $request){
        $request->validate([
            'from' => 'required',
            'to' => 'required',
            'subject' => 'required',
            'details' => 'required'
        ]);



        $leaveRequestInfo = LeaveRequest::where('employee_id',Auth::guard('employee')->User()->id)->where('status','Pending')->first();

        if($leaveRequestInfo != null){
            return back()->with('allready_leave_request_in_pending','You Have already some request in pending');
        }

        $from =  Carbon::createFromFormat('Y-m-d', $request->from);
        $to =  Carbon::createFromFormat('Y-m-d', $request->to);

        if(date('Y', strtotime($request->from)) == date('Y', strtotime($request->to))){
           $yearlyLeaveInfo = EmployeeLeave::where('employee_id',Auth::guard('employee')->User()->id)->where('year',date('Y',strtotime($request->from)))->first();
           if($yearlyLeaveInfo == null){
               return back()->with('your_selected_year_not_assigned_yet','Your Selected Year Not Assigned Yet, Please contct with admin!!!');
           }

           if($yearlyLeaveInfo->total_yearly_leave_remaining >= ($to->diffInDays($from) + 1)){
               //when month is same
               if(date('m',strtotime($request->from)) == date('m',strtotime($request->to))){
                   $monthlyLeaveInfo = EmployeeLeaveDetails::where('employee_leave_id',$yearlyLeaveInfo->id)->where('month',date('m',strtotime($request->from)))->first();
                   if($monthlyLeaveInfo == null){
                       return back()->with('your_selected_month_not_assigned_yet','Your Selected Month Not Assigned Yet, Please contact with admin!!!');
                   }
                   if($monthlyLeaveInfo->total_monthly_leave_remaining >= ($to->diffInDays($from) + 1)){
                       LeaveRequest::insert([
                        'employee_id' => Auth::guard('employee')->User()->id,
                        'subject' => $request->subject,
                        'details' => $request->details,
                        'from' => $request->from,
                        'to' => $request->to,
                        'status' => 'Pending',
                        'created_at' => Carbon::now()
                       ]);
                       return back()->with('leave_request_send_success','Leave Request Send Successfully');
                   }
                   else{
                        return back()->with('monthly_leave_limit_finished','Your Monthly Leave Limit is over!!!');
                   }
               }
               //when month is not same
               else{
                   //get last date of from month
                   $monthlyLeaveInfoFrom = EmployeeLeaveDetails::where('employee_leave_id',$yearlyLeaveInfo->id)->where('month',date('m',strtotime($request->from)))->first();
                   $monthlyLeaveInfoTo = EmployeeLeaveDetails::where('employee_leave_id',$yearlyLeaveInfo->id)->where('month',date('m',strtotime($request->to)))->first();
                   if($monthlyLeaveInfoFrom == null){
                       return back()->with('your_selected_from_month_not_assigned_yet','Your Selected '.date('M',strtotime($request->from)). ' Month not assigned Yet, please contact with admin');
                   }
                   if($monthlyLeaveInfoTo == null){
                       return back()->with('your_selected_to_month_not_assigned_yet','Your Selected '.date('M',strtotime($request->to)). ' Month not assigned Yet, please contact with admin');
                   }
                   $lastDateOfFromMonth = Carbon::parse($from)->endOfMonth();
                   $startDateOfToMonth = Carbon::parse($to)->firstOfMonth();
                   if($monthlyLeaveInfoFrom->total_monthly_leave_remaining >= ($lastDateOfFromMonth->diffInDays($from) + 1) && $monthlyLeaveInfoTo->total_monthly_leave_remaining >= ($to->diffInDays($startDateOfToMonth) + 1)){
                        LeaveRequest::insert([
                            'employee_id' => Auth::guard('employee')->User()->id,
                            'subject' => $request->subject,
                            'details' => $request->details,
                            'from' => $request->from,
                            'to' => $request->to,
                            'status' => 'Pending',
                            'created_at' => Carbon::now()
                       ]);
                       return back()->with('leave_request_send_success','Leave Request Send Successfully');
                   }
                   else{
                    return back()->with('monthly_leave_limit_finished','Your Monthly Leave Limit is over!!!');
                   }

               }
           }
           else{
               return back()->with('please_decrease_total_leave_day','Please Decrease total leave day');
           }
        }
        else{
            $yearlyLeaveInfoFrom = EmployeeLeave::where('employee_id',Auth::guard('employee')->User()->id)->where('year',date('Y',strtotime($request->from)))->first();
            $yearlyLeaveInfoTo = EmployeeLeave::where('employee_id',Auth::guard('employee')->User()->id)->where('year',date('Y',strtotime($request->to)))->first();
           if($yearlyLeaveInfoFrom == null){
               return back()->with('your_selected_from_year_not_assigned_yet','Your Selected Year('.date('Y',strtotime($request->from)) .') Not Assigned Yet, Please contct with admin!!!');
           }
           if($yearlyLeaveInfoTo == null){
               return back()->with('your_selected_to_year_not_assigned_yet','Your Selected Year('.date('Y',strtotime($request->to)) .') Not Assigned Yet, Please contct with admin!!!');
           }

           //do something
           $lastDateOfFromYear = Carbon::parse($from)->endOfMonth();
           $startDateOfToYear = Carbon::parse($to)->firstOfMonth();
            if($yearlyLeaveInfoFrom->total_yearly_leave_remaining >= ($lastDateOfFromYear->diffInDays($from) + 1) && $yearlyLeaveInfoTo->total_yearly_leave_remaining >= ($startDateOfToYear->diffInDays($to) + 1) ){

                    $monthlyLeaveInfoFrom = EmployeeLeaveDetails::where('employee_leave_id',$yearlyLeaveInfoFrom->id)->where('month',date('m',strtotime($request->from)))->first();
                    $monthlyLeaveInfoTo = EmployeeLeaveDetails::where('employee_leave_id',$yearlyLeaveInfoTo->id)->where('month',date('m',strtotime($request->to)))->first();
                    if($monthlyLeaveInfoFrom == null){
                        return back()->with('your_selected_from_month_not_assigned_yet','Your Selected '.date('M',strtotime($request->from)). ' Month not assigned Yet, please contact with admin');
                    }
                    if($monthlyLeaveInfoTo == null){
                        return back()->with('your_selected_to_month_not_assigned_yet','Your Selected '.date('M',strtotime($request->to)). ' Month not assigned Yet, please contact with admin');
                    }
                    $lastDateOfFromMonth = Carbon::parse($from)->endOfMonth();
                    $startDateOfToMonth = Carbon::parse($to)->firstOfMonth();
                    if($monthlyLeaveInfoFrom->total_monthly_leave_remaining >= ($lastDateOfFromMonth->diffInDays($from) + 1) && $monthlyLeaveInfoTo->total_monthly_leave_remaining >= ($to->diffInDays($startDateOfToMonth) + 1)){
                        LeaveRequest::insert([
                            'employee_id' => Auth::guard('employee')->User()->id,
                            'subject' => $request->subject,
                            'details' => $request->details,
                            'from' => $request->from,
                            'to' => $request->to,
                            'status' => 'Pending',
                            'created_at' => Carbon::now()
                        ]);
                        return back()->with('leave_request_send_success','Leave Request Send Successfully');
                    }
                    else{
                    return back()->with('monthly_leave_limit_finished','Your Monthly Leave Limit is over!!!');
                    }
            }
            else{
                return back()->with('please_decrease_total_leave_day','Please Decrease total leave day');
            }
        }
    }

    /**
     * delete leave request
     */
    public function destroy($id){
        $this->leaveRequestRepsitory->destroy($id);
        return back()->with('request_delete_success','Request Deleted Successfully');
    }

}