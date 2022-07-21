@extends('layouts.admin.admin_app')
@section('admin_page_title')
    Update Invoice | BIR it
@endsection
@section('invoice_active')
    mm-active
@endsection
@section('invoice_index_active')
    active
@endsection
@section('admin_css_link')

    <style>
        .area {
        text-align: start !important;
        }
        .area {
            text-align: start !important;
            font-size: .8125rem;
            font-weight: 400;
            padding-top: 8px !important;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            border: 1px solid #ced4da;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: .25rem;
            -webkit-transition: border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
       }
       .area:focus{
           outline: none !important;
       }

    </style>


    <!-- choices css -->
<link href="{{ asset('admin_assets') }}/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('admin_js_link')
  <!-- editable table js -->
  <script src="{{ asset('admin_assets') }}/libs/table-edits/build/table-edits.min.js"></script>
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
                    <h4 class="mb-sm-0 font-size-18">Update Invoice Info</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.invoice.index') }}">All Invoice</a></li>
                            <li class="breadcrumb-item active">Update Invoice</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12 col-md-6 col-sm-12 col-12 m-auto">
                <div class="card">
                    <div class="card-body">
                         <div class="row align-items-center">
                            <div class="table-responsive">
                                <table class="table table-editable table-nowrap align-middle table-edits">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Product Name</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if ($invoice)
                                    @foreach ($invoice->invoiceInfo as $invoices)
                                    <form action="{{route('admin.invoice.updateInvoiceInfo',$invoices->id)}}" method="post">
                                        @csrf
                                        <tr data-id="1">
                                            <td data-field="id" style="width: 80px">{{$loop->iteration}}</td>
                                            <td>{{$invoices->product_name}}</td>
                                            <td >
                                                <input type="text" class="form-control"   name="price" value="
                                                {{$invoices->price}}">
                                            </td>

                                            <td>
                                                <input type="text" class="form-control"   name="quantity" value="
                                                {{$invoices->quantity}}">
                                            </td>

                                            <td style="width: 100px">
                                                <button type="submit" name="delete" value="delete" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt" ></i></button>
                                                <button type="submit" name="save" value="save" class="btn btn-sm btn-primary"><i class="fas fa-save" ></i></button>
                                            </td>
                                        </tr>
                                    </form>
                                        @endforeach
                                        @endif
                                    </tbody>
                                    </table>
                            </div>
                         </div>
                         <!-- end row -->
                         <!-- end table responsive -->
                @if($invoice)
                    <form action="{{route('admin.invoice.update',$invoice->id)}}" method="post">
                        @csrf
                         <div class="row mt-4">

                            <div class="row">
                                <div class="col-6 col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="salary">Discount Type  <span class="text-danger">*</span></label>
                                                <br>
                                                <select name="type" id="status" class=" text-center form-select  @error('type') is-invalid @enderror">
                                                    <option value="">select type</option>
                                                    <option  value="%" {{ ($invoice->discount_type == '%' ? "selected":"") }}>(%)</option>
                                                    <option  value="flat" {{ ($invoice->discount_type == 'flat' ? "selected":"") }}>(&#2547;)</option>
                                                </select>
                                                @error('type')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                           </div>
                                        </div>
                                        <div class="col-4 col-lg-4 mt-1">
                                            <div class="form-group">
                                                 <label for="salary">Discount </label>
                                                 <br>
                                                 <input class="form-control @error('discount') is-invalid @enderror " type="text" value="{{$invoice->discount? $invoice->discount:0}}" name="discount" id="">
                                                 @error('discount')
                                                 <span class="text-danger">{{ $message }}</span>
                                                 @enderror
                                            </div>
                                            <button type="submit"  class="mt-3 btn btn-sm btn-primary mt-2">Update</button>

                                        </div>
                                        <div class="col-4 col-lg-4 mt-1">
                                            <div class="form-group">
                                                 <label for="salary">Tax (%) </label>
                                                 <br>
                                                 <input class="form-control @error('tax') is-invalid @enderror " type="text" value="{{$invoice->tax ? $invoice->tax:0}}" name="tax" id="">
                                                 @error('tax')
                                                 <span class="text-danger">{{ $message }}</span>
                                                 @enderror
                                            </div>

                                        </div>
                                        <div class="col-4 col-lg-4 mt-1">
                                            <div class="form-group">
                                                 <label for="salary">Paid </label>
                                                 <br>
                                                 <input class="form-control @error('paid') is-invalid @enderror " type="text" value="{{$invoice->amount_paid ? $invoice->amount_paid :0}}" name="paid" id="">
                                                 @error('paid')
                                                 <span class="text-danger">{{ $message }}</span>
                                                 @enderror
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div class="col-6 col-lg-6">
                                    <div class="form-group">
                                            <label for="salary">Comment </label>
                                            <br>
                                            <textarea  style=" width:100%; text-align:start!important;" cols="30" rows="5" class="area text-start  @error('Comment') is-invalid @enderror" name="Comment" id="Comment" name="note" value=""  >
                                                {{$invoice?$invoice->comments:''}}
                                            </textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
            @endif
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->
</div>
@section('admin_js')
    @if (Session::has('Information_updated'))
    <script>
            Toast.fire({
                icon: 'success',
                title: '{{  Session::get('Information_updated') }}'
            })
    </script>
    @endif
    @if (Session::has('service_information_updated'))
    <script>
            Toast.fire({
                icon: 'success',
                title: '{{  Session::get('service_information_updated') }}'
            })
    </script>
    @endif
    @if (Session::has('service_deleted'))
    <script>
            Toast.fire({
                icon: 'success',
                title: ' {{  Session::get('service_deleted')}}'
            })
    </script>
    @endif
    @if (Session::has('%_Discount_can_not_be_greater_than_100'))
    <script>
            Toast.fire({
                icon: 'error',
                title: '{{  Session::get('%_Discount_can_not_be_greater_than_100') }}'
            })
    </script>
    @endif
    @if (Session::has('flat_Discount_can_not_be_greater_than_total_amount'))
    <script>
            Toast.fire({
                icon: 'error',
                title: '{{ Session::get('flat_Discount_can_not_be_greater_than_total_amount') }}'
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
