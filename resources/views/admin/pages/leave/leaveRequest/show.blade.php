@extends('layouts.admin.admin_app')
@section('leave_active')
    mm-active
@endsection
@section('leave_request_active')
    active
@endsection
@section('admin_page_title')
    Leave Details | BIR it
@endsection
@section('admin_content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Leave Request details</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.leaveRequest.index') }}">All Leave Reqeust</a></li>
                            <li class="breadcrumb-item active">Leave Request Details</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12 m-auto">
                <div class="card">
                    <div class="card-body">
                        
                      
                        <table class="table table-bordered text-center">
                            <tbody>
                                <tr>
                                    <th>Employee Name:</th>
                                    <td>{{ $leaveRequest->employee->name }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>{{ $leaveRequest->status }}</td>
                                </tr>
                                <tr>
                                    <th>From:</th>
                                    <td>{{ $leaveRequest->from }}</td>
                                </tr>
                                <tr>
                                    <th>To:</th>
                                    <td>{{ $leaveRequest->to }}</td>
                                </tr>
                                <tr>
                                    <th>Subject:</th>
                                    <td>{{ $leaveRequest->subject }}</td>
                                </tr>
                                <tr>
                                    <th>Details:</th>
                                    <td>{{ $leaveRequest->details }}</td>
                                </tr>
                            </tbody>
                        </table>
                       
                    </div>
                </div>
            </div>
        </div>
        
    </div> <!-- container-fluid -->
</div>
@endsection