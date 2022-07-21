<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Customer\ProjectRepository;
class CustomerProjectController extends Controller
{
    /**
     * constract a method
     */
    public $projectRepository;
    public function __construct()
    {
        $this->projectRepository = new ProjectRepository();
    }

    /**
     * get all project of  login customer
     */
    public function index(){
        $projects = $this->projectRepository->index();
        return view('customer.pages.Project.index',compact('projects'));
    }

    /**
     * download deed
     */
    public function show($id){
        $response = $this->projectRepository->downloadDeed($id);
        if($response !=false){
            $filepath = public_path(ProjectRepository::deedFileLocation.$response);
            return Response()->download($filepath);
           }
        else{
            // dd('ddd');
            return back()->with('no_file_found','No Deed file Found');
        }
    }

    /**
     * show a specific project details
     * @param $id
     */

     public function showDetails($id){
        $project = $this->projectRepository->findSpecificProject($id);
        return view('customer.pages.Project.show',compact('project'));

     }
}
