@extends('layouts.admin.admin_app')
@section('admin_page_title')
    Show Employee | BIR it
@endsection
@section('employee_active')
    mm-active
@endsection
@section('admin_content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Employee</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.employee.index') }}">All Employee</a></li>
                            <li class="breadcrumb-item active">Show Employee</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12 text-center">
                <div class="card">
                    <div class="card-body">
                        <img style="width:100px;height:100px;" class="rounded-circle" src="{{ asset('photo/employee_profile') }}/{{ $employee->photo }}" alt="profile">
                        <hr>
                        <table class="table table-bordered text-center">
                            <tbody>
                                <tr>
                                    <th>Name:</th>
                                    <td>{{ $employee->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $employee->email }}</td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td>{{ $employee->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Salary:</th>
                                    <td>{{ $employee->salary }}</td>
                                </tr>
                                <tr>
                                    <th>National Id:</th>
                                    <td>{{ $employee->national_id }}</td>
                                </tr>
                                <tr>
                                    <th>Father Name:</th>
                                    <td>{{ $employee->father_name }}</td>
                                </tr>
                                <tr>
                                    <th>Mother Name:</th>
                                    <td>{{ $employee->mother_name }}</td>
                                </tr>
                                <tr>
                                    <th>Guardian Phone:</th>
                                    <td>{{ $employee->guardian_phone }}</td>
                                </tr>
                                <tr>
                                    <th>Created By:</th>
                                    <td>{{ $employee->createdBy->name }}</td>
                                </tr>
                                <tr>
                                    <th>Edited By:</th>
                                    <td>{{ $employee->edited_by != '' ? $employee->editedBy->name: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>{{ $employee->status }}</td>
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