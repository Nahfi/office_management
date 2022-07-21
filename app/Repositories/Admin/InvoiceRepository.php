<?php
namespace App\Repositories\Admin;
use App\Models\Invoice;
use App\Models\InvoiceInfo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class InvoiceRepository{

     /**
     * store newly created invoice into database
     * @param invoiceStroeRequest $request
     */
    public function store($request){
        $invoice = new Invoice();
        $invoice_id = $this->genarateInvoiceId();
        $invoice->invoice_id =  $invoice_id;
        $invoice->customer_id =  $request->customer_id;
        $invoice->sub_total =  $request->sub_total? $request->sub_total:null;
        $invoice->discount_type =  $request->discount_type;
        $invoice->discount =  $request->discount_amount ? $request->discount_amount :null;
        $invoice->tax =  $request->tax ? $request->tax:null;
        $invoice-> grand_total=  $request->grand_total ? $request->grand_total:null;
        $invoice->amount_paid=  $request->paid ? $request->paid:null;
        $invoice->total_due=  $request->due ? $request->due:null;
        $invoice->due_date =  $request->due_date? $request->due_date:null;
        $invoice->note =  $request->note?$request->note:"thank you for gracing us with your presence.";
        $invoice->save();
        if($invoice){
            $this->storeInvoiceInfo($invoice->id,$request);
        }
         return $invoice;
    }

    /**
     * store invoiceInformation Data
     * @param $request, $invoiceId
     */
    public function storeInvoiceInfo($invoiceId,$request){
        foreach($request->product_name as $i => $product_name)
        {
            $invoice_info = new InvoiceInfo();
            $invoice_info->invoice_id= $invoiceId;
            $invoice_info->product_name = $product_name;
            $invoice_info->quantity =  $request->quantity[$i];
            $invoice_info->price =  $request->price[$i];
            $invoice_info->total =  $request->total[$i];
            $invoice_info ->save();
        }
    }

    /**
     * find a specific invoice information
     *  @param $invoicId
     *  @return invoice
     */
    public function findSpecificInvoice($invoiceId){
        return Invoice::with(['user','invoiceInfo'])->where('id',$invoiceId)->first();
    }
        /**
     * find a specific invoice information
     * @param $invoicId
     * @return invoiceinfo
     */
    public function findSpecificInvoiceInfo($invoicId){
        $trashInvoice = $this->getSpecficeTrashInvoice($invoicId);
        if($trashInvoice){
            abort(403,'Unauthorized access');
        }
        else{
            return InvoiceInfo::where('invoice_id',$invoicId)->get();
        }
    }

    /**
     * @return a specific trashed invoice
     * @param int $id
     */
    public function getSpecficeTrashInvoice($id){
        return Invoice::with(['user','invoiceInfo'])->onlyTrashed()->where('id',$id)->first();
    }

    /**
     * get all deleted invoices
     * @return allDeletedInvoice
     */
    public function showDeletedInvoice(){
        return Invoice::with(['user','invoiceInfo'])->onlyTrashed()->get();
    }

   /**
     * get all active Employee
     * @return $allEmployee
     */
    public function getAllActiveCustomer(){
        return User::where('status','Active')->get();
    }

    /**
     * get all invoice
     * @return allInvoice
     */
    public function allInvoice(){
        return Invoice::with(['user','invoiceInfo'])->latest()->get();
    }

    /**
     * calculate GrandTotal
     * @param $subTotal,$dicountType,$discount
     * @return $grandTotal
     */
    public function calculateDiscount($subTotal,$discountType,$discount){
        if($discountType == '%'){
            if($discount <= 100){
                return $subTotal - ($subTotal*($discount/100));
            }
            else{
                return 'discount_error';
            }
        }
        else{
            if($subTotal < $discount){
                return 'flat_error';
            }
            else{
                return $subTotal - $discount;
            }
        }

    }

    /**
     * calcaulate tax
     * @param $graundTotal,$tax
     * @return $totalAfterTax
     */
    public function calculateTax($graundTotal,$tax){
        if($tax == 0){
            return 0;
        }
        else{
            return ($graundTotal*($tax/100));
        }
    }
    /**
     * @return a specific service form invoiceInfo
     * @param int $id
     */
    public function findSpceficInvoiceService($id){
        return InvoiceInfo::where('id',$id)->first();
    }

    /**
     * delete a service form invoice
     * @param int $id , $request
     */
    public function deleteService($request,$id){
        $invoiceService = $this->findSpceficInvoiceService($id);
        $invoiceInformation = $this->findSpecificInvoiceInfo($invoiceService->invoice_id)->toArray();
        if(count($invoiceInformation) == 1){
            $this->deleteInvoice($invoiceService->invoice_id);
        }
        else{
            $this->updateInvoice($invoiceService);
        }
        $invoiceService->delete();
    }

    /**
     * update  a specific  service form invoice
     * @param int $id , $request
     */
    public function updateInvoiceService($request,$id){
        $invoiceService = $this->findSpceficInvoiceService($id);
        $invoiceService ->price = $request->price;
        $invoiceService ->quantity =$request->quantity;
        $invoiceService ->total = floatval($request->price * $request->quantity);
        $invoiceService->save();
        $this->updateInvoiceWithUpdatedService($invoiceService->invoice_id);
    }

    /**
     * update invoice with updated invoice_service
     * @param int $invoiceId
     * @return void
     */
    public function updateInvoiceWithUpdatedService($invoiceId){
        $invoice = $this->findSpecificInvoice($invoiceId);
        $subTotal = $this->calculateSubTotal($invoice->invoiceInfo);
        $invoice ->sub_total = $subTotal;
        $grandTotal = floatval($this->calculateDiscount( $invoice->sub_total,$invoice->discount_type,$invoice->discount));
        $totalTax = floatval($this->calculateTax($grandTotal,$invoice->tax));
        $totalGrandTotal = $grandTotal +  $totalTax;
        $invoice->grand_total = $totalGrandTotal;
        $invoice->total_due = $totalGrandTotal  - $invoice->amount_paid;
        $invoice->save();
    }

    /**
     * calculate subtotal
     * @param  $invoiceInfo
     * @return void
     * @return $subTotal
     */
    public function calculateSubTotal($invoiceInfos){
        $subTotal = 0;
        foreach($invoiceInfos as $invoiceInfo){
            $subTotal = $subTotal + $invoiceInfo->total;
        }
        return $subTotal;
    }
    /**
     * delete a specefic invoice form storage
     * @param int $invoiceId
     */
    public function deleteInvoice($invoiceId){
        $invoice = $this->findSpecificInvoice($invoiceId);
        $invoice->forceDelete();
    }


    /**
     * update invoice
     * @param $invoiceService
     */
    public function updateInvoice($invoiceService){
        $invoice = $this->findSpecificInvoice($invoiceService->invoice_id);
        $subTotal = $invoice->sub_total - $invoiceService->total;
        $invoice->sub_total = $subTotal;
        $grandTotal = floatval($this->calculateDiscount( $invoice->sub_total,$invoice->discount_type,$invoice->discount));
        $totalTax = floatval($this->calculateTax($grandTotal,$invoice->tax));
        $totalGrandTotal = $grandTotal +  $totalTax;
        $invoice->grand_total = $totalGrandTotal;
        $invoice->total_due = $totalGrandTotal  - $invoice->amount_paid;
        $invoice->save();
    }





    /**
     * update invoice comment
     * @param $id ,$request
     */
    public function updateInvoiceInformation($request,$id){
        $request->validate([
          'type'=>'required',
          'discount'=>'numeric',
          'paid'=>'numeric',
          'tax'=>'numeric',
        ]);

        $invoice = $this->findSpecificInvoice($id);
        $discount = $request->discount ? $request->discount :0;
        $tax = $request->tax ? $request->tax :0;
        $grandTotal =($this->calculateDiscount($invoice->sub_total,$request->type,$discount));

        if($grandTotal == 'discount_error'&& gettype($grandTotal)=='string'){;
            return 'discount_error';
        }
       else if($grandTotal == 'flat_error' && gettype($grandTotal)=='string'  ){
            return 'flat_error';
        }
        else{
            $totalTax = floatval($this->calculateTax($grandTotal,$tax));
            $grandTotalWithTax =  floatval($grandTotal) +$totalTax;
            $invoice->grand_total = $grandTotalWithTax;
            $invoice->discount = $discount;
            $invoice->tax = $tax;
            $invoice->discount_type = $request->type;
            if($request->paid !='' ){
                $this->updatePaymentWithDiscount($invoice,$grandTotalWithTax,$request->paid);
            }
            else{
                $this->updatePaymentWithDiscount($invoice,$grandTotalWithTax,0);
            }
        }
        $invoice ->comments = $request->Comment;
        $invoice -> save();
    }



    /**
     * update a specif invoice payment with discount
     * @param $invoice,$grandTotal,$paid
     */
    public function updatePaymentWithDiscount($invoice,$grandTotal,$paid){
        $invoice->amount_paid = $paid;
        $invoice->total_due = $grandTotal - $paid;
    }
    /**
     * update a specific invoice payment without discount
     * @param $invoice ,$amount
     */
    public function updatePayment($invoice ,$amount){
        $invoice->amount_paid = $amount;
        $invoice->total_due = $invoice->grandtotal - $amount;
    }



    /**
     * Destroy a specfic invoice
     * @param int $id
     */
    public function delete($id){
        $invoice =   $this->findSpecificInvoice($id);
        $invoice->delete();
    }
     /**
     * Restore from trash
     */
    public function restore($id){
        $invoice = $this->getSpecficeTrashInvoice($id);
        $invoice->restore();
    }
     /**
     * mark delete all selected expense invoice
     * @param array $ids
     * @param string type
     *
     */
    public function markDelete($ids){
        Invoice::with(['user','invoiceInfo'])->whereIn('id',$ids)->delete();
    }

    /**
     * Parmanent Delete of a package
     * @param int $id
     */
    public function parmanentDelete($id){
        $this->getSpecficeTrashInvoice($id)->forceDelete();
        $this->deleteInvoiceInfo($id);
    }
    /**
     * delete invoice info for a specefic invoice
     * @param $invoiceId
     */
    public function deleteInvoiceInfo($invoiceId){
        InvoiceInfo::where('invoice_id',$invoiceId)->delete();
    }

    /**
     * mark restore all selected Invoice
     * @param array $ids
     * @param string type
     *
     */
    public function markRestore($ids){
        Invoice::with(['user','invoiceInfo'])->onlyTrashed()->whereIn('id',$ids)->restore();
    }

    /**
     * mark parmanent delete all selected package
     */
    public function markParmanentlyDelete($ids){
        Invoice::with(['user','invoiceInfo'])->onlyTrashed()->whereIn('id',$ids)->forceDelete();
        $this->markDeleteInvoiceInfo($ids);
    }

    /**
     * delete invoice info
     * @param $invoiceIds
     */
    public function markDeleteInvoiceInfo($invoiceIds){
        InvoiceInfo::whereIn('invoice_id',$invoiceIds)->delete();
    }
    /**
     * get a single customerInfo
     * @param $id
     * @return $customer
     */
    public function getSpecficeCustomer($id){
        return User::where("id",$id)->first();
    }

    /**
     * public function genrate invoice id
     * @param $totalInvoice
     */
    public function genarateInvoiceId(){
        return date('Ymd').rand(100,999);
    }

}