<?php
namespace App\Repositories\Admin;

use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class ExpenseRepository{
     /**
     * @return App\Models\Expense
     * 
     */
    public function index(){
        return Expense::with(['category','createdBy','editedBy'])->orderby('id','desc')->get();
    }
    /**
     * @return App\Models\Expense deleted
     */
    public function showDeletedExpense(){
        return Expense::with(['category','createdBy','editedBy'])->onlyTrashed()->orderBy('id','desc')->get();
    }
    
    /**
     * @return App\Models\Expense where status is Active
     */
    public function activeExpense(){
        $expenses = Expense::with(['category','createdBy','editedBy'])->where('status','Active')->orderBy('id','desc')->get();
        return $expenses;
    }
    /**
     * @return App\Models\Expense where status is DeActive
     */
    public function deActiveExpense(){
        $expenses = Expense::with(['category','createdBy','editedBy'])->where('status','DeActive')->orderBy('id','desc')->get();
        return $expenses;
    }
    /**
     * @return a specefic category
     * @param int $id
     */
    public function getSpecficeExpense($id){
        return Expense::with(['category','createdBy','editedBy'])->where('id',$id)->first();
    }
    /**
     * @param int $id
     */
    public function getSpecficeTrashExpense($id){
        return Expense::with(['category','createdBy','editedBy'])->onlyTrashed()->where('id',$id)->first();
    }
    /**
     * store new expense in specefice storage
     * @param \Rquests\ExpenseRequest $request
     */
    public function create($request){
        $expense = new Expense();
        $expense->category_id = $request->category_id;
        $expense->name = $request->name;
        $expense->amount = $request->amount;
        $expense->status = $request->status;
        $expense->created_by = Auth::guard('admin')->User()->id;
        $expense->save();
        return $expense;
    }
    /**
     * @param \Rquests\ExpenseUpdateRequest $request
     * @param int $id
     * 
     */
    public function update($request,$id){
        $expense = $this->getSpecficeExpense($id);
        $expense->category_id = $request->category_id;
        $expense->name = $request->name;
        $expense->amount = $request->amount;
        $expense->status = $request->status;
        $expense->edited_by = Auth::guard('admin')->user()->id;
        $expense->save();
        return $expense;
    }

    /**
     * Destroy a specfic Category
     * @param int $id
     */
    public function delete($id){
        $expense =   $this->getSpecficeExpense($id);
        $expense->delete();
        return back();
    }
     /**
     * Restore from trash
     */
    public function restore($id){
        $expense = $this->getSpecficeTrashExpense($id);
        $expense->restore();
    }

    /**
     * Parmanent Delete
     * @param int $id
     */
    public function parmanentDelete($id){
        $expense = Expense::onlyTrashed()->where('id',$id)->first();
        $expense->forceDelete();
    }

    /**
     * mark active all selected expense 
     * @param array $ids
     * @param string type
     * 
     */
    public function markActive($type,$ids){
        Expense::whereIn('id',$ids)->update([
            'status' => 'Active',
        ]);
        return $type;
    }
    /**
     * mark deactive all selected expense 
     * @param array $ids
     * @param string type
     * 
     */
    public function markDeActive($type,$ids){
        Expense::whereIn('id',$ids)->update([
            'status' => 'DeActive',
        ]);
        return $type;
    }
    /**
     * mark delete all selected expense 
     * @param array $ids
     * @param string type
     * 
     */
    public function markDelete($type,$ids){
        Expense::whereIn('id',$ids)->delete();
        return $type;
    }
    /**
     * mark parmanent delete all selected expense category
     */
    public function markParmanentlyDelete($ids){
        Expense::whereIn('id',$ids)->forceDelete();
    }
    /**
     * mark restore all selected expense 
     * @param array $ids
     * @param string type
     * 
     */
    public function markRestore($type,$ids){
        Expense::onlyTrashed()->whereIn('id',$ids)->restore();
        return $type;
    }

}