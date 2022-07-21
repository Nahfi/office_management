<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">


                <li class="@yield('home_active')">
                    <a href="{{ route('customer.home') }}">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>
                <li class=" @yield('project_active') ">
                    <a href="{{ route('customer.project.index') }}" >
                        <i data-feather="activity"></i>
                        <span data-key="t-ecommerce">Projects</span>
                    </a>

                </li>
                <li class=" @yield('invoice_active') ">
                    <a href="{{ route('customer.invoice.index') }}" >
                        <i data-feather="package"></i>
                        <span data-key="t-ecommerce">Invoice</span>
                    </a>
                </li>
        </div>
        <!-- Sidebar -->
    </div>
</div>
