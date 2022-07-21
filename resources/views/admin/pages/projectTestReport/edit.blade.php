@extends('layouts.admin.admin_app')
@section('admin_page_title')
 Update Project Test Report | BIR it
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
                    <h4 class="mb-sm-0 font-size-18">Update Status </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.project.index') }}">All Project</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.project.showTestReport',$testReport->project_id) }}">All Test Report </a></li>
                            <li class="breadcrumb-item active">Update Test Report Status</li>
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
                          <form action="{{ route('admin.projectTesting.update',$testReport->id)}}" method="POST" enctype="multipart/form-data">
                              @csrf
                              <div class="row justify-content-center">

                                  <div class="col-lg-8 col-md-6 col-sm-12 col-12 ">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-select  @error('status') is-invalid @enderror">
                                            <option value="">select status</option>
                                            <option  value="pending" {{ ($testReport->status == 'pending' ? "selected":"") }}>Pending</option>
                                            <option  value="decline " {{ ($testReport->status == 'decline' ? "selected":"") }}>Decline</option>
                                            <option  value="accepted" {{ ($testReport->status == 'accepted' ? "selected":"") }}>Accepted</option>
                                        </select>
                                        @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                  </div>

                                  <div class="col-lg-8 col-12">
                                    <button type="submit" class="btn btn-sm btn-primary mt-4">Update</button>
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
    @if (Session::has('test_report_update_success'))
    <script>
            Toast.fire({
                icon: 'success',
                title: "{{ Session::get('test_report_update_success') }}"
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
