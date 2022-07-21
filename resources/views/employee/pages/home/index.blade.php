@extends('layouts.employee.employee_app')
@section('home_active')
active
@endsection
@section('employee_title')
Home
@endsection
@section('employee_css')
    <style>
        .icon{
            font-size: 40px;
            color: #2AB57E;
        }
        .icon_info{
            font-size: 40px;
            color: #2a74b5;
        }
        .icon_danger{
            font-size: 40px;
            color: #d4241b;
        }
    </style>
@endsection
@section('employee_content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row mb-4">
            <div class="col-12 col-lg-3 col-md-3 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <p>C. M . WorkingDay</p>
                                <span> <b>{{ $data['current_month_working_day'] }}</b> </span>
                            </div>
                            <div class="col-4">
                                <i class=" fas fa-anchor icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3 col-md-3 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <p>C. M . Present</p>
                                <span> <b>{{ $data['currrent_month_total_present'] }}</b> </span>
                            </div>
                            <div class="col-4">
                                <i class=" fas fa-user-check icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3 col-md-3 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <p>C. M . Absent</p>
                                <span> <b>{{ $data['currrent_month_total_absent'] }}</b> </span>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-user-alt-slash icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3 col-md-3 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <p>Basic Salary</p>
                                <span> <b>{{ $data['basic_salary'] }}</b> </span>
                            </div>
                            <div class="col-4">
                                <i class="icon">৳</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3 col-md-3 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <p>Receivable Salary</p>
                                <span> <b>{{ $data['receiable_salary'] }}</b> </span>
                            </div>
                            <div class="col-4">
                                <i class="icon_info">৳</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3 col-md-3 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <p>Punishment Salary</p>
                                <span> <b>{{ $data['punishment_salary'] }}</b> </span>
                            </div>
                            <div class="col-4">
                                <i class="icon_danger">৳</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3 col-md-3 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <p>Assigned Projects</p>
                                <span> <b>{{ $data['assigned_projects'] }}</b> </span>
                            </div>
                            <div class="col-4">
                                <i class=" fas fa-project-diagram icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- container-fluid -->
</div>
@endsection
