<?php
namespace App\Repositories\Admin;

use App\Models\Invoice;
use App\Models\Project;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerRepository{
    public $imageService;
    public $imagename = 'default.jpg';
    public $imageLocation = 'photo/user_profile/';

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }
    /**
     * show all customer
     */
    public function index(){
        return User::with(['createdBy','editedBy'])->orderBy('id','asc')->get();
    }

    /**
     * show all trarsh employee
     */
    public function trashItems(){
       return User::onlyTrashed()->with(['createdBy','editedBy'])->orderBy('id','asc')->get();

    }
    /**
     * get specefic employee
     */
    public function getSpecificedItem($id){
        return User::with(['createdBy','editedBy'])->where('id',$id)->first();
    }

    /**
     * get specefied employee from trash
     */
    public function getSpecificedTrashItem($id){
        return User::onlyTrashed()->with(['createdBy','editedBy'])->where('id',$id)->first();
    }
     /**
     * store employees
     */
    public function create($request){
        $customer = new User();
        $customer->status = $request->status;
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->password = Hash::make($request->password);
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->created_by = Auth::guard('admin')->User()->id;
        if($request->hasFile('photo')){
            $this->imageService->upload(str_replace(' ', '', $request->name),$this->imageLocation,$request->photo);
        }
        $customer->save();

    }

    /**
     * update employee information
     */
    public function update($request,$id){
        $customer = $this->getSpecificedItem($id);
        $customer->status = $request->status;
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->edited_by = Auth::guard('admin')->User()->id;
        if($request->hasFile('photo')){
            if($customer->photo != $this->imagename){
                $this->imageService->delete($customer->photo,$this->imageLocation);
            }
            $this->imageService->upload(str_replace(' ', '', $request->name),$this->imageLocation,$request->photo);
        }
        $customer->save();

    }
     /**
     * destroy employee
     */
    public function delete($id){
        if($this->countCustomerProjects($id) > 0){
            return redirect()->route('admin.customer.index')->with('customer_delete_failed','please Delete Projects Under this customer then try again');
        }
        else if($this->countCustomerInvoice($id) > 0){
            return redirect()->route('admin.customer.index')->with('customer_delete_failed','please Delete Invoice Under this customer then try again');
        }
        else{
            $item =  $this->getSpecificedItem($id);
            $item->delete();
        }
    }

    /**
     * count customer total project
     * @param $id
     */
    public function countCustomerProjects($id){
        return count(Project::where('customer_id',$id)->get());
    }
    /**
     * count customer total invoice
     * @param $id
     */
    public function countCustomerInvoice($id){
        return count(Invoice::where('customer_id',$id)->get());
    }

     /**
     * restore employee
     */
    public function restore($id){
        $expense = $this->getSpecificedTrashItem($id);
        $expense->restore();
    }

    /**
     * parmanently delete
     */
    public function parmanentlyDelete($id){
        $employee = $this->getSpecificedTrashItem($id);
        if($employee->photo != $this->imagename){
            $this->imageService->delete($employee->photo,$this->imageLocation);
        }
        $employee->forceDelete();
    }
}