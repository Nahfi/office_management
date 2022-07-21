<?php
namespace App\Repositories\Admin;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\EmployeeLeave;
use App\Models\LeaveRequest;
use App\Models\MeetingReport;
use App\Models\Project;
use App\Models\ProjectTestingReport;
use App\Models\Report;
use App\Models\Salary;
use App\Services\ImageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeRepository{
    public $imageService;
    public $imagename = 'default.jpg';
    public $imageLocation = 'photo/employee_profile/';

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }
    /**
     * show all employee
     */
    public function index(){
        return Employee::with(['createdBy','editedBy'])->orderBy('id','asc')->get();

    }

    /**
     * show all trarsh employee
     */
    public function trashItems(){
       return Employee::onlyTrashed()->with(['createdBy','editedBy'])->orderBy('id','asc')->get();

    }
    /**
     * get specefic employee
     */
    public function getSpecificedItem($id){
        return Employee::with(['createdBy','editedBy'])->where('id',$id)->first();
    }

    /**
     * get specefied employee from trash
     */
    public function getSpecificedTrashItem($id){
        return Employee::onlyTrashed()->with(['createdBy','editedBy'])->where('id',$id)->first();
    }
    /**
     * store employees
     */
    public function create($request){
        $employee = new Employee();
        $employee->status = $request->status;
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->password =  Hash::make($request->password);
        $employee->salary = $request->salary;
        $employee->phone = $request->phone;
        $employee->address = $request->address;
        $employee->national_id = $request->national_id;
        $employee->father_name = $request->father_name;
        $employee->mother_name = $request->mother_name;
        $employee->guardian_phone = $request->guardian_phone;
        $employee->created_by = Auth::guard('admin')->User()->id;
        if($request->hasFile('photo')){
            $this->imageService->upload(str_replace(' ', '', $request->name),$this->imageLocation,$request->photo);
        }
        $employee->save();
    }

    /**
     * update employee information
     */
    public function update($request,$id){
        $employee = $this->getSpecificedItem($id);
        $employee->status = $request->status;
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->salary = $request->salary;
        $employee->address = $request->address;
        $employee->national_id = $request->national_id;
        $employee->father_name = $request->father_name;
        $employee->mother_name = $request->mother_name;
        $employee->guardian_phone = $request->guardian_phone;
        $employee->edited_by = Auth::guard('admin')->User()->id;
        if($request->hasFile('photo')){
            if($employee->photo != $this->imagename){
                $this->imageService->delete($employee->photo,$this->imageLocation);
            }
            $this->imageService->upload(str_replace(' ', '', $request->name),$this->imageLocation,$request->photo);
        }
        $employee->save();

    }

    /**
     * destroy employee
     */
    public function delete($id){
        if($this->countEmployeeProjects($id) > 0){
            return redirect()->route('admin.employee.index')->with('employee_delete_failed','please Delete Projects Under this employee then try again');
        }
        if($this->countEmployeeAssignTestProjects($id) > 0){
            return redirect()->route('admin.employee.index')->with('employee_delete_failed','please Delete  assign testing project  Under this employee then try again');
        }
        else if($this->countEmployeeTestingProjects($id) > 0){
            return redirect()->route('admin.employee.index')->with('employee_delete_failed','please Delete Testing Project Report  Under this employee then try again');
        }
        else if($this->countEmployeeWorkReport($id) > 0){
            return redirect()->route('admin.employee.index')->with('employee_delete_failed','please Delete Work Report Under this employee then try again');
        }
        else if($this->countEmployeeMeetingReport($id) > 0){
            return redirect()->route('admin.employee.index')->with('employee_delete_failed','please Delete Meeting Report Under this employee then try again');
        }
        else if($this->countEmployeeSalary($id) > 0){
            return redirect()->route('admin.employee.index')->with('employee_delete_failed','please Delete Salary Under this employee then try again');
        }
        else if($this->countEmployeeLeaveRequest($id) > 0){
            return redirect()->route('admin.employee.index')->with('employee_delete_failed','please Delete Leave Request Under this employee then try again');
        }
        else if($this->countEmployeeAttendances($id) > 0){
            return redirect()->route('admin.employee.index')->with('employee_delete_failed','please Delete Attendances Under this employee then try again');
        }
        else if($this->countEmployeeLeaves($id) > 0){
            return redirect()->route('admin.employee.index')->with('employee_delete_failed','please Delete Attendances Under this employee then try again');
        }
        else{
            $item =  $this->getSpecificedItem($id);
            $item->delete();
        }

    }

    /**
     * count total employee project
     * @param $id
     */
    public function countEmployeeProjects($id){
        return Project::where('employee_id',$id)->count();
    }
    /**
     * count total employee assign test project
     * @param $id
     */
    public function countEmployeeAssignTestProjects($id){
        return Project::where('testing_employee_id',$id)->count();
    }
    /**
     * count total employee testiing project
     * @param $id
     */
    public function countEmployeeTestingProjects($id){
        return ProjectTestingReport::where('employee_id',$id)->count();
    }

    /**
     * count total employee work report
     * @param $id
     */
    public function countEmployeeWorkReport($id){
        return Report::where('employee_id',$id)->count();
    }

    /**
     * count total meeting work report
     * @param $id
     */
    public function countEmployeeMeetingReport($id){
        return MeetingReport::where('employee_id',$id)->count();
    }

    /**
     * count total meeting work report
     * @param $id
     */
    public function countEmployeeSalary($id){
        return Salary::where('employee_id',$id)->count();
    }
    /**
     * count total  LeaveRequest
     * @param $id
     */
    public function countEmployeeLeaveRequest($id){
        return LeaveRequest::where('employee_id',$id)->count();
    }
    /**
     * count total  employee Attendance
     * @param $id
     */
    public function countEmployeeAttendances($id){
        return Attendance::where('employee_id',$id)->count();
    }
    /**
     * count total  employee leaves
     * @param $id
     */
    public function countEmployeeLeaves($id){
        return EmployeeLeave::where('employee_id',$id)->count();
    }

    /**
     * restore employee
     */
    public function restore($id){
        $expense = $this->getSpecificedTrashItem($id);
        $expense->restore();
    }

    /**
     * parmanently delete
     */
    public function parmanentlyDelete($id){
        $employee = $this->getSpecificedTrashItem($id);
        if($employee->photo != $this->imagename){
            $this->imageService->delete($employee->photo,$this->imageLocation);
        }
        $employee->forceDelete();
    }




}