@extends('layouts.admin.admin_app')
@section('admin_page_title')
    Expenses  | BIR it
@endsection
@section('expense_active')
    mm-active
@endsection
@section('expense_expenses_active')
    active
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
                    <h4 class="mb-sm-0 font-size-18">Expenses</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">ExpenseCategory</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <form action="{{ route('admin.expense.mark') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <h5 class="card-title me-4" style="float:left;margin-top:5px">Total Expense <span class="text-muted fw-normal ms-2">({{ $data['expenses']->count() }})</span></h5>
                                        @if (Auth::guard('admin')->User()->can('expense.edit')|| Auth::guard('admin')->User()->can('expense.delete')|| Auth::guard('admin')->User()->can('expense.parmanentDelete'))
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Select an Action <i class="mdi mdi-chevron-down"></i></button>
                                                    <div class="dropdown-menu">
                                                        @if (Route::currentRouteName() != 'admin.expense.trash')
                                                            @if (Auth::guard('admin')->User()->can('expense.edit'))
                                                                @if (Route::currentRouteName() != 'admin.expense.active')
                                                                    <button class="dropdown-item" type="submit" value="Active" name="type">Active All</button>
                                                                @endif
                                                                @if (Route::currentRouteName() != 'admin.expense.deactive')
                                                                    <button class="dropdown-item" type="submit" value="DeActive" name="type">DeActive All</button>
                                                                @endif
                                                            @endif
                                                            @if (Auth::guard('admin')->User()->can('expense.delete'))
                                                                <button class="dropdown-item" type="submit" value="Delete" name="type">Delete All</button>
                                                            @endif
                                                        @endif

                                                        @if (Route::currentRouteName() == 'admin.expense.trash')
                                                            @if (Auth::guard('admin')->User()->can('expense.delete'))
                                                                <button class="dropdown-item" type="submit" value="Restore" name="type">Restore All</button>
                                                            @endif
                                                            @if (Auth::guard('admin')->User()->can('expense.parmanentDelete'))
                                                                <button class="dropdown-item" type="submit" value="ParmanentDelete" name="type">Parmanent Delete All</button>
                                                            @endif
                                                        @endif
                                                    </div>
                                            </div><!-- /btn-group -->
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                                        <div id="category_button">
                                            <a href="{{ route('admin.expense.index') }}" class="btn btn-sm btn-primary mb-2">All</a>

                                            <a href="{{ route('admin.expense.active') }}"  class="btn btn-sm mb-2 btn-primary">Active({{ $data['total_active_expense'] }})</a>
                                            <a href="{{ route('admin.expense.deactive') }}"  class="btn btn-sm mb-2 btn-primary">DeActive({{ $data['total_deactive_expense'] }})</a>


                                            <a href="{{ route('admin.expense.trash',) }}"  class="btn btn-sm mb-2 btn-danger">Trush({{ $data['total_deleted_expense'] }})</a>
                                            @if (Auth::guard('admin')->User()->can('expense.store'))
                                                <a href="{{ route('admin.expense.create') }}" class="btn btn-primary mb-2 btn-sm"><i class="bx bx-plus me-1"></i> Add New</a>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="height: calc(100vh - 270px);overflow-y:scroll;overflow-x:hidden;">


                                <table id="datatable-buttons" class="table table-bordered dt-responsive  nowrap w-100" style="height: 10px;">
                                    <thead>
                                    <tr>
                                        <th scope="col" style="width: 50px;">
                                            <div class="form-check font-size-16">

                                            </div>
                                        </th>
                                        <th>S\N</th>
                                        <th>Category name</th>
                                        <th>Name</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                        <th>Edited By</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data['expenses'] as $expense)
                                            <tr>
                                                <input class="expense_val_id" type="hidden" name="id" value="{{ $expense->id }}">
                                                <th scope="row">
                                                    <div class="form-check font-size-16">
                                                        <input type="checkbox" name="ids[]" class="form-check-input" value="{{ $expense->id }}">
                                                        <label class="form-check-label"></label>
                                                    </div>
                                                </th>
                                                <th>{{ $loop->iteration }}</th>
                                                <th>
                                                    {{ $expense->category->name }} <br>
                                                     ({{ $expense->category->status }})
                                                </th>
                                                <td>
                                                    {{ $expense->name }}
                                                </td>
                                                <td>{{ $expense->amount }}</td>
                                                <td>
                                                    <span class="badge {{ ($expense->status == 'Active' ? "bg-success":"bg-danger")  }}">{{ $expense->status }}</span>
                                                </td>
                                                <td>{{ $expense->createdBy->name }}</td>
                                                <td>{{ $expense->edited_by != '' ? $expense->editedBy->name:'N/A' }}</td>
                                                <td>
                                                    @if (Route::currentRouteName() == 'admin.expense.index' || Route::currentRouteName() == 'admin.expense.active' || Route::currentRouteName() == 'admin.expense.deactive' )
                                                        @if (Auth::guard('admin')->User()->can('expense.edit'))
                                                            @if ($expense->category->status == 'Active')
                                                                <a href="{{ route('admin.expense.edit',$expense->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-user-edit" ></i></a>
                                                            @endif
                                                        @endif
                                                        @if (Auth::guard('admin')->User()->can('expense.delete'))
                                                            <a href="{{ route('admin.expense.destroy',$expense->id) }}"  class="btn btn-sm btn-danger"> <i class="fas fa-trash-alt"></i></a>
                                                        @endif
                                                    @endif

                                                    @if(Route::currentRouteName() == 'admin.expense.trash')
                                                        @if (Auth::guard('admin')->User()->can('expense.delete'))
                                                            <a href="{{ route('admin.expense.restore',$expense->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-trash-restore" ></i></a>
                                                        @endif
                                                        @if (Auth::guard('admin')->User()->can('expense.parmanentDelete'))
                                                            <button type="button" class="btn btn-sm btn-danger sweet_delete"> <i class="fas fa-trash"></i></button>
                                                        @endif
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
                    </form>

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
                 var delete_id = $(this).closest("tr").find('.expense_val_id').val();
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
                          url:'/admin/expense/parmanent-delete/'+delete_id,
                          data: data,
                          success: function (response){
                          Swal.fire(
                                'Deleted!',
                                'Expense deleted.',
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
    @if (Session::has('expense_restore_success'))
      <script>
              Toast.fire({
                  icon: 'success',
                  title: 'Expense Restore Successfully'
              })
      </script>
    @endif
    @if (Session::has('mark_active_success'))
      <script>
              Toast.fire({
                  icon: 'success',
                  title: 'Selected Expenses Activate Successfully'
              })
      </script>
    @endif
    @if (Session::has('mark_deactive_success'))
      <script>
              Toast.fire({
                  icon: 'success',
                  title: 'Selected Expenses DeActivate Successfully'
              })
      </script>
    @endif
    @if (Session::has('mark_delete_success'))
      <script>
              Toast.fire({
                  icon: 'success',
                  title: 'Selected Expenses Deleted Successfully'
              })
      </script>
    @endif
    @if (Session::has('mark_restore_success'))
      <script>
              Toast.fire({
                  icon: 'success',
                  title: 'Selected Expenses Restore Successfully'
              })
      </script>
    @endif
    @if (Session::has('parmanent_delete_success'))
      <script>
              Toast.fire({
                  icon: 'success',
                  title: 'Expense Parmanently deleted'
              })
      </script>
    @endif
    @if (Session::has('mark_parmanent_delete_success'))
      <script>
              Toast.fire({
                  icon: 'success',
                  title: 'selected Expenses Parmanently deleted'
              })
      </script>
    @endif
@endsection
@endsection
