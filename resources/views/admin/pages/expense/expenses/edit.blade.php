@extends('layouts.admin.admin_app')
@section('admin_page_title')
 Update   Expenses  | BIR it
@endsection
@section('expense_active')
    mm-active
@endsection
@section('expense_expenses_active')
    active
@endsection
@section('expense_active')
    mm-active
@endsection
@section('expense_category_active')
    active
@endsection
@section('admin_css_link')
    <!-- choices css -->
<link href="{{ asset('admin_assets') }}/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('admin_js_link')
     <!-- choices js -->
  <script src="{{ asset('admin_assets') }}/libs/choices.js/public/assets/scripts/choices.min.js"></script>
  <!-- init js -->
  <script src="{{ asset('admin_assets') }}/js/pages/form-advanced.init.js"></script>
@endsection
@section('admin_content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Update Expense</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.expense.index') }}">All Expenses</a></li>
                            <li class="breadcrumb-item active">Update Expense</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-6-12 col-md-6 col-sm-12 col-12 m-auto">
                <div class="card">
                    <div class="card-body">
                         <div class="row align-items-center">
                          <form action="{{ route('admin.expense.update',$expense->id) }}" method="POST">
                              @csrf
                              <div class="row">
                                  <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Category Name <span class="text-danger">*</span></label>
                                        <select class="form-control @error('category_id') is-invalid @enderror mb-2" name="category_id" data-trigger
                                            id="choices-single-default">
                                            <option value="">select category </option>
                                            @foreach ($categories as $category )
                                                <option {{ ($expense->category_id == $category->id ? "selected":"") }} value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                  </div>
                                  <div class="col-12 mt-2">
                                    <div class="form-group">
                                        <label for="name">Expense Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ $expense->name }}">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                  </div>
                                  <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Amount <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('amount') is-invalid @enderror" name="amount"  value="{{ $expense->amount }}">
                                        @error('amount')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                  </div>
                                  <div class="col-12 mt-4">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-select  @error('name') is-invalid @enderror"">
                                            <option value="">select status</option>
                                            <option  value="Active" {{ ($expense->status == 'Active' ? "selected":"") }}>Active</option>
                                            <option  value="DeActive" {{ ($expense->status == 'Deactive' ? "selected":"") }}>Deactive</option>
                                        </select>
                                        @error('status')
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
    @if (Session::has('expense_update_success'))
    <script>
            Toast.fire({
                icon: 'success',
                title: 'Expense Update Successfully'
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
