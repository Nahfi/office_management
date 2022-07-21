<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HolidayDetailsStoreRequest;
use App\Http\Requests\HolidayDetailsUpdateRequest;
use App\Http\Requests\HolidayStoreRequest;
use App\Http\Requests\HolidayUpdateRequest;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Holiday;
use App\Models\HolidayDetails;
use App\Models\LeaveRequest;
use App\Repositories\Admin\HolidayRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HolidayController extends Controller
{
    /**
     * Construct method
     */
    public $user,$holidayRepository;
    public function __construct(HolidayRepository $holidayRepository)
    {
        $this->middleware(function($request,$next){
            $this->user = Auth::guard('admin')->User();
            return $next($request);
        });
        $this->holidayRepository = $holidayRepository;
    }
    /**
     * show all holiday
     */
    public function index(){
        if(is_null($this->user) || !$this->user->can('holiday.index')){
            abort(403,'Unauthorized access');
        }
        $holidays = $this->holidayRepository->index();
        return view('admin.pages.holiday.index',[
            'holidays' => $holidays
        ]);
    }

    /**
     * show all holiday date under a holiday month
     */
    public function showDetails($id){
        if(is_null($this->user) || !$this->user->can('holiday.index')){
            abort(403,'Unauthorized access');
        }
        $holidayDates = HolidayDetails::where('holiday_id',$id)->get();
        $holidayMonth = Holiday::where('id',$id)->first();
        return view('admin.pages.holiday.showDetails',[
            'holidayDates' => $holidayDates,
            'holidayMonth' => $holidayMonth
        ]);
    }

    /**
     * show  a form for creating new item
     */
    public function create(){
        if(is_null($this->user) || !$this->user->can('holiday.create')){
            abort(403,'Unauthorized access');
        }
        return view('admin.pages.holiday.create');
    }
    /**
     * store a new item in specificed storage
     */
    public function store(HolidayStoreRequest $request){
        if(is_null($this->user) || !$this->user->can('holiday.create')){
            abort(403,'Unauthorized access');
        }
        $this->holidayRepository->create($request);
        return back()->with('holiday_month_create_success','Holiday Month Added Successfully');
    }
    /**
     * store a new holiday date under a holiday month
     */
    public function storeDetails(HolidayDetailsStoreRequest $request,$id){
        if(is_null($this->user) || !$this->user->can('holiday.create')){
            abort(403,'Unauthorized access');
        }
        $this->holidayRepository->createDetails($request,$id);
        return back()->with('holiday_details_add_success','Holiday details Added Successfully');
    }

    /**
     * show a form for updating a specifice holiday month informtion
     */
    public function edit($id){
        if(is_null($this->user) || !$this->user->can('holiday.update')){
            abort(403,'Unauthorized access');
        }
        $holiday = $this->holidayRepository->getSpecificedHolidayMonth($id);
        return view('admin.pages.holiday.edit',[
            'holiday' => $holiday
        ]);
    }
    /**
     * update a specificed holiday month
     */
    public function update(HolidayUpdateRequest $request ,$id){
        if(is_null($this->user) || !$this->user->can('holiday.update')){
            abort(403,'Unauthorized access');
        }
        $this->holidayRepository->update($request,$id);
        return back()->with('holiday_update_success','Holiday Updated Successfully');
    }
    /**
     * update a specifice holiday date which is under a specificed holiday month
     */
    public function updateDetails(HolidayDetailsUpdateRequest $request,$id){
        if(is_null($this->user) || !$this->user->can('holiday.update')){
            abort(403,'Unauthorized access');
        }
        $this->holidayRepository->updateDetails($request,$id);
        return back()->with('holiday_details_update_success','Holiday Details Update Successfully');
    }

    /**
     * destroy a specficed holiday month
     */
    public function destroy($id){
        if(is_null($this->user) || !$this->user->can('holiday.delete')){
            abort(403,'Unauthorized access');
        }
        $this->holidayRepository->destroy($id);
        return back()->with('holiday_destory_success','Holiday Month Deleted Successfully');
    }
    /**
     * destroy  a specificed holiday date which is under a holiday month
     */
    public function destroyDetails($id){
        if(is_null($this->user) || !$this->user->can('holiday.delete')){
            abort(403,'Unauthorized access');
        }
        $this->holidayRepository->destroyDetails($id);
        return back()->with('holiday_details_destory_success','Holiday Details Deleted Successfully');
    }
}
