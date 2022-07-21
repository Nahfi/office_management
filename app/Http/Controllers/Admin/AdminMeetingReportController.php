<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\admin\EmployeeMeetingReportUpdateRequest;
use App\Repositories\Admin\MeetingReportRepository;
use Illuminate\Support\Facades\Auth;
class AdminMeetingReportController extends Controller
{
    /**
     * Construct method
     */
    public $meetingReportRepository,$user;
    public function __construct(MeetingReportRepository $meetingReportRepository)
    {
        $this->middleware(function($request,$next){
            $this->user = Auth::guard('admin')->User();
            return $next($request);
        });
        $this->meetingReportRepository = $meetingReportRepository;
    }
    /**
     * show all meeting report
     */
    public function index(){

        if(is_null($this->user) || !$this->user->can('meeting.report.index')){
            abort(403,'Unauthorized access');
        }
        $meetingReports = $this->meetingReportRepository->index();
        return view('admin.pages.meetingReport.index',compact('meetingReports'));
    }

    /**
     * show all deleted work report
     */
    public function showDeletedMeetingReport(){
        if(is_null($this->user) || !$this->user->can('meeting.report.index')){
            abort(403,'Unauthorized access');
        }
        $meetingReports = $this->meetingReportRepository->trashReport();
        return view('admin.pages.meetingReport.index',compact('meetingReports'));
    }

    /**
     * show a sepecefiec report
     */
    public function show($id){
        if(is_null($this->user) || !$this->user->can('meeting.report.index')){
            abort(403,'Unauthorized access');
        }
        $report =$this->meetingReportRepository->getSpecificedReport($id);
        return view('admin.pages.meetingReport.show',compact('report'));


    }

    /**
     * show a edit form of  a report
     */
    public function edit($id){
        if(is_null($this->user) || !$this->user->can('meeting.report.status.edit')){
            abort(403,'Unauthorized access');
        }
        $report = $this->meetingReportRepository->getSpecificedReport($id);
        return view('admin.pages.meetingReport.edit',compact('report'));
    }

    /**
     * update a specefied report
     */
    public function update(EmployeeMeetingReportUpdateRequest $request,$id){
        if(is_null($this->user) || !$this->user->can('meeting.report.status.update')){
            abort(403,'Unauthorized access');
        }
        $this->meetingReportRepository->update($request,$id);
        return back()->with('report_update_success','Report Status Updated Successfully');
    }

    /**
     * delete a specefit report
     */
    public function destroy ($id){
        if(is_null($this->user) || !$this->user->can('meeting.report.delete')){
            abort(403,'Unauthorized access');
        }
        $this->meetingReportRepository->delete($id);
        return back()->with('report_delete_success','Report Deleted Successfully');
    }
    /**
     * restore a specefied report
     */
    public function restore($id){
        if(is_null($this->user) || !$this->user->can('meeting.report.restore')){
            abort(403,'Unauthorized access');
        }
        $this->meetingReportRepository->restore($id);
        return back()->with('report_restore_success','Report Restored Successfully');
    }
    /**
     * parmanently delete a report
     */
    public function parmanentDelete($id){
        if(is_null($this->user) || !$this->user->can('meeting.report.parmanentDelete')){
            abort(403,'Unauthorized access');
        }
        $this->meetingReportRepository->parmanentlyDelete($id);
        return back()->with('report_parmanent_delete_success','Report Parmanently Deleted Successfullsy');
    }

}