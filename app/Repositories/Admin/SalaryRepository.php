<?php
namespace App\Repositories\Admin;

use App\Models\Salary;

class SalaryRepository{
    /**
     * show all salary sheet
     */
    public function index(){
        return Salary::with(['employee','workingday'])->orderBy('id','desc')->get();
    }

    /**
     * update salary status
     */
    public function update($request ,$id){
       $salary = $this->getSpecificSalary($id);
       $salary->status =  $request->status;
       $salary->save();
    }

    /**
     * get specific salarry
     * @param $id
     */
    public function getSpecificSalary($id){
        return Salary::with(['employee','workingday'])->where('id',$id)->first();
    }

    }
