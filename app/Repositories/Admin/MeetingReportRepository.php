<?php
namespace App\Repositories\Admin;
use App\Models\MeetingReport;
use Illuminate\Support\Facades\Auth;
class MeetingReportRepository{

    /**
     * show all work report
     */
    public function index(){
        return MeetingReport:: with(['employee','admin','MeetingReportDetails'])->withTrashed()->latest()->get();
    }

   /**
    * get a specified report from storage
    * @param $id
    * @return $report
    */
    public function getSpecificedReport($id){
        return MeetingReport:: with(['employee','admin','MeetingReportDetails'])->withTrashed()->where('id',$id)->first();
    }

    /*
     *  show all trash report
     */
    public function trashReport(){
        return MeetingReport:: with(['employee','admin','MeetingReportDetails'])->onlyTrashed()->latest()->get();
    }

    /**
     * update  a specific report status
     * @param int $id , $request
     */
    public function update($request ,$id){
        $report = $this->getSpecificedReport($id);
        $report->status = $request->status;
        if( $request->status == 'approved'){
            $report->approved_by =  Auth::guard('admin')->user()->id;
        }
        else{
            $report->approved_by =  null;
        }
        $report->save();
    }
    /**
     * delete  a specific report
     * @param int $id
     */
    public function delete( $id){
        $report = $this->getSpecificedReport($id);
        $report->delete();
    }
    /**
     * restore  a specific report form trash
     * @param int $id
     */
    public function restore( $id){
        $report = $this->getSpecificedTrashReport($id);
        $report->restore();
    }

    /**
     * permanently delete  a specific report form trash
     * @param int $id
     */
    public function parmanentlyDelete( $id){
        $report = $this->getSpecificedTrashReport($id);
        $report->forceDelete();
    }

    /**
     * get  specified trash report from strorage
     * @param $id
     * @return App\Models\Report
     */
    public function getSpecificedTrashReport($id){
        return  MeetingReport:: with(['employee','admin','MeetingReportDetails'])->onlyTrashed()->where('id',$id)->first();
    }


}
