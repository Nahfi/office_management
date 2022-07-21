<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Customer\DashboardRepository;

class DashboardController extends Controller
{

    /**
     * constract a method
     */
    public $dashboardRepository;
    public function __construct()
    {
        $this->dashboardRepository = new dashboardRepository();
    }

    /**
     * Show the user dashboard
     */
     public function index(){
        $totalProject =  $this->dashboardRepository->countProject();
        $totalInvoice =  $this->dashboardRepository->countInvoice();
        $assignedProject = $this->dashboardRepository->countProjectByStatus("assigned");
        $runningProject = $this->dashboardRepository->countProjectByStatus("running");
        $completedProject = $this->dashboardRepository->countProjectByStatus("completed");
        $totalDue =  $this->dashboardRepository->calculateTotal('total_due');
        $totalPaid =  $this->dashboardRepository->calculateTotal('amount_paid');
        $totalSpend =  $this->dashboardRepository->calculateTotal('grand_total');
        return view('customer.pages.home.index',compact('totalProject','assignedProject','runningProject','completedProject','totalInvoice','totalDue','totalPaid','totalSpend'));
     }
}