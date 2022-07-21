<?php
namespace App\Repositories\Customer;

use App\Models\Invoice;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
class DashboardRepository{


    /**
     * count invoice
     */
    public function countInvoice(){
        return count(Invoice::with(['user','invoiceInfo'])->where('customer_id',Auth::guard('web')->user()->id)->latest()->get());
    }

    /**
     * count project
     */
    public function countProject(){
        return count(Project::where('customer_id',Auth::guard('web')->user()->id)->latest()->get());
    }

    /**
     * count project by status
     */
    public function countProjectByStatus($status){
        return count(Project::where('customer_id',Auth::guard('web')->user()->id)->where('status',$status)->latest()->get());
    }

    /**
     * calculate total
     * @param $field
     */
    public function calculateTotal($field){
        return (Invoice::where('customer_id',Auth::guard('web')->user()->id)->sum($field));

    }
}