<?php
namespace App\Repositories\Admin;

use App\Models\Admin;
use App\Models\Employee;
use App\Models\Project;
use App\Models\ProjectTestingReport;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Services\FileService;

class ProjectTestingReportRepository{

    const testReportLocation = "/file/project/testReports/";
    /**
     * show all porojects
     */
    public function index(){
        return ProjectTestingReport::with(['project','testingEmployee'])->latest()->get();
    }

    /**
     * get  a specific test report file
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
     * find  specific test report
     */
    public function findSpecificTestReport($id){
        return  ProjectTestingReport::with(['project','testingEmployee'])->where('id',$id)->first();
    }

    /**
     * update a specific test report status
     * @param $request $id
     */
    public function update($request,$id){
        $testReport = $this->findSpecificTestReport($id);
        $testReport->status = $request->status;
        $testReport->save();
    }
}