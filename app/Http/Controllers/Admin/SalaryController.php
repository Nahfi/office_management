<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Salary;
use App\Models\WorkingDay;
use App\Repositories\Admin\SalaryRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalaryController extends Controller
{
    /**
     * Construct method
     */
    public $user,$salaryRepository;
    public function __construct(SalaryRepository $salaryRepository)
    {
        $this->middleware(function($request,$next){
            $this->user = Auth::guard('admin')->User();
            return $next($request);
        });

        $this->salaryRepository = $salaryRepository;
    }

    /**
     * show all salary sheet
     */
    public function index(){

        if(is_null($this->user) || !$this->user->can('salary.update')){
            abort(403,'Unauthorized access');
        }
        $salaries = $this->salaryRepository->index();
        return view('admin.pages.salary.index',[
            'salaries' => $salaries
        ]);
    }

    /**
     * show pay slip
     * @param $id
     */
    public function show($id){
        if(is_null($this->user) || !$this->user->can('salary.update')){
            abort(403,'Unauthorized access');
        }
        $paySlip = $this->salaryRepository->getSpecificSalary($id);
        return view('admin.pages.salary.paySlip',compact('paySlip'));

    }

    /**
     * update a specefied report
     */
    public function update(Request $request,$id){
        if(is_null($this->user) || !$this->user->can('salary.update')){
            abort(403,'Unauthorized access');
        }
        $this->salaryRepository->update($request,$id);
        return back()->with('report_update_success','Report Status Updated Successfully');
    }


}
