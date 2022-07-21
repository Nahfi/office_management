<?php
namespace App\Repositories\Employee;
use App\Models\Admin;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isNull;

class UpdatePasswordRepository{
    /**
     * @param request data
     */
    public function update($requestData){


       $data =  DB::table('password_resets')->whereRaw('email = ?',$requestData->email)->whereRaw('token = ?',$requestData->token)->first();

        if(!$data){
            return redirect('/employee/login')->with('something_wrong','Something wrong please try again!!');
        }
        else{
            $employee = Employee::where('email',$data->email)->first();
            $employee->password = $employee->passwordEncrypt($requestData->password);
            $employee->save();
            return back();

        }
    }
}