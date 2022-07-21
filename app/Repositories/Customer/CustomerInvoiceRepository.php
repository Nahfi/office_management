<?php
namespace App\Repositories\Customer;

use App\Models\Invoice;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
class CustomerInvoiceRepository{


    /**
     * get all invoice
     * @return allInvoice
     */
    public function allInvoice(){
        return Invoice::with(['user','invoiceInfo'])->latest()->get();
    }

    /**
     * find a specific invoice information
     *  @param $invoicId
     *  @return invoice
     */
    public function findSpecificInvoice($invoiceId){
        return Invoice::with(['user','invoiceInfo'])->where('id',$invoiceId)->first();
    }

}