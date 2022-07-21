<?php
namespace App\Repositories\Admin;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\Auth;

class ExpenseCategoryRepository{
    /**
     * @return App\Models\ExpenseCategory
     * 
     */
    public function index(){
        return ExpenseCategory::with(['createdBy','editedBy'])->orderby('id','desc')->get();
    }

    /**
     * @return App\Models\ExpenseCategory deleted
     */
    public function showDeletedCategory(){
        return ExpenseCategory::with(['createdBy','editedBy'])->onlyTrashed()->orderBy('id','desc')->get();
    }

    /**
     * @return App\Models\ExpenseCategory where status is Active
     */
    public function activeCategory(){
        $categories = ExpenseCategory::with(['createdBy','editedBy'])->where('status','Active')->orderBy('id','desc')->get();
        return $categories;
    }
    /**
     * @return App\Models\ExpenseCategory where status is DeActive
     */
    public function deActiveCategory(){
        $categories = ExpenseCategory::with(['createdBy','editedBy'])->where('status','DeActive')->orderBy('id','desc')->get();
        return $categories;
    }

    /**
     * @return a specefic category
     * @param int $id
     */
    public function getSpecficeCategory($id){
        return ExpenseCategory::with(['createdBy','editedBy'])->where('id',$id)->first();
    }

    /**
     * @param int $id
     */
    public function getSpecficeTrashCategory($id){
        return ExpenseCategory::with(['createdBy','editedBy'])->onlyTrashed()->where('id',$id)->first();
    }

    /**
     * store new category in specefice storage
     * @param \Rquests\ExpenseCategoryRequest $request
     */
    public function create($request){
        $category = new ExpenseCategory();
        $category->name = str_replace(',', ' ', $request->name) ;
        $category->status = $request->status;
        $category->created_by = Auth::guard('admin')->User()->id;
        $category->save();
        return $category;
    }

    /**
     * @param \Rquests\ExpenseCategoryUpdateRequest $request
     * @param int $id
     * 
     */
    public function update($request,$id){
        $category = $this->getSpecficeCategory($id);
        $category->name = str_replace(',', ' ', $request->name);
        $category->status = $request->status;
        $category->edited_by = Auth::guard('admin')->user()->id;
        $category->save();
        return $category;
    }

    /**
     * Destroy a specfic Category
     * @param int $id
     */
    public function delete($id){
      $category=   $this->getSpecficeCategory($id);
      $expense = Expense::where('category_id',$category->id)->first();
      if($expense != null){
          return true;
      }
      else{
         $category->delete();
         return false;
      }
    }

    /**
     * Restore from trash
     */
    public function restore($id){
        $category = $this->getSpecficeTrashCategory($id);
        $category->restore();
    }

    /**
     * Parmanent Delete
     * @param string $name
     */
    public function parmanentDelete($id){
        $category = ExpenseCategory::onlyTrashed()->where('id',$id)->first();
        $category->forceDelete();
    }

    /**
     * mark active all selected expense category
     * @param array $ids
     * @param string type
     * 
     */
    public function markActive($ids){
        ExpenseCategory::whereIn('id',$ids)->update([
            'status' => 'Active',
        ]);  
    }
    /**
     * mark deactive all selected expense category
     * @param array $ids
     * @param string type
     * 
     */
    public function markDeActive($ids){
        ExpenseCategory::whereIn('id',$ids)->update([
            'status' => 'DeActive',
        ]);  
    }
    /**
     * mark delete all selected expense category
     * @param array $ids
     * @param string type
     * 
     */
    public function markDelete($ids){
        $categories =  ExpenseCategory::whereIn('id',$ids)->get();
        foreach ($categories as $category) {
            $check = Expense::where('category_id',$category->id)->first();
            if($check == null){
                $category->delete();
            }
        }
    }

    /**
     * mark parmanent delete all selected expense category
     */
    public function markParmanentlyDelete($ids){
        ExpenseCategory::whereIn('id',$ids)->forceDelete();
    }
    /**
     * mark restore all selected expense category
     * @param array $ids
     * @param string type
     * 
     */
    public function markRestore($ids){
        ExpenseCategory::onlyTrashed()->whereIn('id',$ids)->restore();
    }
    
}