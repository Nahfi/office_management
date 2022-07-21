@extends('layouts.customer.customer_app')
@section('project_active')
mm-active
@endsection
@section('user_page_title')
project Details
@endsection
@section('customer_content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Project Details</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('customer.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('customer.project.index') }}">All project</a></li>
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

                                      <input type="text" class="form-control @error('work_order') is-invalid @enderror" name="work_order" value="{{ $project->title }}">
                                  </div>
                              </div>
                              <div class="mt-2 col-lg-12 col-md-6 col-sm-12 col-12">
                                  <div class="form-group">
                                      <label>Project Details </label>
                                      <textarea class="form-control" name="" id="" cols="30" rows="10">
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
@section('customer_js')
@endsection
@endsection
