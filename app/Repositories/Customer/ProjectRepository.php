<?php
namespace App\Repositories\Customer;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
class ProjectRepository{

    const deedFileLocation = "/file/project/deeds/";
    /**
     * get all project of login customer
     */
    public function index(){
        return Project::with(['createdBy','editedBy','customer','employee','tester'])->where('customer_id',Auth::guard('web')->user()->id)->get();

    }

    /**
     * find  specific project
     */
    public function findSpecificProject($id){
        return Project::with(['createdBy','editedBy','customer','employee','tester'])->where('id',$id)->first();
    }
    /**
     * download deed
     * @param $id
     */
    public function downloadDeed($id){
        $project =  $this->findSpecificProject($id);
        if($project->deed == null){
            return false;
        }
        else{
            return $project->deed;
        }
    }
}
