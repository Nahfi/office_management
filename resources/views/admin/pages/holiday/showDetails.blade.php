@extends('layouts.admin.admin_app')
@section('holiday_active')
    mm-active
@endsection
@section('admin_page_title')
    Holiday Details | BIR it
@endsection
@section('admin_content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">All Date</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.holiday.index') }}">All HoliDay</a></li>
                            <li class="breadcrumb-item active">All Holidate Date</li>
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
                                                    <form action="{{ route('admin.holiday.storeDetails',$holidayMonth->id )}}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="staticBackdropLabel">Add Date({{ $holidayMonth->month }})</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                        
                                                                <div class="form-group">
                                                                    <label>Date <span class="text-danger">*</span> </label>
                                                                    <input type="date" class="form-control @error('date') is-invalid @enderror" name="date">
                                                                    @error('date')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
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
                            <table class="table table-bordered">
                                <thead>
                                   <tr>
                                       <th>S/N</th>
                                       <th>Date</th>
                                       <th>Action</th>
                                   </tr>
                                </thead>
                                <tbody>
                                    @foreach ($holidayDates as $holidayDate)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $holidayDate->date }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $holidayDate->id }}"><i class="fas fa-user-edit" ></i></button> 
                                                <div class="modal fade" id="staticBackdrop{{ $holidayDate->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <form action="{{ route('admin.holiday.updateDetails',$holidayDate->id )}}" method="POST">
                                                                @csrf
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="staticBackdropLabel">Update Date({{ $holidayDate->id }})</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                
                                                                        <div class="form-group">
                                                                            <label>Date <span class="text-danger">*</span> </label>
                                                                            <input type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ $holidayDate->date }}">
                                                                            @error('date')
                                                                                <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
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
                                                <a href="{{ route('admin.holiday.destroyDetails',$holidayDate->id) }}" onclick="return confirm('Data will be deleted!!')" class="btn btn-sm btn-primary"><i class="fas fa-trash-alt"></i></a> 
                                            </td>
                                        </tr>
                                    @endforeach
                                    
                                </tbody>
                            </table>
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
    @if (Session::has('holiday_month_create_success'))
        <script>
            Toast.fire({
                icon: 'success',
                title: "{{ Session::get('holiday_month_create_success') }}"
            })
        </script>
    @endif
    @if (Session::has('holiday_details_update_success'))
        <script>
            Toast.fire({
                icon: 'success',
                title: "{{ Session::get('holiday_details_update_success') }}"
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