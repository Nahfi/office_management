<?php

namespace App\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Employee\MeetingReportRepository;
use App\Http\Requests\employee\MeetingReportStoreRequest;
use App\Models\MeetingReport;
use Illuminate\Support\Facades\Auth;

class EmployeeMeetingReportController extends Controller
{
    /**
     * constract a method
     */
    public $meetingReportRepository ,$pendingReports ,$approvedReports , $deletedReports , $countReports;
    public function __construct(){
        $this->meetingReportRepository   =  new MeetingReportRepository();
    }

    /**
     * Display a listing of the report.
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $pendingReports =  MeetingReport::getReport('pending',Auth::guard('employee')->user()->id);
        $approvedReports  =  MeetingReport::getReport('approved',Auth::guard('employee')->user()->id);
        $deletedReports  =   MeetingReport::getReport('deleted',Auth::guard('employee')->user()->id);
        $countReports  =   MeetingReport::countReport(Auth::guard('employee')->user()->id);
        return view('employee.pages.meetingReport.index',compact('pendingReports','approvedReports','deletedReports','countReports'));
    }

    /**
     * Show the form for creating a new report.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employee.pages.meetingReport.create');
    }

    /**
     * Store a newly created report in storage.
     * @param  App\Http\Requests\employee\MeetingReportStoreRequest
     * @return \Illuminate\Http\Response
     */
    public function store(MeetingReportStoreRequest $request)
    {
        $this->meetingReportRepository ->create($request);
        return back()->with('report_added','Report Added Successfully');
    }

    /**
     * Store a newly created report in storage.
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function detailsStore (Request $request)
    {
        $this->meetingReportRepository ->createReportDetails($request);
        return  $this->returnJsonResponse();
    }

   /**
     * Show the form for editing the specified report title resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $report = $this->meetingReportRepository ->findSpecificReport($id);
        return json_encode([
            'report'=>$report->title
        ]);
    }
   /**
     * Show the form for editing the specified report title resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editDetails($id)
    {
        $reportDetails = $this->meetingReportRepository ->findSpecificReportDetails($id);
        return json_encode([
            'reportDetails'=>$reportDetails->report
        ]);
    }

    /**
     * Update the specified report in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $this->meetingReportRepository ->updateSpecificReport($request);
        return  $this->returnJsonResponse();
    }

    /**
     * Update the specified report details in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return returnJsonResponse
     */

    public function updateDetails(Request $request)
    {
        $this->meetingReportRepository ->updateSpecificReportDetails($request);
        return  $this->returnJsonResponse();
    }

   /**
     * Remove the specified report  from storage.
     *
     * @param  int  $id
     * @return  returnJsonResponse
     */
    public function destroy($id)
    {
        $this->meetingReportRepository ->deleteSpecificReport($id);
        return $this->returnJsonResponse();
    }

   /**
     * Remove the specified report  details from storage.
     *
     * @param  int  $id
     * @return  returnJsonResponse
     */
    public function destroyDetails($id)
    {
        $this->meetingReportRepository ->deleteSpecificReportDetails($id);
        return $this->returnJsonResponse();
    }

   /**
     * Permanently Remove the specified report  from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function parmanentDelete($id){
        $this->meetingReportRepository ->permanentlyDeleteSpecificReport($id);
    }

    /**
     * restore a specific trash report
     * @param $id
     * @return   returnJsonResponse
     */
    public function restore($id){
        $this->meetingReportRepository ->restoreTrashReport($id);
        return $this->returnJsonResponse();
    }

    /**
     * search specific report
     * @param Request $request
     * @return  returnJsonResponse
     */
    public function search(Request $request){
        $pendingReports = $this->meetingReportRepository ->searchReports('pending',$request);
        $approvedReports  =  $this->meetingReportRepository ->searchReports('approved',$request);
        $deletedReports  =    $this->meetingReportRepository ->searchReports('deleted',$request);
        $countReports  =  $this-> meetingReportRepository ->countTotalReports($request);
        return response()->json([
            'view' => view('employee.pages.includes.meetingReport',compact('pendingReports','approvedReports','deletedReports','countReports'))->render()
        ],200);

    }


    /**
     * @return json respose
     */
    public function returnJsonResponse(){
        $pendingReports =  MeetingReport::getReport('pending',Auth::guard('employee')->user()->id);
        $approvedReports  =  MeetingReport::getReport('approved',Auth::guard('employee')->user()->id);
        $deletedReports  =   MeetingReport::getReport('deleted',Auth::guard('employee')->user()->id);
        $countReports  =MeetingReport::countReport(Auth::guard('employee')->user()->id);;
        return response()->json([
            'view' => view('employee.pages.includes.meetingReport',compact('pendingReports','approvedReports','deletedReports','countReports'))->render()
        ],200);
    }



}