@extends('layouts.employee.employee_app')
@section('employee_title')
    Email | BIR it
@endsection
@section('email_active')
mm-active
@endsection
@section('email_index_active')
active
@endsection

@section('employee_css_link')
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
<script src="{{ asset('admin_assets') }}/js/rte.js"></script>
<script src="{{ asset('admin_assets') }}/js/all_plugins.js"></script>
@endsection
@section('employee_content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Inbox</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('employee.email.index') }}">Email</a></li>
                            <li class="breadcrumb-item active">Inbox</li>
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
                <div class="email-rightbar mb-3">
                    <div class="card">
                        <form action="{{ route('employee.email.mark') }}" method="post">
                            @csrf
                        <ul class="message-list">
                            <div class="btn-toolbar gap-2 p-3" role="toolbar">
                                <div class="btn-group">
                                    @if (Route::currentRouteName() == 'employee.email.index'  || Route::currentRouteName() == 'employee.email.allSentEmail' || Route::currentRouteName() == 'employee.email.allUnreadEmail' )
                                    <button  name='submitType' value="softDelete" type="submit" class="btn btn-primary waves-light waves-effect"><i
                                        class="far fa-trash-alt"></i>
                                    </button>
                                    @endif

                                    @if (Route::currentRouteName() == 'employee.email.trash' )
                                    <button  name='submitType' value="restore"   type="submit" class="btn btn-primary waves-light waves-effect"><i
                                            class="fas fa-trash-restore"></i></button>
                                            <button type="submit" name='submitType' value="parmanentDelete"   class="btn btn-danger waves-light waves-effect"><i
                                                class="far fa-trash-alt"></i></button>
                                    @endif
                                </div>
                            </div>
                        @if (Route::currentRouteName() == 'employee.email.index' ||  Route::currentRouteName()=='employee.email.allUnreadEmail' )

                         @foreach ($allEmailInfo['emailInfo'] as $email )
                                <li class="{{ $email->status=="unread" ?'unread':' '}}">
                                    <div class="col-mail col-mail-1">
                                        <div class="checkbox-wrapper-mail">
                                            <input name="markedId[]" type="checkbox" id="{{ $email->id }}" multiple value="{{ $email->id }}">
                                            <label for="{{ $email->id }}" class="toggle"></label>
                                        </div>
                                        @if ($email->employee_form)
                                        <a href="{{ route('employee.email.showSpecificMail',$email->slug)}}" class="title">{{$email->EmployeeSender->name }}

                                        </a>
                                        @endif
                                         @if ($email->form)
                                        <a href="{{ route('employee.email.showSpecificMail',$email->slug)}}" class="title">{{$email->sender->name }}
                                        </a>
                                        @endif
                                    </div>


                                    <div class="col-mail col-mail-2">
                                        @if($email->employee_form)
                                        <a href={{ route('employee.email.showSpecificMail',$email->slug)}} class="subject">
                                            <span class="bg-{{ $email->status == 'unread' ? "danger":"success"}} badge me-2">{{ $email->status }}</span>
                                            <span class="teaser">
                                            {!! htmlspecialchars_decode(strip_tags($email->description ))!!}
                                        </span>
                                        </a>
                                        @else
                                        <a href={{ route('employee.email.showSpecificMail',$email->slug)}} class="subject">
                                            <span class="bg-{{ $email->status == 'unread' ? "danger":"success"}} badge me-2">{{ $email->status }}</span>
                                            <span class="teaser">
                                            {!! htmlspecialchars_decode(strip_tags($email->email))!!}
                                        </span>
                                        </a>
                                        @endif
                                        <div class="date">
                                            @if ($email->created_at->toDateString() == Carbon\Carbon::today()->toDateString())
                                            {{  date('h:i A', strtotime($email->created_at->format('g:i A'))); }}
                                            @else
                                            {{date("F j ",strtotime($email->created_at )) }}
                                            @endif
                                        </div>
                                    </div>
                                </li>

                         @endforeach

                         @elseif(Route::currentRouteName() == 'employee.email.allSentEmail')
                            @foreach ($allEmailInfo['emailInfo'] as $email )
                            <li>
                                <div class="col-mail col-mail-1">
                                    <div class="checkbox-wrapper-mail">
                                        <input name="markedId[]" type="checkbox" id="{{ $email->id }}" multiple value="{{ $email->id }}">
                                        <label for="{{ $email->id }}" class="toggle"></label>
                                    </div>
                                    <a href="{{route('employee.email.showSpecificMail',$email->slug)}}" class="title">To :
                                        @if ($email->receiver)
                                                {{ $email->receiver->name  ==   Auth::guard('employee')->user()->name ? 'me' : $email->receiver->name }}
                                        @endif
                                        @if ($email->EmployeeReceiver)
                                        {{ $email->EmployeeReceiver->name  ==   Auth::guard('employee')->user()->name ? 'me' : $email->EmployeeReceiver->name }}
                                @endif
                                    </a>
                                </div>
                                <div class="col-mail col-mail-2">
                                    <a href="{{ route('employee.email.showSpecificMail',$email->slug)}}" class="subject">
                                        <span class="bg-{{ $email->status == 'unread' ? "danger":"success"}} badge me-2">{{ $email->status }}</span>
                                        <span class="teaser">
                                        {!! htmlspecialchars_decode(strip_tags($email->description))!!}
                                    </span>
                                    </a>
                                    <div class="date">
                                        @if ($email->created_at->toDateString() == Carbon\Carbon::today()->toDateString())
                                        {{  date('h:i A', strtotime($email->created_at->format('g:i A'))); }}
                                        @else
                                        {{date("F j ",strtotime($email->created_at )) }}
                                        @endif
                                    </div>
                                </div>
                            </li>
                            @endforeach
                         @elseif(Route::currentRouteName()=='employee.email.trash' )
                            @foreach ($allEmailInfo['emailInfo'] as $email )
                            <li>
                                <div class="col-mail col-mail-1">
                                    <div class="checkbox-wrapper-mail">
                                        <input name="markedId[]" type="checkbox" id="{{ $email->id }}" multiple value="{{ $email->id }}">
                                        <label for="{{ $email->id }}" class="toggle"></label>
                                    </div>
                                    <a style="pointer-events: none"  href="{{route('employee.email.showSpecificMail',$email->slug)}}" class="title">To :
                                        @if ($email->receiver)
                                                {{ $email->receiver->name  ==   Auth::guard('employee')->user()->name ? 'me' : $email->receiver->name }}
                                        @endif
                                        @if ($email->EmployeeReceiver)
                                        {{ $email->EmployeeReceiver->name  ==   Auth::guard('employee')->user()->name ? 'me' : $email->EmployeeReceiver->name }}
                                @endif
                                    </a>
                                </div>
                                <div class="col-mail col-mail-2">
                                    <a style="pointer-events: none" href="{{ route('employee.email.showSpecificMail',$email->slug)}}" class="subject">
                                        <span class="bg-{{ $email->status == 'unread' ? "danger":"success"}} badge me-2">{{ $email->status }}</span>
                                        <span class="teaser">
                                        {!! htmlspecialchars_decode(strip_tags($email->description))!!}
                                    </span>
                                    </a>
                                    <div class="date">
                                        @if ($email->created_at->toDateString() == Carbon\Carbon::today()->toDateString())
                                        {{  date('h:i A', strtotime($email->created_at->format('g:i A'))); }}
                                        @else
                                        {{date("F j ",strtotime($email->created_at )) }}
                                        @endif
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        @endif

                        </ul>
                        <input type="hidden" name="routeName" value="{{ Route::currentRouteName() }}">
                    </form>
                    </div> <!-- card -->

                </div> <!-- end Col-9 -->

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
                                <option value="{{ $employee->id}}">{{ $employee->email }}</option>
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
    $(function(){
        $(document).on('click','#email_button',function(e){
            const emailTo=$('#choices-single-default').val()
            if(emailTo == ''){
                Toast.fire({
                    icon: 'error',
                    title: 'Add at least one recipent'
                })
            }
            else{
                $('#email_send_form').submit()
            }
            e.preventDefault()
        })
    })

</script>
@if(Session::has('mark_delete_success'))
    <script>
        Toast.fire({
            icon: 'success',
            title: '{{ Session::get('mark_delete_success') }}'
        })

    </script>
@endif
@if($errors->any())
    <script>
        Toast.fire({
            icon: 'error',
            title: 'Something Went Wrong , please Try Again'
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
@if(Session::has('destory_success'))
    <script>
        Toast.fire({
            icon: 'success',
            title: '{{ Session::get('destory_success') }}'
        })

    </script>
@endif
@if(Session::has('mark_parmanent_delete_success'))
    <script>
        Toast.fire({
            icon: 'success',
            title: '{{ Session::get('mark_parmanent_delete_success') }}'
        })

    </script>
@endif
@if(Session::has('delete_success'))
    <script>
        Toast.fire({
            icon: 'success',
            title: '{{ Session::get('delete_success') }}'
        })

    </script>
@endif
@if(Session::has('mark_restore_success'))
    <script>
        Toast.fire({
            icon: 'success',
            title: '{{ Session::get('mark_restore_success') }}'
        })

    </script>
@endif
@if(Session::has('restore_success'))
    <script>
        Toast.fire({
            icon: 'success',
            title: ' {{ Session::get('restore_success') }}'
        })

    </script>
@endif
@if(Session::has('parmanent_delete_success'))
    <script>
        Toast.fire({
            icon: 'success',
            title: '{{ Session::get('parmanent_delete_success') }}'
        })

    </script>
@endif
@endsection
