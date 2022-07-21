@extends('layouts.employee.employee_app')
@section('project_active')
mm-active
@endsection
@section('work_order_active')
active
@endsection
@section('employee_title')
Edit WorkOrder
@endsection
@section('employee_content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Create Work Order</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('employee.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('employee.workOrder.index') }}">All project</a></li>
                            <li class="breadcrumb-item active">Create Work Order</li>
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
                      <form action="{{ route('employee.workOrder.update',$project->id) }}" method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="row justify-content-center">
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
                          </div>

                      </form>
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
