@extends('layouts.employee.employee_app')
@section('leave_active')
mm-active
@endsection
@section('leave_request_active')
active
@endsection
@section('employee_title')
Send Leave Request
@endsection
@section('employee_content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Send Leave Request</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('employee.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('employee.leaveRequest.index') }}">All Leave Request</a></li>
                            <li class="breadcrumb-item active">Send Leave Request</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                      <form action="{{ route('employee.leaveRequest.store') }}" method="POST">
                          @csrf
                          <div class="row">
                              <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                  <div class="form-group">
                                      <label>From <span class="text-danger">*</span> </label>
                                      <input type="date" class="form-control @error('from') is-invalid @enderror" name="from" value="{{ old('from') }}">
                                      @error('form')
                                          <span class="text-danger">{{ $message }}</span>
                                      @enderror
                                  </div>
                              </div>
                              <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                  <div class="form-group">
                                      <label>To <span class="text-danger">*</span></label>
                                      <input type="date" class="form-control @error('to') is-invalid @enderror" name="to" value="{{ old('to') }}">
                                      @error('to')
                                          <span class="text-danger">{{ $message }}</span>
                                      @enderror
                                  </div>
                              </div>
                              <div class="col-12">
                                  <div class="form-group">
                                      <label>Subject <span class="text-danger">*</span></label>
                                      <input type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" value="{{ old('subject') }}">
                                      @error('subject')
                                          <span class="text-danger">{{ $message }}</span>
                                      @enderror
                                  </div>
                              </div>
                              <div class="col-12">
                                  <div class="form-group">
                                      <label>Details <span class="text-danger">*</span></label>
                                      <textarea name="details" class="form-control @error('details') is-invalid @enderror" cols="30" rows="10">{{ old('details') }}</textarea>

                                      @error('details')
                                          <span class="text-danger">{{ $message }}</span>
                                      @enderror
                                  </div>
                              </div>

                          </div>
                          <button type="submit" class="btn btn-sm btn-primary mt-4">Submit</button>
                      </form>
                    </div>
                </div>
            </div>
        </div>


    </div> <!-- container-fluid -->
</div>
@section('employee_js')
    @if (Session::has('allready_leave_request_in_pending'))
        <script>
            Toast.fire({
                icon: 'error',
                title: "{{ Session::get('allready_leave_request_in_pending') }}"
            })
        </script>
    @endif
    @if (Session::has('your_selected_year_not_assigned_yet'))
        <script>
            Toast.fire({
                icon: 'error',
                title: "{{ Session::get('your_selected_year_not_assigned_yet') }}"
            })
        </script>
    @endif
    @if (Session::has('your_selected_from_year_not_assigned_yet'))
        <script>
            Toast.fire({
                icon: 'error',
                title: "{{ Session::get('your_selected_from_year_not_assigned_yet') }}"
            })
        </script>
    @endif
    @if (Session::has('your_selected_to_year_not_assigned_yet'))
        <script>
            Toast.fire({
                icon: 'error',
                title: "{{ Session::get('your_selected_to_year_not_assigned_yet') }}"
            })
        </script>
    @endif
    @if (Session::has('your_selected_month_not_assigned_yet'))
        <script>
            Toast.fire({
                icon: 'error',
                title: "{{ Session::get('your_selected_month_not_assigned_yet') }}"
            })
        </script>
    @endif
    @if (Session::has('your_selected_from_month_not_assigned_yet'))
        <script>
            Toast.fire({
                icon: 'error',
                title: "{{ Session::get('your_selected_from_month_not_assigned_yet') }}"
            })
        </script>
    @endif
    @if (Session::has('your_selected_to_month_not_assigned_yet'))
        <script>
            Toast.fire({
                icon: 'error',
                title: "{{ Session::get('your_selected_to_month_not_assigned_yet') }}"
            })
        </script>
    @endif
    @if (Session::has('please_decrease_total_leave_day'))
        <script>
            Toast.fire({
                icon: 'error',
                title: "{{ Session::get('please_decrease_total_leave_day') }}"
            })
        </script>
    @endif
    @if (Session::has('monthly_leave_limit_finished'))
        <script>
            Toast.fire({
                icon: 'error',
                title: "{{ Session::get('monthly_leave_limit_finished') }}"
            })
        </script>
    @endif
    @if (Session::has('leave_request_send_success'))
        <script>
            Toast.fire({
                icon: 'success',
                title: "{{ Session::get('leave_request_send_success') }}"
            })
        </script>
    @endif
@endsection
@endsection
