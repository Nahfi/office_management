<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Employee\TestReportRepository;
class EmployeeProjectTestingReportController extends Controller
{
    /**
     * constract a method
     */
    public $testReportRepository ;
    public function __construct(){
        $this->testReportRepository = new TestReportRepository();
    }

    /**
     * Display a listing of the test report
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $projects = $this->testReportRepository->index();
        return view('employee.pages.projectTestReport.index',compact('projects'));
    }

    /**
     * show test report form
     */
    public function create($id){
        return view('employee.pages.projectTestReport.create',compact('id'));
    }


    /**
     * store a test report
     * @return void
     */
    public function store(Request $request){
        $request->validate([
            'project_id'=>'required',
            "test_report"=>'required'
        ]);
        $testReport = $this->testReportRepository->create($request);
        return back()->with('test_report_add_success','Test Report Created Successfully');
    }
    /**
     * edit a specvific project work order
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $testReport = $this->testReportRepository->findSpecificTestReport($id);
        return view('employee.pages.projectTestReport.edit',compact('testReport'));
    }
    /**
     * update a  work order
     * @param $request ,$id
     */

     public function update(Request $request,$id){
         $request->validate([
             'test_report'=>'required'
         ]);
        $this->testReportRepository->update($request,$id);
        return back()->with('test_report_update_success','Project Test Report Updated Successfully');
     }

    /**
     * update a  test report status
     * @param $request ,$id
     */
     public function updateStatus(Request $request,$id){
         $request->validate([
             'status'=>'required'
         ]);

        $this->testReportRepository->updateStatus($request,$id);
        return back()->with('test_report_update_success','Project Test Report Status Updated Successfully');
     }

    /**
     * download a specific  work worder.
     */
    public function show($id)
    {
        $response = $this->testReportRepository->testReportFile($id);
        if($response !=false){
         $filepath = public_path(testReportRepository::testReportLocation.$response);
         return Response()->download($filepath);
        }
        else{
         return back()->with('no_file_found','No Test Report file Found');
        }

    }


    /**
     * show all testing report under a specific project
     * @param $id
     */
    public function showTestReport($id){
        $testReports = $this->testReportRepository-> findProjectTestReport($id);
        return view('employee.pages.projectTestReport.testReport',compact('testReports'));
    }


    /**
     * destory an specific project report work order
     */
    public function destroy($id){
        $this->testReportRepository->delete($id);
        return back()->with('test_report_delete_success','Project Test Report Deleted Successfully');
    }
}