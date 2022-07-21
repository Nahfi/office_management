@extends('layouts.admin.admin_app')
@section('leave_active')
    mm-active
@endsection
@section('employee_leave_active')
    active
@endsection
@section('admin_page_title')
    Update Employee Leave | BIR it
@endsection
@section('admin_content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Update Employee Leave Info</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.employeeLeave.index') }}">All Employee Leave</a></li>
                            <li class="breadcrumb-item active">Update Emmployee Leave Info</li>
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
                          <form action="{{ route('admin.employeeLeave.update',$employee_leave->id) }}" method="POST">
                              @csrf
                              <div class="row">
                                  
                                 
                                  <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-4">
                                    <div class="form-group">
                                        <label for="month">Select Employee <span class="text-danger">*</span></label>
                                        <select name="employee_id" class="form-select @error('employee_id') is-invalid @enderror">
                                            <option value="">select employee</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}" {{ ($employee->id == $employee_leave->employee_id? "selected":"") }}>{{ $employee->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('employee_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                  </div>
                                  <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-4">
                                    <div class="form-group">
                                        <label for="month">Year <span class="text-danger">*</span></label>
                                        <select name="year" class="form-select @error('year') is-invalid @enderror" id="">
                                            <option value="">select year</option>
                                            <option value="2020" @if ($employee_leave->year == '2020')
                                                {{ 'selected' }}
                                            @endif>2020</option>
                                            <option value="2021" @if ($employee_leave->year == '2021')
                                                {{ 'selected' }}
                                            @endif>2021</option>
                                            <option value="2022" @if ($employee_leave->year == '2022')
                                                {{ 'selected' }}
                                            @endif>2022</option>
                                            <option value="2023" @if ($employee_leave->year == '2023')
                                                {{ 'selected' }}
                                            @endif>2023</option>
                                            <option value="2024" @if ($employee_leave->year == '2024')
                                                {{ 'selected' }}
                                            @endif>2024</option>
                                            <option value="2025" @if ($employee_leave->year == '2025')
                                                {{ 'selected' }}
                                            @endif>2025</option>
                                            <option value="2026" @if ($employee_leave->year == '2026')
                                                {{ 'selected' }}
                                            @endif>2026</option>
                                            <option value="2027" @if ($employee_leave->year == '2027')
                                                {{ 'selected' }}
                                            @endif>2027</option>
                                            <option value="2028" @if ($employee_leave->year == '2028')
                                                {{ 'selected' }}
                                            @endif>2028</option>
                                            <option value="2029" @if ($employee_leave->year == '2029')
                                                {{ 'selected' }}
                                            @endif>2029</option>
                                            <option value="2030" @if ($employee_leave->year == '2030')
                                                {{ 'selected' }}
                                            @endif>2030</option>
                                            <option value="2031" @if ($employee_leave->year == '2031')
                                                {{ 'selected' }}
                                            @endif>2031</option>
                                        </select>
                                        @error('year')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                  </div>
                                  <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-4">
                                    <div class="form-group">
                                        <label for="month">Total Yearly Leave <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('total_yearly_leave') is-invalid @enderror" name="total_yearly_leave" id="month" value="{{ $employee_leave->total_yearly_leave }}">
                                        @error('total_yearly_leave')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                  </div>
                              </div>
                            <button type="submit" class="btn btn-sm btn-primary mt-4">Submit</button> 
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
    @if (Session::has('employee_leave_update_success'))
        <script>
            Toast.fire({
                icon: 'success',
                title: "{{ Session::get('employee_leave_update_success') }}"
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