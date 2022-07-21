<?php
namespace App\Repositories\Employee;
use App\Models\MeetingReport;
use App\Models\MeetingReportDetail;
use Illuminate\Support\Facades\Auth;

class MeetingReportRepository{

    /**
     * store new report in specefice storage
     * @param \Rquests\ReportStoreRequest $request
     */
    public function create($request){
        $report = new MeetingReport();
        $report->title = $request->title;
        $report->employee_id = Auth::guard('employee')->user()->id;
        $report->save();
    }

   /**
     * store new report details in specefice storage
     *
     * @param  $request
     * @return void
     */
    public function createReportDetails($request){
        $meetingReportDetails = new MeetingReportDetail();
        $meetingReportDetails ->meeting_report_id =  $request->id;
        $meetingReportDetails ->report  =  $request->report;
        $meetingReportDetails ->save();
    }


    /**
     * fiind a specific trash report
     * @param int $id
     * @return App\Models\MeetingReport
     */
    public function findSpecificTrashReport($id){
        return MeetingReport::with(['employee','admin','MeetingReportDetails'])->onlyTrashed()->where('id',$id)->first();
    }

    /**
     * fiind a specific report
     * @param int $id
     * @return App\Models\MeetingReport
     */
    public function findSpecificReport($id){
        return MeetingReport::with(['employee','admin','MeetingReportDetails'])->where('id',$id)->first();
    }
    /**
     * fiind a specific report  detaiuls
     * @param int $id
     * @return App\Models\MeetingReportDetail
     */
    public function findSpecificReportDetails($id){
        return MeetingReportDetail::where('id',$id)->first();
    }

    /**
     * update specific report title
     * @param Request $request
     */
    public function updateSpecificReport($request){
       $report = $this->findSpecificReport($request->edit_id);
       $report->title = $request->report_title;
       $report->save();
    }

    /**
     * update specific report details
     * @param Request $request
     */
    public function updateSpecificReportDetails($request){
       $reportDetails = $this->findSpecificReportDetails($request->edit_details_id);
       $reportDetails->report = $request->report_details;
       $reportDetails->save();
    }

    /**
     * delete report details
     *
     * @param int $meeting_report_id
     * @return void
     */
    public function deleteReportDetails($meeting_report_id){
        MeetingReportDetail::where('meeting_report_id',$meeting_report_id)->delete();
    }
    /**
     * delete a specific report
     * @param $id
     */
    public function deleteSpecificReport($id){
        $report = $this->findSpecificReport($id);
        $report->delete();
    }
    /**
     * delete a specific report details
     * @param $id
     */
    public function deleteSpecificReportDetails($id){
        $report = $this->findSpecificReportDetails($id);
        $report->delete();
    }
    /**
     * permanently delete a specific report
     * @param $id
     */
    public function permanentlyDeleteSpecificReport($id){
        $report = $this->findSpecificTrashReport($id);
        $this->deleteReportDetails( $report->id);
        $report->forceDelete();
    }


    /**
     * restore a trash report
     * @param $id
     */
    public function restoreTrashReport($id){
        $report = $this->findSpecificTrashReport($id);
        $report->restore();
    }
    /**
     * search reports
     * @param string $type , Request $request
     */
    public function searchReports($type , $request){
            if($request->startDate == ''){
                return $this->searchByDate($type ,$request->endDate);
            }
            if($request->endDate == ''){
               return $this->searchByDate($type ,$request->startDate);
            }
            else{
                return $this->searchBetweenDate($type ,$request->startDate,$request->endDate);
            }
    }

    /**
     * count total reports by dates
     * @param $request
     * @return $countReport
     */
    public function countTotalReports($request){
        if($request->startDate == ''){
            return count(MeetingReport::with(['employee','admin','MeetingReportDetails'])->withTrashed()->whereDate('created_at',$request->endDate)->get()->toArray());
        }
        if($request->endDate == ''){
            return count(MeetingReport::with(['employee','admin','MeetingReportDetails'])->withTrashed()->whereDate('created_at',$request->startDate)->get()->toArray());
        }
        else{
            return count( MeetingReport::with(['employee','admin','MeetingReportDetails'])->withTrashed()->whereDate('created_at', '>=', $request->startDate)->whereDate('created_at', '<=', $request->endDate)->get()->toArray());
        }
    }

    /**
     * search report by date
     * @param $type ,$date
     * @return  App\Models\MeetingReport;
     */
    public function searchByDate($type ,$date){
        if($type == 'deleted'){
            return MeetingReport::with(['employee','admin','MeetingReportDetails'])->onlyTrashed()->whereDate('created_at',$date)->get();
        }
        else{
            return MeetingReport::with(['employee','admin','MeetingReportDetails'])->where('status',$type)->whereDate('created_at',$date)->get();
        }
    }
    /**
     * search bettween date
     * @param $type , $startDate,$endDate
     *  @return App\Models\MeetingReport;
     */
    public function searchBetweenDate($type , $startDate,$endDate){
        if($type == 'deleted'){
            return MeetingReport::with(['employee','admin','MeetingReportDetails'])->onlyTrashed()->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate)->get();
        }
        else{
            return MeetingReport::with(['employee','admin','MeetingReportDetails'])->where('status',$type)->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate)->get();
        }
    }
}
