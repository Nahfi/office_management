@extends('layouts.employee.employee_app')
@section('meeting_reports_active')
mm-active
@endsection
@section('meeting_reports_create_active')
active
@endsection
@section('employee_title')
Add Meeting Report
@endsection
@section('employee_content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Create Work Report</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('employee.meetingReport.index') }}"> All Report
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Create Report</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row ">
            <div class="col-lg-6 mx-auto ">
                <div class="card">
                    <div class="card-body  ">
                        <div class="row mx-auto ">
                            <div class="col-lg-6 col-6  col-sm-6 col-md-6  mx-auto   ">
                                <form  action="{{ route('employee.meetingReport.store') }}" class="outer-repeater" method="post">
                                  @csrf
                                    <div data-repeater-list="outer-group" class="outer">
                                        <div data-repeater-item="" class="outer">
                                            <div class="form-group row mb-4">
                                                <div class="row">
                                                    <label for="name"> Title <span class="text-danger">*</span></label>
                                                    <div class="col-lg-10  col-10">
                                                        <input id="title" name="title" type="text" class="form-control"
                                                            placeholder="Enter Report Title..."
                                                            value="{{ old('title') }}">
                                                        @error('title')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-2 col-2 ">
                                                        <button type="submit" class="btn btn-primary">Create </button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

    </div> <!-- container-fluid -->
</div>
@endsection
@section('employee_js')
@if(Session::has('report_added'))
    <script>
        Toast.fire({
            icon: 'success',
            title: '{{ session()->get('report_added')}}'
        })
    </script>
@endif

        @if ($errors->any())
        <script>
                Toast.fire({
                    icon: 'error',
                    title: 'Something went wrong, Please enter a Title'
                })
        </script>
      @endif
@endsection



