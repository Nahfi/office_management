<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Repositories\Employee\HomeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeHomeController extends Controller
{
    /**
     * construct method
     */
    public $user, $homeRepository;
   
    public function __construct(HomeRepository $homeRepository)
    {
        $this->middleware(function($request,$next){
            $this->user = Auth::guard('employee')->User();
            return $next($request);
        });
        $this->homeRepository = $homeRepository;
       
    }
    public function index(){
        $data = $this->homeRepository->index();
        return view('employee.pages.home.index',[
            'data' => $data,
        ]);
    }
}
