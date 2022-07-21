<?php
namespace App\Repositories\Admin;

use App\Models\Admin;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\Salary;
use App\Models\User;
use Carbon\Carbon;

class HomeRepository{
    /**
     * count all information
     */
    public function index(){
        
        $data[] ='';

        $data['admin'] = Admin::count();
        $data['employee'] = Employee::count();
        $data['todays_leave'] = Attendance::whereDate('date_time',Carbon::now()->format('Y-m-d'))->where('status','Leave')->count();
        $data['todays_present'] = Attendance::whereDate('date_time',Carbon::now()->format('Y-m-d'))->where('status','Present')->count();
        $data['todays_absent'] = Attendance::whereDate('date_time',Carbon::now()->format('Y-m-d'))->where('status','Absent')->count();
        $data['customer'] = User::count();
        $data['invoice'] = Invoice::count();
        $data['income'] = Invoice::sum('grand_total');
        $data['amount_paid'] = Invoice::sum('amount_paid');
        $data['total_due'] = Invoice::sum('total_due');
        $data['project'] = Project::count();
        $data['other_expense'] = Expense::sum('amount');
        $data['salary_expense'] = Salary::sum('payable_salary');


        return $data;

    }
}