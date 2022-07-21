@extends('layouts.employee.employee_app')
@section('employee_title')
   Email Show | BIR it
@endsection
@section('email_active')
mm-active
@endsection
@section('email_index_active')
active
@endsection

@section('employee_css_link')
<!-- choices css-->
<link href="{{ asset('admin_assets') }}/libs/choices.js/public/assets/styles/choices.min.css"
    rel="stylesheet" type="text/css" />
<!-- editor css-->
<link href="{{ asset('admin_assets') }}/css/rte_theme_default.css" rel="stylesheet" type="text/css" />
@endsection

@section('employee_js_link')
<!-- choices js -->
<script src="{{ asset('admin_assets') }}/libs/choices.js/public/assets/scripts/choices.min.js">
</script>
<!-- init js -->
<script src="{{ asset('admin_assets') }}/js/pages/form-advanced.init.js"></script>
<!-- editor js -->
<script src="{{ asset('admin_assets') }}/js/all_plugins.js"></script>
<script src="{{ asset('admin_assets') }}/js/rte.js"></script>
@endsection
@section('employee_content')
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
      @include('employee.pages.includes.email_left_side_bar')
       <!-- End Left sidebar -->
                <!-- Right Sidebar -->

                @if($allEmailInfo['emailInfo'] )
                <div class="email-rightbar mb-3">
                    <div class="card">
                       <div class="btn-toolbar gap-2 p-3" role="toolbar">
                           <div class="btn-group">
                               @if ( app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName() == 'employee.email.trash')
                               <a   href="{{ route('employee.email.restore', $allEmailInfo['emailInfo'] ->id) }}"   class="btn btn-success waves-light waves-effect"><i
                                class="fas fa-trash-restore"></i></a>
                                @else
                                <a   href="{{ route('employee.email.destroySentEmail', $allEmailInfo['emailInfo'] ->id) }}"   class="btn btn-success waves-light waves-effect"><i
                                    class="far fa-trash-alt"></i></a>
                               @endif

                           </div>
                       </div>

                         <div class="card-body">
                           <div class="d-flex align-items-center mb-4">
                               <div class="flex-shrink-0 me-3">
                                   @if($allEmailInfo['emailInfo']->sender)
                                        <img class="rounded-circle avatar-sm" src="{{ asset('/photo/profile/'.$allEmailInfo['emailInfo']->sender->photo) }}"
                                        alt="{{  $allEmailInfo['emailInfo']->sender->photo }}">

                                        @elseif($allEmailInfo['emailInfo']->EmployeeSender)
                                            <img class="rounded-circle avatar-sm" src="{{ asset('/photo/employee_profile/'.$allEmailInfo['emailInfo']->EmployeeSender->photo) }}"
                                            alt="{{  $allEmailInfo['emailInfo']->EmployeeSender->photo }}">
                                    @endif

                               </div>
                               <div class="flex-grow-1">
                                   <h5 class="font-size-14 mb-0">
                                       @if ($allEmailInfo['emailInfo']->sender)
                                       {{ $allEmailInfo['emailInfo']->sender->name }}
                                       @elseif($allEmailInfo['emailInfo']->EmployeeSender)
                                       {{ $allEmailInfo['emailInfo']->EmployeeSender->name }}
                                       @endif
                                    </h5>
                                   <small class="text-muted">
                                    @if ($allEmailInfo['emailInfo']->sender)
                                    {{  $allEmailInfo['emailInfo']->sender->email }}
                                    @elseif ($allEmailInfo['emailInfo']->EmployeeSender)
                                    {{  $allEmailInfo['emailInfo']->EmployeeSender->email }}
                                    @endif
                                    </small>
                               </div>
                           </div>
                           <h4 class="font-size-16">{{  $allEmailInfo['emailInfo']->subject ? $allEmailInfo['emailInfo']->subject : "no subject" }}</h4>
                           <p>Dear : <span class=" bg-success badge me-2">
                         @if ( $allEmailInfo['emailInfo']->receiver)
                            {{
                                 $allEmailInfo['emailInfo']->receiver->name
                            }}
                        @elseif( $allEmailInfo['emailInfo']->EmployeeReceiver)
                            {{   $allEmailInfo['emailInfo']->EmployeeReceiver->name  }}
                        @elseif( $allEmailInfo['emailInfo']->sender)
                            {{   $allEmailInfo['emailInfo']->sender->name  }}
                        @elseif( $allEmailInfo['emailInfo']->EmployeeSender)

                            {{
                                $allEmailInfo['emailInfo']->EmployeeSender->name
                           }}
                        @endif

                        </span></p>
                           <p>   {!! htmlspecialchars_decode(($allEmailInfo['emailInfo']->description))!!}
                           </p>
                           <p>Sincerly,</p>
                           <hr />
                       </div>
                   </div>
               </div>
                @endif


            </div>

        </div><!-- End row -->
    </div> <!-- container-fluid -->
    <!-- Modal -->
    <div class="modal fade" id="composemodal" tabindex="-1" role="dialog" aria-labelledby="composemodalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <form id="email_send_form" action="{{ route('employee.email.store') }}" method="post">
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
                            <option value="admin{{ $admin->id}}">{{ $admin->email }}</option>
                            @empty
                             empty
                            @endforelse
                            @forelse ($allEmployee as $employee )
                            <option value="{{ $employee->id }}">{{ $employee->email }}</option>
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
@section('employee_js')
<script>
    var editor1 = new RichTextEditor("#inp_editor1");
</script>
@if(Session::has('delete_success'))
    <script>
        Toast.fire({
            icon: 'success',
            title: '{{ Session::get('delete_success') }}'
        })
    </script>

@endif
@if(Session::has('restore_success'))
    <script>
        Toast.fire({
            icon: 'success',
            title: '{{ Session::get('restore_success') }}'
        })
    </script>
@endif
@if(Session::has('email_sends_successfully'))
    <script>
        Toast.fire({
            icon: 'success',
            title: '{{ Session::get('email_sends_successfully') }}'
        })

    </script>
@endif
@endsection
