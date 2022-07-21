<?php
namespace App\Repositories\Employee;
use Illuminate\Support\Str;
use App\Models\Admin;
use App\Models\Email;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
 use Illuminate\Support\Facades\Route;

class EmployeeEmailRepository{

    /**
     * get all admin
     * @param $emaail
     * @return  $allEmailInfo
     */
    public  function allAdmin(){
        return Admin::select('id','email')->get();
    }
    /**
     * get all employee
     */
    public  function allEmployee($email){
        return Employee::select('id','email')->where('email','!=',$email)->get();
    }

    /**
     * get all customer
     */
    public  function allCustomer(){
        return User::select('id','email')->get();
    }

    /**
     * count all recivved  mail
     * @return $totalEmail
     */
    public function countTotalEmail(){
        return Email::with(['sender','receiver','EmployeeReceiver','EmployeeSender']) ->where(function($query){
            return $query-> where('employee_to',
            Auth::guard('employee')->user()->id
            )->whereNull('soft_deleted_by_receiver');
        })->count();
    }

    /**
     * find  email
     * @param $id
     * @return $allEmailInfo
     */
    public function findEmail($id){
        $this->changeStatus($id);
        $emails = Email::with(['sender','receiver','EmployeeReceiver','EmployeeSender'])->where('form',$id)->where('to',Auth::guard('employee')->user()->id)->whereNull('soft_deleted_by_receiver')->get();
        $allEmailInfo = [
            'totalEmail' =>$this->countTotalEmail(),
            'emailInfo'=>$emails,
            "totalUnreadEmail"=>$this->countUnreadEmail(),
            "totalTrashEmail"=>$this->countTrashEmail()
        ];
        return $allEmailInfo;
    }

    /**
     * find a specific sent email
     * @param $slug
     * @return $allEmailInfo
     */
    public function findSpecificEmail($slug){

            $email = Email::with(['sender','receiver','EmployeeReceiver','EmployeeSender'])->where('slug',$slug)->first();
            if( $email->status == "unread" && $email->employee_to == Auth::guard('employee')->user()->id  ){
                $this->changeStatus($email->id);
            }

        $allEmailInfo = [
            'totalEmail' =>$this->countTotalEmail(),
            'emailInfo'=>$email,
            "totalUnreadEmail"=>$this->countUnreadEmail(),
            "totalTrashEmail"=>$this->countTrashEmail()
        ];
        return $allEmailInfo;
    }

    /**
     * change email status
     * @param $id
     */
    public function changeStatus($id){
        Email::with(['sender','receiver','EmployeeReceiver','EmployeeSender'])->where('id',$id)->update([
            'status'=>'read'
        ]);
    }

   /**
     * get all email
     * @return $allEmailInfo
     */
    public  function allUnreadEmail(){

        $allEmails = Email::with(['sender','receiver','EmployeeReceiver','EmployeeSender']) -> where('employee_to',
            Auth::guard('employee')->user()->id
            )->whereNull('soft_deleted_by_receiver')->where('status','unread')->latest()->get();

       $allEmailInfo = [
           'totalEmail' =>$this->countTotalEmail(),
           'emailInfo'=>$allEmails,
           "totalUnreadEmail"=>$this->countUnreadEmail(),
           "totalTrashEmail"=>$this->countTrashEmail()
       ];
       return $allEmailInfo;
    }

    /**
     *  count total trash email
     */
    public function countTrashEmail(){
         $allTrashEmail= Email::with(['sender','receiver','EmployeeReceiver','EmployeeSender'])
        ->where(function($query){
            return $query->where('employee_form',Auth::guard('employee')->User()->id)
            ->where('soft_deleted_by_sender','!=',' ')
            ->where('permanent_deleted_by_sender',null);
        })
        ->orWhere(function($query){
            return $query->where('employee_to',Auth::guard('employee')->User()->id)->where('soft_deleted_by_receiver','!=',' ')->where('permanent_deleted_by_receiver',null);
        })
        ->latest()->get();
        return count($allTrashEmail);
    }

   /**
     * get all sent-email
     * @return  App\Models\Email;
     */
    public  function allSentEmail(){
        $allSentEmails = Email::with(['sender','receiver','EmployeeReceiver','EmployeeSender'])-> where('employee_form',
            Auth::guard('employee')->user()->id
            )->whereNull('soft_deleted_by_sender')->latest()->get();

        $allEmailInfo = [
            'totalEmail' =>$this->countTotalEmail(),
            'emailInfo'=>$allSentEmails,
            "totalUnreadEmail"=>$this->countUnreadEmail(),
            "totalTrashEmail"=>$this->countTrashEmail()
        ];
        return $allEmailInfo;
    }


    /**
     * restore an email from trash
     * @param int $id
     * @return void
     */
    public function restore($id){
        $email = Email::with(['sender','receiver','EmployeeReceiver','EmployeeSender'])->where('id',
        $id
        )->first();
       if($email->employee_form == Auth::guard('employee')->user()->id){
           $email->soft_deleted_by_sender = null;
       }
       else if($email->employee_to == Auth::guard('employee')->user()->id){
        $email->soft_deleted_by_receiver = null;
       }
       $email->save();
    }

   /**
     * get all trash-email
     * @return  $allEmailInfo;
     */
    public  function allTrashEmail(){
             $allTrashEmail = Email::with(['sender','receiver','EmployeeReceiver','EmployeeSender'])
                ->where(function($query){
                    return $query->where('employee_form',Auth::guard('employee')->User()->id)
                    ->where('soft_deleted_by_sender','!=',' ')
                    ->where('permanent_deleted_by_sender',null);
                })
                ->orWhere(function($query){
                    return $query->where('employee_to',Auth::guard('employee')->User()->id)->where('soft_deleted_by_receiver','!=',' ')->where('permanent_deleted_by_receiver',null);
                })
                ->latest()->get();

        $allEmailInfo = [
            'totalEmail' =>$this->countTotalEmail(),
            'emailInfo'=>$allTrashEmail,
            "totalUnreadEmail"=>$this->countUnreadEmail(),
            "totalTrashEmail"=>$this->countTrashEmail()
        ];
        return $allEmailInfo;
    }

    /**
     * get all email
     * @param $emaail
     * @return  App\Models\Email;
     */
    public  function allEmail(){

        $allEmails = Email::with(['sender','receiver','EmployeeReceiver','EmployeeSender']) -> where('employee_to',
            Auth::guard('employee')->user()->id
            )->whereNull('soft_deleted_by_receiver')
        ->latest()->get();

       $allEmailInfo = [
           'totalEmail' =>count( $allEmails ),
           'emailInfo'=>$allEmails,
           "totalUnreadEmail"=>$this->countUnreadEmail(),
           "totalTrashEmail"=>$this->countTrashEmail()
       ];
       return $allEmailInfo;
    }

    /**
     * count total unread email
     */
    public function countUnreadEmail(){
     return Email::with(['sender','receiver','EmployeeReceiver','EmployeeSender']) -> where(function($query){
            return $query-> where('employee_to',
            Auth::guard('employee')->user()->id
            )->whereNull('soft_deleted_by_receiver')->where('status','unread');;
        })->count();
    }
    /**
     * get email description
     * @param $value
     * @return $results
     */
    public function getEmailDescription($value){
    $groups = $value->groupBy('status');
    $results = [];
    foreach($groups as $index=>$value) {
    $results[] = [
        'count'=>count($value),
        'status'=>$index,
        'value'=>$value[0]
    ];
    }
    return $results;
    }

    /**
     * send or store email
     * @param $request
     */
    public function store($request){
        // dd($request->description);
        foreach($request->to as $to_id){
            $email = new Email();
            $email->description =  $request->description;
            $email->subject = $request->subject;
            if(Str::startsWith($to_id, 'a')){
                $int = (int) filter_var($to_id, FILTER_SANITIZE_NUMBER_INT);
                $email->to = $int;
            }
            else{
                $email->employee_to = $to_id;
            }
            $email->slug = Str::slug($email->subject?$email->subject."_".rand(100,900) :"null_subject_".rand(100,900));
            $email->employee_form = Auth::guard('employee')->user()->id;
            $email->save();
        }
    }


    /**
     * mark delete recived email
     * @param $markedId
     */
    public function markDelete($markedId){
        Email::with(['sender','receiver','EmployeeReceiver','EmployeeSender'])->whereIn('id',$markedId)->update([
            'soft_deleted_by_receiver'=>'deleted'
        ]);
    }

    /**
     * destory a specific Recived   email
     * @param $id
     */
    public function destroyReceivedEmail($id){
        Email::with(['sender','receiver','EmployeeReceiver','EmployeeSender'])->where('id',$id)->update([
            'soft_deleted_by_receiver'=>'deleted'
        ]);
    }

    /**
     * destory a specific sent  email
     * @param $id
     */
    public function destroySentEmail($id){
       $email =  Email::with(['sender','receiver','EmployeeReceiver',
       'EmployeeSender'])->where('id',$id)->first();
       if($email->employee_to == Auth::guard('employee')->user()->id){
            $email->soft_deleted_by_receiver = 'deleted';
       }
       if($email->employee_form == Auth::guard('employee')->user()->id){
            $email->soft_deleted_by_sender = 'deleted';
       }
       $email->save();
    }

    /**
     * mark delete recived email
     * @param $markedId
     */
    public function markRestore($markedId){
        Email::with(['sender','receiver','EmployeeReceiver','EmployeeSender'])->whereIn('id',$markedId)->update([
            'soft_deleted_by_receiver'=>null,
            'soft_deleted_by_sender'=>null,
        ]);
    }
    /**
     * mark parmanentDelete recived email
     * @param $markedId
     */
    public function parmanentDelete($markedId){
        $emails = Email::with(['sender','receiver','EmployeeReceiver','EmployeeSender'])->whereIn('id',$markedId)->get();
        foreach($emails as $email){
            if($email->employee_to == Auth::guard('employee')->user()->id){
                if( $email->permanent_deleted_by_sender != null )
                {
                    $email->delete();
                }
                else{
                    $email->permanent_deleted_by_receiver = 'deleted';
                    $email->save();
                }
            }
            if($email->employee_form == Auth::guard('employee')->user()->id){
                if( $email->permanent_deleted_by_receiver != null )
                {
                    $email->delete();
                }
                else{
                $email->permanent_deleted_by_sender = 'deleted';
                $email->save();
                }
            };
        }
    }

    /**
     * mark delete sent email
     * @param $markedId
     */
    public function markDeleteSendEmail($markedId){
        Email::with(['sender','receiver','EmployeeReceiver','EmployeeSender'])->whereIn('id',$markedId)->update([
            'soft_deleted_by_sender'=>'deleted'
        ]);
    }
}