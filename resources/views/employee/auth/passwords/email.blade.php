

@extends('layouts.employee.auth.employee_auth_app')
@section('employee_auth_page_title')
    Reset Password | BIR it
@endsection
@section('employee_auth_content')
<div class="auth-content my-auto">
    <div class="text-center">

        @if (Session::has('reset_link_send_success'))
            <div class="alert alert-success">
                {{ Session::get('reset_link_send_success') }}
            </div>
        @endif
    </div>
    <form class="mt-2 pt-2" action="{{ route('employee.resetpassword.post') }}" method="POST">
        @csrf
        <div class="form-group mb-4">
            <input type="email" class="form-control" id="input-username" name="email" placeholder="Enter Email">
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror


        </div>
        <div class="mb-3">
            <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Send Password Reset Link</button>
        </div>
    </form>

    <div class="mt-5 text-center">
        <p class="text-muted mb-0">Do Nothing? <a href="{{ route('employee.login') }}"
                class="text-primary fw-semibold"> Login</a> </p>
    </div>


</div>
@endsection
