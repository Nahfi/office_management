<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('/admin_assets/images/payslip/logo/favicon.png') }}" type="image/png" sizes="16x16">

    <!-- Bootstrap CSS -->


    <title>BIRit - Salary Slip</title>
</head>

<body>
    <div style="text-align: center">
        <button id="print" style="cursor: pointer;     padding: 5px 15px;font-size: 14px;background: #01c273;color: #fff;text-transform: uppercase;border: none;">Print</button>
    </div>
    <section id="salary_slip">
        <div>
            <!-- A4 page print size 796*1150. Half of A4 page 796*575px. -->
            <div
                 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; width:796px; height:1150px; margin: 0 auto;color:#000; padding:0px;background-color: #fff;overflow: hidden;">
                <!-- Office Copy Start -->
                <div class="office-copy"
                     style="background-image:  url('/admin_assets/images/payslip/logo/logo-watermark.png');background-position: center;background-repeat: no-repeat;width:796px; height:570px;overflow:hidden; font-size:13px;letter-spacing: 0.5px; font-weight: 400;">
                    <!-- Header Start -->
                    <div class="header" style="height: 25%;overflow: hidden;">
                        <div class="content">
                            <div style="width: 50%;float: left;">
                                <h1 style="color:#01c273;margin: 0;font-size: 34px; letter-spacing: 2px;">
                                    SALARY SLIP
                                </h1>
                                <p style="border-bottom: 1px dotted #222; display: inline-block;margin: 0;">Office Copy
                                </p>
                            </div>
                            <div style="width: 50%;text-align: end;float: left;">
                                <img style="width: 222px; height: 57px;margin-bottom: 5px;"
                                     src="{{ asset('/admin_assets/images/payslip/logo/logo.png') }}" alt="">
                                <p style="margin: 0;">www.birit.com.bd</p>
                                <p style="margin: 0;">+8801766766771</p>
                                <p style="margin: 0;">House#27, Road#09, Sector#11, Uttara, Dhaka.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Header End -->
                    <!-- Main Start -->
                    <div class="main" style="height: 50%;overflow: hidden;">
                        <!-- Basic Info Start -->
                        <div class="basic-info" style="border:1px solid #222;">
                            <table style="width:100%;border-collapse:collapse;">
                                <tbody>
                                    <tr>
                                        <td
                                            style="font-weight: 500;padding-left: 15px;padding-bottom: 5px;padding-top: 5px;">
                                            Employee ID
                                        </td>
                                        <td>:</td>
                                        <td>{{ $paySlip->employee_id }}</td>
                                        <td style="font-weight: 500;">Basic Salary</td>
                                        <td>:</td>
                                        <td>{{ $paySlip->basic_salary }}/-</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 500;padding-left: 15px;padding-bottom: 5px;">Employee
                                            Name</td>
                                        <td>:</td>
                                        <td>{{  $paySlip->employee->name }}</td>
                                        <td style="font-weight: 500;">Total Working</td>
                                        <td>:</td>
                                        <td>{{ $paySlip->workingday->total_day }} Days</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 500;padding-left: 15px;padding-bottom: 5px;">Designation
                                        </td>
                                        <td>:</td>
                                        <td></td>
                                        <td style=" font-weight: 500;">Total Present</td>
                                        <td>:</td>
                                        <td>{{ $paySlip->total_present }} Days</td>
                                    </tr>
                                    @php
                                    $date = new DateTime($paySlip->date);
                                    $date->modify('first day of this month');
                                    $firstday= $date->format('j, F Y');
                                    $date->modify('last day of this month');
                                    $lastday= $date->format('j, F Y');
                                    @endphp

                                    <tr>
                                        <td style="font-weight: 500;padding-left: 15px;padding-bottom: 10px;">
                                            Salary Date Range</td>
                                        <td>:</td>
                                <td>{{ $firstday }} - {{ $lastday }}</td>
                                <td style=" font-weight: 500;">Total Absent</td>
                                <td>:</td>
                                <td>{{ $paySlip->total_absent }} Days</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Basic Info End -->
                        <!-- Salary Info Start -->
                        <div class="salary-info" style="padding-top: 20px;">
                            <table
                                   style="width: 100%;border-collapse:collapse;text-align: center;border: 1px solid #222;">
                                <thead>
                                    <tr style="background: #01c273;color: #fff;letter-spacing: 2px;">
                                        <th style="border-bottom: 1px solid #222;border-right: 1px solid #222;">Earning
                                        </th>
                                        <th style="border-right: 1px solid #222;border-bottom: 1px solid #222;">Amount
                                        </th>
                                        <th style="border-bottom: 1px solid #222;border-right: 1px solid #222;">
                                            Deduction</th>
                                        <th style="border-bottom: 1px solid #222;">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="border-right: 1px solid #222;">Payable Salary</td>
                                        <td style="border-right: 1px solid #222;">{{ $paySlip->payable_salary  }}/-</td>
                                        <td style="border-right: 1px solid #222;">Absent</td>
                                        <td>{{$paySlip-> punishment==0?'00.00':$paySlip-> punishment }}/-</td>
                                    </tr>
                                    <tr>
                                        <td style="border-right: 1px solid #222;">Others</td>
                                        <td style="border-right: 1px solid #222;">00.00/-</td>
                                        <td style="border-right: 1px solid #222;">Others</td>
                                        <td>00.00/-</td>
                                    </tr>
                                    <tr>
                                        <td style="border-right: 1px solid #222;"></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr style="background: #f7f7f7;">
                                        <td style="border: 1px solid #222;">Total Earning</td>
                                        <td style="border: 1px solid #222;">
                                            {{ $paySlip->payable_salary }}/-</td>
                                        <td style="border: 1px solid #222;">Total Deduction</td>
                                        <td style="border: 1px solid #222;">{{$paySlip-> punishment==0?'00.00':$paySlip-> punishment }}/-</td>
                                    </tr>
                                     <tr style="background: #f2f2f2; color: #222;font-weight: 500;"> <td
                                        colspan="2" style="border-bottom: 1px solid #222;border-right: 1px solid #222;">
                                        Net Salary</td> <td colspan="2" style="border-bottom: 1px solid #222;"> {{ $paySlip->payable_salary - $paySlip->punishment }}
                                        Tk</td> </tr>
                                </tfoot>
                            </table>
                            <table style="border-collapse:collapse; width: 100%;text-align: center;">
                                <tbody>
                                    <tr>
                                        <td style="width:472px;"></td>
                                        <td
                                            style="background-color: #01c17180;border-left: 1px solid #222;border-right: 1px solid #222;border-bottom: 1px solid #222;">
                                            Net Salary
                                        </td>
                                        <td
                                            style="background-color: #01c17180;border-left: 1px solid #222;border-right: 1px solid #222;border-bottom: 1px solid #222;">
                                            {{ $paySlip->payable_salary - $paySlip->punishment }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Salary Info End -->
                    </div>
                    <!-- Main End -->
                    <!-- Footer Start -->
                    <div class="footer" style="height: 25%;overflow: hidden;">
                        <div class="content">
                            <table style="width: 100%;border-collapse:collapse;">
                                <tbody>
                                    <tr>
                                        <td style="width: 170px;">
                                            Write the full Tk in word :
                                        </td>
                                        <td style="border-bottom: 1px dotted #222;">

                                        </td>
                                        <td style="border-bottom: 1px dotted #222;"></td>
                                    </tr>
                                    <tr style="text-align: center;">
                                        <td style="padding-top: 45px;">...........................................</td>
                                        <td style="padding-top: 45px;">...........................................</td>
                                        <td style="padding-top: 45px;">...........................................</td>
                                    </tr>
                                    <tr style="text-align: center;">
                                        <td>Employee Signature</td>
                                        <td>CEO Signature</td>
                                        <td>Date</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Footer End -->
                </div>
                <!-- Office Copy End -->
                <!-- Center Line Start -->
                <div class="center-line" style="height: 10px;">
                    <div style="border-bottom: 1px dashed #222;height: 50%;"></div>
                </div>
                <!-- Center Line End -->
                <!-- Employee Copy Start -->
                <div class="employee-copy"
                {{--  {{ asset('/admin_assets/images/payslip/logo/logo.png') }}  --}}
                     style="background-image: url('/admin_assets/images/payslip/logo/logo-watermark.png');background-position: center;background-repeat: no-repeat;width:796px; height:570px;overflow:hidden; font-size:13px;letter-spacing: 0.5px; font-weight: 400;padding-top: 40px;">
                    <!-- Header Start -->
                    <div class="header" style="height: 25%;overflow: hidden;">
                        <div class="content">
                            <div style="width: 50%;float: left;">
                                <h1 style="color:#01c273;margin: 0;font-size: 34px; letter-spacing: 2px;">
                                    SALARY SLIP
                                </h1>
                                <p style="border-bottom: 1px dotted #222; display: inline-block;margin: 0;">Employee
                                    Copy
                                </p>
                            </div>
                            <div style="width: 50%;text-align: end;float: left;">
                                <img style="width: 222px; height: 57px;margin-bottom: 5px;"
                                     src="{{ asset('/admin_assets/images/payslip/logo/logo.png') }}" alt="">
                                <p style="margin: 0;">www.birit.com.bd</p>
                                <p style="margin: 0;">+8801766766771</p>
                                <p style="margin: 0;">House#27, Road#09, Sector#11, Uttara, Dhaka.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Header End -->
                    <!-- Main Start -->
                    <div class="main" style="height: 50%;overflow: hidden;">
                        <!-- Basic Info Start -->
                        <div class="basic-info" style="border:1px solid #222;">
                            <table style="width:100%;border-collapse:collapse;">
                                <tbody>
                                    <tr>
                                        <td
                                            style="font-weight: 500;padding-left: 15px;padding-bottom: 5px;padding-top: 5px;">
                                            Employee ID
                                        </td>
                                        <td>:</td>
                                        <td>{{ $paySlip->employee_id }}</td>
                                        <td style="font-weight: 500;">Basic Salary</td>
                                        <td>:</td>
                                        <td>{{ $paySlip->basic_salary }}/-</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 500;padding-left: 15px;padding-bottom: 5px;">Employee
                                            Name</td>
                                        <td>:</td>
                                        <td>{{  $paySlip->employee->name }}</td>
                                        <td style="font-weight: 500;">Total Working</td>
                                        <td>:</td>
                                        <td>{{ $paySlip->workingday->total_day }} Days</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 500;padding-left: 15px;padding-bottom: 5px;">Designation
                                        </td>
                                        <td>:</td>
                                        <td></td>
                                        <td style=" font-weight: 500;">Total Present</td>
                                        <td>:</td>
                                        <td>{{ $paySlip->total_present }} Days</td>
                                    </tr>
                                    @php
                                    $date = new DateTime($paySlip->date);
                                    $date->modify('first day of this month');
                                    $firstday= $date->format('j, F Y');
                                    $date->modify('last day of this month');
                                    $lastday= $date->format('j, F Y');
                                    @endphp

                                    <tr>
                                        <td style="font-weight: 500;padding-left: 15px;padding-bottom: 10px;">
                                            Salary Date Range</td>
                                        <td>:</td>
                                <td>{{ $firstday }} - {{ $lastday }}</td>
                                <td style=" font-weight: 500;">Total Absent</td>
                                <td>:</td>
                                <td>{{ $paySlip->total_absent }} Days</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Basic Info End -->
                        <!-- Salary Info Start -->
                        <div class="salary-info" style="padding-top: 20px;">
                            <table
                                   style="width: 100%;border-collapse:collapse;text-align: center;border: 1px solid #222;">
                                <thead>
                                    <tr style="background: #01c273;color: #fff;letter-spacing: 2px;">
                                        <th style="border-bottom: 1px solid #222;border-right: 1px solid #222;">Earning
                                        </th>
                                        <th style="border-right: 1px solid #222;border-bottom: 1px solid #222;">Amount
                                        </th>
                                        <th style="border-bottom: 1px solid #222;border-right: 1px solid #222;">
                                            Deduction</th>
                                        <th style="border-bottom: 1px solid #222;">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="border-right: 1px solid #222;">Payable Salary</td>
                                        <td style="border-right: 1px solid #222;">{{ $paySlip->payable_salary  }}/-</td>
                                        <td style="border-right: 1px solid #222;">Absent</td>
                                        <td>{{$paySlip-> punishment==0?'00.00':$paySlip-> punishment }}/-</td>
                                    </tr>
                                    <tr>
                                        <td style="border-right: 1px solid #222;">Others</td>
                                        <td style="border-right: 1px solid #222;">00.00/-</td>
                                        <td style="border-right: 1px solid #222;">Others</td>
                                        <td>00.00/-</td>
                                    </tr>
                                    <tr>
                                        <td style="border-right: 1px solid #222;"></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr style="background: #f7f7f7;">
                                        <td style="border: 1px solid #222;">Total Earning</td>
                                        <td style="border: 1px solid #222;">
                                            {{ $paySlip->payable_salary }}/-</td>
                                        <td style="border: 1px solid #222;">Total Deduction</td>
                                        <td style="border: 1px solid #222;">{{$paySlip-> punishment==0?'00.00':$paySlip-> punishment }}/-</td>
                                    </tr>
                                     <tr style="background: #f2f2f2; color: #222;font-weight: 500;"> <td
                                        colspan="2" style="border-bottom: 1px solid #222;border-right: 1px solid #222;">
                                        Net Salary</td> <td colspan="2" style="border-bottom: 1px solid #222;"> {{ $paySlip->payable_salary - $paySlip->punishment }}
                                        Tk</td> </tr>
                                </tfoot>
                            </table>
                            <table style="border-collapse:collapse; width: 100%;text-align: center;">
                                <tbody>
                                    <tr>
                                        <td style="width:472px;"></td>
                                        <td
                                            style="background-color: #01c17180;border-left: 1px solid #222;border-right: 1px solid #222;border-bottom: 1px solid #222;">
                                            Net Salary
                                        </td>
                                        <td
                                            style="background-color: #01c17180;border-left: 1px solid #222;border-right: 1px solid #222;border-bottom: 1px solid #222;">
                                            {{ $paySlip->payable_salary - $paySlip->punishment }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Salary Info End -->
                    </div>
                    <!-- Main End -->
                    <!-- Footer Start -->
                    <div class="footer" style="height: 25%;overflow: hidden;">
                        <div class="content">
                            <table style="width: 100%;border-collapse:collapse;">
                                <tbody>
                                    <tr>
                                        <td style="width: 170px;">
                                            Write the full Tk in word :
                                        </td>
                                        <td style="border-bottom: 1px dotted #222;">

                                        </td>
                                        <td style="border-bottom: 1px dotted #222;"></td>
                                    </tr>
                                    <tr style="text-align: center;">
                                        <td style="padding-top: 45px;">...........................................</td>
                                        <td style="padding-top: 45px;">...........................................</td>
                                        <td style="padding-top: 45px;">...........................................</td>
                                    </tr>
                                    <tr style="text-align: center;">
                                        <td>Employee Signature</td>
                                        <td>CEO Signature</td>
                                        <td>Date</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Footer End -->
                </div>
                <!-- Employee Copy End -->
            </div>
        </div>
    </section>

    <!-- script -->


    <script src="{{ asset('admin_assets') }}/libs/jquery/jquery.min.js"></script>
    <script src="{{ asset('admin_assets') }}/libs/jquery/printThis.js"></script>

</body>
<script>
$(function(){
    $(document).on('click','#print',function(e){

       $('#salary_slip').printThis()
        e.preventDefault();
    })

})
</script>

</html>
