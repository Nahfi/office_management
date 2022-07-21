<?php
    function generalSettings(){
        $generalSettings = App\Models\GeneralSettings::latest()->first();
        return $generalSettings;
    }

    //pending workreport count
    function pendingWorkReport(){
        return App\Models\Report::where('status','Pending')->count();
    }

    //pending meeting report
    function pendingMettingReport(){
        return App\Models\MeetingReport::where('status','Pending')->count();
    }


    //pending attendance count
    function pendingAttendance(){
        return App\Models\Attendance::where('status','Pending')->count();
    }


    //pending leave request
    function pendingLeaveRequest(){
        return App\Models\LeaveRequest::where('status','Pending')->count();
    }