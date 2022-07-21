@extends('layouts.admin.admin_app')
@section('admin_page_title')
    Dashboard | BIR it
@endsection
@section('home_active')
    active
@endsection
@section('admin_css')
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
@section('admin_content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Home</li>
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
                                <p>Total Admin</p>
                                <span> <b>{{ $data['admin'] }}</b> </span>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-user-shield icon"></i>
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
                                <p>Total Customer</p>
                                <span> <b>{{ $data['customer'] }}</b> </span>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-users icon"></i>
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
                                <p>Total Project</p>
                                <span> <b>{{ $data['project'] }}</b> </span>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-project-diagram icon"></i>
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
                                <p>Total Invoice</p>
                                <span> <b>{{ $data['invoice'] }}</b> </span>
                            </div>
                            <div class="col-4">
                                <i class=" fas fa-file-invoice icon"></i>
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
                                <p>Total Employee</p>
                                <span> <b>{{ $data['employee'] }}</b> </span>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-users-cog icon"></i>
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
                                <p>Todays Leave</p>
                                <span> <b>{{ $data['todays_leave'] }}</b> </span>
                            </div>
                            <div class="col-4">
                                <i class=" fas fa-user-minus icon_info"></i>
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
                                <p>Todays Present</p>
                                <span> <b>{{ $data['todays_present'] }}</b> </span>
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
                                <p>Todays Absent</p>
                                <span> <b>{{ $data['todays_absent'] }}</b> </span>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-user-alt-slash icon_danger"></i>
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
                                <p>Total Income</p>
                                <span> <b>{{ $data['income'] }}</b> </span>
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
                                <p>Total Expense</p>
                                <span> <b>{{ $data['other_expense'] + $data['salary_expense'] }}</b> </span>
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
                                <p>Total Received</p>
                                <span> <b>{{ $data['amount_paid'] }}</b> </span>
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
                                <p>Total Due</p>
                                <span> <b>{{ $data['total_due'] }}</b> </span>
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
                                <p>Others Expense</p>
                                <span> <b>{{ $data['other_expense'] }}</b> </span>
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
                                <p>Salary Expense</p>
                                <span> <b>{{ $data['salary_expense'] }}</b> </span>
                            </div>
                            <div class="col-4">
                                <i class="icon_danger">৳</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
           
        </div>
        
    </div> <!-- container-fluid -->
</div>
@endsection