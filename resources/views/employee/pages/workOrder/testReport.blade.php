@extends('layouts.employee.employee_app')
@section('test_active')
mm-active
@endsection
@section('employee_title')
Project Test Report
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
                    <h4 class="mb-sm-0 font-size-18">Test Report List</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('employee.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All Test Reports  </li>
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
                                        <h5 class="card-title me-4" style="float:left;margin-top:5px">Total Test Report <span class="text-muted fw-normal ms-2">({{ count($testReports) }})</span></h5>

                                    </div>
                                </div>

                            </div>
                            <div style="height: calc(100vh - 270px);overflow-y:scroll;overflow-x:hidden;">
                                <table id="datatable-buttons" class="table table-bordered dt-responsive  nowrap w-100" style="height: 10px;">
                                    <thead>
                                    <tr>
                                        <th>S\N</th>
                                        <th>
                                            Project Title
                                        </th>
                                        <td>
                                            Status
                                        </td>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($testReports as $report)
                                            <tr>

                                                <th>{{ $loop->iteration }}</th>
                                                <th>
                                                    {{ $report->project->title }}
                                                </th>
                                                <th>
                                                    <span class="badge bg-success">{{ $report->status }}</span>
                                                </th>

                                                <td>
                                                    <a class="btn btn-sm btn-primary" href="{{ route('employee.testReport.show',$report->id) }}">
                                                        <i  class="ms-1 fas fa-download"></i></a>


                                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $report->id }}"> <i class="fas fa-edit"></i> </button>

                                                </td>
                                            </tr>
                                            <div class="modal fade" id="staticBackdrop{{ $report->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <form action="{{ route('employee.testReport.updateStatus',$report->id) }}" method="POST">
                                                        @csrf

                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="staticBackdropLabel">Update Status</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label> Status <span class="text-danger">*</span> </label>
                                                                    <select name="status" id="status" class="form-select  @error('status') is-invalid @enderror">
                                                                        <option value="">select status</option>
                                                                        <option  value="pending" {{ ($report->status == 'pending' ? "selected":"") }}>Pending</option>
                                                                        <option  value="decline " {{ ($report->status == 'decline' ? "selected":"") }}>Decline</option>
                                                                        <option  value="accepted" {{ ($report->status == 'accepted' ? "selected":"") }}>Accepted</option>
                                                                    </select>
                                                                    {{--  <select name="status" class="form-select">
                                                                        <option value="">select status</option>
                                                                        <option value="pending" @if ($report->status == 'pending')
                                                                            {{ 'selected' }}
                                                                        @endif>Pending</option>
                                                                        <option value="approved" @if ($report->status == 'approved')
                                                                            {{ 'selected' }}
                                                                        @endif>Approved</option>
                                                                    </select>  --}}
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
@section('employee_js')

       @if (Session::has('test_report_delete_success'))
        <script>
            Toast.fire({
                icon: 'success',
                title: "{{ Session::get('test_report_delete_success') }}"
            })
        </script>
    @endif
       @if (Session::has('test_report_update_success'))
        <script>
            Toast.fire({
                icon: 'success',
                title: "{{ Session::get('test_report_update_success') }}"
            })
        </script>
    @endif

    @if (Session::has('no_file_found'))
    <script>
        Toast.fire({
            icon: 'error',
            title: "{{ Session::get('no_file_found') }}"
        })
    </script>
@endif

@endsection
@endsection
