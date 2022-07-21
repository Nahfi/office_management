@extends('layouts.admin.admin_app')
@section('admin_page_title')
   Email Show | BIR it
@endsection
@section('email_active')
mm-active
@endsection
@section('email_show_active')
active
@endsection
@section('admin_css')
@endsection
@section('admin_css_link')
<!-- choices css-->
<link href="{{ asset('admin_assets') }}/libs/choices.js/public/assets/styles/choices.min.css"
    rel="stylesheet" type="text/css" />
<!-- editor css-->
<link href="{{ asset('admin_assets') }}/css/rte_theme_default.css" rel="stylesheet" type="text/css" />
@endsection

@section('admin_js_link')
<!-- choices js -->
<script src="{{ asset('admin_assets') }}/libs/choices.js/public/assets/scripts/choices.min.js">
</script>
<!-- init js -->
<script src="{{ asset('admin_assets') }}/js/pages/form-advanced.init.js"></script>
<!-- editor js -->
<script src="{{ asset('admin_assets') }}/js/all_plugins.js"></script>
<script src="{{ asset('admin_assets') }}/js/rte.js"></script>
@endsection
@section('admin_content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Read Email</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Email</a></li>
                            <li class="breadcrumb-item active">Read Email</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <!-- Left sidebar -->
                @include('admin.pages.includes.email_left_side_bar')
                <!-- End Left sidebar -->

                <!-- Right Sidebar -->
                <div class="email-rightbar mb-3">
                     @foreach ($allEmailInfo['emailInfo'] as $email )
                     <div class="card">
                        <div class="btn-toolbar gap-2 p-3" role="toolbar">
                            <div class="btn-group">
                                <a   href="{{ route('admin.email.destroyReceivedEmail', $email ->id) }}"   class="btn btn-success waves-light waves-effect"><i
                                        class="far fa-trash-alt"></i></a>
                            </div>
                        </div>

                          <div class="card-body">
                            <div class="d-flex align-items-center mb-4">
                                <div class="flex-shrink-0 me-3">
                                    <img class="rounded-circle avatar-sm" src="{{ asset('/photo/profile/'.$email->sender->photo) }}"
                                        alt="{{  $email->sender->photo }}">
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="font-size-14 mb-0">{{ $email->sender->name }}</h5>
                                    <small class="text-muted">{{  $email->sender->email }}</small>
                                </div>
                            </div>

                            <h4 class="font-size-16">{{  $email->subject ?  $email->subject : "no subject" }}</h4>
                            <p>Dear : <span class=" bg-success badge me-2">
                                @if ( $email->receiver)
                                {{   $email->receiver->name  ==   Auth::guard('admin')->user()->name ? 'me' : $email->receiver->name }}
                              @elseif($email->EmployeeReceiver)
                                {{   $email->EmployeeReceiver->name  ==   Auth::guard('admin')->user()->name ? 'me' : $email->EmployeeReceiver->name }}
                            @endif
                             </span></p>
                            <p>   {!! htmlspecialchars_decode(( $email->description))!!}
                            </p>

                            <p>Sincerly,</p>
                            <hr />

                        </div>

                        @endforeach

                    </div>

                </div>

            </div>

        </div><!-- End row -->
    </div> <!-- container-fluid -->
    <!-- Modal -->
    <div class="modal fade" id="composemodal" tabindex="-1" role="dialog" aria-labelledby="composemodalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <form id="email_send_form" action="{{ route('admin.email.store') }}" method="post">
            @csrf

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-size-16" id="composemodalTitle">New Message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <div class="mb-3">
                        <select class="form-control" data-trigger name="to[]" multiple
                            id="choices-single-default">
                            <option value="">To</option>
                            @forelse ($allAdmin as $admin )
                            <option value="{{ $admin->id}}">{{ $admin->email }}</option>
                            @empty
                             empty
                            @endforelse

                            @forelse ($allEmployee as $employee )
                            <option value="employee{{ $employee->id }}">{{ $employee->email }}</option>
                            @empty
                             empty
                            @endforelse

                        </select>
                        @error('to')
                        <span class="text text-danger">{{ $message }}</span>
                    @enderror
                    </div>

                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Subject" name="subject">
                    </div>
                    <div class="mb-3 email-editor">
                        <input class="form-control" type="text" name="description" id="inp_editor1" >
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="email_button" type="submit" class="btn btn-primary">Send <i
                        class="fab fa-telegram-plane ms-1"></i></button>
            </div>
        </div>
    </form>
    </div>
</div>
    <!-- end modal -->

</div>
@endsection
@section('admin_js')
<script>
    var editor1 = new RichTextEditor("#inp_editor1");
</script>

@if(Session::has('destory_success'))
    <script>
        Toast.fire({
            icon: 'success',
            title: '{{ Session::get('destory_success') }}'
        })

    </script>
@endif

@endsection
