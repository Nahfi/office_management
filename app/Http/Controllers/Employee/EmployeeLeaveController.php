<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\EmployeeLeave;
use App\Repositories\Employee\LeaveRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeLeaveController extends Controller
{
     /**
     * constract a method
     */
    public $user, $leaveRepository;
   
    public function __construct(LeaveRepository $leaveRepository)
    {
        $this->middleware(function($request,$next){
            $this->user = Auth::guard('employee')->User();
            return $next($request);
        });
        $this->leaveRepository = $leaveRepository;
       
    }
    /**
     * show all leave list
     */
    public function index(){
        $leaves = $this->leaveRepository->index();
        return view('employee.pages.leave.index',[
            'leaves' => $leaves
        ]);
    }

    /**
     * show a specificed leave
     */
    public function show($id){
        $leaveDetails = $this->leaveRepository->show($id);
        return view('employee.pages.leave.show',[
            'leaveDetails' => $leaveDetails
        ]);
    }
}
