
@section('admin_content')
@extends('layouts.admin.admin_app')
@section('invoice_active')
    mm-active
@endsection
@section('admin_page_title')
 Invoice | BIR it
@endsection
@section('invoice_index_active')
    active
@endsection


@section('admin_js_link')
     <script src="{{ asset('admin_assets') }}/js/printThis.js"></script>
@endsection
<section id="invoice-print" class="smt-50" style="margin-top:50px;">

    <div>

        <div
            style="width:796px; height:1120px; margin: 0 auto;text-transform:capitalize;color:#222; padding:20px;background: #fff;overflow: hidden;">
            <div class="print mt-3">
                <button id="print" class=" btn btn-success btn sm" style="margin-left: 50%; margin-top: 10px;">Print</button>

            </div>
            <div id="demo" style="width:756px; height:1080px;font-size:13px;">
                <div style="height:110px;">
                    <div style="width:606px;float:left;padding-top: 36px;">
                        <div
                            style="border-bottom:2px solid #f0674c;width:50px;float:left;padding-top:39px;margin-right:5px;">
                        </div>
                        <h1 style="text-transform:uppercase;letter-spacing: 12px;font-weight:600;">Invoice</h1>
                        <p style="margin-bottom:0;letter-spacing:2px">No. <span
                                style="font-weight: 700;font-size:15px;">{{$invoice->invoice_id}}</span> // <span>  {{ date("F j, Y",strtotime($invoice->created_at))}}</span>
                        </p>
                        <p style="margin-bottom:0;letter-spacing:2px">Bin No. <span
                                style="font-weight: 700;font-size:14px;">{{generalSettings()->bin_number}}</span>
                        </p>
                    </div>
                    <div style="width:150px;float:left;">
                        <div>
                            <img src="{{ asset('photo/settings/general') }}/{{ generalSettings()->favicon }}" alt="company logo"
                                style="height:100px; width:100px; border-radius:50% !important;  margin: 15px 25px;">
                        </div>
                    </div>
                </div>
                <div style="height:100px;margin-top:50px;">
                    <div style="width:368px;float:left;overflow:hidden;margin-right:10px;">
                        <h3 style="font-size: 18px;font-weight: 600;margin-bottom:5px;">Billing From:</h3>
                        <p style="margin-bottom:0;">{{generalSettings()->name}} | {{generalSettings()->phone}} </p>
                        <p style="margin-bottom:0;">{{generalSettings()->address}}</p>
                    </div>
                    <div style="width:368px;float:left;overflow:hidden;margin-left:10px;">
                        <h3 style="font-size: 18px;font-weight: 600;margin-bottom:5px;">Billing To:</h3>
                        <p style="margin-bottom:0;">{{$invoice->user->name}} | {{$invoice->user->phone}}</p>
                        <p style="margin-bottom:0;">{{$invoice->user->address}}</p>
                    </div>
                </div>
                <div style="height:25px;">
                    <div style="width:368px;float:left;">
                        <p style="font-size:17px;float:left;margin-right:5px;margin-bottom:5px">Grand Total:
                            <b>{{$invoice->grand_total}}</b>/-</p>
                    </div>
                    <div style="width:368px;float:left;">
                        <p style="font-size:17px;float:right;margin-right:5px;margin-bottom:5px;">Total Due:
                            <b>{{$invoice->total_due}}</b>/-</p>
                    </div>
                </div>
                <div style="position: relative;">
                    <table
                        style="border-top: 2px solid #999;text-align:center;border-bottom: 2px solid #999;border-collapse: collapse;width: 100%;margin-bottom: 1rem;">
                        <thead>
                            <tr style="text-transform:uppercase;font-weight: bold;border-bottom: 2px solid #999;">
                                <td style="padding: 0.75rem;vertical-align: top;border-top: 1px solid #dee2e6;">SN</td>
                                <td
                                    style="padding: 0.75rem;vertical-align: top;border-top: 1px solid #dee2e6;text-align:left;">
                                    Product Information</td>
                                <td style="padding: 0.75rem;vertical-align: top;border-top: 1px solid #dee2e6;">Quantity
                                </td>

                                <td style="padding: 0.75rem;vertical-align: top;border-top: 1px solid #dee2e6;">price
                                </td>

                                <td style="padding: 0.75rem;vertical-align: top;border-top: 1px solid #dee2e6;">total
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoice->invoiceInfo as $invoices )

                            <tr style="text-transform:capitalize;">
                                <td style="padding: 0.75rem;vertical-align: top;border-top: 1px solid #dee2e6;">0{{$loop->iteration}}</td>
                                <td
                                    style="padding: 0.75rem;vertical-align: top;border-top: 1px solid #dee2e6;text-align:left;">
                                    {{$invoices->product_name}}</td>
                                <td style="padding: 0.75rem;vertical-align: top;border-top: 1px solid #dee2e6;">{{$invoices->quantity}}</td>

                                <td style="padding: 0.75rem;vertical-align: top;border-top: 1px solid #dee2e6;">{{$invoices->price}}
                                </td>
                                <td style="padding: 0.75rem;vertical-align: top;border-top: 1px solid #dee2e6;">{{$invoices->total}} &#2547;
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    @if($invoice->total_due>0)
                    <img src="{{asset('admin_assets/images/invoice/payment/due.png')}}" alt="due.png"
                        style="position: absolute;top: 30%;opacity:0.5;left: 40%;height: 100px;width: 100px; tra">
                    @else
                    <img src="{{asset('admin_assets/images/invoice/payment/paid.png')}}" alt="paid.png"
                        style="position: absolute;top: 30%;opacity:0.5;left: 40%;height: 100px;width: 100px;">
                    @endif
                </div>
                <div style="height:100px;">
                    <div style="width: 545px;float:left;padding-top:35px;">
                        <p style="margin-bottom:0;font-size:12px;padding-right:0px;"><b>Notes: </b>{{$invoice->note}}</p>
                        <p style="margin-top:10px; margin-bottom:0;font-size:12px;padding-right:0px;"><b>Due Date: </b>{{$invoice->due_date}}</p>
                    </div>

                    <div style="width:200px;float:left;">
                        <table style="border-collapse: collapse;width: 100%;margin-bottom: 1rem;">
                            <tbody>
                                <tr>
                                    <th style="padding:3px 10px;">Subtotal</th>
                                    <td style="text-align:center;padding-right:20px;">{{$invoice->sub_total}} &#2547; </td>
                                </tr>

                                <tr>
                                    <th style="padding:3px 10px;">Discount (-)</th>
                                    <td style="text-align:center;padding-right:20px;">{{$invoice->discount  ? $invoice->discount :0}} @if ($invoice->discount_type == '%')
                                        {{$invoice->discount_type}}
                                        @else
                                        &#2547;
                                        @endif </td>
                                </tr>
                                <tr>
                                    <th style="padding:3px 10px;">Tax (+)</th>
                                    <td style="text-align:center;padding-right:20px;">{{$invoice->tax  ?$invoice->tax :0}} % </td>
                                </tr>
                                <tr style="border-top: 1px solid #999;color:#da291c;font-weight:bold;">
                                    <th style="padding:3px 10px;">Grand Total</th>
                                    <td style="text-align:center;padding-right:20px;">{{$invoice->grand_total}}&#2547;</td>
                                </tr>
                                <tr>
                                    <th style="padding:3px 10px;">Amount Paid</th>
                                    <td style="text-align:center;padding-right:20px;">{{$invoice->amount_paid?$invoice->amount_paid:0}}&#2547;</td>
                                </tr>
                                <tr>
                                    <th style="padding:3px 10px;">Total Due</th>
                                    <td style="text-align:center;padding-right:20px;">{{$invoice->total_due ? $invoice->total_due :0}} &#2547;</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('admin_js')

    <script>
     $(document).ready(function() {
        $(document).on('click','#print',function(e){
            $("#demo").printThis({
                pageTitle: "",
                header: null,
                footer: null,
            });

        e.preventDefault()
        })

     })
    </script>
    @endsection
