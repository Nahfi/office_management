@extends('layouts.admin.admin_app')
@section('admin_page_title')
Create Project| BIR it
@endsection
@section('project_active')
    mm-active
@endsection
@section('admin_css_link')
    <!-- choices css -->
<link href="{{ asset('admin_assets') }}/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('admin_js_link')
     <!-- choices js -->
  <script src="{{ asset('admin_assets') }}/libs/choices.js/public/assets/scripts/choices.min.js"></script>
  <!-- init js -->
  <script src="{{ asset('admin_assets') }}/js/pages/form-advanced.init.js"></script>
@endsection
@section('admin_content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Add Project</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.project.index') }}">All Project</a></li>
                            <li class="breadcrumb-item active">Add Project</li>
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
                          <form action="{{ route('admin.project.store') }}" method="POST" enctype="multipart/form-data">
                              @csrf
                              <div class="row">

                                  <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-4">
                                    <div class="form-group">
                                        <label for="customer_id">Customer <span class="text-danger">*</span></label>
                                        <select  data-trigger
                                        id="choices-single-default"  name="customer_id" id="customer_id" class="form-select  @error('customer_id') is-invalid @enderror">
                                            <option value="">select customer </option>
                                            @foreach ($customers as $customer)
                                            <option  value="{{ $customer->id }}" {{ (old("customer_id") == $customer->id  ? "selected":"") }}>{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('customer_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                  </div>
                                  <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-4">
                                    <div class="form-group">
                                        <label for="employee_id">Employee </label>
                                        <select name="employee_id" id="employee_id" class="form-select  @error('employee_id') is-invalid @enderror"    data-trigger
                                        id="choices-single-default"  >
                                            <option value="">select employee </option>
                                            @foreach ($employees as $employee)
                                            <option  value="{{ $employee->id }}" {{ (old("employee_id") == $employee->id  ? "selected":"") }}>{{ $employee->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('employee_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                  </div>
                                  <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-4">
                                    <div class="form-group">
                                        <label for="testing_employee_id">Testing Employee </label>
                                        <select name="testing_employee_id" id="testing_employee_id" class="form-select  @error('testing_employee_id') is-invalid @enderror"    data-trigger
                                        id="choices-single-default"  >
                                            <option value="">select employee </option>
                                            @foreach ($employees as $employee)
                                            <option  value="{{ $employee->id }}" {{ (old("testing_employee_id") == $employee->id  ? "selected":"") }}>{{ $employee->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('testing_employee_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                  </div>
                                  <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-4">
                                    <div class="form-group">
                                        <label for="requirements">Requirements </label>
                                        <input type="file" class="form-control @error('requirements') is-invalid @enderror" name="requirements" id="requirements" >
                                        @error('requirements')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                  </div>
                                  <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-4">
                                    <div class="form-group">
                                        <label for="title">Title <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{ old('title') }}">
                                        @error('title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                  </div>
                                  <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-4">
                                    <div class="form-group">
                                        <label for="deed">Deed </label>
                                        <input type="file" class="form-control @error('deed') is-invalid @enderror" name="deed" id="deed" >
                                        @error('deed')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                  </div>
                                  <div class="col-lg-12 col-md-6 col-sm-12 col-12 mb-4">
                                    <div class="form-group">
                                        <label for="details">Details <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('details') is-invalid @enderror"   name="details" id="details" cols="30" rows="6"></textarea>
                                        @error('details')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                  </div>
                                  <div class="col-lg-12">
                                    <button type="submit" class="btn btn-sm btn-primary mt-4">Submit</button>
                                  </div>
                              </div>

                          </form>
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
    @if (Session::has('project_store_success'))
    <script>
            Toast.fire({
                icon: 'success',
                title: "{{ Session::get('project_store_success') }}"
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
