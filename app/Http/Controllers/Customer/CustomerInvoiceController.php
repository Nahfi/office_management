<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Customer\CustomerInvoiceRepository;

class CustomerInvoiceController extends Controller
{
    /**
     * constract a method
     */
    public $customerInvoiceRepository;
    public function __construct(CustomerInvoiceRepository $customerInvoiceRepository)
    {
        $this->customerInvoiceRepository = $customerInvoiceRepository;
    }

    /**
     * show all invoices
     */
    public function index(){
        $allInvoice = $this->customerInvoiceRepository->allInvoice();
        return view('customer.pages.invoice.index',compact('allInvoice'));
    }
    /**
     * show a specific invoice
     * @param $id
     */
    public function show($id){
        $invoice = $this->customerInvoiceRepository->findSpecificInvoice($id);
        return view('customer.pages.invoice.show',compact('invoice'));
    }

    /**
     * show a specific pos invoice
     */
    public function showPos($id){
        $invoice = $this->customerInvoiceRepository->findSpecificInvoice($id);
        return view('customer.pages.invoice.pos',compact('invoice'));
    }
}