<?php
namespace App\Repositories\Admin;

use App\Models\EmployeeLeave;
use App\Models\EmployeeLeaveDetails;
use App\Models\LeaveRequest;
use Carbon\Carbon;

class EmployeeLeaveRequestRepository{
    /**
     * show all leave request
     */
    public function index(){
        return LeaveRequest::with('employee')->orderBy('id','desc')->get();
    }

    /**
     * show a specifice leave reqeust
     */
    public function show($id){
        return LeaveRequest::with('employee')->where('id',$id)->first();
    }

    /**
     * update status
     */
    public function statusUpdate($request,$id){
        $leaveRequest = LeaveRequest::where('id',$id)->first();
        if ($leaveRequest->updated_at != null && $leaveRequest->updated_at->addMinutes(5) < Carbon::now() ) {
            return redirect()->route('admin.leaveRequest.index')->with('leave_request_update_timeout','Leave Request Updated Timeout!!!');
        }

        LeaveRequest::where('id',$id)->update([
            'status' => $request->status
        ]);

        $from =  Carbon::createFromFormat('Y-m-d', $leaveRequest->from);
        $to =  Carbon::createFromFormat('Y-m-d', $leaveRequest->to);

        $totalDay = $to->diffInDays($from) + 1;

        if($leaveRequest->status == 'Accept' && $request->status != 'Accept'){
            if(date('Y', strtotime($leaveRequest->from)) == date('Y', strtotime($leaveRequest->to))){
                $leaveInfo = EmployeeLeave::where('employee_id',$leaveRequest->employee_id)->where('year',date('Y', strtotime($leaveRequest->to)))->first();
                EmployeeLeave::where('employee_id',$leaveRequest->employee_id)->where('year',date('Y', strtotime($leaveRequest->to)))->increment('total_yearly_leave_remaining',$totalDay);
    
                //when month is same
                if(date('m',strtotime($leaveRequest->from)) == date('m',strtotime($leaveRequest->to))){
                    EmployeeLeaveDetails::where('employee_leave_id',$leaveInfo->id)->where('month',date('m',strtotime($leaveRequest->from)))->increment('total_monthly_leave_remaining',$totalDay);
                }
                //when month is not same
                else{
                    $lastDateOfFromMonth = Carbon::parse($leaveRequest->from)->endOfMonth();
                    $startDateOfToMonth = Carbon::parse($leaveRequest->to)->firstOfMonth();
    
                    $totalDayOfFromMonth = $lastDateOfFromMonth->diffInDays($leaveRequest->from) + 1;
                    $totalDayOfToMonth = $leaveRequest->to->diffInDays($startDateOfToMonth) + 1;
    
                    EmployeeLeaveDetails::where('employee_leave_id',$leaveInfo->id)->where('month',date('m',strtotime($leaveRequest->from)))->increment('total_monthly_Leave_remaining',$totalDayOfFromMonth);
                    EmployeeLeaveDetails::where('employee_leave_id',$leaveInfo->id)->where('month',date('m',strtotime($leaveRequest->to)))->increment('total_monthly_Leave_remaining',$totalDayOfToMonth);
    
                }
    
            }
            else{
                $lastDateOfFromYear = Carbon::parse($leaveRequest->from)->endOfMonth();
                $startDateOfToYear = Carbon::parse($leaveRequest->to)->firstOfMonth();
    
                $totalDayOfFromYear = $lastDateOfFromYear->diffInDays($leaveRequest->from) + 1;
                $totalDayOfToYear = $leaveRequest->to->diffInDays($startDateOfToYear) + 1;
    
              $fromLeaveinfo =   EmployeeLeave::where('employee_id',$leaveRequest->employee_id)->where('year',date('Y',strtotime($leaveRequest->from)))->first();
              $toLeaveInfo =   EmployeeLeave::where('employee_id',$leaveRequest->employee_id)->where('year',date('Y',strtotime($leaveRequest->to)))->first();
    
              EmployeeLeave::where('employee_id',$leaveRequest->employee_id)->where('year',date('Y',strtotime($leaveRequest->from)))->increment('total_yearly_leave_remaining',$totalDayOfFromYear);
              EmployeeLeave::where('employee_id',$leaveRequest->employee_id)->where('year',date('Y',strtotime($leaveRequest->to)))->increment('total_yearly_leave_remaining',$totalDayOfToYear);
             
    
              EmployeeLeaveDetails::where('employee_leave_id',$fromLeaveinfo->id)->where('month',date('Y',strtotime($leaveRequest->from)))->increment('total_monthly_Leave_remaining',$totalDayOfFromYear);
              EmployeeLeaveDetails::where('employee_leave_id',$toLeaveInfo->id)->where('month',date('Y',strtotime($leaveRequest->to)))->increment('total_monthly_Leave_remaining',$totalDayOfToYear);
    
            }
        }
        if($leaveRequest->status != 'Accept' && $request->status == 'Accept'){
            if(date('Y', strtotime($leaveRequest->from)) == date('Y', strtotime($leaveRequest->to))){
                $leaveInfo = EmployeeLeave::where('employee_id',$leaveRequest->employee_id)->where('year',date('Y', strtotime($leaveRequest->to)))->first();
                EmployeeLeave::where('employee_id',$leaveRequest->employee_id)->where('year',date('Y', strtotime($leaveRequest->to)))->decrement('total_yearly_leave_remaining',$totalDay);
    
                //when month is same
                if(date('m',strtotime($leaveRequest->from)) == date('m',strtotime($leaveRequest->to))){
                    EmployeeLeaveDetails::where('employee_leave_id',$leaveInfo->id)->where('month',date('m',strtotime($leaveRequest->from)))->decrement('total_monthly_leave_remaining',$totalDay);
                }
                //when month is not same
                else{
                    $lastDateOfFromMonth = Carbon::parse($leaveRequest->from)->endOfMonth();
                    $startDateOfToMonth = Carbon::parse($leaveRequest->to)->firstOfMonth();
    
                    $totalDayOfFromMonth = $lastDateOfFromMonth->diffInDays($leaveRequest->from) + 1;
                    $totalDayOfToMonth = $leaveRequest->to->diffInDays($startDateOfToMonth) + 1;
    
                    EmployeeLeaveDetails::where('employee_leave_id',$leaveInfo->id)->where('month',date('m',strtotime($leaveRequest->from)))->decrement('total_monthly_Leave_remaining',$totalDayOfFromMonth);
                    EmployeeLeaveDetails::where('employee_leave_id',$leaveInfo->id)->where('month',date('m',strtotime($leaveRequest->to)))->decrement('total_monthly_Leave_remaining',$totalDayOfToMonth);
    
                }
    
            }
            else{
                $lastDateOfFromYear = Carbon::parse($leaveRequest->from)->endOfMonth();
                $startDateOfToYear = Carbon::parse($leaveRequest->to)->firstOfMonth();
    
                $totalDayOfFromYear = $lastDateOfFromYear->diffInDays($leaveRequest->from) + 1;
                $totalDayOfToYear = $leaveRequest->to->diffInDays($startDateOfToYear) + 1;
    
              $fromLeaveinfo =   EmployeeLeave::where('employee_id',$leaveRequest->employee_id)->where('year',date('Y',strtotime($leaveRequest->from)))->first();
              $toLeaveInfo =   EmployeeLeave::where('employee_id',$leaveRequest->employee_id)->where('year',date('Y',strtotime($leaveRequest->to)))->first();
    
              EmployeeLeave::where('employee_id',$leaveRequest->employee_id)->where('year',date('Y',strtotime($leaveRequest->from)))->decrement('total_yearly_leave_remaining',$totalDayOfFromYear);
              EmployeeLeave::where('employee_id',$leaveRequest->employee_id)->where('year',date('Y',strtotime($leaveRequest->to)))->decrement('total_yearly_leave_remaining',$totalDayOfToYear);
             
    
              EmployeeLeaveDetails::where('employee_leave_id',$fromLeaveinfo->id)->where('month',date('Y',strtotime($leaveRequest->from)))->decrement('total_monthly_Leave_remaining',$totalDayOfFromYear);
              EmployeeLeaveDetails::where('employee_leave_id',$toLeaveInfo->id)->where('month',date('Y',strtotime($leaveRequest->to)))->decrement('total_monthly_Leave_remaining',$totalDayOfToYear);
    
            }
        }


        //do others staff


        

    }
}