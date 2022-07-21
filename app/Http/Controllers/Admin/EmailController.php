<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Admin\EmailRepository;
use Illuminate\Support\Facades\Route;
class EmailController extends Controller
{
    /**
     * Construct method
     */
    public $user, $emailRepository;
    public function __construct()
    {
        $this->middleware(function($request,$next){
            $this->user = Auth::guard('admin')->User();
            return $next($request);
        });
        $this->emailRepository = new  EmailRepository();
    }

    /**
     * show all email in inbox
     */
    public function index(){
        if(is_null($this->user) || !$this->user->can('email.index')){
            abort(403,'Unauthorized access');
        }
        $allAdmin =$this->emailRepository ->allAdmin(auth()->user()->email);
        $allEmployee =$this->emailRepository ->allEmployee();
        $allCustomer =$this->emailRepository ->allCustomer();
        $allEmailInfo = $this->emailRepository->allEmail();
        return view('admin.pages.email.index',compact('allAdmin','allEmailInfo','allEmployee','allCustomer'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request  $request){
        if(is_null($this->user) || !$this->user->can('email.create')){
            abort(403,'Unauthorized access');
        }
        $this->emailRepository ->store($request);
        return back()->with('email_sends_successfully','Email send Successfully');
    }

    /**
     * @param $id
     * show a specific email from inbox
     */
    public function show($id){
        if(is_null($this->user) || !$this->user->can('email.index')){
            abort(403,'Unauthorized access');
        }
        $allEmployee =$this->emailRepository ->allEmployee();
        $allEmailInfo = $this->emailRepository ->findEmail($id);
        $allAdmin = $this->emailRepository ->allAdmin(auth()->user()->email);
        return view('admin.pages.email.show',compact('allAdmin','allEmailInfo','allEmployee'));
    }
    /**
     * @param $slug
     * show a specific email from inbox
     */
    public function showSpecificMail($slug){
        if(is_null($this->user) || !$this->user->can('email.index')){
            abort(403,'Unauthorized access');
        }
        $allEmailInfo = $this->emailRepository ->findSpecificEmail($slug);
        $allEmployee =$this->emailRepository ->allEmployee();
        $allAdmin = $this->emailRepository ->allAdmin(auth()->user()->email);
        return view('admin.pages.email.show_single_email',compact('allAdmin','allEmailInfo','allEmployee'));
    }

    /**
     * show all unread email from inbox
     */
    public function allUnreadEmail(){
        if(is_null($this->user) || !$this->user->can('email.index')){
            abort(403,'Unauthorized access');
        }
        $allEmployee =$this->emailRepository ->allEmployee();
        $allAdmin = $this->emailRepository ->allAdmin(auth()->user()->email);
        $allEmailInfo = $this->emailRepository->allUnreadEmail();
        return view('admin.pages.email.index',compact('allAdmin','allEmailInfo','allEmployee'));
    }

    /**
     * show all unread email from inbox
     */
    public function allSentEmail(){
        if(is_null($this->user) || !$this->user->can('email.index')){
            abort(403,'Unauthorized access');
        }
        $allEmployee =$this->emailRepository ->allEmployee();

        $allAdmin = $this->emailRepository ->allAdmin(auth()->user()->email);
        $allEmailInfo = $this->emailRepository->allSentEmail();
        return view('admin.pages.email.index',compact('allAdmin','allEmailInfo','allEmployee'));
    }


    /**
     * get all trashed email
     */
    public function trash(){
        if(is_null($this->user) || !$this->user->can('email.index')){
            abort(403,'Unauthorized access');
        }
        $allEmployee =$this->emailRepository ->allEmployee();

        $allAdmin = $this->emailRepository ->allAdmin(auth()->user()->email);
        $allEmailInfo = $this->emailRepository->allTrashEmail();
        return view('admin.pages.email.index',compact('allAdmin','allEmailInfo','allEmployee'));
    }
    /**
     * restore a specific email form trash
     */
    public function restore($id){
        if(is_null($this->user) || !$this->user->can('email.restore')){
            abort(403,'Unauthorized access');
        }
        $this->emailRepository->restore($id);
        return back()->with('restore_success',' Email Restored Successfully');
    }

    /**
     * destroy a specific Received   email
     * @param int $id
     */
    public function destroyReceivedEmail($id){
        if(is_null($this->user) || !$this->user->can('email.delete')){
            abort(403,'Unauthorized access');
        }
        $this->emailRepository->destroyReceivedEmail($id);
        return back()->with('destory_success','Recived Email Destroyed Successfully');

    }
    /**
     * destroy a specific sent email
     * @param int $id
     */
    public function destroySentEmail($id){
        if(is_null($this->user) || !$this->user->can('email.delete')){
            abort(403,'Unauthorized access');
        }
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
        if( request()->get('routeName')  != 'admin.email.allSentEmail' ){
            if(request()->get('submitType') == 'softDelete' ){
                if(is_null($this->user) || !$this->user->can('email.delete')){
                    abort(403,'Unauthorized access');
                }
                $this->emailRepository ->markDelete(request()->get('markedId'));
                return back()->with('mark_delete_success','All Email Deleted Successfully');
            }
            else{
                if(request()->get('submitType') == 'restore' ){
                    if(is_null($this->user) || !$this->user->can('email.restore')){
                        abort(403,'Unauthorized access');
                    }
                    $this->emailRepository ->markRestore(request()->get('markedId'));
                    return back()->with('mark_restore_success','All Email Restored Successfully');

                }
                else{
                    if(is_null($this->user) || !$this->user->can('email.parmanentDelete')){
                        abort(403,'Unauthorized access');
                    }
                    $this->emailRepository ->parmanentDelete(request()->get('markedId'));
                    return back()->with('mark_parmanent_delete_success','All Email Parmanently Deleted Successfully');
                }
            }
        }
        else{
            if(request()->get('submitType') == 'softDelete' ){
                if(is_null($this->user) || !$this->user->can('email.delete')){
                    abort(403,'Unauthorized access');
                }
                $this->emailRepository ->markDeleteSendEmail(request()->get('markedId'));
                return back()->with('mark_delete_success','All Email Deleted Successfully');
            }

        }

    }

}