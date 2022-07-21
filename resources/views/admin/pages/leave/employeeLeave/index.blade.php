@extends('layouts.admin.admin_app')
@section('leave_active')
    mm-active
@endsection
@section('employee_leave_active')
    active
@endsection
@section('admin_page_title')
    All Employee Leave List | BIR it
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
                    <h4 class="mb-sm-0 font-size-18">Employee Leave List</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All Employee Leave List</li>
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
                                        <h5 class="card-title me-4" style="float:left;margin-top:5px">Total Employee Leave List <span class="text-muted fw-normal ms-2">({{ $employee_leaves->count() }})</span></h5>
                                        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                                        <div id="category_button">  
                                            <a href="{{ route('admin.holiday.index') }}" class="btn btn-sm btn-primary mb-2">All</a>
                                            @if (Auth::guard('admin')->User()->can('employee.create')) 
                                                <a href="{{ route('admin.employeeLeave.create') }}" class="btn btn-primary mb-2 btn-sm"><i class="bx bx-plus me-1"></i> Add New</a>
                                            @endif
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="height: calc(100vh - 270px);overflow-y:scroll;overflow-x:hidden;">
                                <table id="datatable-buttons" class="table table-bordered dt-responsive  nowrap w-100" style="height: 10px;">
                                    <thead>
                                    <tr>
                                        <th>S\N</th>
                                        <th>Employee</th>
                                        <th>Year</th>
                                        <th>T.Yearly Leave</th>
                                        <th>T.Yearly Leave R.</th>
                                        <th>Added By</th>
                                        <th>Edited By</th>
                                        <th>Actions</th>  
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($employee_leaves as $employee_leave)
                                            <tr>
                                                <input class="employee_val_id" type="hidden" name="id" value="{{ $employee_leave->id }}">
                                                <th>{{ $loop->iteration }}</th>
                                                <th>
                                                    {{ $employee_leave->employee->name }}
                                                </th>
                                                <td>
                                                    {{ $employee_leave->year }}
                                                </td>
                                                <td>
                                                    {{ $employee_leave->total_yearly_leave }}
                                                </td>
                                                <td>
                                                    {{ $employee_leave->total_yearly_leave_remaining }}
                                                </td>
                                               
                                                <td>{{ $employee_leave->createdBy->name }}</td>
                                                <td>
                                                    @if ($employee_leave->edited_by != '')
                                                        {{ $employee_leave->editedBy->name }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (Auth::guard('admin')->User()->can('employee.edit')) 
                                                        <a href="{{ route('admin.employeeLeave.showDetails',$employee_leave->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-eye" ></i></a> 
                                                        <a href="{{ route('admin.employeeLeave.edit',$employee_leave->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-user-edit" ></i></a> 
                                                    @endif
                                                    @if (Auth::guard('admin')->User()->can('employee.delete'))
                                                        <button type="button"  class="btn btn-sm btn-danger sweet_delete"> <i class="fas fa-trash-alt"></i></button>
                                                    @endif  
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
                 var delete_id = $(this).closest("tr").find('.employee_val_id').val();
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
                          url:'/admin/employee-leave/destroy/'+delete_id,
                          data: data,
                          success: function (response){
                          Swal.fire(
                                'Deleted!',
                                'Employee Leave deleted.',
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
    @if (Session::has('woking_day_delete_success'))
      <script>
              Toast.fire({
                  icon: 'success',
                  title: "{{ Session::get('woking_day_delete_success') }}"
              })
      </script>
    @endif
    @if (Session::has('holiday_details_add_success'))
      <script>
              Toast.fire({
                  icon: 'success',
                  title: "{{ Session::get('holiday_details_add_success') }}"
              })
      </script>
    @endif
@endsection
@endsection