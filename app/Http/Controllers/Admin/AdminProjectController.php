<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Admin\ProjectRepository;
use App\Http\Requests\admin\ProjectStoreRequest;
use App\Http\Requests\admin\ProjectUpdateRequest;

class AdminProjectController extends Controller
{

   /**
     * Construct method
     */
    public $projectRepository,$user;
    public function __construct(ProjectRepository $projectRepository)
    {
        $this->middleware(function($request,$next){
            $this->user = Auth::guard('admin')->User();
            return $next($request);
        });
        $this->projectRepository = $projectRepository;
    }
    /**
     * show all project
     */
    public function index(){
        if(is_null($this->user) || !$this->user->can('project.index')){
            abort(403,'Unauthorized access');
        }
        $projects = $this->projectRepository->index();
        return view('admin.pages.project.index',compact('projects'));
    }

   /**
     * show create new project form
     */
    public function create(){
        if(is_null($this->user) || !$this->user->can('project.create')){
            abort(403,'Unauthorized access');
        }
        $employees = $this->projectRepository->getAllEmployee();
        $customers = $this->projectRepository->getAllCustomer();
        return view('admin.pages.project.create',compact('employees','customers'));
    }

    /**
     * Store a new project
     */
    public function store(ProjectStoreRequest $request){
        if(is_null($this->user) || !$this->user->can('project.create')){
            abort(403,'Unauthorized access');
        }
        $this->projectRepository->create($request);
        return back()->with('project_store_success','Project Added Successfully');
    }

   /**
     * show a sepecefiec customer
     */
    public function show($id){
        if(is_null($this->user) || !$this->user->can('project.index')){
            abort(403,'Unauthorized access');
        }
        $project = $this->projectRepository->findSpecificProject($id);
        return view('admin.pages.project.show',compact('project'));
    }
   /**
     * show a sepecefiec customer
     */
    public function showTestReport($id){
        if(is_null($this->user) || !$this->user->can('project.index')){
            abort(403,'Unauthorized access');
        }
        $testingReports = $this->projectRepository->findSpecificProjectTestReport($id);
        return view('admin.pages.projectTestReport.index',compact('testingReports'));
    }

    /**
     * Show a edit form for a specefic project
     */
    public function edit($id){
        if(is_null($this->user) || !$this->user->can('project.edit')){
            abort(403,'Unauthorized access');
        }
        $employees = $this->projectRepository->getAllEmployee();
        $customers = $this->projectRepository->getAllCustomer();
        $project = $this->projectRepository->findSpecificProject($id);
        return view('admin.pages.project.edit',compact('employees','customers','project'));
    }

    /**
     * Update a specefice project
     */
    public function update( ProjectUpdateRequest $request,$id){
        if(is_null($this->user) || !$this->user->can('project.update')){
            abort(403,'Unauthorized access');
        }
        $this->projectRepository->update($request,$id);
        return back()->with('project_update_success','Project Updated Successfully');
    }

   /**
     * delete a project
     */
    public function delete($id){
        if(is_null($this->user) || !$this->user->can('project.delete')){
            abort(403,'Unauthorized access');
        }
        $project = $this->projectRepository->delete($id);
        return back()->with('project_deleted','Project Deleted Successfully');
    }

    /**
     * download Requirments
     * @param $d
     */
    public function downloadRequirment($id){
        if(is_null($this->user) || !$this->user->can('project.index')){
            abort(403,'Unauthorized access');
        }
       $response = $this->projectRepository->requirementsFile($id);

       if($response !=false){
        $filepath = public_path(ProjectRepository::location.$response);
        return Response()->download($filepath);
       }
       else{
        return back()->with('no_file_found','No Requirments file Found');
       }
    }

    /**
     * download  deed
     * @param $d
     */
    public function downloadDeed($id){
        if(is_null($this->user) || !$this->user->can('project.index')){
            abort(403,'Unauthorized access');
        }
       $response = $this->projectRepository->deedFile($id);

       if($response !=false){
        $filepath = public_path(ProjectRepository::deedFileLocation.$response);
        return Response()->download($filepath);
       }
       else{
        return back()->with('no_file_found','No Deed file Found');
       }
    }
    /**
     * download  work order
     * @param $d
     */
    public function downloadWorkOrder($id){
        if(is_null($this->user) || !$this->user->can('project.index')){
            abort(403,'Unauthorized access');
        }
       $response = $this->projectRepository->workOrderFile($id);

       if($response !=false){
        $filepath = public_path(ProjectRepository::workOrderFileLocation.$response);
        return Response()->download($filepath);
       }
       else{
        return back()->with('no_file_found','No Work Order file Found');
       }
    }

}
