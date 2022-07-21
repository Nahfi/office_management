<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class IncomeController extends Controller
{
   /**
     * Construct method
     */
    public $user;
    public function __construct()
    {
        $this->middleware(function($request,$next){
            $this->user = Auth::guard('admin')->User();
            return $next($request);
        });
    }
    public function index(){
        if(is_null($this->user) || !$this->user->can('income.index')){
            abort(403,'Unauthorized access');
        }
        $incomes =  Invoice::with(['user','invoiceInfo'])->latest()->get();
        return view('admin.pages.income.index',compact('incomes'));
    }
}
