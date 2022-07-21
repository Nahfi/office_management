<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseCategoryRequest;
use App\Http\Requests\ExpenseCategoryUpdateRequest;
use App\Models\ExpenseCategory;
use App\Repositories\Admin\ExpenseCategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseCategoryController extends Controller
{
    /**
     * costructor
     */
    private $expenseCategoryRepository;
    public $user;
    private $total_active_category,$total_deactive_category,$total_deleted_category;


   public function __construct(ExpenseCategoryRepository $expenseCategoryRepository)
   {
        $this->middleware(function($request,$next){
            $this->user = Auth::guard('admin')->User();
            return $next($request);
        });
       $this->expenseCategoryRepository = $expenseCategoryRepository;
       $this->total_active_category = ExpenseCategory::groupByStatusCount('Active');
       $this->total_deactive_category = ExpenseCategory::groupByStatusCount('DeActive');
       $this->total_deleted_category = ExpenseCategory::onlyTrashed()->count();
   }
    /**
     * Show all Expense Category
     */
    public function index(){
        if(is_null($this->user) || !$this->user->can('expense.category.index')){
            abort(403,'Unauthorized access');
        }
       $data['categories'] =  $this->expenseCategoryRepository->index();
       $data['total_active_category'] =   $this->total_active_category;
       $data['total_deactive_category'] =  $this->total_deactive_category ;
       $data['total_deleted_category'] = $this->total_deleted_category;
        return view('admin.pages.expense.category.index',[
          'data'=> $data
        ]);
    }

    /**
     * Show all active expense category
     */
    public function showActiveCategory(){
        if(is_null($this->user) || !$this->user->can('expense.category.index')){
            abort(403,'Unauthorized access');
        }
        $data['categories'] = $this->expenseCategoryRepository->activeCategory();
        $data['total_active_category'] =   $this->total_active_category;
        $data['total_deactive_category'] =  $this->total_deactive_category ;
        $data['total_deleted_category'] = $this->total_deleted_category;
        return view('admin.pages.expense.category.index',[
            'data' => $data
        ]);
    }
    /**
     * Show all Deactive expense category
     */
    public function showDeActiveCategory(){
        if(is_null($this->user) || !$this->user->can('expense.category.index')){
            abort(403,'Unauthorized access');
        }
        $data['categories']  = $this->expenseCategoryRepository->deActiveCategory();
        $data['total_active_category'] =   $this->total_active_category;
        $data['total_deactive_category'] =  $this->total_deactive_category ;
        $data['total_deleted_category'] = $this->total_deleted_category;
        return view('admin.pages.expense.category.index',[
            'data' => $data
        ]);
    }

    /**
     * Show all deleted Expense Category
     */
    public function showDeletedCategory(){
        if(is_null($this->user) || !$this->user->can('expense.category.index')){
            abort(403,'Unauthorized access');
        }
        $data['categories'] = $this->expenseCategoryRepository->showDeletedCategory();
        $data['total_active_category'] =   $this->total_active_category;
        $data['total_deactive_category'] =  $this->total_deactive_category ;
        $data['total_deleted_category'] = $this->total_deleted_category;
        return view('admin.pages.expense.category.index',[
          'data' => $data
        ]);
    }

    /**
     * Show a form of create new expense category
     */
    public function create(){
        if(is_null($this->user) || !$this->user->can('expense.category.store')){
            abort(403,'Unauthorized access');
        }
        return view('admin.pages.expense.category.create');
    }

    /**
     * Store the newely created expense category
     */
    public function store(ExpenseCategoryRequest $request){
        if(is_null($this->user) || !$this->user->can('expense.category.store')){
            abort(403,'Unauthorized access');
        }
        $this->expenseCategoryRepository->create($request);
        return back()->with('category_create_success','Category Created successfully');
    }
    /**
     * Show a edit form for a specefic expense category
     */
    public function edit($id){
        if(is_null($this->user) || !$this->user->can('expense.category.edit')){
            abort(403,'Unauthorized access');
        }
        if(is_null($this->user) || !$this->user->can('expense.category.edit')){
            abort(403,'Unauthorized access');
        }
        $category = $this->expenseCategoryRepository->getSpecficeCategory($id);
        return view('admin.pages.expense.category.edit',[
            'category' => $category
        ]);
    }

    /**
     * Update a specefice expense category
     */
    public function update(ExpenseCategoryUpdateRequest $request,$id){
        if(is_null($this->user) || !$this->user->can('expense.category.edit')){
            abort(403,'Unauthorized access');
        }
        $this->expenseCategoryRepository->update($request,$id);
        return back()->with('category_update_success','Category Updated Successfully');
    }

    /**
     *
     * Destroy a specefic expense category
     * @param int $id
     */
    public function destroy($id){
        if(is_null($this->user) || !$this->user->can('expense.category.delete')){
            abort(403,'Unauthorized access');
        }
       $check =  $this->expenseCategoryRepository->delete($id);
       if($check){
            return back()->with('category_delete_unsuccess','Category Delete UnSuccessfull');
        }
        else{
            return back()->with('category_delete_success','Category Deleted Successfully');
        }

    }


    /**
     * Restore form trash
     */
    public function restore($id){
        if(is_null($this->user) || !$this->user->can('expense.category.delete')){
            abort(403,'Unauthorized access');
        }
        $this->expenseCategoryRepository->restore($id);
        return back()->with('category_restore_success','Category Restore Successfully');
    }
    /**
     * Parmanent Delete
     */
    public function parmanentDelete($id){
        if(is_null($this->user) || !$this->user->can('expense.category.parmanentDelete')){
            // parmanentDelete
// expense.category.parmanentDelete
            abort(403,'Unauthorized access');
        }
        $this->expenseCategoryRepository->parmanentDelete($id);
        return back()->with('parmanent_delete_success','Parmanenet Delete Successfull');
    }

    /**
     * Mark  all selected expense category
     *
     */
    public function mark(Request $request){
        $request->validate([
            'type' => 'required',
            'ids' => 'required'
        ]);
       $type = request()->get('type');
       $ids = request()->get('ids');

       if($type == 'Active'){
            if(is_null($this->user) || !$this->user->can('expense.category.edit')){
                abort(403,'Unauthorized access');
            }
            $this->expenseCategoryRepository->markActive($ids);
            return back()->with('mark_active_success','All Category Activated Successfully');
       }
       elseif($type == 'DeActive'){
            if(is_null($this->user) || !$this->user->can('expense.category.edit')){
                abort(403,'Unauthorized access');
            }
            $this->expenseCategoryRepository->markDeActive($ids);
            return back()->with('mark_deactive_success','All Category DeActivated Successfully');
       }
       elseif($type == 'Delete'){
            if(is_null($this->user) || !$this->user->can('expense.category.delete')){
                abort(403,'Unauthorized access');
            }
            $this->expenseCategoryRepository->markDelete($ids);
            return back()->with('mark_delete_success','All Category Deleted Successfully which has no expense');
       }
       elseif($type == 'ParmanentDelete'){
            if(is_null($this->user) || !$this->user->can('expense.category.parmanentDelete')){
                abort(403,'Unauthorized access');
            }
            $this->expenseCategoryRepository->markParmanentlyDelete($ids);
            return back()->with('mark_parmanent_delete_success','All Category Parmanently Deleted Successfully');
       }
       elseif($type == 'Restore'){
            if(is_null($this->user) || !$this->user->can('expense.category.delete')){
                abort(403,'Unauthorized access');
            }
            $this->expenseCategoryRepository->markRestore($ids);
            return back()->with('mark_restore_success','All Category Restore Successfully');
       }
    }


}
