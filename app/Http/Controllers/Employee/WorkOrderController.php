<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Employee\WorkOrderRepository;


class WorkOrderController extends Controller
{
    /**
     * constract a method
     */
    public $workOrderRepository ;
    public function __construct(){
        $this->workOrderRepository = new WorkOrderRepository();
    }

    /**
     * Display a listing of the assigned project
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $projects = $this->workOrderRepository->index();
        return view('employee.pages.workOrder.index',compact('projects'));
    }

    /**
     * edit a specvific project work order
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = $this->workOrderRepository->findSpecificProject($id);
        return view('employee.pages.workOrder.edit',compact('project'));
    }
    /**
     * store a  work order
     * @param $request ,$id
     */

     public function update(Request $request,$id){
         $request->validate([
             'work_order'=>'required'
         ]);
        $this->workOrderRepository->update($request,$id);
        return back()->with('work_order_update_success','Project Work Order Updated Successfully');
     }

    /**
     * download a specific  work worder.
     */
    public function show($id)
    {
        $response = $this->workOrderRepository->workOrderFile($id);

        if($response !=false){
         $filepath = public_path(WorkOrderRepository::workOrderFileLocation.$response);
         return Response()->download($filepath);
        }
        else{
         return back()->with('no_file_found','No Work Order file Found');
        }

    }

    /**
     * @param int $id
     * @return void
     */
    public function showDetails($id){
        $project = $this->workOrderRepository->findSpecificProject($id);
        return view('employee.pages.workOrder.show',compact('project'));
    }
    /**
     * @param int $id
     * @return void
     */
    public function showTestReport($id){
        $testReports = $this->workOrderRepository->testReport($id);
        return view('employee.pages.workOrder.testReport',compact('testReports'));
    }
    /**
     * download project requirments
     * @param $id
     */
    public function downloadRequirment($id){
        $response = $this->workOrderRepository->requirmentsFile($id);

        if($response !=false){
         $filepath = public_path(WorkOrderRepository::requirmentsFilelocation.$response);
         return Response()->download($filepath);
        }
        else{
         return back()->with('no_file_found','No project Requirments File Found');
        }
    }
    /**
     * destory an specific project report work order
     */
    public function destroy($id){
        $this->workOrderRepository->delete($id);
        return back()->with('work_order_delete_success','Project Work Order Deleted Successfully');
    }

}