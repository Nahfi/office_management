@extends('layouts.employee.employee_app')
@section('attendance_active')
mm-active
@endsection
@section('employee_title')
Attendance
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
                    <h4 class="mb-sm-0 font-size-18">Attendance List</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('employee.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All Attendance list</li>
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
                                        <h5 class="card-title me-4" style="float:left;margin-top:5px">Total Days<span class="text-muted fw-normal ms-2">({{ $attendanceLists->count() }})</span></h5>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                                        <a href="{{ route('employee.attendance.sendRequest') }}" class="btn btn-primary mb-2 btn-sm"><i class="bx bx-plus me-1"></i>Click for Attendance</a>
                                    </div>
                                </div>
                            </div>
                            <div style="height: calc(100vh - 270px);overflow-y:scroll;overflow-x:hidden;">
                                <table id="datatable-buttons" class="table table-bordered dt-responsive  nowrap w-100" style="height: 10px;">
                                    <thead>
                                    <tr>
                                        <th>S\N</th>
                                        <th>Time</th>
                                        <th>Date</th>
                                        <th>IP</th>
                                        <th>Status</th>
                                        <th>Approved By</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($attendanceLists as $attendanceList)
                                            <tr>

                                                <th>{{ $loop->iteration }}</th>
                                                <th>
                                                    {{ date('h:i A',strtotime($attendanceList->date_time)) }}
                                                </th>
                                                <td>
                                                    {{ date('Y-M-d', strtotime($attendanceList->date_time)) }}
                                                </td>
                                                <td>
                                                    {{ $attendanceList->ip }}
                                                </td>
                                                <td>
                                                    {{ $attendanceList->status }}
                                                </td>
                                                <td>
                                                    {{ $attendanceList->approved_by != null ? $attendanceList->admin->name:'N/A' }}
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
    @if (Session::has('request_submit_success'))
        <script>
            Toast.fire({
                icon: 'success',
                title: "{{ Session::get('request_submit_success') }}"
            })
        </script>
    @endif
    @if (Session::has('attendance_already_submit'))
        <script>
            Toast.fire({
                icon: 'error',
                title: "{{ Session::get('attendance_already_submit') }}"
            })
        </script>
    @endif
@endsection
@endsection
