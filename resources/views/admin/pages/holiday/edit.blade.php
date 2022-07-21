@extends('layouts.admin.admin_app')
@section('holiday_active')
    mm-active
@endsection
@section('admin_page_title')
    Edit Holidays | BIR it
@endsection
@section('admin_content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Add Holiday</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.holiday.index') }}">All HoliDay</a></li>
                            <li class="breadcrumb-item active">Add Holiday</li>
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
                          <form action="{{ route('admin.holiday.update',$holiday->id) }}" method="POST">
                              @csrf
                              <div class="row">
                                  <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-4">

                                    <div class="form-group">
                                        <label for="month">Year <span class="text-danger">*</span></label>
                                        <select name="year" class="form-select @error('year') is-invalid @enderror" id="">
                                            <option value="">select year</option>
                                            <option value="2020" @if ($holiday->year == '2020')
                                                {{ 'selected' }}
                                            @endif>2020</option>
                                            <option value="2021" @if ($holiday->year == '2021')
                                                {{ 'selected' }}
                                            @endif>2021</option>
                                            <option value="2022" @if ($holiday->year == '2022')
                                                {{ 'selected' }}
                                            @endif>2022</option>
                                            <option value="2023" @if ($holiday->year == '2023')
                                                {{ 'selected' }}
                                            @endif>2023</option>
                                            <option value="2024" @if ($holiday->year == '2024')
                                                {{ 'selected' }}
                                            @endif>2024</option>
                                            <option value="2025" @if ($holiday->year == '2025')
                                                {{ 'selected' }}
                                            @endif>2025</option>
                                            <option value="2026" @if ($holiday->year == '2026')
                                                {{ 'selected' }}
                                            @endif>2026</option>
                                            <option value="2027" @if ($holiday->year == '2027')
                                                {{ 'selected' }}
                                            @endif>2027</option>
                                            <option value="2028" @if ($holiday->year == '2028')
                                                {{ 'selected' }}
                                            @endif>2028</option>
                                            <option value="2029" @if ($holiday->year == '2029')
                                                {{ 'selected' }}
                                            @endif>2029</option>
                                            <option value="2030" @if ($holiday->year == '2030')
                                                {{ 'selected' }}
                                            @endif>2030</option>
                                            <option value="2031" @if ($holiday->year == '2031')
                                                {{ 'selected' }}
                                            @endif>2031</option>
                                        </select>
                                        {{-- <input type="date" class="form-control @error('month') is-invalid @enderror" name="month" id="month" value="{{ old('month') }}"> --}}
                                        @error('year')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="month">Month <span class="text-danger">*</span></label>
                                        <select name="month" class="form-select @error('month') is-invalid @enderror" id="">
                                            <option value="">select month</option>
                                            <option value="01" @if ( $holiday->month == '01')
                                                {{ 'selected' }}
                                            @endif>January</option>
                                            <option value="02" @if ( $holiday->month == '02')
                                                {{ 'selected' }}
                                            @endif>February</option>
                                            <option value="03" @if ( $holiday->month == '03')
                                                {{ 'selected' }}
                                            @endif>March</option>
                                            <option value="04" @if ( $holiday->month == '04')
                                                {{ 'selected' }}
                                            @endif>April</option>
                                            <option value="05" @if ( $holiday->month == '05')
                                                {{ 'selected' }}
                                            @endif>May</option>
                                            <option value="06" @if ( $holiday->month == '06')
                                                {{ 'selected' }}
                                            @endif>June</option>
                                            <option value="07" @if ( $holiday->month == '07')
                                                {{ 'selected' }}
                                            @endif>July</option>
                                            <option value="08" @if ($holiday->month == '08')
                                                {{ 'selected' }}
                                            @endif>August</option>
                                            <option value="09" @if ( $holiday->month == '09')
                                                {{ 'selected' }}
                                            @endif>September</option>
                                            <option value="10" @if ( $holiday->month == '10')
                                                {{ 'selected' }}
                                            @endif>October</option>
                                            <option value="11" @if ( $holiday->month == '11')
                                                {{ 'selected' }}
                                            @endif>November</option>
                                            <option value="12" @if ( $holiday->month == '12')
                                                {{ 'selected' }}
                                            @endif>December</option>
                                        </select>
                                        {{-- <input type="date" class="form-control @error('month') is-invalid @enderror" name="month" id="month" value="{{ $holiday->month }}"> --}}
                                        @error('month')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                  </div>
                              </div>
                            <button type="submit" class="btn btn-sm btn-primary mt-4">Update</button> 
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
    @if (Session::has('holiday_update_success'))
        <script>
            Toast.fire({
                icon: 'success',
                title: "{{ Session::get('holiday_update_success') }}"
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