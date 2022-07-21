@extends('layouts.admin.admin_app')
@section('salary_active')
    mm-active
@endsection
@section('admin_page_title')
    Salary Report
@endsection
@section('admin_css_link')
     <!-- DataTables -->
  <link href="{{ asset('admin_assets') }}/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
  <link href="{{ asset('admin_assets') }}/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
  <!-- Responsive datatable examples -->
  <link href="{{ asset('admin_assets') }}/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('admin_js_link')
    <!-- Required datatable js -->
 <script src="{{ asset('admin_assets') }}/libs/datatables.net/js/jquery.dataTables.min.js"></script>
 <script src="{{ asset('admin_assets') }}/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
 <!-- Buttons examples -->
 <script src="{{ asset('admin_assets') }}/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
 <script src="{{ asset('admin_assets') }}/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
 <script src="{{ asset('admin_assets') }}/libs/jszip/jszip.min.js"></script>
 <script src="{{ asset('admin_assets') }}/libs/pdfmake/build/pdfmake.min.js"></script>
 <script src="{{ asset('admin_assets') }}/libs/pdfmake/build/vfs_fonts.js"></script>
 <script src="{{ asset('admin_assets') }}/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
 <script src="{{ asset('admin_assets') }}/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
 <script src="{{ asset('admin_assets') }}/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
 <!-- Responsive examples -->
 <script src="{{ asset('admin_assets') }}/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
 <script src="{{ asset('admin_assets') }}/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
 <!-- Datatable init js -->
 <script src="{{ asset('admin_assets') }}/js/pages/datatables.init.js"></script>
@endsection
@section('admin_content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Salary Report</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Salary Report</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <h5 class="card-title me-4" style="float:left;margin-top:5px">All Employee Salary</h5>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                </div>
                            </div>
                            <div style="height: calc(100vh - 270px);overflow-y:scroll;overflow-x:hidden;">
                                <table id="datatable-buttons" class="table table-bordered dt-responsive  nowrap w-100" style="height: 10px;">
                                    <thead>
                                    <tr>

                                        <th>S\N</th>
                                        <th>Employee</th>
                                        <th>Date</th>
                                        <th>Basic Salary</th>
                                        <th>Payable Salary</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        {{--  cleared   --}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($salaries as $salary)
                                            <tr>
                                                <th>{{ $loop->iteration }}</th>
                                                <th>
                                                    {{ $salary->employee->name }}
                                                </th>
                                                <td>{{ $salary->date }}</td>
                                                <td>{{ $salary->basic_salary }}</td>
                                                <td>{{ $salary->payable_salary }}</td>
                                                <td>
                                                    <span class="badge
                                                    @if($salary->status == 'pending')
                                                      bg-warning
                                                    @elseif ($salary->status == 'cleared' )
                                                     bg-success
                                                    @endif
                                                    ">
                                                    {{ $salary->status }}
                                                    </span>
                                               </td>
                                               <td>
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $salary->id }}"> <i class="fas fa-edit"></i> </button>

                                                @if($salary->status == 'cleared' )
                                                <a class="btn btn-sm btn-primary" href="{{ route('admin.salary.show',$salary->id) }}">Pay Slip<i  class="ms-1 fas fa-download"></i></a>
                                                @endif
                                               </td>

                                            </tr>
                                            <div class="modal fade" id="staticBackdrop{{ $salary->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <form action="{{ route('admin.salary.update',$salary->id) }}" method="POST">
                                                        @csrf

                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="staticBackdropLabel">Update Status</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label> Status <span class="text-danger">*</span> </label>
                                                                    <select name="status" class="form-select">
                                                                        <option value="">select status</option>
                                                                        <option value="pending" @if ($salary->status == 'pending')
                                                                            {{ 'selected' }}
                                                                        @endif>Pending</option>
                                                                        <option value="
                                                                        cleared" @if ($salary->status == 'cleared')
                                                                            {{ 'selected' }}
                                                                        @endif>Cleared</option>
                                                                    </select>
                                                                    @error('status')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                <button type="sbumit" class="btn btn-primary">Update</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                                <!-- end table -->
                            <!-- end table responsive -->
                        </div>


                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->
</div>

@endsection
