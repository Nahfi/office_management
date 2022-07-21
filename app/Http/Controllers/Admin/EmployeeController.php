<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Models\Employee;
use App\Repositories\Admin\EmployeeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Contracts\Role;

class EmployeeController extends Controller
{
     /**
     * Construct method
     */
    public $user,$employeeRepository,$totalTrashItem;
    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->middleware(function($request,$next){
            $this->user = Auth::guard('admin')->User();
            return $next($request);
        });
        $this->employeeRepository = $employeeRepository;
        $this->totalTrashItem = Employee::trashItemCount();
    }
    /**
     * show all employee
     */
    public function index(){
        if(is_null($this->user) || !$this->user->can('employee.index')){
            abort(403,'Unauthorized access');
        }
        $employees = $this->employeeRepository->index();
        $totalTrashItem = $this->totalTrashItem;
        return view('admin.pages.employee.index',[
            'employees' => $employees,
            'totalTrashItem' => $totalTrashItem
        ]);
    }

    /**
     * show all trash employee
     */
    public function trashEmployee(){
        if(is_null($this->user) || !$this->user->can('employee.index')){
            abort(403,'Unauthorized access');
        }
        $employees = $this->employeeRepository->trashItems();
        $totalTrashItem = $this->totalTrashItem;
        return view('admin.pages.employee.index',[
            'employees' => $employees,
            'totalTrashItem' => $totalTrashItem
        ]);
    }
    /**
     * show create new employee form
     */
    public function create(){
        if(is_null($this->user) || !$this->user->can('employee.create')){
            abort(403,'Unauthorized access');
        }
        $roles = DB::table('roles')->get();
        return view('admin.pages.employee.create',[
            'roles' => $roles
        ]);
    }

    /**
     * Store a new emmpoyee
     */
    public function store(EmployeeStoreRequest $request){
        if(is_null($this->user) || !$this->user->can('employee.create')){
            abort(403,'Unauthorized access');
        }
        $this->employeeRepository->create($request);
        return back()->with('employee_store_success','Employee Store Successfully');
    }

    /**
     * show a sepecefiec employee
     */
    public function show($id){
        if(is_null($this->user) || !$this->user->can('employee.index')){
            abort(403,'Unauthorized access');
        }
        $employee = $this->employeeRepository->getSpecificedItem($id);
        return view('admin.pages.employee.show',[
            'employee' => $employee
        ]);
    }

    /**
     * shoa a edit form of  a employee
     */
    public function edit($id){
        if(is_null($this->user) || !$this->user->can('employee.edit')){
            abort(403,'Unauthorized access');
        }
        $employee = $this->employeeRepository->getSpecificedItem($id);
        $roles = DB::table('roles')->get();
        return view('admin.pages.employee.edit',[
            'employee' => $employee,
            'roles' => $roles
        ]);
    }

    /**
     * update a specefied employee
     */
    public function update(EmployeeUpdateRequest $request,$id){
        if(is_null($this->user) || !$this->user->can('employee.edit')){
            abort(403,'Unauthorized access');
        }
        $this->employeeRepository->update($request,$id);
        return back()->with('employee_update_success','Employee Update Successfully');
    }

    /**
     * delete a specefit employee
     */
    public function destroy($id){
        if(is_null($this->user) || !$this->user->can('employee.delete')){
            abort(403,'Unauthorized access');
        }
        $this->employeeRepository->delete($id);
        return back()->with('employee_delete_success','Employee Delete Successfully');
    }
    /**
     * restore a specefied employee
     */
    public function restore($id){
        if(is_null($this->user) || !$this->user->can('employee.restore')){
            abort(403,'Unauthorized access');
        }
        $this->employeeRepository->restore($id);
        return back()->with('employee_delete_success','Employee Delete Successfully');
    }
    /**
     * parmanently delete a employee
     */
    public function parmanentDelete($id){
        if(is_null($this->user) || !$this->user->can('employee.parmanentDelete')){
            abort(403,'Unauthorized access');
        }
        $this->employeeRepository->parmanentlyDelete($id);
        return back()->with('employee_parmanent_delete_success','Employee Parmanently Delete Successfulyy');
    }
}