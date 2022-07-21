<?php
namespace App\Repositories\Admin;

use App\Models\Holiday;
use App\Models\HolidayDetails;
use Illuminate\Support\Facades\Auth;

class HolidayRepository{
    /**
     * show all holidays
     */
    public function index(){
        return Holiday::with(['createdBy','editedBy','holidayDetails'])->orderBy('id','desc')->get();
    }

    /**
     * store a holiday in specifice storage
     */
    public function create($request){
        $holiday = new Holiday();
        $holiday->year = $request->year;
        $holiday->month = $request->month;
        $holiday->created_by = Auth::guard('admin')->User()->id;
        $holiday->save();
    }

    /**
     * store all holiday details under a specifice month
     */
    public function createDetails($request,$id){
        $holidayDetails = new HolidayDetails();
        $holidayDetails->holiday_id = $id;
        $holidayDetails->date = $request->date;
        $holidayDetails->save();
    }

    /**
     * get a specifice holiday month
     */
    public function getSpecificedHolidayMonth($id){
        return Holiday::with(['createdBy','editedBy','holidayDetails'])->where('id',$id)->first();
    }

    /**
     * get a specifice holiday date under a holiday month
     */
    public function getSpecificedHolidayDate($id){
        return HolidayDetails::where('id',$id)->first();
    }

    /**
     * update a specifice holiday  month
     */
    public function update($request,$id){
        $holiday = $this->getSpecificedHolidayMonth($id);
        $holiday->year = $request->year;
        $holiday->month = $request->month;
        $holiday->edited_by = Auth::guard('admin')->User()->id;
        $holiday->save();
    }

    /**
     * update a specefice holiday date
     */
    public function updateDetails($request,$id){
        $holidayDetails = $this->getSpecificedHolidayDate($id);
        $holidayDetails->date = $request->date;
        $holidayDetails->save();
    }

    /**
     * destroy a specifice holiday month
     */
    public function destroy($id){
        $holiday = $this->getSpecificedHolidayMonth($id);
        HolidayDetails::where('holiday_id',$holiday->id)->delete();
        $holiday->delete();
    }

    /**
     * destroy a specifice holiday date
     */
    public function destroyDetails($id){
        $holidaDetails = $this->getSpecificedHolidayDate($id);
        $holidaDetails->delete();
    }
}