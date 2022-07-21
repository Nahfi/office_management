<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeLeaveStoreDetailsRequest;
use App\Http\Requests\EmployeeLeaveStoreRequest;
use App\Http\Requests\EmployeeLeaveUpdateDetailsRequest;
use App\Http\Requests\EmployeeLeaveUpdateRequest;
use App\Models\Employee;
use App\Models\EmployeeLeave;
use App\Models\EmployeeLeaveDetails;
use App\Repositories\Admin\EmployeeLeaveRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    /**
     * Construct method
     */
    public $user,$employeeLeaveRepository,$totalTrashItem;
    public function __construct(EmployeeLeaveRepository $employeeLeaveRepository)
    {
        $this->middleware(function($request,$next){
            $this->user = Auth::guard('admin')->User();
            return $next($request);
        });
        $this->employeeLeaveRepository = $employeeLeaveRepository;
    }

    /**
     * get all employee leave
     */
    public function index(){
        if(is_null($this->user) || !$this->user->can('employeeLeave.index')){
            abort(403,'Unauthorized access');
        }
        $employee_leaves = $this->employeeLeaveRepository->index();
        return view('admin.pages.leave.employeeLeave.index',[
            'employee_leaves' => $employee_leaves
        ]);
    }

    /**
     * get all employee leave details
     */
    public function showDetails($id){
        if(is_null($this->user) || !$this->user->can('employeeLeave.index')){
            abort(403,'Unauthorized access');
        }
        $employee_leave_details = $this->employeeLeaveRepository->showDetails($id);
        $employee_leave = EmployeeLeave::where('id',$id)->first();
        return view('admin.pages.leave.employeeLeave.showDetails',[
            'employee_leave_details' => $employee_leave_details,
            'employee_leave' => $employee_leave
        ]);
    }

    /**
     * show a form for createing new item
     */
    public function create(){
        if(is_null($this->user) || !$this->user->can('employeeLeave.create')){
            abort(403,'Unauthorized access');
        }
        $employees = Employee::all();
        return view('admin.pages.leave.employeeLeave.create',[
            'employees' => $employees
        ]);
    }
    /**
     * store a new item in specificed storage
     */
    public function store(EmployeeLeaveStoreRequest $request){
        if(is_null($this->user) || !$this->user->can('employeeLeave.create')){
            abort(403,'Unauthorized access');
        }
        $this->employeeLeaveRepository->create($request);
        return back()->with('employee_leave_store_success','Employee yearly leave store successfully');
    }
    /**
     * store a new employee leave month under a employee leave year
     */
    public function storeDetails(EmployeeLeaveStoreDetailsRequest $request,$id){
        if(is_null($this->user) || !$this->user->can('employeeLeave.create')){
            abort(403,'Unauthorized access');
        }
        $yearlyLeaveInfo = EmployeeLeave::where('id',$id)->first();
        $monthlyLeaveInfoSum = EmployeeLeaveDetails::where('employee_leave_id',$id)->sum('total_monthly_leave');
        if($monthlyLeaveInfoSum >= $yearlyLeaveInfo->total_yearly_leave){
            return back()->with('total_monthly_leave_is_greater','Total Monthly Leavef or all month can not greate then total yearly leave');
        }
        $this->employeeLeaveRepository->createDetails($request,$id);
        return back()->with('employee_leave_store_details_success','Employee Monthly Leave Store Successfully');
    }

    /**
     * show a edit form for updating employee leave
     */
    public function edit($id){
        if(is_null($this->user) || !$this->user->can('employeeLeave.update')){
            abort(403,'Unauthorized access');
        }
        $employee_leave = $this->employeeLeaveRepository->getSpecificedEmployeeLeave($id);
        $employees = Employee::all();
        return view('admin.pages.leave.employeeLeave.edit',[
            'employee_leave' => $employee_leave,
            'employees' => $employees
        ]);
    }
    /**
     * update a employee leave
     */
    public function update(EmployeeLeaveUpdateRequest $request,$id){
        if(is_null($this->user) || !$this->user->can('employeeLeave.update')){
            abort(403,'Unauthorized access');
        }
        $this->employeeLeaveRepository->update($request,$id);
        return back()->with('employee_leave_update_success','Employee yearly leave update success');
    }

    /**
     * update employee monthly leave details
     */
    public function updateDetails(EmployeeLeaveUpdateDetailsRequest $request,$id){
        if(is_null($this->user) || !$this->user->can('employeeLeave.update')){
            abort(403,'Unauthorized access');
        }
        $this->employeeLeaveRepository->updateDetails($request,$id);
        return back()->with('employee_leave_details_update_success','Employee Monthly Leave Update Success');
    }

    /**
     * destroy employee leave
     */
    public function destroy($id){
        if(is_null($this->user) || !$this->user->can('employeeLeave.delete')){
            abort(403,'Unauthorized access');
        }
        $this->employeeLeaveRepository->delete($id);
        return back()->with('employee_leave_destroy_success','Employee Leave Destroy Sucessfully');
    }

    /**
     * destroy employee Leave details
     */
    public function destroyDetails($id){
        if(is_null($this->user) || !$this->user->can('employeeLeave.delete')){
            abort(403,'Unauthorized access');
        }
        $this->employeeLeaveRepository->deleteDetails($id);
        return back()->with('employee_leave_details_destroy_success','Empmloyee Leave Details Destroy Successfully');
    }
}
