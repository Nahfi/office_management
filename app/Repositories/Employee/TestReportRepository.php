<?php
namespace App\Repositories\Employee;
use App\Models\MeetingReport;
use App\Models\MeetingReportDetail;
use App\Models\Project;
use App\Models\ProjectTestingReport;
use Illuminate\Support\Facades\Auth;
use App\Services\FileService;

class TestReportRepository{

    const testReportLocation = "/file/project/testReports/";
    /**
     * constact a method
     */
    public $fileService;
    public function __construct()
    {
        $this->fileService = new FileService();
    }
    /**
     * get all  project testing report
     */
    public  function index(){
        return Project::with(['createdBy','editedBy','customer','employee','tester'])->where('testing_employee_id',Auth::guard('employee')->user()->id)->latest()->get();
        // return ProjectTestingReport::with(['project','testingEmployee'])->where('employee_id',Auth::guard('employee')->user()->id)->get();
    }

    /**
     * get all  project
     */
    public  function getAllProject(){
        return Project::with(['createdBy','editedBy','customer','employee','tester'])->where('testing_employee_id',Auth::guard('employee')->user()->id)->latest()->get();
    }

    /**
     * store a test report
     * @param $request
     */
    public  function create($request){
        $testReport = new ProjectTestingReport();
        $testReport->project_id = $request->project_id;
        $testReport->employee_id = Auth::guard('employee')->user()->id;
        $testReport->test_report = $this->fileService ->upload("test_report",TestReportRepository::testReportLocation,$request->test_report);
        $testReport->save();
    }

    /**
     * store new work order in specefice storage
     * @param $request
     */
    public function update($request,$id){

        $testReport = $this->findSpecificTestReport($id);
        if( $request->hasFile('test_report')){
            if($testReport->test_report){
                $this->fileService->delete($testReport->test_report,TestReportRepository::testReportLocation);
            }
            $testReport->test_report = $this->fileService->upload('test_report',TestReportRepository::testReportLocation,$request->test_report);
        }
        $testReport->save();

    }

    /**
     * update status
     * @param $request ,$id
     */
    public function updateStatus($request,$id){

        $testReport = $this->findSpecificTestReport($id);
        $testReport->status =$request->status;
        $testReport->save();

    }

    /**
     * download  project deed file
     */
    public function testReportFile($id){
        $testReport =  $this->findSpecificTestReport($id);
        if($testReport->test_report == null){
            return false;
        }
        else{
            return $testReport->test_report;
        }

    }

    /**
     * delete a specific project work ordert
     * @param $id
     */
    public function delete($id){
        $testReport = $this->findSpecificTestReport($id);
            if($testReport->test_report){
                $this->fileService->delete($testReport->test_report,TestReportRepository::testReportLocation);
            }
        $testReport->delete();
    }

    /**
     * find  specific test report
     */
    public function findSpecificTestReport($id){
        return  ProjectTestingReport::with(['project','testingEmployee'])->where('id',$id)->first();
    }

    /**
     * find all test  report under a projects
     * @param $id
     */
    public function findProjectTestReport($id){
        return  ProjectTestingReport::with(['project','testingEmployee'])->where('project_id',$id)->get();
    }
}