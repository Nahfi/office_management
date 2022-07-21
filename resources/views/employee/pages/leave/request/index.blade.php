@extends('layouts.employee.employee_app')
@section('leave_active')
mm-active
@endsection
@section('leave_request_active')
active
@endsection
@section('employee_title')
Leave Request
@endsection
@section('employee_css_link')
     <!-- DataTables -->
  <link href="{{ asset('admin_assets') }}/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
  <link href="{{ asset('admin_assets') }}/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
  <!-- Responsive datatable examples -->
  <link href="{{ asset('admin_assets') }}/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('employee_js_link')
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
@section('employee_content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Leave List</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('employee.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All Leave list</li>
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
                                        <h5 class="card-title me-4" style="float:left;margin-top:5px">Total Leave Request <span class="text-muted fw-normal ms-2">({{ $leaveRequests->count() }})</span></h5>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                                        <a href="{{ route('employee.leaveRequest.create') }}" class="btn btn-primary mb-2 btn-sm"><i class="bx bx-plus me-1"></i> Send New Request</a>
                                    </div>
                                </div>
                            </div>
                            <div style="height: calc(100vh - 270px);overflow-y:scroll;overflow-x:hidden;">
                                <table id="datatable-buttons" class="table table-bordered dt-responsive  nowrap w-100" style="height: 10px;">
                                    <thead>
                                    <tr>
                                        <th>S\N</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($leaveRequests as $leaveRequest)
                                            <tr>

                                                <th>{{ $loop->iteration }}</th>
                                                <th>
                                                    {{Str::limit($leaveRequest->subject, 20, $end='.......')}}
                                                </th>
                                                <td>
                                                    {{ $leaveRequest->status }}
                                                </td>
                                                <td>
                                                    {{ date('Y-M-d', strtotime($leaveRequest->from)) }}
                                                </td>
                                                <td>
                                                    {{ date('Y-M-d', strtotime($leaveRequest->to)) }}
                                                </td>

                                                <td>
                                                    <a href="{{ route('employee.leaveRequest.show',$leaveRequest->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-eye" ></i></a>

                                                    <a href="{{ route('employee.leaveRequest.destroy',$leaveRequest->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Data will be deleted!!')"> <i class="fas fa-trash-alt"></i> </a>
                                                </td>
                                            </tr>
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
@section('employee_js')

       @if (Session::has('leave_request_can_not_be_deleted'))
        <script>
            Toast.fire({
                icon: 'error',
                title: "{{ Session::get('leave_request_can_not_be_deleted') }}"
            })
        </script>
    @endif

@endsection
@endsection
