@extends('layouts.admin.admin_app')
@section('admin_page_title')
    Create Invoice | BIR it
@endsection
@section('invoice_active')
mm-active
@endsection
@section('invoice_invoices_active')
active
@endsection
@section('admin_css_link')

<style>

    .btn-group-sm>.btn, .btn-sm {
        padding: .22rem .5rem !important;

    }
    .margin {
        margin-bottom: 1.5px !important;
    }

    .t-align {
        text-align: start !important;
    }

    .btn-group-sm>.btn,
    .btn-sm {
        text-align: center !important padding: 0.15rem .4rem !important;
        font-size: .61094rem !important;
        border-radius: .1.2rem !important;
    }

    .form-control {
        text-align: center;
        width: 100% !important;
        height: auto !important;
        color: rgb(63, 62, 62) !important;
        border-radius: 5px !important;
        padding: 0px 5px !important;
        margin-bottom: 0px !important;
        -webkit-box-shadow: none;
        box-shadow: none;
        -webkit-transition: 0.5s;
        transition: 0.5s;
    }

    .form-control {
        width: 100%;
        height: auto;
        color: rgb(63, 62, 62);
        border-radius: 5px;
        padding: 0px 5px;
        margin-bottom: 0px;
        -webkit-box-shadow: none;
        box-shadow: none;
        -webkit-transition: 0.5s;
        transition: 0.5s;
    }

    .pd {
        padding: 7px 5px !important;
    }

    textarea {
        display: block;
        width: 100%;
        padding: .47rem .75rem;
        font-size: .8125rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
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

    textarea:focus {
        outline: none !important;
    }

    .bg-green {
        background-color: #01c273 !important;
    }

    .btn-green {
        padding: 5px 5px !important;
        border-radius: 10px !important;
        background-color: #01c273 !important;
        text-transform: uppercase !important;
    }

</style>
<link href="{{ asset('admin_assets') }}/libs/choices.js/public/assets/styles/choices.min.css"
    rel="stylesheet" type="text/css" />

@endsection
@section('admin_js_link')

<!-- choices js -->
<script src="{{ asset('admin_assets') }}/libs/choices.js/public/assets/scripts/choices.min.js">
</script>
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
                    <h4 class="mb-sm-0 font-size-18">Invoice</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('admin.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Invoice</li>

                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="row mt-4">
                                <div class="col-6 col-lg-6 col-md-6 col-sm-6 pr-md-0 ">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                            <div class="form-group">
                                                <h5>
                                                    Billing From
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-7 col-md-7 col-sm-7 col-lg-7 pr-lg-0">
                                                <div class="form-group">
                                                    <input type="text" placeholder="Name"
                                                        value="{{ GeneralSettings()->name }}"
                                                        class="t-align form-control pd ">
                                                </div>
                                            </div>
                                            <div class="col-lg-5 col-5 col-md-5 col-sm-5">
                                                <div class="form-group">
                                                    <input type="text" placeholder="Phone"
                                                        value="{{ GeneralSettings()->phone }}"
                                                        class="t-align form-control pd ">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row ">
                                            <div class="col-lg-12 col-12 col-sm-12 col-md-12 ">
                                                <div class="form-group mt-3">
                                                    <textarea name="" id="">{{ GeneralSettings()->address }}</textarea>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-6 col-sm-6 col-md-6 pl-md-0">
                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <h5>
                                                    Billing To
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-7 col-md-7 col-sm-7 col-lg-7 pr-lg-0">
                                                <select id="customer_name" class="t-align form-control select2"
                                                    data-trigger id="choices-single-default">
                                                    <option value=""> Customer</option>
                                                    @foreach ($customers as  $customer)
                                                    <option value="{{$customer->id}}"> {{ $customer->name}}</option>

                                                    @endforeach

                                                </select>
                                            </div>
                                            <div class="col-lg-5 col-5 col-md-5 col-sm-5">
                                                <div class="form-group">
                                                    <input id="phone_number" type="text" placeholder="Phone"
                                                        class="t-align form-control pd ">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 col-12 col-sm-12 col-md-12 ">
                                                <div class="col-lg-12 col-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <textarea id="billing_address" name="address"
                                                            placeholder="Address" cols="30"
                                                            class="t-align form-control pd mt-3">
                                                                    </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="row">
                                    <div class="col-lg-4 col-4 col-md-4 col-sm-4 ">
                                        <div class="form-group">
                                            <input disabled type="text" value="Product"
                                                class=" text-white form-control  bg-green border-0 p-1">
                                        </div>
                                    </div>
                                    <div class="col-lg-1 pr-lg-1 col-1 col-md-1 col-sm-1">
                                        <div class="form-group">
                                            <input disabled type="text" value="Qty"
                                                class=" text-white form-control  bg-green border-0 p-1">
                                        </div>
                                    </div>

                                    <div class="col-lg-2 pr-lg-1 col-2 col-md-2 col-sm-2 ">
                                        <input disabled type="text" value="price"
                                            class=" text-white form-control  bg-green border-0 p-1">
                                    </div>
                                    <div class="col-lg-4 pr-lg-1 col-4 col-md-4 col-sm-4 ">
                                        <div class="form-group">
                                            <input disabled type="text"
                                                class="text-white form-control  bg-green border-0 p-1" value="Total">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="row mt-3">
                            <div class="col-lg-12">
                            <form style="padding: 0 !important; margin:0 !important;"  id="form_submit" action="{{ route('admin.invoice.store') }}" method="post">
                                @csrf
                                <div class="row " id="body_data">
                                    <div  class="row mb-2">
                                        <div class="col-4 col-md-4 col-sm-4 col-lg-4 pr-lg-1">
                                            <div class="form-group ">
                                                <input type="text" name="product_name[]" id="product_name"
                                                multiple
                                                placeholder="product name"
                                                    class="form-control product_name">
                                            </div>
                                        </div>
                                        <div class=" col-1 col-lg-1 col-md-1 col-sm-1 pr-1 pl-1 col-lg-1 pr-lg-1 pl-lg-1">
                                            <div class="form-group text-center justify-content-center">
                                                <input id="quantity0"  total_id='0' type="text" name="quantity[]"
                                                class="form-control quantity" multiple
                                                placeholder="0"
                                                >
                                            </div>
                                        </div>

                                        <div class=" col-sm-2 col-md-2 col-2 col-lg-2">
                                            <div class="form-group">
                                                <input name="price[]" id="price0" total_id='0'   multiple type="number" placeholder="0"
                                                    class="form-control price">
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-4 col-md-4 col-sm-4">
                                            <div class="form-group ">
                                                <input type="number" class="form-control total" name='total[]' id="total0"
                                                multiple readonly
                                                placeholder="0">
                                            </div>
                                        </div>
                                </div>

                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-12">
                                        <button id="add_product"class="btn btn-primary pd mb-2 btn-sm"><i class="bx bx-plus me-1"></i>
                                            Add Product</button>
                                    </div>
                                </div>

                                <div class="row">
                                    <input hidden value=" " id="customer_id" type="text" name="customer_id">

                                    <div class="col-lg-12 col-12">
                                        <div class="row align-items-center">
                                            <div class="col-lg-5 col-md-5 col-12">
                                                <div class="col-lg-12 col-md-12 col-12 mt-4 ">
                                                    <div class="row">
                                                        <div class="col-4 col-lg-4 col-4">
                                                            <p class="mr-2">Due Date </p>
                                                        </div>
                                                        <div class="col-8 col-lg-8">
                                                            <div class="form-group">
                                                                <input type="date" name="due_date" id="due_date" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4 col-lg-4 col-md-4 col-sm-4">
                                                            <p class="mr-2">DiscountType (<i id="icon"
                                                                    style="font-size: 12px !important"
                                                                    class="fas fa-percent">
                                                                </i>)</p>
                                                        </div>
                                                        <div class="col-8 col-lg-8">
                                                            <div class="form-group">
                                                                <select id="discount_type" name="discount_type"
                                                                    class="form-control">
                                                                    <option selected="selected" value="%">
                                                                        <span>(%)</span></option>
                                                                    <option value="flat"><span>(&#2547;)</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4 col-lg-4 col-4">
                                                            <p class="mr-2">Notes </p>

                                                        </div>
                                                        <div class="col-8 col-lg-8">
                                                            <div class="form-group">
                                                                <textarea name="note"
                                                                    value='thank you for gracing us with your presence.'
                                                                    placeholder="thank you for gracing us with your presence. "
                                                                    class="text-align-start "></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-2">
                                            </div>
                                            <div class="col-lg-5 col-md-5 mt-2">
                                                <div class="row">
                                                    <div class="col-lg-12 mt-3">
                                                        <div class="row">
                                                            <div class="col-6 col-lg-5 pl-lg-1 pr-1">
                                                                <input type="text" disabled value="Subtotal"
                                                                    class="bg-green text-white form-control border-0"
                                                                    style="background-color: rgb(1, 194, 115);">
                                                            </div>
                                                            <div class="col-6 col-lg-6 pl-1">
                                                                <input readonly  name="sub_total" id="sub_total"
                                                                    type="number" placeholder="0"
                                                                    class="form-control">

                                                            </div>
                                                        </div>
                                                    </div>



                                                    <div class="col-lg-12">
                                                        <hr style="margin-top: 10px; margin-bottom: 5px;">
                                                    </div>
                                                    <div class="col-lg-12 mt-1">
                                                        <div class="row">
                                                            <div class="col-6 col-lg-5 pl-lg-1 pr-1">
                                                                <input type="text" disabled value="Discount"
                                                                    class="bg-green text-white form-control border-0"
                                                                    style="background-color: rgb(1, 194, 115);">
                                                            </div>
                                                            <div class="col-6 col-lg-6 pl-1">
                                                                <input name="discount_amount" id="discount_amount" type="number"
                                                                    placeholder="0" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12 mt-1">
                                                        <div class="row">
                                                            <div class="col-6 col-lg-5 pl-lg-1 pr-1">
                                                                <input type="text" disabled value="Tax (%)"
                                                                    class="bg-green text-white form-control border-0"
                                                                    style="background-color: rgb(1, 194, 115);">
                                                            </div>
                                                            <div class="col-6 col-lg-6 pl-1">
                                                                <input name="tax" id="tax" type="number" placeholder="0"
                                                                    class="form-control">
                                                                <input  hidden name="subtotal_2" id="subtotal_2" type="text"
                                                                     placeholder="0" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                        <hr style="margin-top: 10px; margin-bottom: 5px;">
                                                    </div>
                                                    <div class="col-lg-12 mt-1">
                                                        <div class="row">
                                                            <div class="col-6 col-lg-5 pl-lg-1 pr-1">
                                                                <input type="text" disabled value="Grand Total"
                                                                    class="bg-green text-white form-control border-0"
                                                                    style="background-color: rgb(1, 194, 115);">
                                                            </div>
                                                            <div class="col-6 col-lg-6 pl-1">
                                                                <input readonly  name="grand_total" id='grand_total'
                                                                    type="number" placeholder="0"
                                                                    class="form-control"> </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 mt-1">
                                                        <div class="row">
                                                            <div class="col-6 col-lg-5 pl-lg-1 pr-1">
                                                                <input type="text" disabled value="Amount Paid"
                                                                    class="bg-green text-white form-control border-0"
                                                                    style="background-color: rgb(1, 194, 115);">
                                                            </div>
                                                            <div class="col-6 col-lg-6 pl-1 text-center">
                                                                <input name="paid" type="number" id="paid"
                                                                    placeholder="0"
                                                                    class="text-center form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 mt-1">
                                                        <div class="row">
                                                            <div class="col-6 col-lg-5 pl-lg-1 pr-1">
                                                                <input type="text" disabled value="Total Due"
                                                                    class="bg-red text-white form-control border-0"
                                                                    style="background-color: rgb(218, 41, 28);">
                                                            </div>
                                                            <div class="col-6 col-lg-6 pl-1">
                                                                <input readonly  name="due" type="number" id="due"
                                                                    placeholder="0" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3 justify-content-center">
                                    <div class="col-lg-12 text-center justify-content-center">
                                        <button id="submit_button" type="submit" class="btn btn-primary pd mb-2 btn-sm">Submit</button>
                                    </div>
                                </div>

                            </form>
                            </div>
                        </div>

                        </div>
                    </div>
                </div>


            </div>

            <!-- end row -->
            <!-- end table responsive -->
        </div>
    </div>
</div>

</div>
</div>
</div>
</div> <!-- container-fluid -->
</div>
@section('admin_js')

<script>
    $(document).ready(function () {

        /* =============================
                                 ajax setup start
            ==============================*/

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

     /* ================================
                                 ajax setup end
        ================================ */

     /* =================================
                                 add  new product row start
        ================================= */
        $(document).on('click','#add_product',function(e){
            let price_field = checkInputField('price');
            let quantity_field = checkInputField('quantity');
            let product_name_field = checkInputField('product_name');
            if(product_name_field != false && quantity_field != false && price_field != false){
                appendNewProductRow()
            }
            else{
                Toast.fire({
                    icon: 'error',
                    title: 'Something went wrong, All Input Is Required '
                })
            }
            e.preventDefault()
        })

     /* ==================================
                            add  new product row end
        ==================================*/

     /* ==================================
                           appendNewProductRow fuction start
        ==================================*/
        function appendNewProductRow(){
            let  count = $(this).data("count") || 0
            $(this).data("count", ++count);
             $('#body_data').append(`<div id="${count}" class="row mb-2">
                <div class="col-4 col-md-4 col-sm-4 col-lg-4 pr-lg-1">
                    <div class="form-group ">
                        <input type="text" name="product_name[]" id="product_name"
                        placeholder="product name"
                            class="form-control product_name" multiple>
                    </div>
                </div>
                <div class=" col-1 col-lg-1 col-md-1 col-sm-1 pr-1 pl-1 col-lg-1 pr-lg-1 pl-lg-1">
                    <div class="form-group text-center justify-content-center">
                        <input  total_id="${count}" multiple id="quantity${count}" type="text" name="quantity[]"
                        class="form-control quantity"
                        placeholder="0"
                        >
                    </div>
                </div>

                <div class=" col-sm-2 col-md-2 col-2 col-lg-2">
                    <div class="form-group">
                        <input  multiple name="price[]" id="price${count}"  total_id="${count}" type="number" placeholder="0"
                            class="form-control price">
                    </div>
                </div>

                <div class="col-lg-4 col-4 col-md-4 col-sm-4">
                    <div class="form-group ">
                        <input readonly  multiple type="number" class="form-control total" name='total[]' id="total${count}"
                        placeholder="0">
                    </div>
                </div>

            <div class="col-1 col-md-1 col-sm-1  col-lg-1 ">
                    <div class="form-group text-center justify-content-center ">
                        <a value="${count}"  id="deleted_product" class="text-center btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
                    </div>
             </div>
        </div>`);

        callCalDisCalTaxFun()
        calculateDue()
        }

     /* ==================================
                                 appendNewProductRow function end
        ==================================*/

     /* ==================================
                                callCalDisCalTaxFun  function start
        ==================================*/
        function callCalDisCalTaxFun(){
            const tax = $('#tax').val();
            callCalculateDiscountFun()
            const subtotal_2 = $('#subtotal_2').val()
            calculateTotalTax(tax,parseFloat(subtotal_2).toFixed(2))
        }

     /* ==================================
                                callCalDisCalTaxFun  function end
        ==================================*/

     /* ==================================
                                 delete  new product row start
        ==================================*/
        $(document).on('click','#deleted_product',function(e){
            const deletd_id = $(this).attr('value')
           $(`#${deletd_id}`).remove()
           subTotalCalculation()
           callCalDisCalTaxFun()
           calculateDue()
           e.preventDefault()
        })

     /* ==================================
                                 delete  new product row end
        ==================================*/

     /* ==================================
                            quantity on chnage calculation start
        ==================================*/
        $(document).on('change','.quantity',function(e){
            const quantity = $(this).val()
            const total_id = $(this).attr('total_id')
            const checkQuantity = checkValueIsNumber(quantity);
            const price = $(`#price${total_id}`).val()? $(`#price${total_id}`).val():0;
            if(checkQuantity){
            totalCalculation(quantity,price,total_id)
            }
            else{
                Toast.fire({
                    icon: 'error',
                    title: 'Something went wrong, Quantity must be  Number'
                })
            }
            callCalDisCalTaxFun()
            calculateDue()
            e.preventDefault()
        })
     /* ==================================
                            quantity  on chnage calculation end
        ==================================*/

     /* ==================================
                            price on chnage calculation start
        ==================================*/
        $(document).on('change','.price',function(e){
            const price = $(this).val()
            const total_id = $(this).attr('total_id')
            const quantity = $(`#quantity${total_id}`).val()? $(`#quantity${total_id}`).val():0
            const checkQuantity = checkValueIsNumber(quantity);
            if(checkQuantity){
            totalCalculation(quantity,price,total_id)
            }
            else{
                Toast.fire({
                    icon: 'error',
                    title: 'Something went wrong, Quantity must be  Number'
                })
            }
            callCalDisCalTaxFun()
            calculateDue()
            e.preventDefault()
        })
     /* ==================================
                            price  on chnage calculation end
        ==================================*/

     /* ==================================
                            totalCalculation function start
        ==================================*/
        function totalCalculation(quantity,price,total_id){
            const total = parseFloat(price).toFixed(2)*quantity;
            $(`#total${total_id}`).val(parseFloat(total).toFixed(2))
            subTotalCalculation();
        }
     /* ==================================
                            totalCalculation function end
        ==================================*/


     /* ==================================
                              callCalculateDiscountFun function start
        ==================================*/
        function   callCalculateDiscountFun(){
            const discount_amount = $('#discount_amount').val()
            const discount_type = $('#discount_type').val();
            const sub_total = $('#sub_total').val()
            calculateDiscount(discount_type,discount_amount,sub_total)
        }
     /* ==================================
                              callCalculateDiscountFun function end
        ==================================*/


     /* ==================================
                            subTotalCalculation function end
        ==================================*/
        function subTotalCalculation(){
            let sub_total = 0;
            $('.total').each(function(){
                sub_total=parseFloat(sub_total) + parseFloat($(this).val());
             });
             setInputValue('sub_total',sub_total);
             setInputValue('grand_total',sub_total);
        }
     /* ==================================
                            subTotalCalculation function end
        ==================================*/


     /* ==================================
                            checkValueIsNumber function start
        ==================================*/
        function checkValueIsNumber(value){
            return $.isNumeric(value)
        }
     /* ==================================
                            checkValueIsNumber function end
        ==================================*/

     /* ==================================
                            checkInputField function start
        ==================================*/

        function checkInputField(selector){
            let class_list = $(`.${selector}`)
            for(let i = 0; i <class_list.length; i++){
                if($(class_list[i]).val() == ''){
                    return false
                    break;
                }
           }
        }

     /* ==================================
                            checkInputField function end
        ==================================*/


     /* ==================================
                           discount icon change start
        ==================================*/
        $(document).on('change', '#discount_type', function (e) {
            const discount_type = $(this).val()
            const tax = $('#tax').val();
            if (discount_type != '%') {
                $('#icon').removeClass('fas fa-percent')
                $('#icon').addClass(' fas fa-money-bill-alt')
            } else {
                $('#icon').removeClass('fas fa-money-bill-alt')
                $('#icon').addClass('fas fa-percent')
            }
            callCalDisCalTaxFun()
            calculateDue()
            e.preventDefault()

        })

     /* ==================================
                            discount icon change end
        ==================================*/


     /* ==================================
                            discount calculation start
        ==================================*/
        $(document).on('change', '#discount_amount', function (e) {
            const discount_amount = $(this).val()
            const discount_type = $('#discount_type').val();
            const sub_total = $('#sub_total').val()
            if(sub_total == ''){
                $(this).val(' ')
                Toast.fire({
                    icon: 'error',
                    title: 'Something went wrong,  Sub Total  can not be 0 , please add some product '
                })
            }
            else{
                callCalDisCalTaxFun()
                calculateDue()
            }

            e.preventDefault()
        })

    /* ==================================
                            calculateDiscount function start
        ==================================*/
        function calculateDiscount(discount_type,discount_amount,sub_total){
            if(discount_type =='%'){
                if(discount_amount >100){
                    setInputValue('subtotal_2',sub_total);
                    emptyInputField('discount_amount');
                    Toast.fire({
                        icon: 'error',
                        title: '% disocunt can not be grater than 100 '
                    })
                }
                else{
                let parcentDiscount  =   parcentDiscountCalculation(sub_total,discount_amount)
                setInputValue('subtotal_2',parcentDiscount);
                }
            }
            else{
                  let flatDiscount =   flatDiscountCalculation(sub_total,discount_amount)
                  if(flatDiscount < 0){
                    setInputValue('subtotal_2',sub_total);
                    emptyInputField('discount_amount');
                    Toast.fire({
                        icon: 'error',
                        title: 'flat disocunt can not be grater than subtotal '
                    })
                  }
                  else{
                      setInputValue('grand_total',flatDiscount);
                      setInputValue('subtotal_2',flatDiscount);
                     }
            }
        }

    /* ==================================
                            calculateDiscount function end
        ==================================*/

    /* ==================================
                            parcentDiscountCalculation function start
        ==================================*/
        function parcentDiscountCalculation(sub_total,discount_amount){
             return sub_total - (sub_total * (discount_amount / 100));
        }
    /* ==================================
                            parcentDiscountCalculation function end
        ==================================*/


    /* ==================================
                            setInputValue function start
        ==================================*/
        function setInputValue(selector,amount){
            $(`#${selector}`).val(parseFloat(amount).toFixed(2))
        }

    /* ==================================
                            setInputValue function end
        ==================================*/



    /* ==================================
                            flatDiscountCalculation function start
        ==================================*/

        function flatDiscountCalculation(sub_total,discount_amount){
                return sub_total- discount_amount;
        }

    /* ==================================
                            flatDiscountCalculation function end
        ==================================*/


     /* ==================================
                            discount  calculation end
        ==================================*/


     /* ==================================
                            tax  calculation start
        ==================================*/
        $(document).on('change','#tax',function(e){
            const tax = $(this).val()? $(this).val():0;
            const subtotal_2 = $('#subtotal_2').val();
            if(subtotal_2 == ''){
                $(this).val(' ')
                Toast.fire({
                    icon: 'error',
                    title: 'Something went wrong,  Sub Total  can not be 0 , please add some product '
                })
            }
            else{
                calculateTotalTax(tax,parseFloat(subtotal_2).toFixed(2))
                calculateDue()
            }
            e.preventDefault()
        })

    /* ==================================
                           calculateTotalTax function start
        ==================================*/
        function calculateTotalTax(tax,sub_total_2){
            let totalTax =parseFloat(sub_total_2).toFixed(2)* (tax/100);
            const finalTotal =parseFloat(sub_total_2)+ (totalTax);
            setInputValue('grand_total',finalTotal);
        }

   /* ==================================
                    calculateTotalTax function end
    ==================================*/


     /* ==================================
                            tax  calculation end
        ==================================*/


     /* ==================================
                            emptyInputField function start
        ==================================*/
        function emptyInputField(selector){
            $(`#${selector}`).val(' ')
        }
     /* ==================================
                            emptyInputField  function end
        ==================================*/


     /* ==================================
                            due  calculation start
        ==================================*/
        $(document).on('change', '#paid', function (e) {
            const grand_total = $('#grand_total').val();
            if(grand_total == ''){
                $(this).val(' ')
                Toast.fire({
                    icon: 'error',
                    title: 'Something went wrong,  grand  Total  can not be 0 , please add some product '
                })
            }
            else{
                calculateDue();
            }
            e.preventDefault()
        })
     /* ==================================
                               due  calculation end
        ==================================*/

     /* ==================================
                                  calculateDue function  start
        ==================================*/
        function calculateDue(){
            const paid = $('#paid').val();
            const grand_total = $('#grand_total').val();
            const  due = grand_total - paid ;
            setInputValue('due',due);
        }
     /* ==================================
                               calculateDue function  end
        ==================================*/


     /* ==================================
                               submit form validatioion  start
        ==================================*/
        $(document).on('click','#submit_button',function(e){
            let price_field = checkInputField('price');
            let quantity_field = checkInputField('quantity');
            let product_name_field = checkInputField('product_name');
            const due = $('#due').val()
            const due_date  = $('#due_date').val()
            const customer_id  = $('#customer_id').val()
            if(product_name_field != false && quantity_field != false && price_field != false){
                if(customer_id == ' '){
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong, Please Select a Customer'
                    })
                }
                else{
                    if(due > 0  && due_date =='' ){
                        Toast.fire({
                            icon: 'error',
                            title: 'Something went wrong, Due Date is Required '
                        })
                    }
                    else{
                        $('#form_submit').submit()
                        $('#due_date').val(' ')
                    }
                }
            }
            else{
                Toast.fire({
                    icon: 'error',
                    title: 'Something went wrong, All Input Is Required '
                })
            }
            e.preventDefault()
        })
     /* ==================================
                                submit form validatioion  end
        ==================================*/

     /* ==================================
                                customer find ajax  start
        ==================================*/
        $(document).on('change', '#customer_name', function (e) {
            let customerId = $(this).val()
            if(customerId){
                $.ajax({
                    method: 'get',
                    url: `/admin/invoice/find-specific-customer/${customerId}`,
                    dataType: 'json',
                    async: false
                }).done(customerInfo => {
                   if(customerInfo!=null){
                    $('#phone_number').val(
                        customerInfo.customer.phone)
                    $('#billing_address').val(
                        customerInfo.customer.address)
                    $('#customer_id').val(customerInfo.customer.id)
                   }

                })
            }
            else{
                $('#phone_number').val(' ')
                $('#billing_address').val(' ')
                $('#customer_id').val(' ')
            }

            e.preventDefault()

        })
     /* ==================================
                                     customer find ajax  end
        ==================================*/

    });

</script>

@if($errors->any())
    <script>
        Toast.fire({
            icon: 'error',
            title: 'Something went wrong, Please select billing to Customer Name'
        })

    </script>
@endif

@endsection
@endsection
