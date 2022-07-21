@extends('layouts.employee.employee_app')
@section('meeting_reports_active')
mm-active
@endsection
@section('meeting_reports_index_active')
active
@endsection
@section('employee_title')
Meeting Report
@endsection
@section('employee_content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Meeting Report</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/employee/dashboard') }}"> DashBoard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Reports</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="reportbody">
            @include('employee.pages.includes.meetingReport')
        </div>
    </div>
</div> <!-- container-fluid -->

<!-- modal start-->
<div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('employee.meetingReport.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <label for="name"> Title <span class="text-danger">*</span></label>
                        <div class="col-lg-10  col-10">
                            <input id="title" name="title" type="text" class="form-control"
                                placeholder="Enter Report Title..." value="{{ old('title') }}">
                            @error('title')
                                <span class="text-danger mt-3">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-lg-2 col-2 ">
                            <button type="submit" class="btn btn-primary">Create </button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- modal end-->

<!-- second modal start -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Report Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id='report_form' action="">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Report Details <span
                                class="text-danger">*</span></label>
                        <input id='id' name="id" hidden type="text" class="form-control">
                        <input  id='report' name="report" class="form-control" id="message-text">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>

    </div>
</div>
</div>
<!-- second modal end -->

<!-- titile edit modal start -->
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Report Title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id='update_title' action="">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Report Details <span
                                class="text-danger">*</span></label>
                        <input id='edit_id' name="edit_id"  type="text" class="form-control" hidden>
                        <input id='report_title' name="report_title" class="form-control" id="message-text">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>

    </div>
</div>
</div>
<!-- title edit modal end -->

<!-- report title details modal start -->
<div class="modal fade" id="xyz" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id='update_details' action="">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Details <span
                                class="text-danger">*</span></label>
                        <input id='edit_details_id' name="edit_details_id" type="text" class="form-control" hidden>
                        <input id='report_details' name="report_details" type="text" class="form-control">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>

    </div>
</div>
<!-- report details edit modal end -->

@endsection
@section('employee_js')
@if(Session::has('report_added'))
    <script>
        Toast.fire({
            icon: 'success',
            title: '{{ session()->get('report_added')}}'
        })

    </script>
@endif

@if($errors->any())
    <script>
        Toast.fire({
            icon: 'error',
            title: 'Something went wrong, Please enter a Title'
        })

    </script>
@endif
<script>
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta [name="csrf-token"]').attr('content')
            }
        })
        /*  ==============================
                               add report details start
            ==============================   */
        $(document).on('click', '#create', function (e) {
            $('#id').val($(this).attr('value'))
            e.preventDefault()
        })

        $(document).on('submit', '#report_form', function (e) {
            let report = $('#report').val();

            if (report == '') {
                Toast.fire({
                    icon: 'error',
                    title: 'Something went wrong, Please enter a Report Details'
                })
            } else {
                $.ajax({
                    method: "post",
                    url: '/employee/meeting-report/store-report-details',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    async: false
                }).done(response => {

                    $('#reportbody').html(response.view)
                    $('#report').val('')
                })
                Toast.fire({
                    icon: 'success',
                    title: 'Report Details Created'
                })
            }
            e.preventDefault()
        })
    })

    /*  ==============================
                        add report details end
        ==============================   */


    /*  ==============================
                        edit report title start
        ==============================   */
    $(document).on('click', '#titleedit', function (e) {
        let edit_id = $(this).attr('value');

        $('#edit_id').val($(this).attr('value'));

        $.ajax({
            method: 'get',
            url: `/employee/meeting-report/edit/${edit_id}`,
            dataType: 'json'
        }).done(response => {
            $('#report_title').val(response.report)
        })

        e.preventDefault()
    })

    /*  ==============================
                        edit report title end
        ==============================   */

    /*  ==============================
                        update report title start
        ==============================   */
    $(document).on('submit', '#update_title', function (e) {
        let title = $('#report_title').val();
        if (title == '') {
            Toast.fire({
                icon: 'error',
                title: 'Something went wrong, Please enter a Report title'
            })
        } else {
            $.ajax({
                method: "post",
                url: '/employee/meeting-report/update',
                data: new FormData(this),
                processData: false,
                contentType: false,
                async: false
            }).done(response => {

                $('#reportbody').html(response.view)
            })
            Toast.fire({
                icon: 'success',
                title: 'Report Title Updated Successfully'
            })
        }
        e.preventDefault()
    })


    /*  ==============================
                        update report title end
        ==============================   */

    /*  ==============================
                      delete  report start
        ==============================   */

    $(document).on('click', '#delete_report', function (e) {
        const deleted_id = $(this).attr('value');
        $.ajax({
            method: 'get',
            url: `/employee/meeting-report/destroy/${deleted_id}`
        }).done(response => {
            $('#reportbody').html(response.view)
            Toast.fire({
                icon: 'success',
                title: 'Report  Deleted Successfully'
            })
        })

    })
    /*  ==============================
                     delete report end
        ==============================   */


    /*  ==============================
                     permanently  delete report start
        ==============================   */

    $(document).on('click', '.sweet_delete', function (e) {

        const delete_id = $(this).attr('value');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var data = {
                    "_token": $('input[name=_token]').val(),
                    "id": delete_id,
                };
                $.ajax({
                    type: "get",
                    url: '/employee/meeting-report/parmanent-delete/' + delete_id,
                    data: data,
                    success: function (response) {
                        Swal.fire(
                                'Deleted!',
                                'Report deleted.',
                                'success'
                            )
                            .then((response) => {
                                location.reload();
                            });
                    }
                });
            }
        })
    });

    /*  ==============================
                    permanently  delete report end
        ==============================   */

    /*  ==============================
                   restore report start
        ==============================   */
    $(document).on('click', '#restore', function (e) {
        const restore_id = $(this).attr('value')
        $.ajax({
            method: 'get',
            url: `/employee/meeting-report/restore/${restore_id}`
        }).done(response => {
            $('#reportbody').html(response.view)
            Toast.fire({
                icon: 'success',
                title: 'Report  Restored Successfully'
            })
        })
        e.preventDefault()
    })

    /*  ==============================
                    restore report end
        ==============================   */


    /*  ==============================
                    edit report details start
        ==============================   */
    $(document).on('click', '#edit_details', function (e) {
        const edit_id = $(this).attr('value');
        $('#edit_details_id').val(edit_id);

        $.ajax({
            method: 'get',
            url: `/employee/meeting-report/edit-details/${edit_id}`,
            dataType: 'json'
        }).done(response => {

            $('#report_details').val(response.reportDetails)
        })

        e.preventDefault()
    })
    /*  ==============================
                    edit report details end
        ==============================   */

    /*  ==============================
                    update report details start
        ==============================   */
    $(document).on('submit', '#update_details', function (e) {
        let details = $('#report_details').val();
        if (details == '') {
            Toast.fire({
                icon: 'error',
                title: 'Something went wrong, Please enter a Report Details'
            })
        } else {
            $.ajax({
                method: "post",
                url: '/employee/meeting-report/update-details',
                data: new FormData(this),
                processData: false,
                contentType: false,
                async: false
            }).done(response => {
                $('#reportbody').html(response.view)
            })
            Toast.fire({
                icon: 'success',
                title: 'Report Details Updated Successfully'
            })
        }
        e.preventDefault()
    })
    /*  ==============================
                    update report details end
        ==============================   */


    /*  ==============================
                    delete report details start
        ==============================   */

    $(document).on('click', '#delete_details', function (e) {

        const deleted_id = $(this).attr('value');
        $.ajax({
            method: 'get',
            url: `/employee/meeting-report/destroy-details/${deleted_id}`
        }).done(response => {
            $('#reportbody').html(response.view)
            Toast.fire({
                icon: 'success',
                title: 'Report Details  Deleted Successfully'
            })
        })

    })

    /*  ==============================
                    delete report details end
        ==============================   */

    /*  ==============================
                    filter by date search start
        ==============================   */
        $(document).on('click','#filter',function(e){
        const startDate = $('#startDate').val();
        const endDate = $('#endDate').val();
        if(startDate =="" && endDate==""){
            Toast.fire({
                icon: 'error',
                title: 'Something went wrong, Please select any date'
            })
        }
        if(startDate !="" && endDate!=""){
            if(startDate > endDate){
                Toast.fire({
                    icon: 'error',
                    title: 'Something went wrong, StartDate must be less than EndDate'
                })
            }
            else{
                $.ajax({
                    method: 'get',
                    url: `/employee/meeting-report/search-by-date`,
                    data:{
                        'startDate' : startDate,
                        'endDate' : endDate,
                    }
                }).done(response => {
                   $('#reportbody').html(response.view)
                   $('#startDate').val(startDate);
                   $('#endDate').val(endDate);
                })
            }
        }
        else{
            $.ajax({
                method: 'get',
                url: `/employee/meeting-report/search-by-date`,
                data:{
                    'startDate' : startDate,
                    'endDate' : endDate,
                }
            }).done(response => {
               $('#reportbody').html(response.view)
               $('#startDate').val(startDate);
               $('#endDate').val(endDate);
            })
        }
            e.preventDefault()
        })
    /*  ==============================
                    filter by date search end
        ==============================   */
</script>
@endsection
