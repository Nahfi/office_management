<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\InvoiceRepository;
use Illuminate\Support\Facades\Auth;
class InvoiceController extends Controller
{
    /**
     * constract a method
     */
    public $invoiceRepository,$user,$customers,$deletedInvoiceCount;
    public function __construct(InvoiceRepository $invoiceRepository)
    {
        $this->middleware(function($request,$next){
            $this->user = Auth::guard('admin')->User();
            return $next($request);
        });
        $this->invoiceRepository = $invoiceRepository;
        $this->customers = $this->invoiceRepository->getAllActiveCustomer();
        $this->deletedInvoiceCount = count($this->invoiceRepository->showDeletedInvoice()->toArray());

    }

    /**
     * show all invoices
     */
    public function index(){
        if(is_null($this->user) || !$this->user->can('invoice.index')){
            abort(403,'Unauthorized access');
        }
        $deletedInvoice = $this->deletedInvoiceCount;
        $allInvoice = $this->invoiceRepository->allInvoice();
        return view('admin.pages.invoice.index',compact('allInvoice','deletedInvoice'));
    }

    /**
     * create an invoice
     */
    public function create(){
        if(is_null($this->user) || !$this->user->can('invoice.create')){
            abort(403,'Unauthorized access');
        }
        $customers = $this->customers;
        return view('admin.pages.invoice.create',compact('customers'));
    }


    /**
     * Store a newly created invoice  in storage.
     */
    public function store(Request $request){
        if(is_null($this->user) || !$this->user->can('invoice.create')){
            abort(403,'Unauthorized access');
        }
        $invoice = $this->invoiceRepository->store($request);
        return redirect()->route('admin.invoice.invoice-show',$invoice->id);
    }

    /**
     * show a specific invoice
     * @param $id
     */
    public function show($id){
        if(is_null($this->user) || !$this->user->can('invoice.index')){
            abort(403,'Unauthorized access');
        }
        $invoice = $this->invoiceRepository->findSpecificInvoice($id);
        return view('admin.pages.invoice.show',compact('invoice'));
    }

    /**
     * show a specific pos invoice
     */
    public function showPos($id){
        if(is_null($this->user) || !$this->user->can('invoice.index')){
            abort(403,'Unauthorized access');
        }
        $invoice = $this->invoiceRepository->findSpecificInvoice($id);
        return view('admin.pages.invoice.pos',compact('invoice'));
    }

    /**
     * Show all deleted invoices
     */
    public function showDeletedInvoice(){
        if(is_null($this->user) || !$this->user->can('invoice.index')){
            abort(403,'Unauthorized access');
        }
        $allInvoice =$this->invoiceRepository->showDeletedInvoice();
        $deletedInvoice = $this->deletedInvoiceCount;
        return view('admin.pages.invoice.index',compact('allInvoice','deletedInvoice'));
    }


    /**
     * Show a edit form for a specefic invoice
     */
    public function edit($id){
        if(is_null($this->user) || !$this->user->can('invoice.edit')){
            abort(403,'Unauthorized access');
        }
        $invoice = $this->invoiceRepository->findSpecificInvoice($id);
        return view('admin.pages.invoice.edit',compact('invoice'));
    }

   /**
     * Update the specified invoice resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request ,$id){
        if(is_null($this->user) || !$this->user->can('invoice.update')){
            abort(403,'Unauthorized access');
        }
           $response = $this->invoiceRepository->updateInvoiceInformation($request,$id);
           if($response == 'discount_error'){
                return redirect()->back()->with('%_Discount_can_not_be_greater_than_100','% Discount can not be greater than 100');
           }
           if($response == 'flat_error'){
                return redirect()->back()->with('flat_Discount_can_not_be_greater_than_total_amount','flat Discount can not be greater than total amount');
           }
           else{
            return back()->with('Information_updated', 'Information_updated');
           }

    }

   /**
     * Update the specified invoice resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateInvoiceInfo(Request $request ,$id){
        if(is_null($this->user) || !$this->user->can('invoice.update')){
            abort(403,'Unauthorized access');
        }
        if($request->get('delete')){
            $this->invoiceRepository->deleteService($request,$id);
            return back()->with('service_deleted', 'service deleted');
         }
        if($request->get('save')){
            $this->invoiceRepository->updateInvoiceService($request,$id);
            return back()->with('service_information_updated', 'service_information_updated');
         }
    }

    /**
     * Destroy a specefic package
     * @param int $id
     */
    public function destroy($id){
        if(is_null($this->user) || !$this->user->can('invoice.delete')){
            abort(403,'Unauthorized access');
        }
        $this->invoiceRepository->delete($id);
        return back()->with('delete_success',' invoice Deleted Successfully');
    }

    /**
     * Restore form trash
     */
    public function restore($id){
        if(is_null($this->user) || !$this->user->can('invoice.delete')){
            abort(403,'Unauthorized access');
        }
        $this->invoiceRepository->restore($id);
        return back()->with('restore_success',' invoice Restore Successfully');
    }

    /**
     * Parmanent Delete
     */
    public function parmanentDelete($id){
        if(is_null($this->user) || !$this->user->can('invoice.parmanentDelete')){
            abort(403,'Unauthorized access');
        }
        $this->invoiceRepository->parmanentDelete($id);
        return back()->with('parmanent_delete_success','Parmanenet Delete Successfull');
    }

    /**
     * Mark  all selected customer
     */
    public function mark(Request $request){
        $request->validate([
            'type' => 'required',
            'ids' => 'required'
        ]);
        $type = request()->get('type');
        $ids = request()->get('ids');
        if($type == 'Delete'){
             if(is_null($this->user) || !$this->user->can('invoice.delete')){
                 abort(403,'Unauthorized access');
             }
             $this->invoiceRepository->markDelete($ids);
             return back()->with('mark_delete_success','All invoice Deleted Successfully');
        }
        else if($type == 'Restore'){
            if(is_null($this->user) || !$this->user->can('invoice.delete')){
                abort(403,'Unauthorized access');
            }
            $this->invoiceRepository->markRestore($ids);
            return back()->with('mark_restore_success','All invoice Restore Successfully');
       }
       else if($type == 'ParmanentDelete'){
        if(is_null($this->user) || !$this->user->can('invoice.parmanentDelete')){
            abort(403,'Unauthorized access');
        }
        $this->invoiceRepository->markParmanentlyDelete($ids);
        return back()->with('mark_parmanent_delete_success','All invoice Parmanently Deleted Successfully');
       }
    }
   /**
     * find a specific Customer
     * @param $id
     * @return jsonData
     */
    public function findSpecificCustomer($id){
        if(is_null($this->user) || !$this->user->can('invoice.create')){
            abort(403,'Unauthorized access');
        }
        $customer = $this->invoiceRepository->getSpecficeCustomer($id);
        return json_encode([
            "customer" => $customer
        ]);
    }

}