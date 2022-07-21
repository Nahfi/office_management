@extends('layouts.admin.admin_app')
@section('meeting_report_active')
    active
@endsection
@section('admin_page_title')
Meeting Report | BIR it
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
                    <h4 class="mb-sm-0 font-size-18">Meeting Report</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"> Meeting Report</li>
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
                                        <h5 class="card-title me-4" style="float:left;margin-top:5px">Total Meeting Reports <span class="text-muted fw-normal ms-2">({{ count($meetingReports->toArray()) }})</span></h5>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                                        <div id="category_button">
                                            <a href="{{ route('admin.meetingReport.index') }}" class="btn btn-sm btn-primary mb-2">All</a>
                                            <a href="{{ route('admin.meetingReport.trash') }}"  class="btn btn-sm mb-2 btn-danger">Trash</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="height: calc(100vh - 270px);overflow-y:scroll;overflow-x:hidden;">
                                <table id="datatable-buttons" class="table table-bordered dt-responsive  nowrap w-100" style="height: 10px;">
                                    <thead>
                                    <tr>

                                        <th>S\N</th>
                                        <th>Employee Name</th>
                                        <th>Report Title</th>
                                        <th>Status</th>
                                        <th>Approved By</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($meetingReports as $report)
                                            <tr>
                                                <th>{{ $loop->iteration }}</th>
                                                <th>
                                                    {{ $report->employee->name}}
                                                </th>
                                                <td>
                                                    {{  $report->title }}
                                                </td>
                                                <td>
                                                    <span class="badge
                                                    @if($report->status == 'pending' && !$report->deleted_at)
                                                      bg-warning
                                                    @elseif ($report->status =='approved' && !$report->deleted_at)
                                                    bg-success
                                                    @elseif($report->deleted_at)
                                                    bg-danger
                                                    @endif
                                                    ">
                                                    @if($report->deleted_at)
                                                    {{ $report->status }} (deleted)
                                                    @else
                                                    {{ $report->status }}
                                                    @endif
                                                    </span>
                                                </td>
                                                <td>
                                                    {{ $report->admin ?$report->admin->name: 'Not Approved Yet'}}
                                                </td>
                                                <td>
                                                    @if (Route::currentRouteName() == 'admin.meetingReport.index')
                                                        @if (Auth::guard('admin')->User()->can('meeting.report.status.edit') && !$report->deleted_at)
                                                            {{--  <a href="{{ route('admin.meetingReport.edit', $report->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-user-edit" ></i></a>  --}}
                                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $report->id }}"> <i class="fas fa-edit"></i> </button>
                                                        @endif
                                                        @if (Auth::guard('admin')->User()->can('meeting.report.delete') &&!$report->deleted_at)
                                                            <a href="{{ route('admin.meetingReport.destroy', $report->id) }}"  class="btn btn-sm btn-danger"> <i class="fas fa-trash-alt"></i></a>
                                                        @endif
                                                        <a href="{{ route('admin.meetingReport.show',$report->id) }}"  class="btn btn-sm btn-info"> <i class="fas fa-eye"></i></a>
                                                    @endif

                                                    @if(Route::currentRouteName() == 'admin.meetingReport.trash')
                                                        @if (Auth::guard('admin')->User()->can('meeting.report.restore'))
                                                            <a href="{{ route('admin.meetingReport.restore', $report->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-trash-restore" ></i></a>
                                                        @endif
                                                        @if (Auth::guard('admin')->User()->can('meeting.report.parmanentDelete'))
                                                            <button type="button"  value="{{ $report->id }}" class="btn btn-sm btn-danger sweet_delete"> <i class="fas fa-trash"></i></button>
                                                        @endif
                                                    @endif
                                                    <!-- Static Backdrop Modal -->

                                                    <div class="modal fade" id="staticBackdrop{{ $report->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <form action="{{ route('admin.meetingReport.update',$report->id) }}" method="POST">
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
                                                                                <option value="pending" @if ($report->status == 'pending')
                                                                                    {{ 'selected' }}
                                                                                @endif>Pending</option>
                                                                                <option value="approved" @if ($report->status == 'approved')
                                                                                    {{ 'selected' }}
                                                                                @endif>Approved</option>
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
    <script>
        $(document).ready(function() {
             $.ajaxSetup({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
             });
             $('.sweet_delete').click(function(){
                 var delete_id = $(this).attr('value');
                 Swal.fire({
                   title: 'Are you sure?',
                   text: "You won't be able to revert this!",
                   icon: 'warning',
                   showCancelButton: true,
                   confirmButtonColor: '#3085d6',
                   cancelButtonColor: '#d33',
                   confirmButtonText: 'Yes, delete it!'
                 }).then((result) => {
                   if (result.isConfirmed) {
                       var data = {
                           "_token": $('input[name=_token]').val(),
                           "id": delete_id,
                       };
                       $.ajax({
                          type:"GET",
                          url:'/admin/meeting-report/parmanent-delete/'+delete_id,
                          data: data,
                          success: function (response){
                          Swal.fire(
                                'Deleted!',
                                'Report deleted.',
                                'success'
                              )
                              .then((result) =>{
                                 location.reload();
                              });
                          }
                       });
                   }
                 })
             });
         } );
     </script>
    @if (Session::has('report_restore_success'))
      <script>
              Toast.fire({
                  icon: 'success',
                  title: '{{ session()->get('report_restore_success') }}'
              })
      </script>
    @endif

    @if (Session::has('report_delete_success'))
      <script>
              Toast.fire({
                  icon: 'success',
                  title: '{{ session()->get('report_delete_success') }}'
              })
      </script>
    @endif

    @if (Session::has('report_update_success'))
    <script>
            Toast.fire({
                icon: 'success',
                title: '{{ session()->get('report_update_success')}}'
            })
    </script>
    @endif

@endsection
@endsection
