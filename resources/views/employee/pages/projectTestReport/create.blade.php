@extends('layouts.employee.employee_app')
@section('test_active')
 mm-active
@endsection
@section('employee_title')
Add Testing Report
@endsection
@section('employee_css_link')
    <!-- choices css -->
<link href="{{ asset('admin_assets') }}/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('employee_js_link')
     <!-- choices js -->
  <script src="{{ asset('admin_assets') }}/libs/choices.js/public/assets/scripts/choices.min.js"></script>
  <!-- init js -->
  <script src="{{ asset('admin_assets') }}/js/pages/form-advanced.init.js"></script>
@endsection
@section('employee_content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Add Test Report</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('employee.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('employee.testReport.index') }}">All Testing Project </a></li>
                            <li class="breadcrumb-item active">Create  Test Report</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12s">
                <div class="card">
                    <div class="card-body">
                      <form action="{{ route('employee.testReport.store') }}" method="POST" enctype="multipart/form-data">
                          @csrf
                          {{--  <div class="row justify-content-center">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>Work Order File <span class="text-danger">*</span> </label>
                                    <a class="mt-1 mb-2 btn btn-sm btn-primary" href="{{ route('employee.workOrder.show',$project->id) }}">Work Order<i  class="ms-1 fas fa-download"></i></a>
                                    <input type="file" class="form-control @error('work_order') is-invalid @enderror" name="work_order">
                                    @error('work_order')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-6 mt-3">
                              <button type="submit" class="btn btn-sm btn-primary mt-4">Submit</button>
                            </div>
                        </div>  --}}
                          <div class="row justify-content-center">
                            <div class="col-lg-8 col-md-6 col-sm-12 col-12 ">
                                <div class="form-group">

                                    <input hidden type="text" class="form-control @error('project_id') is-invalid @enderror" name="project_id" value="{{ $id }}">

                                    {{--  <select  data-trigger
                                    id="choices-single-default"  name="project_id" id="project_id" class="form-select  @error('project_id') is-invalid @enderror">
                                        <option value="">select project </option>
                                        @foreach ($projects as $project)
                                        <option  value="{{ $project->id }}" {{ (old("project_id") == $project->id  ? "selected":"") }}>{{ $project->title }}</option>
                                        @endforeach
                                    </select>  --}}
                                    @error('project_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                              </div>
                              <div class="mt-2 col-lg-8 col-md-6 col-sm-12 col-12">
                                  <div class="form-group">
                                      <label>Test Report <span class="text-danger">*</span> </label>
                                      <input type="file" class="form-control @error('test_report') is-invalid @enderror" name="test_report">
                                      @error('test_report')
                                      <span class="text-danger">{{ $message }}</span>
                                      @enderror
                                  </div>
                              </div>
                          <div class="col-lg-8">
                            <button type="submit" class="btn btn-sm btn-primary mt-4">Submit</button>
                          </div>
                          </div>

                      </form>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- container-fluid -->
</div>
@section('employee_js')
@if (Session::has('test_report_add_success'))
<script>
    Toast.fire({
        icon: 'success',
        title: "{{ Session::get('test_report_add_success') }}"
    })
</script>
@endif
@endsection
@endsection
