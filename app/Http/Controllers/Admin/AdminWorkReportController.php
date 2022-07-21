<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\admin\EmployeeWorkReportUpdateRequest;
use App\Repositories\Admin\WorkReportRepository;
use Illuminate\Support\Facades\Auth;
class AdminWorkReportController extends Controller
{
    /**
     * Construct method
     */
    public $workReportRepository,$user;
    public function __construct(WorkReportRepository $workReportRepository)
    {
        $this->middleware(function($request,$next){
            $this->user = Auth::guard('admin')->User();
            return $next($request);
        });
        $this->workReportRepository = $workReportRepository;
    }
    /**
     * show all work report
     */
    public function index(){

        if(is_null($this->user) || !$this->user->can('work.report.index')){
            abort(403,'Unauthorized access');
        }
        $workReports = $this->workReportRepository->index();
        return view('admin.pages.workReport.index',compact('workReports'));
    }

    /**
     * show all deleted work report
     */
    public function showDeletedWorkReport(){
        if(is_null($this->user) || !$this->user->can('work.report.index')){
            abort(403,'Unauthorized access');
        }
        $workReports = $this->workReportRepository->trashReport();
        return view('admin.pages.workReport.index',compact('workReports'));
    }

    /**
     * show a sepecefiec report
     */
    public function show($id){
        if(is_null($this->user) || !$this->user->can('work.report.index')){
            abort(403,'Unauthorized access');
        }
        $report =$this->workReportRepository->getSpecificedReport($id);
        return view('admin.pages.workReport.show',compact('report'));


    }

    /**
     * show a edit form of  a report
     */
    public function edit($id){
        if(is_null($this->user) || !$this->user->can('work.report.status.edit')){
            abort(403,'Unauthorized access');
        }
        $report = $this->workReportRepository->getSpecificedReport($id);
        return view('admin.pages.workReport.edit',compact('report'));
    }

    /**
     * update a specefied report
     */
    public function update(EmployeeWorkReportUpdateRequest $request,$id){
        if(is_null($this->user) || !$this->user->can('work.report.status.update')){
            abort(403,'Unauthorized access');
        }
        $this->workReportRepository->update($request,$id);
        return back()->with('report_update_success','Report Status Updated Successfully');
    }

    /**
     * delete a specefit report
     */
    public function destroy ($id){
        if(is_null($this->user) || !$this->user->can('work.report.delete')){
            abort(403,'Unauthorized access');
        }
        $this->workReportRepository->delete($id);
        return back()->with('report_delete_success','Report Deleted Successfully');
    }
    /**
     * restore a specefied report
     */
    public function restore($id){
        if(is_null($this->user) || !$this->user->can('work.report.restore')){
            abort(403,'Unauthorized access');
        }
        $this->workReportRepository->restore($id);
        return back()->with('report_restore_success','Report Restored Successfully');
    }
    /**
     * parmanently delete a report
     */
    public function parmanentDelete($id){
        if(is_null($this->user) || !$this->user->can('work.report.parmanentDelete')){
            abort(403,'Unauthorized access');
        }
        $this->workReportRepository->parmanentlyDelete($id);
        return back()->with('report_parmanent_delete_success','Report Parmanently Deleted Successfullsy');
    }

}
