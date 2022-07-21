<?php
namespace App\Repositories\Employee;
use App\Models\MeetingReport;
use App\Models\MeetingReportDetail;
use App\Models\Project;
use App\Models\ProjectTestingReport;
use Illuminate\Support\Facades\Auth;
use App\Services\FileService;

class WorkOrderRepository{

    const workOrderFileLocation = "/file/project/workOrders/";
    const requirmentsFilelocation = "/file/project/requiremnts/";
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
     * get all assigned project
     */
    public  function index(){
        return Project::with(['createdBy','editedBy','customer','employee','tester'])->where('employee_id',Auth::guard('employee')->user()->id)->get();
    }

    /**
     * store new work order in specefice storage
     * @param $request
     */
    public function update($request,$id){
        $project = $this->findSpecificProject($id);
        if( $request->hasFile('work_order')){
            if($project->work_order){
                $this->fileService->delete($project->work_order,WorkOrderRepository::workOrderFileLocation);
            }
            $project->work_order = $this->fileService->upload('project_work_order',WorkOrderRepository::workOrderFileLocation,$request->work_order);
        }
        $project->save();

    }

    /**
     * download  project work order file
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
     * download  project requirments file
     */
    public function requirmentsFile($id){
        $project =  $this->findSpecificProject($id);
        if($project->requirements == null){
            return false;
        }
        else{
            return $project->requirements;
        }

    }

    /**
     * delete a specific project work ordert
     * @param $id
     */
    public function delete($id){
        $project = $this->findSpecificProject($id);
            if($project->work_order){
                $this->fileService->delete($project->work_order,WorkOrderRepository::workOrderFileLocation);
                $project->work_order = null;
            }
        $project->save();
    }

    /**
     * find  specific project
     */
    public function findSpecificProject($id){
        return Project::with(['createdBy','editedBy','customer','employee','tester'])->where('id',$id)->first();
    }
    /**
     * find  specific project test reports
     */
    public function testReport($id){
        return  ProjectTestingReport::with(['project','testingEmployee'])->where('project_id',$id)->get();
    }
}