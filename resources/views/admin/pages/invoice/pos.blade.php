@extends('layouts.admin.admin_app')
@section('admin_page_title')
    Pos Invoice | BIR it
@endsection
@section('invoice_active')
mm-active
@endsection
@section('invoice_index_active')
active
@endsection


@section('admin_js_link')
<script src="{{ asset('admin_assets') }}/js/printThis.js"></script>

@endsection
@section('admin_content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Pos Invoice</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"> Invoice</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <section id="invoice-print">
                <div style="font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; width:219px; min-height:377px; margin: 0 auto;text-transform:capitalize;color:#222; padding:10px;background: #fff;overflow: hidden;border: 1px dotted #999;">
                    <div style="min-height:357px;font-size:9px;background: #fff;margin: 0 auto;">
                        <div class="store-info">
                            <div style="display: flex;">
                                <div style="width: 100%; text-align: center;
                                            margin-bottom: 5px;">
                                    <img src="{{ asset('photo/settings/general') }}/{{ generalSettings()->favicon }}" alt="logo" style="width: 40%;">
                                    <p style="margin-bottom: 0;margin-top: 0px; font-size: 8px;padding: 0px 10%;">{{ generalSettings()->address }}</p>
                                    <p style="margin-bottom: 0;margin-top: 5px;font-size: 8px;">Bin No: {{ generalSettings()->bin_number }}</p>
                                    @if ($invoice->due_date)
                                    <p style="margin-bottom: 0;margin-top: 5px;font-size: 8px;">Due Date: {{ date("F j, Y",strtotime($invoice->due_date))}} </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="invoice-info">
                            <div>
                                <div style="width: 100%; text-align: center;">
                                    <p
                                        style="margin-bottom: 5px;margin-top: 5px;border: 1px dashed #999;display: inline-block;font-weight: 500;padding: 2px;">
                                        Invoice No: {{ $invoice->invoice_id }}</p>
                                </div>
                                <div style="width: 100%;">
                                    <div style="display: flex;">
                                        <div style="width: 50%;">
                                            <p style="margin-bottom: 0;margin-top: 5px;">Customer: {{$invoice->user->name}}</p>
                                        </div>
                                        <div style="width: 50%;">
                                            <p style="margin-bottom: 0;margin-top: 5px;">Phone:  {{$invoice->user->phone}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div style="width: 100%;">
                                    <div style="display: flex;margin-bottom: 5px;">
                                        <div style="width: 50%;">
                                            <p style="margin-bottom: 0;margin-top: 5px;">Seller: {{Auth::guard('admin')->user()->name}}</p>
                                        </div>
                                        <div style="width: 50%;">
                                            <p style="margin-bottom: 0;margin-top: 5px;">Date: {{ date("F j, Y",strtotime($invoice->created_at))}} </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-info">
                            <table style="width: 100%;border-bottom: 1px dashed #999;">
                                <thead>
                                    <tr>
                                        <th style="text-align: start ; border-top: 1px dashed #999;border-bottom: 1px dashed #999;">
                                            #</th>
                                        <th
                                            style="max-width: 110px;text-align: center ; border-top: 1px dashed #999;border-bottom: 1px dashed #999;">
                                            product</th>

                                        <th style="text-align: center;border-top: 1px dashed #999;border-bottom: 1px dashed #999;">
                                            price</th>
                                        <th style="text-align: center;border-top: 1px dashed #999;border-bottom: 1px dashed #999;">
                                            price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 @foreach ($invoice->invoiceInfo as $invoices )
                                 <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td style="max-width: 110px;text-align: center;">{{$invoices->product_name}}</td>
                                    <td style="text-align: center;">{{$invoices->price}}</td>
                                    <td style="text-align: center;">{{$invoices->total}}<span>&#2547;</span></td>
                                </tr>
                                 @endforeach


                                </tbody>
                            </table>
                            <table style="text-align: end;margin-left: auto">
                                <tbody>
                                    <tr>
                                        <td>Sub Total</td>
                                        <td>:</td>
                                        <td>{{$invoice->sub_total}}<span>&#2547;</span></td>
                                    </tr>
                                    <tr>
                                        <td>Discount(-)</td>
                                        <td>:</td>
                                        <td>{{$invoice->discount ? $invoice->discount :0}} @if ($invoice->discount_type == '%')
                                            <span>&#37;</span>
                                            @else
                                            <span>&#2547;</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border-bottom: 0.5px dashed #999;">Tax(+)</td>
                                        <td style="border-bottom: 0.5px dashed #999;">:</td>
                                        <td style="border-bottom: 0.5px dashed #999;">{{$invoice->tax ? $invoice->tax :0}}<span>&#37;</span></td>
                                    </tr>
                                    <tr>
                                        <th>Grand Total</th>
                                        <td>:</td>
                                        <th>{{$invoice->grand_total}}<span>&#2547;</span></th>
                                    </tr>
                                    <tr>
                                        <td>Amount Paid</td>
                                        <td>:</td>
                                        <td>{{$invoice->amount_paid ? $invoice->amount_paid:0}}<span>&#2547;</span></td>
                                    </tr>
                                    <tr>
                                        <td>Amount Due</td>
                                        <td>:</td>
                                        <td>{{$invoice->total_due}}<span>&#2547;</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="pos-footer" style="border-top: 0.5px dashed #999;margin-top: 10px;">
                            <h1 style="text-align: center; font-size: 11px;padding-top:8px;margin-bottom: 0;">Thanks For Visiting Us</h1>
                        </div>
                    </div>
                </div>
            </section>

            <center style="margin-bottom:34px !important; margin-top:14px!important;">
                <div class="row no-print">
                    <div class="col-md-12">
                        <div class="col-md-2 col-md-offset-5 col-xs-4 col-xs-offset-4 form-group">
                            <button type="button" id="print" title="Print" class="btn btn-block btn-success btn-xs">Print</button>
                        </div>
                    </div>
                </div>
            </center>
        </div>
    </div> <!-- container-fluid -->
</div>

@endsection
@section('admin_js')
<script>



$(document).ready(function() {

$(document).on('click','#print',function(e){
    // $('#print').hide();
    $("#invoice-print").printThis({
        pageTitle: "",
        header: null,
        footer: null,
    });

e.preventDefault()
})

})
</script>

@endsection
