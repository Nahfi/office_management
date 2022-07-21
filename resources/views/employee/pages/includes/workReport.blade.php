
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            {{-- row align-items-center start --}}
            <div class="row mb-3">
               <div class="col-lg-12 col-12">
                   <div class="row">
                       <div class="col-lg-4 col-4">
                           <label for="message-text" class="col-form-label">Start Date</label>
                           <input type="date" class="form-control" name="startDate" id="startDate">
                       </div>
                       <div class="col-lg-4 col-4">
                           <label for="message-text" class="col-form-label">End Date </label>
                           <input type="date" class="form-control" id="endDate" name="endDate">
                       </div>
                       <div class="col-lg-4 col-4" style="margin-top: 36px">
                           <a id="filter"
                           class="btn btn-primary mb-2 btn-md">
                           Filter</a>
                       </div>
                   </div>
               </div>
            </div>
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="mb-3">
                        <h5 class="card-title me-4" style="float:left;margin-top:5px">Total Reports <span
                                class="text-muted fw-normal ms-2">({{ $countReports }})</span></h5>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                        <div id="category_button">
                            <a data-bs-toggle="modal" data-bs-target=".bs-example-modal-center"
                                class="btn btn-primary mb-2 btn-sm"><i class="bx bx-plus me-1"></i>
                                Add New</a>
                        </div>
                    </div>
                </div>
            </div>
            {{-- row align-items-center end --}}
            <div class="row">
                <div class="col-lg-4">
                    <div class="border rounded p-4">
                        <h4 class="card-title mb-4">Pending ({{ count($pendingReports) }})</h4>
                        @forelse($pendingReports as $pendingReport)
                            <div id="task-1">
                                <div id="upcoming-task" class="pb-1 task-list">
                                    <div class="card task-box" id="uptask-2">
                                        <div class="card-body">
                                            <div class="dropdown float-end">
                                                <a href="#" class="dropdown-toggle arrow-none"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item edittask-details" href="#" id="create"
                                                        value='{{ $pendingReport->id }}' data-id="#uptask-2"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal">Add Iteam</a>

                                                    <a class="dropdown-item edittask-details" href="#" id="titleedit"
                                                    value='{{ $pendingReport->id }}'
                                                         data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal1"
                                                   >Edit</  a>
                                                    <a class="dropdown-item edittask-details"   id="delete_report"
                                                       value='{{ $pendingReport->id }}'
                                                      >Delete</a>
                                                </div>
                                            </div> <!-- end dropdown -->
                                            <div class="float-end ms-2">
                                                <span class="badge rounded-pill badge-soft-warning font-size-12 "
                                                    id="task-status">Pending</span>
                                            </div>
                                            <div>
                                                <h5 class="font-size-14"><a href="javascript: void(0);"
                                                        class="text-dark" id="task-name">{{ $pendingReport->title }}
                                                    </a></h5>
                                                    <hr>

                                            </div>
                                            <ul class="ps-3 mb-4 text-muted" id="task-desc">

                                                @forelse($pendingReport->reportDetails as $details)
                                                    <li class="py-1">{{ $details->report }}
                                                    <div class="dropdown float-end">
                                                <a href="#" class="dropdown-toggle arrow-none"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">

                                                    <a class="dropdown-item edittask-details" href="#" id="edit_details"
                                                        value='{{ $details->id }}' data-bs-toggle="modal"
                                                        data-bs-target="#xyz" data-bs-whatever="@getbootstrap">Edit</a>
                                                    <a class="dropdown-item edittask-details" id="delete_details"  value='{{ $details->id }}'    >Delete</a>
                                                </div>
                                            </div> <!-- end dropdown -->

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
                        @empty
                            <p> no reports found </p>
                        @endforelse

                    </div>
                </div>
                {{-- pending reports end --}}

                <div class="col-lg-4">
                    <div class="border rounded p-4">
                        <h4 class="card-title mb-4">Approved ({{ count($approvedReports) }})</h4>
                        @forelse($approvedReports as $approvedReport)
                            <div id="task-1">
                                <div id="upcoming-task" class="pb-1 task-list">
                                    <div class="card task-box" id="uptask-2">
                                        <div class="card-body">
                                            <div class="dropdown float-end">
                                                <a href="#" class="dropdown-toggle arrow-none"
                                                    data-bs-toggle="dropdown" aria-expanded="false">

                                                </a>

                                            </div> <!-- end dropdown -->
                                            <div class="float-end ms-2">
                                                <span class="badge rounded-pill badge-soft-success font-size-12 "
                                                    id="task-status">Approved</span>
                                            </div>

                                            <div>
                                                <h5 class="font-size-14"><a href="javascript: void(0);"
                                                        class="text-dark" id="task-name">{{ $approvedReport->title }}
                                                    </a></h5>

                                                    <hr>

                                            </div>
                                            <ul class="ps-3 mb-4 text-muted" id="task-desc">
                                           @forelse($approvedReport->reportDetails as $details)
                                                   <li class="py-1">{{ $details->report }}</li>
                                           @empty
                                                       <p> no details found </p>
                                           @endforelse
                                           </ul>

                                        </div>

                                    </div>
                                    <!-- end task card -->
                                </div>
                            </div>

                        @empty
                            <p> no reports found </p>
                        @endforelse


                    </div>
                </div>
                <!-- end col -->
                <div class="col-lg-4">
                    <div class="border rounded p-4">
                        <!-- end dropdown -->
                        <h4 class="card-title mb-4">Deleted ({{ count($deletedReports) }})</h4>
                        @forelse($deletedReports as $deletedReport)
                            <div id="task-1">
                                <div id="upcoming-task" class="pb-1 task-list">
                                    <div class="card task-box" id="uptask-2">
                                        <div class="card-body">
                                            <div class="dropdown float-end">
                                                <a href="#" class="dropdown-toggle arrow-none"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item deletetask sweet_delete " href="#" id="permanent_delete"
                                                    value="{{$deletedReport->id}}"
                                                        data-id="#uptask-2">Delete</a>
                                                    <a class="dropdown-item deletetask" href="#" value="{{$deletedReport->id}}"
                                                    id="restore"
                                                        data-id="#uptask-2">Restore</a>
                                                </div>
                                            </div> <!-- end dropdown -->
                                            <div class="float-end ms-2">
                                                <span class="badge rounded-pill badge-soft-danger font-size-12 "
                                                    id="task-status">Deleted</span>
                                            </div>
                                            <div>
                                                <h5 class="font-size-14"><a href="javascript: void(0);"
                                                        class="text-dark" id="task-name">{{ $deletedReport->title }}
                                                    </a></h5>
                                                    <hr>
                                            </div>
                                            <ul class="ps-3 mb-4 text-muted" id="task-desc">
                                             @forelse($deletedReport->reportDetails as $details)
                                                   <li class="py-1">{{ $details->report }}</li>
                                           @empty
                                                       <p> no details found </p>
                                           @endforelse

                                           </ul>

                                        </div>

                                    </div>
                                    <!-- end task card -->
                                </div>
                            </div>

                        @empty
                            <p> no reports found </p>
                        @endforelse


                    </div>
                </div>
                <!-- end col -->
            </div>
        </div>
    </div>

</div>



