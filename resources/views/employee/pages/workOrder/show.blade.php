@extends('layouts.employee.employee_app')
@section('project_active')
mm-active
@endsection
@section('work_order_active')
active
@endsection
@section('employee_title')
Project Details
@endsection
@section('employee_content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Project Details</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('employee.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('employee.workOrder.index') }}">All project</a></li>
                            <li class="breadcrumb-item active">Project Details</li>
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

                          <div class="row justify-content-center">
                              <div class="col-lg-12 col-md-6 col-sm-12 col-12">
                                  <div class="form-group">
                                      <label>Project Title </label>

                                      <input disabled type="text" class="form-control @error('work_order') is-invalid @enderror" name="work_order" value="{{ $project->title }}">
                                  </div>
                              </div>
                              <div class="mt-2 col-lg-12 col-md-6 col-sm-12 col-12">
                                  <div class="form-group">
                                      <label>Project Details </label>
                                      <textarea  disabled class="form-control" name="" id="" cols="30" rows="10">
                                          {{ $project->details }}
                                      </textarea>
                                  </div>
                              </div>
                    </div>
                </div>
            </div>
        </div>


    </div> <!-- container-fluid -->
</div>
@section('employee_js')
@if (Session::has('work_order_update_success'))
<script>
    Toast.fire({
        icon: 'success',
        title: "{{ Session::get('work_order_update_success') }}"
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
