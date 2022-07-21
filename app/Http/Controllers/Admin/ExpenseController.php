<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseRequest;
use App\Http\Requests\ExpenseUpdateRequest;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Repositories\Admin\ExpenseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    /**
     * costructor
     */
    private $expenseRepository;
    private $total_active_expense,$total_deactive_expense,$total_deleted_expense;


   public function __construct(ExpenseRepository $expenseRepository)
   {
        $this->middleware(function($request,$next){
            $this->user = Auth::guard('admin')->User();
            return $next($request);
        });
       $this->expenseRepository = $expenseRepository;
       $this->total_active_expense = Expense::groupByStatusCount('Active');
       $this->total_deactive_expense = Expense::groupByStatusCount('DeActive');
       $this->total_deleted_expense = Expense::onlyTrashed()->count();
   }
   /**
     * Show all Expense
     */
    public function index(){
        if(is_null($this->user) || !$this->user->can('expense.index')){
            abort(403,'Unauthorized access');
        }
       $data['expenses'] =  $this->expenseRepository->index();
       $data['total_active_expense'] =   $this->total_active_expense;
       $data['total_deactive_expense'] =  $this->total_deactive_expense ;
       $data['total_deleted_expense'] = $this->total_deleted_expense;
        return view('admin.pages.expense.expenses.index',[
          'data'=> $data
        ]);
    }
    /**
     * Show all active expense
     */
    public function showActiveExpense(){
        if(is_null($this->user) || !$this->user->can('expense.index')){
            abort(403,'Unauthorized access');
        }
        $data['expenses'] = $this->expenseRepository->activeExpense();
        $data['total_active_expense'] =   $this->total_active_expense;
        $data['total_deactive_expense'] =  $this->total_deactive_expense ;
        $data['total_deleted_expense'] = $this->total_deleted_expense;
        return view('admin.pages.expense.expenses.index',[
            'data' => $data
        ]);
    }
    /**
     * Show all Deactive expense
     */
    public function showDeActiveExpense(){
        if(is_null($this->user) || !$this->user->can('expense.index')){
            abort(403,'Unauthorized access');
        }
        $data['expenses']  = $this->expenseRepository->deActiveExpense();
        $data['total_active_expense'] =   $this->total_active_expense;
        $data['total_deactive_expense'] =  $this->total_deactive_expense ;
        $data['total_deleted_expense'] = $this->total_deleted_expense;
        return view('admin.pages.expense.expenses.index',[
            'data' => $data
        ]);
    }
    /**
     * Show all deleted Expense
     */
    public function showDeletedExpense(){
        if(is_null($this->user) || !$this->user->can('expense.index')){
            abort(403,'Unauthorized access');
        }
        $data['expenses'] = $this->expenseRepository->showDeletedExpense();
        $data['total_active_expense'] =   $this->total_active_expense;
        $data['total_deactive_expense'] =  $this->total_deactive_expense ;
        $data['total_deleted_expense'] = $this->total_deleted_expense;
        return view('admin.pages.expense.expenses.index',[
          'data' => $data
        ]);
    }
    /**
     * Show a form of create new expense
     */
    public function create(){
        if(is_null($this->user) || !$this->user->can('expense.store')){
            abort(403,'Unauthorized access');
        }
        $categories = ExpenseCategory::where('status','Active')->get();
        return view('admin.pages.expense.expenses.create',[
           'categories' => $categories
        ]);
    }
    /**
     * Store the newely created expense category
     */
    public function store(ExpenseRequest $request){
        if(is_null($this->user) || !$this->user->can('expense.store')){
            abort(403,'Unauthorized access');
        }
        if(is_null($this->user) || !$this->user->can('expense.category.store')){
            abort(403,'Unauthorized access');
        }
        $this->expenseRepository->create($request);
        return back()->with('expense_add_success','expenses added successfully');
    }
    /**
     * Show a edit form for a specefic expense
     */
    public function edit($id){
        if(is_null($this->user) || !$this->user->can('expense.edit')){
            abort(403,'Unauthorized access');
        }
        $expense = $this->expenseRepository->getSpecficeExpense($id);
        if($expense->category->status == 'DeActive'){
            return back();
        }
        $categories = ExpenseCategory::where('status','Active')->get();
        return view('admin.pages.expense.expenses.edit',[
            'expense' => $expense,
            'categories' => $categories
        ]);
    }
    /**
     * Update a specefice expense
     */
    public function update(ExpenseUpdateRequest $request,$id){
        if(is_null($this->user) || !$this->user->can('expense.edit')){
            abort(403,'Unauthorized access');
        }
        $this->expenseRepository->update($request,$id);
        return back()->with('expense_update_success','Expense Updated Successfully');
    }
    /**
     *
     * Destroy a specefic expense
     * @param int $id
     */
    public function destroy($id){
        if(is_null($this->user) || !$this->user->can('expense.delete')){
            abort(403,'Unauthorized access');
        }
        $this->expenseRepository->delete($id);
        return back()->with('expense_delete_success','Expense Deleted Successfully');
    }
    /**
     * Restore form trash
     */
    public function restore($id){
        if(is_null($this->user) || !$this->user->can('expense.delete')){
            abort(403,'Unauthorized access');
        }
        $this->expenseRepository->restore($id);
        return back()->with('expense_restore_success','Expense Restore Successfully');
    }

     /**
     * Parmanent Delete
     */
    public function parmanentDelete($id){
        if(is_null($this->user) || !$this->user->can('expense.parmanentDelete')){
            abort(403,'Unauthorized access');
        }
        $this->expenseRepository->parmanentDelete($id);
        return back()->with('parmanent_delete_success','Parmanenet Delete Successfull');
    }
    /**
     * Mark  all selected expense
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
             if(is_null($this->user) || !$this->user->can('expense.edit')){
                 abort(403,'Unauthorized access');
             }
             $type = $this->expenseRepository->markActive($type,$ids);
             return back()->with('mark_active_success','All Expense Activated Successfully');
        }
        elseif($type == 'DeActive'){
             if(is_null($this->user) || !$this->user->can('expense.edit')){
                 abort(403,'Unauthorized access');
             }
             $type = $this->expenseRepository->markDeActive($type,$ids);
             return back()->with('mark_deactive_success','All Expense DeActivated Successfully');
        }
        elseif($type == 'Delete'){
             if(is_null($this->user) || !$this->user->can('expense.delete')){
                 abort(403,'Unauthorized access');
             }
             $type = $this->expenseRepository->markDelete($type,$ids);
             return back()->with('mark_delete_success','All Expense Deleted Successfully');
        }
        elseif($type == 'ParmanentDelete'){
            if(is_null($this->user) || !$this->user->can('expense.parmanentDelete')){
                abort(403,'Unauthorized access');
            }
            $this->expenseRepository->markParmanentlyDelete($ids);
            return back()->with('mark_parmanent_delete_success','All Category Parmanently Deleted Successfully');
       }
        elseif($type == 'Restore'){
            if(is_null($this->user) || !$this->user->can('expense.delete')){
                abort(403,'Unauthorized access');
            }
            $type = $this->expenseRepository->markRestore($type,$ids);
            return back()->with('mark_restore_success','All Expense Restore Successfully');
        }

     }

}