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

class ProjectRepository{

    const location = "/file/project/requiremnts/";
    const deedFileLocation = "/file/project/deeds/";
    const workOrderFileLocation = "/file/project/workOrders/";
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
     * show all porojects
     */
    public function index(){
        return Project::with(['createdBy','editedBy','customer','employee','tester'])->latest()->get();
    }


    /**
     * get all employee
     */
     public function getAllEmployee(){
         return Employee::with(['createdBy','editedBy'])->latest()->get();
     }
    /**
     * get all customer
     */
     public function getAllCustomer(){
         return User::with(['createdBy','editedBy'])->latest()->get();
     }

   /**
     * store projects
     */
    public function create($request){
        $project = new Project();
        $project->customer_id = $request->customer_id;
        $project->employee_id = $request->employee_id;
        $project->testing_employee_id = $request->testing_employee_id;
        $project->title = $request->title;
        $project->details = $request->details;
        $project->created_by = Auth::guard('admin')->user()->id;
        if( $request->hasFile('requirements')){
            $project->requirements = $this->fileService->upload('project_requirments',ProjectRepository::location,$request->requirements);
        }
        if( $request->hasFile('deed')){
            $project->deed = $this->fileService->upload('project_deed',ProjectRepository::deedFileLocation,$request->deed);
        }
        $project->save();

    }

    /**
     * download  project requirments
     */
    public function requirementsFile($id){
        $project =  $this->findSpecificProject($id);
        if($project->requirements == null){
            return false;
        }
        else{
            return $project->requirements;
        }

    }

    /**
     * download  project deed file
     */
    public function deedFile($id){
        $project =  $this->findSpecificProject($id);
        if($project->deed == null){
            return false;
        }
        else{
            return $project->deed;
        }
    }
    /**
     * download  project deed file
     */
    public function workOrderFile($id){
        $project =  $this->findSpecificProject($id);
        if($project->work_order == null){
            return false;
        }
        else{
            return $project->work_order;
        }

    }

    /**
     * find  specific project
     */
    public function findSpecificProject($id){
        return Project::with(['createdBy','editedBy','customer','employee','tester'])->where('id',$id)->first();
    }
    /**
     * find  specific project test report
     * @param $id
     */
    public function findSpecificProjectTestReport($id){
        return ProjectTestingReport::with(['project','testingEmployee'])->where('project_id',$id)->get();
    }

    /**
     * update a  specific project
     * @param  $request ,$id
     */
    public function update($request,$id){
        $project = $this->findSpecificProject($id);
        $project->customer_id = $request->customer_id;
        $project->employee_id = $request->employee_id;
        $project->testing_employee_id = $request->testing_employee_id;
        $project->title = $request->title;
        $project->details = $request->details;
        $project->status = $request->status;
        $project->edited_by = Auth::guard('admin')->user()->id;
        if( $request->hasFile('requirements')){
            if($project->requirements){
                $this->fileService->delete($project->requirements,ProjectRepository::location);
            }
            $project->requirements = $this->fileService->upload('project_requirments',ProjectRepository::location,$request->requirements);
        }
        if( $request->hasFile('deed')){
            if($project->deed){
                $this->fileService->delete($project->deed,ProjectRepository::deedFileLocation);
            }
            $project->deed = $this->fileService->upload('project_deed',ProjectRepository::deedFileLocation,$request->deed);
        }
        $project->save();
    }
    /**
     * delete  specific project
     */
    public function delete($id){
        $project =  Project::with(['createdBy','editedBy','customer','employee','tester'])->where('id',$id)->first();
        $this->deleteProjectTestingReport($id);
        if($project->requirements){
            $this->fileService->delete($project->requirements,ProjectRepository::location);
        }
        if($project->deed){
            $this->fileService->delete($project->deed,ProjectRepository::deedFileLocation);
        }
        if($project->work_order){
            $this->fileService->delete($project->work_order,ProjectRepository::workOrderFileLocation);
        }
        $project->delete ();
    }

    /**
     * delete project testing report
     * @param $projectId
     */
    public function deleteProjectTestingReport($projectId){
        $testReports =  ProjectTestingReport::with(['project','testingEmployee'])->where('project_id',$projectId)->latest()->get();
        foreach($testReports as $report){
            $this->fileService->delete($report->test_report,ProjectRepository::testReportLocation);
            $report->delete();
        }
    }

}