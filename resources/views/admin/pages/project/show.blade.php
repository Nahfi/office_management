@extends('layouts.admin.admin_app')
@section('admin_page_title')
 Project Show | BIR it
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
                    <h4 class="mb-sm-0 font-size-18">Show Project</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.project.index') }}">All Project</a></li>
                            <li class="breadcrumb-item active"> Project</li>
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
                              <div class="row justify-content-center">
                                  <div class="col-lg-6 col-6 col-sm-6  col-md-6">
                                    <div class="col-lg-12 col-md-6 col-sm-12 col-12 mb-4">
                                        <div class="form-group">
                                            <label for="title">Title </label>
                                            <input readonly type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{ $project->title }}">

                                        </div>
                                      </div>
                                    <div class="col-lg-12 col-md-6 col-sm-12 col-12 mb-4">
                                        <div class="form-group">
                                            <label for="customer_id">Customer Name</label>
                                            <input readonly type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{ $project->customer->name }}">
                                        </div>
                                      </div>
                                      <div class="col-lg-12 col-md-6 col-sm-12 col-12 mb-4">
                                        <div class="form-group">
                                            <label for="employee_id">Employee Name </label>
                                            <input readonly type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{ $project->employee ? $project->employee->name :'No Employee  Assgined Yet' }}">

                                        </div>
                                      </div>
                                      <div class="col-lg-12 col-md-6 col-sm-12 col-12 mb-4">
                                        <div class="form-group">
                                            <label for="testing_employee_id">Testing Employee Name </label>
                                            <input readonly type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{ $project->tester ? $project->tester->name :'No Testing Employee  Assgined Yet' }}">
                                        </div>
                                      </div>

                                      <div class="col-lg-12 col-md-6 col-sm-12 col-12 mb-4">
                                        <div class="form-group">
                                            <label for="details">Details </label>
                                            <textarea readonly class="form-control @error('details') is-invalid @enderror"   name="details" id="details" cols="30" rows="6">
                                                {{ $project->details }}
                                            </textarea>

                                        </div>
                                      </div>

                                      <div class="col-lg-12 col-md-6 col-sm-12 col-12 mb-4">
                                        <div class="form-group">
                                            <label for="">Status </label>
                                            <input readonly type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{ $project->status}}">
                                        </div>
                                      </div>
                                      <div class="col-lg-12 col-md-6 col-sm-12 col-12 mb-4">
                                        <div class="form-group">
                                            <label for="">Created By </label>
                                            <input readonly type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{ $project->createdBy->name}}">
                                        </div>
                                      </div>
                                      <div class="col-lg-12 col-md-6 col-sm-12 col-12 mb-4">
                                        <div class="form-group">
                                            <label for="">Created By </label>
                                            <input readonly type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{ $project->editedBy? $project->editedBy->name : "Not Edited Yet"}}">
                                        </div>
                                      </div>

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

@endsection
