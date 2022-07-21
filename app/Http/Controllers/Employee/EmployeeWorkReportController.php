<?php
namespace App\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\employee\WorkReportStoreRequest;
use App\Repositories\Employee\WorkReportRepository;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class EmployeeWorkReportController extends Controller
{
    /**
     * constract a method
     */
    public $workReportRepository ,$pendingReports ,$approvedReports , $deletedReports , $countReports;
    public function __construct(){
        $this->workReportRepository   =  new WorkReportRepository();
    }
     /**
     * Display a listing of the report.
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $pendingReports =   Report::getReport('pending',Auth::guard('employee')->user()->id);
        $approvedReports  =  Report::getReport('approved',Auth::guard('employee')->user()->id);
        $deletedReports  =  Report::getReport('deleted',Auth::guard('employee')->user()->id);
        $countReports  =  Report::countReport(Auth::guard('employee')->user()->id);
        return view('employee.pages.workReport.index',compact('pendingReports','approvedReports','deletedReports','countReports'));
    }

    /**
     * Show the form for creating a new report.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employee.pages.workReport.create');
    }

    /**
     * Store a newly created report in storage.
     * @param  App\Http\Requests\employee\WorkReportStoreRequest
     * @return \Illuminate\Http\Response
     */
    public function store(WorkReportStoreRequest $request)
    {
        $this->workReportRepository ->create($request);
        return back()->with('report_added','Report Added Successfully');
    }

    /**
     * Store a newly created report in storage.
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function detailsStore (Request $request)
    {
        $this->workReportRepository ->createReportDetails($request);
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
        $report = $this->workReportRepository ->findSpecificReport($id);
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
        $reportDetails = $this->workReportRepository ->findSpecificReportDetails($id);
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
        $this->workReportRepository ->updateSpecificReport($request);
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
        $this->workReportRepository ->updateSpecificReportDetails($request);
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
        $this->workReportRepository ->deleteSpecificReport($id);
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
        $this->workReportRepository ->deleteSpecificReportDetails($id);
        return $this->returnJsonResponse();
    }

   /**
     * Permanently Remove the specified report  from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function parmanentDelete($id){
        $this->workReportRepository ->permanentlyDeleteSpecificReport($id);
    }

    /**
     * restore a specific trash report
     * @param $id
     * @return   returnJsonResponse
     */
    public function restore($id){
        $this->workReportRepository ->restoreTrashReport($id);
        return $this->returnJsonResponse();
    }

    /**
     * search specific report
     * @param Request $request
     * @return  returnJsonResponse
     */
    public function search(Request $request){
        $pendingReports = $this->workReportRepository ->searchReports('pending',$request);
        $approvedReports  =  $this->workReportRepository ->searchReports('approved',$request);
        $deletedReports  =    $this->workReportRepository ->searchReports('deleted',$request);
        $countReports  =  $this-> workReportRepository ->countTotalReports($request);
        return response()->json([
            'view' => view('employee.pages.includes.workReport',compact('pendingReports','approvedReports','deletedReports','countReports'))->render()
        ],200);

    }
    /**
     * @return json respose
     */
    public function returnJsonResponse(){
        $pendingReports =  Report::getReport('pending',Auth::guard('employee')->user()->id);
        $approvedReports  =  Report::getReport('approved',Auth::guard('employee')->user()->id);
        $deletedReports  =   Report::getReport('deleted',Auth::guard('employee')->user()->id);
        $countReports  =  Report::countReport(Auth::guard('employee')->user()->id);
        return response()->json([
            'view' => view('employee.pages.includes.workReport',compact('pendingReports','approvedReports','deletedReports','countReports'))->render()
        ],200);
    }
}