<?php
namespace App\Repositories\Admin;

use App\Models\WorkingDay;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class WorkingDayRepository{
    /**
     * show all working day
     */
    public function index(){
        return WorkingDay::with(['createdBy','editedBy'])->orderby('id','desc')->get();
    }

   /**
     * get specefic working day
     */
    public function getSpecificedItem($id){
        return WorkingDay::with(['createdBy','editedBy'])->where('id',$id)->first();
    }

    /**
     * store item in specificed storage
     */
    public function create($request){
        $workingDay = new WorkingDay();
        $workingDay->year = $request->year;
        $workingDay->month = $request->month;
        $workingDay->total_day = $request->total_day;
        $workingDay->created_by = Auth::guard('admin')->User()->id;
        $workingDay->save();
    }

    /**
     * update a specificed item
     */
    public function update($request,$id){
        $workingDay = $this->getSpecificedItem($id);
        $workingDay->year = $request->year;
        $workingDay->month = $request->month;
        $workingDay->total_day = $request->total_day;
        $workingDay->edited_by = Auth::guard('admin')->User()->id;
        $workingDay->save();
    }

    /**
     * delete specefied item
     */
    public function destroy($id){
        $workingDay = $this->getSpecificedItem($id);
        $workingDay->delete();
    }
}