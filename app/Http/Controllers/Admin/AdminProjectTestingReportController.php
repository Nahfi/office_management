<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Admin\ProjectTestingReportRepository;
class AdminProjectTestingReportController extends Controller
{

   /**
     * Construct method
     */
    public $projectTestingReportRepository,$user;
    public function __construct(ProjectTestingReportRepository $projectTestingReportRepository)
    {
        $this->middleware(function($request,$next){
            $this->user = Auth::guard('admin')->User();
            return $next($request);
        });
        $this->projectTestingReportRepository = $projectTestingReportRepository;
    }
    /**
     * show all report
     */
    public function index(){
        if(is_null($this->user) || !$this->user->can('project.index')){
            abort(403,'Unauthorized access');
        }
        $testingReports = $this->projectTestingReportRepository->index();
        return view('admin.pages.projectTestReport.index',compact('testingReports'));
    }


    /**
     * Show a edit form for a specefic project test report
     */
    public function edit($id){
        if(is_null($this->user) || !$this->user->can('project.edit')){
            abort(403,'Unauthorized access');
        }
        $testReport = $this->projectTestingReportRepository->findSpecificTestReport($id);
        return view('admin.pages.projectTestReport.edit',compact('testReport'));
    }

    /**
     * Update a specefice project
     */
    public function update(Request $request,$id){
        if(is_null($this->user) || !$this->user->can('project.update')){
            abort(403,'Unauthorized access');
        }
        $request->validate([
            'status'=>'required'
        ]);
        $this->projectTestingReportRepository->update($request,$id);
        return back()->with('test_report_update_success','Test Report Updated Successfully');
    }


    /**
     * download test report
     * @param $id
     */
    public function show($id){
        if(is_null($this->user) || !$this->user->can('project.index')){
            abort(403,'Unauthorized access');
        }
       $response = $this->projectTestingReportRepository->testReportFile($id);

       if($response !=false){
        $filepath = public_path(ProjectTestingReportRepository::testReportLocation.$response);
        return Response()->download($filepath);
       }
       else{
        return back()->with('no_file_found','No Deed file Found');
       }
    }

}
