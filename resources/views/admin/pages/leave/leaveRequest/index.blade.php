
@extends('layouts.admin.admin_app')
@section('leave_active')
    mm-active
@endsection
@section('leave_request_active')
    active
@endsection
@section('admin_page_title')
    All Leave Request | BIR it
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
                    <h4 class="mb-sm-0 font-size-18">All Leave Request</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All Leave Request</li>
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
                                    
                                </div>
                            </div>
                            <div style="height: calc(100vh - 270px);overflow-y:scroll;overflow-x:hidden;">
                                <table id="datatable-buttons" class="table table-bordered dt-responsive  nowrap w-100" style="height: 10px;">
                                    <thead>
                                    <tr>
                                        <th>S\N</th>
                                        <th>Employee</th>
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
                                                    {{ $leaveRequest->employee->name }}
                                                </th>
                                                <td>
                                                    {{ $leaveRequest->subject }}
                                                </td>
                                                <td>
                                                    {{ $leaveRequest->status }}
                                                </td>
                                                <td>
                                                    {{ $leaveRequest->from }}
                                                </td>
                                               
                                                <td>{{ $leaveRequest->to }}</td>
                                              
                                                <td>
                                                   <a href="{{ route('admin.leaveRequest.show',$leaveRequest->id) }}" class="btn btn-sm btn-primary"><i class=" fas fa-eye"></i> </a>
                                                   <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $leaveRequest->id }}"> <i class="fas fa-edit"></i> </button>
                                                    <!-- Static Backdrop Modal -->
                                                    <div class="modal fade" id="staticBackdrop{{ $leaveRequest->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <form action="{{ route('admin.leaveRequest.statusUpdate',$leaveRequest->id) }}" method="POST">
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
                                                                                <option value="Pending" @if ($leaveRequest->status == 'Pending')
                                                                                    {{ 'selected' }}
                                                                                @endif>Pending</option>
                                                                                <option value="Declined" @if ($leaveRequest->status == 'Declined')
                                                                                    {{ 'selected' }}
                                                                                @endif>Declined</option>
                                                                                <option value="Accept" @if ($leaveRequest->status == 'Accept')
                                                                                    {{ 'selected' }}
                                                                                @endif>Accept</option>
                                                                            </select>
                                                                            @error('status')
                                                                                <span class="text-danger">{{ $mssage }}</span>
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
@section('admin_js')
    
    @if (Session::has('leave_reqeust_update_success'))
      <script>
              Toast.fire({
                  icon: 'success',
                  title: "{{ Session::get('leave_reqeust_update_success') }}"
              })
      </script>
    @endif
    @if (Session::has('leave_request_update_timeout'))
      <script>
              Toast.fire({
                  icon: 'error',
                  title: "{{ Session::get('leave_request_update_timeout') }}"
              })
      </script>
    @endif
@endsection
@endsection