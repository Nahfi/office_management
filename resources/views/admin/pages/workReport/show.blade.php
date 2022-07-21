@extends('layouts.admin.admin_app')
@section('work_report_active')
    active
@endsection
@section('admin_page_title')
 Show Work Report | BIR it
@endsection
@section('admin_content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Work Report</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.workReport.index') }}">All Report</a></li>
                            <li class="breadcrumb-item active"> Work Report</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="reportbody">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-lg-6">
                                    <div class="border rounded p-4">
                                            <div id="task-1">
                                                <div id="upcoming-task" class="pb-1 task-list">
                                                    <div class="card task-box" id="uptask-2">
                                                        <div class="card-body">

                                                            <div class="float-end ms-2">
                                                                <span class="badge rounded-pill badge-soft-warning font-size-12 "
                                                                    id="task-status">Pending</span>
                                                            </div>
                                                            <div>
                                                                <h5 class="font-size-14"><a href="javascript: void(0);"
                                                                        class="text-dark" id="task-name">{{ $report->title  }}
                                                                    </a></h5>

                                                                    <hr>

                                                                    <p>Created by <span style="font-size: 15px" class="badge bg-info">
                                                                        {{ $report->employee->name }}</span></p>

                                                            </div>
                                                            <ul class="ps-3 mb-4 text-muted" id="task-desc">

                                                                @forelse($report->reportDetails as $details)
                                                                    <li class="py-1">{{ $details->report }}


                                                                    </li>
                                                                @empty
                                                                    <p> no details found </p>
                                                                @endforelse

                                                            </ul>

                                                        </div>

                                                    </div>
                                                    <!-- end task card -->
                                                </div>
                                            </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>


@endsection


