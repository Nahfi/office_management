<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class EmployeeProfileController extends Controller
{
    /**
     * Construct method
     */
    public $user;
    public function __construct()
    {
        $this->middleware(function($request,$next){
            $this->user = Auth::guard('employee')->User();
            return $next($request);
        });
    }
    /**
     * Show the authenticated user profile
     */
    public function index(){
        if(is_null($this->user)){
            abort(403,'Unauthorized access');
        }
        $employee = Employee::with('roles')->where('email',Auth::guard('employee')->User()->email)->first();
        return view('employee.pages.profile.index',[
            'employee' => $employee
        ]);
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request){
        if(is_null($this->user)){
            abort(403,'Unauthorized access');
        }
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if (Hash::check($request->old_password,Auth::guard('employee')->User()->password)) {

            $id = Auth::guard('employee')->User()->id;

            Employee::where('id',Auth::guard('employee')->User()->id)->update([
                'password' => Hash::make($request->password),
             ]);

             Auth::guard('employee')->loginUsingId($id);


             return back()->with('password_changed','Password Change Successfully');
         }

         return back()->with('password_not_match','Password does not match with previous Password');
    }


    /**
     * Update Genearl Information
     */
    public function update(Request $request){
        if(is_null($this->user)){
            abort(403,'Unauthorized access');
        }
        $employee = Employee::where('email',Auth::guard('employee')->User()->email)->first();
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:employees,email,'.$employee->id,
        ]);
        $imageService = new ImageService();

        $image_name = $employee->photo;
        $image_location = 'photo/employee_profile/';
        if($request->hasFile('photo')){
            if($image_name != 'default.jpg'){
                $imageService->delete($image_name,$image_location);
            }
            $image_name = $imageService->upload($request->name,$image_location,$request->file('photo'));
        }
        Employee::where('email',$employee->email)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'photo' => $image_name,
        ]);

       return back()->with('profile_updated',"Profile Update Successfully");
    }
}