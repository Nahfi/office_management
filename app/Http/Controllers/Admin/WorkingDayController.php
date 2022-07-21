<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkingDayStoreRequest;
use App\Http\Requests\WorkingDayUpdateRequest;
use App\Repositories\Admin\WorkingDayRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkingDayController extends Controller
{
    /**
     * Construct method
     */
    public $user,$workingDayRepositor;
    public function __construct(WorkingDayRepository $workingDayRepository )
    {
        $this->middleware(function($request,$next){
            $this->user = Auth::guard('admin')->User();
            return $next($request);
        });
        $this->workingDayRepository = $workingDayRepository;
    }

    /**
     * Show all working day
     */
    public function index(){
        if(is_null($this->user) || !$this->user->can('workingDay.index')){
            abort(403,'Unauthorized access');
        }
        $workingDays = $this->workingDayRepository->index();
        return view('admin.pages.workingDay.index',[
            'workingDays' => $workingDays
        ]);
    }

    /**
     * show a form for createing new item
     */
    public function create(){
        if(is_null($this->user) || !$this->user->can('workingDay.create')){
            abort(403,'Unauthorized access');
        }
        return view('admin.pages.workingDay.create');
    }

    /**
     * store a item in specificed storage
     */
    public function store(WorkingDayStoreRequest $request){
        if(is_null($this->user) || !$this->user->can('workingDay.create')){
            abort(403,'Unauthorized access');
        }
        $this->workingDayRepository->create($request);
        return back()->with('working_day_add_success','Working Day Added Successfully');
    }

    /**
     * get a speceficed item
     */
    public function edit($id){
        if(is_null($this->user) || !$this->user->can('workingDay.update')){
            abort(403,'Unauthorized access');
        }
        $workingDay = $this->workingDayRepository->getSpecificedItem($id);
        return view('admin.pages.workingDay.edit',[
            'workingDay' => $workingDay
        ]);
    }

    /**
     * update a specefied item
     */
    public function update(WorkingDayUpdateRequest $request,$id){
        if(is_null($this->user) || !$this->user->can('workingDay.update')){
            abort(403,'Unauthorized access');
        }
        $this->workingDayRepository->update($request,$id);
        return back()->with('working_day_update_success','Working Day Updated Successfully');
    }

    /**
     * destory a speceficed item
     */
    public function destroy($id){
        if(is_null($this->user) || !$this->user->can('workingDay.delete')){
            abort(403,'Unauthorized access');
        }
        $this->workingDayRepository->destroy($id);
        return back()->with('woking_day_delete_success','Working Day Deleted Successfully');
    }
}
