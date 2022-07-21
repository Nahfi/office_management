<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Employee\EmployeeEmailRepository;
use Illuminate\Support\Facades\Route;
class EmployeeEmailController extends Controller
{
  /**
     * Construct method
     */
    public $user, $emailRepository;
    public function __construct()
    {
        $this->middleware(function($request,$next){
            $this->user = Auth::guard('employee')->User();
            return $next($request);
        });
        $this->emailRepository = new  EmployeeEmailRepository();
    }

    /**
     * show all email in inbox
     */
    public function index(){

        $allAdmin =$this->emailRepository ->allAdmin();
        $allEmployee =$this->emailRepository ->allEmployee( Auth::guard('employee')->User()->email);
        $allCustomer =$this->emailRepository ->allCustomer();
        $allEmailInfo = $this->emailRepository->allEmail();
        return view('employee.pages.email.index',compact('allAdmin','allEmailInfo','allEmployee','allCustomer'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request  $request){
        $this->emailRepository ->store($request);
        return back()->with('email_sends_successfully','Email send Successfully');
    }

    // /**
    //  * @param $id
    //  * show a specific email from inbox
    //  */
    // public function show($id){
    //     $allEmployee =$this->emailRepository ->allEmployee( Auth::guard('employee')->User()->email);
    //     $allEmailInfo = $this->emailRepository ->findEmail($id);
    //     $allAdmin = $this->emailRepository ->allAdmin();
    //     return view('employee.pages.email.show',compact('allAdmin','allEmailInfo','allEmployee'));
    // }
    /**
     * @param $slug
     * show a specific email from inbox
     */
    public function showSpecificMail($slug){
        $allEmailInfo = $this->emailRepository ->findSpecificEmail($slug);
        $allEmployee =$this->emailRepository ->allEmployee( Auth::guard('employee')->User()->email);
        $allAdmin = $this->emailRepository ->allAdmin();
        return view('employee.pages.email.show_single_email',compact('allAdmin','allEmailInfo','allEmployee'));
    }

    /**
     * show all unread email from inbox
     */
    public function allUnreadEmail(){
        $allEmployee =$this->emailRepository ->allEmployee( Auth::guard('employee')->User()->email);

        $allAdmin = $this->emailRepository ->allAdmin();
        $allEmailInfo = $this->emailRepository->allUnreadEmail();
        return view('employee.pages.email.index',compact('allAdmin','allEmailInfo','allEmployee'));
    }

    /**
     * show all unread email from inbox
     */
    public function allSentEmail(){
        $allEmployee =$this->emailRepository ->allEmployee( Auth::guard('employee')->User()->email);
        $allAdmin = $this->emailRepository ->allAdmin();
        $allEmailInfo = $this->emailRepository->allSentEmail();
        return view('employee.pages.email.index',compact('allAdmin','allEmailInfo','allEmployee'));
    }


    /**
     * get all trashed email
     */
    public function trash(){
        $allEmployee =$this->emailRepository ->allEmployee( Auth::guard('employee')->User()->email);
        $allAdmin = $this->emailRepository ->allAdmin();
        $allEmailInfo = $this->emailRepository->allTrashEmail();
        return view('employee.pages.email.index',compact('allAdmin','allEmailInfo','allEmployee'));
    }
    /**
     * restore a specific email form trash
     */
    public function restore($id){

        $this->emailRepository->restore($id);
        return back()->with('restore_success',' Email Restored Successfully');
    }

    /**
     * destroy a specific Received   email
     * @param int $id
     */
    public function destroyReceivedEmail($id){

        $this->emailRepository->destroyReceivedEmail($id);
        return back()->with('destory_success','Recived Email Destroyed Successfully');

    }
    /**
     * destroy a specific sent email
     * @param int $id
     */
    public function destroySentEmail($id){
        $this->emailRepository->destroySentEmail($id);
        return back()->with('destory_success','Sent Email Destroyed Successfully');
    }

    /**
     * Mark  all selected  emails
     */
    public function mark(Request $request){
        $request->validate([
            'submitType' => 'required',
            'markedId' => 'required'
        ]);
        if( request()->get('routeName')  != 'employee.email.allSentEmail' ){
            if(request()->get('submitType') == 'softDelete' ){
                $this->emailRepository ->markDelete(request()->get('markedId'));
                return back()->with('mark_delete_success','All Email Deleted Successfully');
            }
            else{
                if(request()->get('submitType') == 'restore' ){
                    $this->emailRepository ->markRestore(request()->get('markedId'));
                    return back()->with('mark_restore_success','All Email Restored Successfully');

                }
                else{
                    $this->emailRepository ->parmanentDelete(request()->get('markedId'));
                    return back()->with('mark_parmanent_delete_success','All Email Parmanently Deleted Successfully');
                }
            }
        }
        else{
            if(request()->get('submitType') == 'softDelete' ){

                $this->emailRepository ->markDeleteSendEmail(request()->get('markedId'));
                return back()->with('mark_delete_success','All Email Deleted Successfully');
            }

        }

    }

}