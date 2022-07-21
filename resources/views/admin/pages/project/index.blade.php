@extends('layouts.admin.admin_app')
@section('admin_page_title')
 Project| BIR it
@endsection
@section('project_active')
    mm-active
@endsection
@section('admin_css_link')
     <!-- DataTables -->
  <link href="{{ asset('admin_assets') }}/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
  <link href="{{ asset('admin_assets') }}/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
  <!-- Responsive datatable examples -->
  <link href="{{ asset('admin_assets') }}/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('admin_js_link')
    <!-- Required datatable js -->
 <script src="{{ asset('admin_assets') }}/libs/datatables.net/js/jquery.dataTables.min.js"></script>
 <script src="{{ asset('admin_assets') }}/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
 <!-- Buttons examples -->
 <script src="{{ asset('admin_assets') }}/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
 <script src="{{ asset('admin_assets') }}/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
 <script src="{{ asset('admin_assets') }}/libs/jszip/jszip.min.js"></script>
 <script src="{{ asset('admin_assets') }}/libs/pdfmake/build/pdfmake.min.js"></script>
 <script src="{{ asset('admin_assets') }}/libs/pdfmake/build/vfs_fonts.js"></script>
 <script src="{{ asset('admin_assets') }}/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
 <script src="{{ asset('admin_assets') }}/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
 <script src="{{ asset('admin_assets') }}/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
 <!-- Responsive examples -->
 <script src="{{ asset('admin_assets') }}/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
 <script src="{{ asset('admin_assets') }}/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
 <!-- Datatable init js -->
 <script src="{{ asset('admin_assets') }}/js/pages/datatables.init.js"></script>
@endsection
@section('admin_content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Projects</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Projects</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <h5 class="card-title me-4" style="float:left;margin-top:5px">Total Projects <span class="text-muted fw-normal ms-2">({{ $projects->count() }})</span></h5>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                                        <div id="category_button">
                                            @if (Auth::guard('admin')->User()->can('project.create'))
                                                <a href="{{ route('admin.project.create') }}" class="btn btn-primary mb-2 btn-sm"><i class="bx bx-plus me-1"></i> Add New</a>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="height: calc(100vh - 270px);overflow-y:scroll;overflow-x:hidden;">


                                <table id="datatable-buttons" class="table table-bordered dt-responsive  nowrap w-100" style="height: 10px;">
                                    <thead>
                                    <tr>

                                        <th>S\N</th>
                                        <th>Name</th>
                                        <th>Customer Name</th>
                                        <th>status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($projects as $project)
                                            <tr>

                                                <th>{{ $loop->iteration }}</th>
                                                <th>
                                                    {{    $project->title }}
                                                </th>

                                                <td>{{ $project->customer->name }}</td>

                                                <td>
                                                    <span class="badge bg-success">{{ $project->status }}</span>
                                                </td>

                                                <td>
                                                    @if (Route::currentRouteName() == 'admin.project.index')
                                                         @if (Auth::guard('admin')->User()->can('project.index'))
                                                            <a href="{{ route('admin.project.show',$project->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-eye" ></i></a>
                                                            <a href="{{ route('admin.project.showTestReport',$project->id) }}" class="btn btn-sm btn-primary"> Test Report <i class="fas fa-eye" ></i></a>
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"> <i style="font-size:12px !important;" class="mdi mdi-chevron-down"></i></button>
                                                                <div class="dropdown-menu dropdownmenu-success" style="">
                                                                    <a class="btn btn-sm btn-primary" href="{{ route('admin.project.downloadWorkOrder',$project->id) }}">Wrok Order <i  class="ms-1 fas fa-download"></i></a>
                                                                    <a class="btn btn-sm btn-primary" href="{{ route('admin.project.downloadDeed',$project->id) }}">Deed<i  class="ms-1 fas fa-download"></i></a>

                                                                    <a class="btn btn-sm btn-primary" href="{{ route('admin.project.downloadRequirment',$project->id) }}">Requirments<i  class="ms-1 fas fa-download"></i></a>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if (Auth::guard('admin')->User()->can('project.edit'))
                                                            <a href="{{ route('admin.project.edit',$project->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-user-edit" ></i></a>
                                                        @endif
                                                        @if (Auth::guard('admin')->User()->can('project.delete'))
                                                            <a href="{{ route('admin.project.delete',$project->id) }}"  class="btn btn-sm btn-danger"> <i class="fas fa-trash-alt"></i></a>
                                                        @endif
                                                    @endif


                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                                <!-- end table -->
                            <!-- end table responsive -->
                        </div>


                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->
</div>
@section('admin_js')

@if (Session::has('no_file_found'))
<script>
        Toast.fire({
            icon: 'error',
            title: "{{ Session::get('no_file_found') }}"
        })
</script>
@endif

@if (Session::has('project_deleted'))
<script>
        Toast.fire({
            icon: 'success',
            title: "{{ Session::get('project_deleted') }}"
        })
</script>
@endif


@endsection
@endsection
