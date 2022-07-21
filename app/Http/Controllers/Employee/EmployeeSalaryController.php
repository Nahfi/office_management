<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeSalaryController extends Controller
{

    /**
     * show all salary sheet
     */
    public function index(){

        $salaries = Salary::with(['employee','workingday'])->where('employee_id',Auth::guard('employee')->user()->id)->get();
        return view('employee.pages.salary.index',[
            'salaries' => $salaries
        ]);
    }

    /**
     * show pay slip
     * @param $id
     */
    public function show($id){

        $paySlip = Salary::with(['employee','workingday'])->where('id',$id)->first();
        return view('employee.pages.salary.paySlip',compact('paySlip'));

    }

}