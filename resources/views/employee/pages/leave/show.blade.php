@extends('layouts.employee.employee_app')
@section('leave_active')
mm-active
@endsection
@section('leave_list_active')
active
@endsection
@section('employee_title')
Leave List
@endsection
@section('employee_content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">All Month</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('employee.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('employee.leave.index') }}">All Leave List</a></li>
                            <li class="breadcrumb-item active">Leave Details</li>
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
                        <div class="row align-items-center">
                            <div class="col-12">
                                <table class="table table-bordered">
                                    <thead>
                                       <tr>
                                           <th>S/N</th>
                                           <th>Month</th>
                                           <th>T. Monthly Leave</th>
                                           <th>T. Monthly Leave R.</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($leaveDetails as $leaveDetail)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ date('M', strtotime($leaveDetail->month)) }}</td>
                                                <td>{{ $leaveDetail->total_monthly_leave }}</td>
                                                <td>{{ $leaveDetail->total_monthly_leave_remaining }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                         </div>

                         <!-- end row -->
                         <!-- end table responsive -->
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- container-fluid -->
</div>
@endsection
