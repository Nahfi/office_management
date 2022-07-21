@extends('layouts.admin.admin_app')
@section('leave_active')
    mm-active
@endsection
@section('employee_leave_active')
    active
@endsection
@section('admin_page_title')
    Details | BIR it
@endsection
@section('admin_content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">All Month</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.employeeLeave.index') }}">All EmployeeLeaveList</a></li>
                            <li class="breadcrumb-item active">All Employee Leave</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12 m-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                               
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                                    <div id="category_button">  
                                        <button class="btn btn-primary mb-2 btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="bx bx-plus me-1"></i> Add New</button>
                                        <!-- Static Backdrop Modal -->
                                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <form action="{{ route('admin.employeeLeave.storeDetails',$employee_leave->id )}}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="staticBackdropLabel">Add Month({{ $employee_leave->year }})</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-4">
                                                                    <div class="form-group">
                                                                        <label>Month <span class="text-danger">*</span> </label>
                                                                        <select name="month" class="form-select @error('month') is-invalid @enderror" id="">
                                                                            <option value="">select month</option>
                                                                            <option value="1">January</option>
                                                                            <option value="2">February</option>
                                                                            <option value="3">March</option>
                                                                            <option value="4">April</option>
                                                                            <option value="5">May</option>
                                                                            <option value="6">June</option>
                                                                            <option value="7">July</option>
                                                                            <option value="8">August</option>
                                                                            <option value="9">September</option>
                                                                            <option value="10">October</option>
                                                                            <option value="11">November</option>
                                                                            <option value="12">December</option>
                                                                        </select>
                                                                        @error('month')
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-4">
                                                                    <div class="form-group">
                                                                        <label>Total Monthly Leave <span class="text-danger">*</span> </label>
                                                                        <input type="number" class="form-control @error('total_monthly_leave') is-invalid @enderror" name="total_monthly_leave">
                                                                        @error('total_monthly_leave')
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                        
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center">  
                            <div class="col-12">
                                <table class="table table-bordered">
                                    <thead>
                                       <tr>
                                           <th>S/N</th>
                                           <th>Month</th>
                                           <th>T. Monthly Leave</th>
                                           <th>T. Monthly Leave R.</th>
                                           <th>Action</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employee_leave_details as $employee_leave_detail)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    @if ($employee_leave_detail->month == '1')
                                                        {{ 'January' }}
                                                    @elseif ($employee_leave_detail->month == '2')
                                                        {{ 'February' }}
                                                    @elseif ($employee_leave_detail->month == '3')
                                                        {{ 'March' }}
                                                    @elseif ($employee_leave_detail->month == '4')
                                                        {{ 'April' }}
                                                    @elseif ($employee_leave_detail->month == '5')
                                                        {{ 'May' }}
                                                    @elseif ($employee_leave_detail->month == '6')
                                                        {{ 'June' }}
                                                    @elseif ($employee_leave_detail->month == '7')
                                                        {{ 'July' }}
                                                    @elseif ($employee_leave_detail->month == '8')
                                                        {{ 'August' }}
                                                    @elseif ($employee_leave_detail->month == '9')
                                                        {{ 'September' }}
                                                    @elseif ($employee_leave_detail->month == '10')
                                                        {{ 'October' }}
                                                    @elseif ($employee_leave_detail->month == '11')
                                                        {{ 'November' }}
                                                    @elseif ($employee_leave_detail->month == '12')
                                                        {{ 'December' }}
                                                    @endif
                                                </td>
                                                <td>{{ $employee_leave_detail->total_monthly_leave }}</td>
                                                <td>{{ $employee_leave_detail->total_monthly_leave_remaining }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $employee_leave_detail->id }}"><i class="fas fa-user-edit" ></i></button> 
                                                    <div class="modal fade" id="staticBackdrop{{ $employee_leave_detail->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <form action="{{ route('admin.employeeLeave.updateDetails',$employee_leave_detail->id )}}" method="POST">
                                                                    @csrf
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="staticBackdropLabel">Update</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                    <div class="row">

                                                                   
                                                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-4">
                                                                            <div class="form-group">
                                                                                <label>Month <span class="text-danger">*</span> </label>
                                                                                <select name="month" class="form-select @error('month') is-invalid @enderror" id="">
                                                                                    <option value="">select month</option>
                                                                                    <option value="1" @if ( $employee_leave_detail->month == '1')
                                                                                        {{ 'selected' }}
                                                                                    @endif>January</option>
                                                                                    <option value="2" @if ( $employee_leave_detail->month == '2')
                                                                                        {{ 'selected' }}
                                                                                    @endif>February</option>
                                                                                    <option value="3" @if ( $employee_leave_detail->month == '3')
                                                                                        {{ 'selected' }}
                                                                                    @endif>March</option>
                                                                                    <option value="4" @if ( $employee_leave_detail->month == '4')
                                                                                        {{ 'selected' }}
                                                                                    @endif>April</option>
                                                                                    <option value="5" @if ( $employee_leave_detail->month == '5')
                                                                                        {{ 'selected' }}
                                                                                    @endif>May</option>
                                                                                    <option value="6" @if ( $employee_leave_detail->month == '6')
                                                                                        {{ 'selected' }}
                                                                                    @endif>June</option>
                                                                                    <option value="7" @if ( $employee_leave_detail->month == '7')
                                                                                        {{ 'selected' }}
                                                                                    @endif>July</option>
                                                                                    <option value="8" @if ($employee_leave_detail->month == '8')
                                                                                        {{ 'selected' }}
                                                                                    @endif>August</option>
                                                                                    <option value="9" @if ( $employee_leave_detail->month == '9')
                                                                                        {{ 'selected' }}
                                                                                    @endif>September</option>
                                                                                    <option value="10" @if ( $employee_leave_detail->month == '10')
                                                                                        {{ 'selected' }}
                                                                                    @endif>October</option>
                                                                                    <option value="11" @if ( $employee_leave_detail->month == '11')
                                                                                        {{ 'selected' }}
                                                                                    @endif>November</option>
                                                                                    <option value="12" @if ( $employee_leave_detail->month == '12')
                                                                                        {{ 'selected' }}
                                                                                    @endif>December</option>
                                                                                </select>
                                                                                @error('month')
                                                                                    <span class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-4">
                                                                            <div class="form-group">
                                                                                <label>Total Leave <span class="text-danger">*</span> </label>
                                                                                <input type="number" class="form-control @error('total_monthly_leave') is-invalid @enderror" name="total_monthly_leave" value="{{ $employee_leave_detail->total_monthly_leave }}">
                                                                                @error('total_monthly_leave')
                                                                                    <span class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                    
                                                                    </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="{{ route('admin.employeeLeave.destroyDetails',$employee_leave_detail->id) }}" onclick="return confirm('Data will be deleted!!')" class="btn btn-sm btn-primary"><i class="fas fa-trash-alt"></i></a> 
                                                </td>
                                            </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                         </div>
                      
                         <!-- end row -->
                         <!-- end table responsive -->
                    </div>
                </div>
            </div>
        </div>
        
    </div> <!-- container-fluid -->
</div>
@section('admin_js')
    @if (Session::has('employee_leave_store_details_success'))
        <script>
            Toast.fire({
                icon: 'success',
                title: "{{ Session::get('employee_leave_store_details_success') }}"
            })
        </script>
    @endif
    @if (Session::has('total_monthly_leave_is_greater'))
        <script>
            Toast.fire({
                icon: 'error',
                title: "{{ Session::get('total_monthly_leave_is_greater') }}"
            })
        </script>
    @endif
    @if (Session::has('employee_leave_update_success'))
        <script>
            Toast.fire({
                icon: 'success',
                title: "{{ Session::get('employee_leave_update_success') }}"
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
    @if ($errors->any())
        <script>
            Toast.fire({
                icon: 'error',
                title: 'Something wrong, Please try again!!'
            })
        </script>
    @endif
@endsection
@endsection