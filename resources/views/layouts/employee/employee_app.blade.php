<!doctype html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>@yield('employee_title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('photo/settings/general') }}/{{ generalSettings()->favicon }}">

      @include('layouts.employee.includes.css')

    </head>

    <body data-topbar="dark">

    <!-- <body data-layout="horizontal"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">

            
           @include('layouts.employee.includes.header')

            <!-- ========== Left Sidebar Start ========== -->
          @include('layouts.employee.includes.left_sidebar')
            <!-- Left Sidebar End -->

            

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                @yield('employee_content')
                <!-- End Page-content -->

                
                @include('layouts.employee.includes.footer')
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        
        <!-- Right Sidebar -->
       @include('layouts.employee.includes.right_sidebar')
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

       @include('layouts.employee.includes.js')
    </body>
</html>
