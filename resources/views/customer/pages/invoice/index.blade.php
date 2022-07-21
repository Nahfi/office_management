
@extends('layouts.customer.customer_app')
@section('user_page_title')
Customer Invoice
@endsection
@section('invoice_active')
    mm-active
@endsection
@section('customer_css_link')
     <!-- DataTables -->
  <link href="{{ asset('admin_assets') }}/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
  <link href="{{ asset('admin_assets') }}/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
  <!-- Responsive datatable examples -->
  <link href="{{ asset('admin_assets') }}/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('customer_js_link')
    <!-- Required datatable js -->
 <script src="{{ asset('admin_assets') }}/libs/datatables.net/js/jquery.dataTables.min.js"></script>
 <script src="{{ asset('admin_assets') }}/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
 <!-- Buttons examples -->
 <script src="{{ asset('admin_assets') }}/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
 <script src="{{ asset('admin_assets') }}/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
 <script src="{{ asset('admin_assets') }}/libs/jszip/jszip.min.js"></script>
 <script src="{{ asset('admin_assets') }}/libs/pdfmake/build/pdfmake.min.js"></script>
 <script src="{{ asset('admin_assets') }}/libs/pdfmake/build/vfs_fonts.js"></script>
 <script src="{{ asset('admin_assets') }}/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
 <script src="{{ asset('admin_assets') }}/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
 <script src="{{ asset('admin_assets') }}/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
 <!-- Responsive examples -->
 <script src="{{ asset('admin_assets') }}/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
 <script src="{{ asset('admin_assets') }}/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
 <!-- Datatable init js -->
 <script src="{{ asset('admin_assets') }}/js/pages/datatables.init.js"></script>
@endsection
@section('customer_content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">All Invoice</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('customer.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All Invoice</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <h5 class="card-title me-4" style="float:left;margin-top:5px">Total Invoice <span class="text-muted fw-normal ms-2">({{$allInvoice->count()}})</span></h5>
                                    </div>
                                </div>

                            </div>
                            <div style="height: calc(100vh - 270px);">

                                <table id="datatable-buttons" class="table table-bordered dt-responsive  nowrap w-100" style="height: 10px;">
                                    <thead>
                                    <tr>

                                        <th>S\N</th>
                                        <th>Customer name</th>
                                        <th>Subtotal</th>
                                        <th>Discount</th>
                                        <th>Tax</th>
                                        <th>Grand Total</th>
                                        <th>Paid</th>
                                        <th>Due</th>
                                        <th>Action </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allInvoice as $invoice )
                                    <tr>

                                        <th>{{$invoice->invoice_id }}</th>
                                        <th>{{ $invoice->user->name  }}</th>
                                        <th>{{ $invoice->sub_total }}</th>
                                        <th>{{ $invoice->discount ?  $invoice->discount  :0  }} {{ $invoice->discount_type == '%' ?'%':'tk'}} </th>
                                        <th>{{ $invoice->tax ?$invoice->tax :0}}%</th>
                                        <th>{{ $invoice->grand_total  }}</th>
                                        <th>{{ $invoice->amount_paid ? $invoice->amount_paid :0  }}</th>
                                        <th>{{ $invoice->total_due  }}</th>

                                        <th>
                                            <a class="btn btn-sm btn-primary" href="{{ route('customer.invoice.invoiceShowPos',$invoice->id) }}">Prtint Pos<i  class="ms-1 fas fa-download"></i></a>
                                            <a class="btn btn-sm btn-primary" href="{{ route('customer.invoice.invoice-show',$invoice->id) }}">Prtint A4 <i  class="ms-1 fas fa-download"></i></a>
                                        </th>
                                    </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                                <!-- end table -->
                            <!-- end table responsive -->
                        </div>

                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->
</div>

@endsection
