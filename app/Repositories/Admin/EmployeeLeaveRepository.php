<?php
namespace App\Repositories\Admin;

use App\Models\EmployeeLeave;
use App\Models\EmployeeLeaveDetails;
use Illuminate\Support\Facades\Auth;

 class EmployeeLeaveRepository{
     /**
      * show all employee leave list
      */
      public function index(){
          return EmployeeLeave::with(['createdBy','editedBy','employee'])->get();
      }
      /**
       * show all leave details under a employee
       */
      public function showDetails($id){
          return EmployeeLeaveDetails::with(['createdby','editedBy','employee'])->where('employee_leave_id',$id)->get();
      }

      /**
       * get Specificed employee leave
       */
      public function getSpecificedEmployeeLeave($id){
          return EmployeeLeave::with(['createdby','editedby','employee'])->where('id',$id)->first();
      }
      /**
       * get specificed employee leave details
       */
      public function getSpecificedEmployeeLeaveDetails($id){
          return EmployeeLeaveDetails::with(['createdby','editedby','employee'])->where('id',$id)->first();
      }
      /**
       * store employee leave
       */
      public function create($request){
          $employee_leave = new EmployeeLeave();
          $employee_leave->employee_id = $request->employee_id;
          $employee_leave->year = $request->year;
          $employee_leave->total_yearly_leave = $request->total_yearly_leave;
          $employee_leave->total_yearly_leave_remaining = $request->total_yearly_leave;
          $employee_leave->created_by = Auth::guard('admin')->User()->id;
          $employee_leave->save();
      }
      /**
       * store employee leave  deatils
       */
      public function createDetails($request,$id){
          $employee_leave_details = new EmployeeLeaveDetails();
          $employee_leave_details->employee_leave_id = $id;
          $employee_leave_details->month = $request->month;
          $employee_leave_details->total_monthly_leave = $request->total_monthly_leave;
          $employee_leave_details->total_monthly_leave_remaining = $request->total_monthly_leave;
          $employee_leave_details->created_by = Auth::guard('admin')->User()->id;
          $employee_leave_details->save();
      }

      /**
       * update employee leave
       */
      public function update($request,$id){
          $employee_leave = $this->getSpecificedEmployeeLeave($id);
          $employee_leave->year = $request->year;
         

          if($employee_leave->total_yearly_leave == $request->total_yearly_leave){
              $employee_leave->total_yearly_leave_remaining = $employee_leave->total_yearly_leave_remaining;
          }
          elseif($employee_leave->total_yearly_leave > $request->total_yearly_leave){
              $employee_leave->total_yearly_leave_remaining = $employee_leave->total_yearly_leave_remaining - ($employee_leave->total_yearly_leave - $request->total_yearly_leave);
          }
          elseif($employee_leave->total_yearly_leave < $request->total_yearly_leave){
            $employee_leave->total_yearly_leave_remaining = $employee_leave->total_yearly_leave_remaining + ($request->total_yearly_leave - $employee_leave->total_yearly_leave);
          }

          $employee_leave->total_yearly_leave = $request->total_yearly_leave;
          $employee_leave->edited_by = Auth::guard('admin')->User()->id;
          $employee_leave->save();
      }

      /**
       * update employee leave details
       */
      public function updateDetails($request,$id){
          $employee_leave_details = $this->getSpecificedEmployeeLeaveDetails($id);
          $employee_leave_details->month = $request->month;

          if($employee_leave_details->total_monthly_leave == $request->total_monthly_leave){
            $employee_leave_details->total_monthly_leave_remaining = $employee_leave_details->total_monthly_leave_remaining;
        }
        elseif($employee_leave_details->total_monthly_leave > $request->total_monthly_leave){
            $employee_leave_details->total_monthly_leave_remaining = $employee_leave_details->total_monthly_leave_remaining - ($employee_leave_details->total_monthly_leave - $request->total_monthly_leave);
        }
        elseif($employee_leave_details->total_monthly_leave < $request->total_monthly_leave){
          $employee_leave_details->total_monthly_leave_remaining = $employee_leave_details->total_monthly_leave_remaining + ($request->total_monthly_leave - $employee_leave_details->total_monthly_leave);
        }

          $employee_leave_details->total_monthly_leave = $request->total_monthly_leave;
          $employee_leave_details->edited_by = Auth::guard('admin')->User()->id;
          $employee_leave_details->save();
      }

      /**
       * delete employee leave
       */
      public function delete($id){
          $employee_leave = $this->getSpecificedEmployeeLeave($id);
          EmployeeLeaveDetails::where('employee_leave_id',$employee_leave->id)->delete();
          $employee_leave->delete();
      }
      /**
       * employee leave details
       */
      public function deleteDetails($id){
          $employee_leave_details = $this->getSpecificedEmployeeLeaveDetails($id);
          $employee_leave_details->delete();
      }
 }