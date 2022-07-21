<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                @if (Auth::guard('admin')->user()->can('dashboard.index'))
                    <li class="@yield('home_active')">
                        <a href="{{ route('admin.home') }}">
                            <i data-feather="home"></i>
                            <span data-key="t-dashboard">Dashboard</span>
                        </a>
                    </li>
                @endif
                @if (Auth::guard('admin')->User()->can('attendanceRequest.index'))
                <li class="@yield('attendance_active')">
                        <a href="{{ route('admin.attendance.index') }}">
                            <i data-feather="list"></i>
                            Attendance List <span class="text-danger">({{ pendingAttendance() }})</span>
                        </a>
                    </li>
                @endif
                @if (Auth::guard('admin')->user()->can('work.report.index'))
                    <li class="@yield('work_report_active')">
                        <a href="{{ route('admin.workReport.index') }}">
                            <i data-feather="info"></i>
                            <span data-key="t-dashboard">WorkReport <span class="text-danger">({{ pendingWorkReport() }})</span> </span>
                        </a>
                    </li>
                @endif
                @if (Auth::guard('admin')->user()->can('meeting.report.index'))
                    <li class="@yield('meeting_report_active')">
                        <a href="{{ route('admin.meetingReport.index') }}">
                            <i data-feather="twitch"></i>
                            <span data-key="t-dashboard">MeetingReport <span class="text-danger">({{ pendingMettingReport() }})</span> </span>
                        </a>
                    </li>
                @endif
                @if (Auth::guard('admin')->User()->can('employeeLeave.index') || Auth::guard('admin')->User()->can('leaveRequest.index'))
                    <li class="@yield('leave_active')">
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="file-minus"></i>
                            <span data-key="t-ecommerce">Leave <span class="text-danger">({{ pendingLeaveRequest() }})</span> </span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a class="@yield('employee_leave_active')" href="{{ route('admin.employeeLeave.index') }}"> <i data-feather="corner-down-right"></i>Employee Leave</a></li>
                            <li><a class="@yield('leave_request_active')" href="{{ route('admin.leaveRequest.index') }}"> <i data-feather="corner-down-right"></i>Leave Requests<span class="text-danger">({{ pendingLeaveRequest() }})</span></a></li>
                        </ul>
                    </li>
                @endif
                @if (Auth::guard('admin')->user()->can('income.index'))
                    <li class="@yield('income_active')">
                        <a href="{{ route('admin.income.index') }}" class="">
                            <i data-feather="codesandbox"></i>
                            Income
                        </a>
                    </li>
                @endif
                @if (Auth::guard('admin')->user()->can('expense.index') || Auth::guard('admin')->user()->can('expense.category.index'))
                    <li class="@yield('expense_active')">
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="dollar-sign"></i>
                            <span data-key="t-ecommerce">Expense</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @if (Auth::guard('admin')->user()->can('expense.category.index'))
                                <li><a class="@yield('expense_category_active')" href="{{ route('admin.expense.category.index') }}"> <i data-feather="corner-down-right"></i>Category</a></li>
                            @endif
                            @if (Auth::guard('admin')->user()->can('expense.index'))
                                <li><a class="@yield('expense_expenses_active')" href="{{ route('admin.expense.index') }}"> <i data-feather="corner-down-right"></i>Expenses</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (Auth::guard('admin')->User()->can('employee.index'))
                    <li class="@yield('employee_active')">
                        <a href="{{ route('admin.employee.index') }}">
                            <i data-feather="users"></i>
                            <span data-key="t-dashboard">Employee</span>
                        </a>
                    </li>
                @endif
                @if (Auth::guard('admin')->User()->can('workingDay.index'))
                    <li class="@yield('working_day_active')">
                        <a href="{{ route('admin.workingDay.index') }}">
                            <i data-feather="calendar"></i>
                            <span data-key="t-dashboard">Working Day</span>
                        </a>
                    </li>
                @endif
                @if (Auth::guard('admin')->User()->can('holiday.index'))
                    <li class="@yield('holiday_active')">
                            <a href="{{ route('admin.holiday.index') }}">
                                <i data-feather="calendar"></i>
                                <span data-key="t-dashboard">Holiday</span>
                            </a>
                        </li>
                @endif
                @if (Auth::guard('admin')->User()->can('salary.index'))
                    <li class="@yield('salary_active')">
                        <a href="{{ route('admin.salary.index') }}">
                            <i data-feather="clipboard"></i>
                            Salary
                        </a>
                    </li>
                @endif
                @if (Auth::guard('admin')->User()->can('customer.index'))
                    <li class="@yield('customer_active')">
                        <a href="{{ route('admin.customer.index') }}">
                            <i data-feather="users"></i>
                            <span data-key="t-dashboard">Customer</span>
                        </a>
                    </li>
                @endif
                @if (Auth::guard('admin')->user()->can('project.index'))
                    <li class="@yield('project_active')">
                        <a href="{{ route('admin.project.index') }}" class="">
                            <i data-feather="octagon"></i>
                            Project
                        </a>
                    </li>
                @endif
                @if (Auth::guard('admin')->user()->can('invoice.index'))
                    <li class="@yield('invoice_active')">
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="dollar-sign"></i>
                            <span data-key="t-ecommerce">invoice</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @if (Auth::guard('admin')->user()->can('invoice.create'))
                                <li><a class="@yield('invoice_create_active')" href="{{ route('admin.invoice.create') }}"> <i data-feather="corner-down-right"></i>Create Invoice</a></li>
                            @endif
                            @if (Auth::guard('admin')->user()->can('invoice.index'))
                                <li><a class="@yield('invoice_index_active')" href="{{ route('admin.invoice.index') }}"> <i data-feather="corner-down-right"></i>All Invoice</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (Auth::guard('admin')->user()->can('email.index'))
                    <li class="@yield('email_active')">
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="mail"></i>
                            <span data-key="t-ecommerce">Email</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @if (Auth::guard('admin')->user()->can('email.index'))
                                <li><a class="@yield('email_index_active')" href="{{ route('admin.email.index') }}"> <i data-feather="corner-down-right"></i>Inbox</a></li>
                            @endif

                        </ul>
                    </li>
                @endif
                @if (Auth::guard('admin')->user()->can('admin.index') || Auth::guard('admin')->user()->can('role.index'))
                    <li class="@yield('admin_active')">
                        <a href="javascript: void(0);" class="has-arrow" >
                            <i data-feather="users"></i>
                            <span data-key="t-ecommerce">Admin Management</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @if (Auth::guard('admin')->user()->can('admin.index'))

                            <li><a class="@yield('admin_admin_active')" href="{{ route('admin.admin.index') }}" key="t-products"><i data-feather="user"></i>Admins</a></li>
                            @endif
                            @if (Auth::guard('admin')->user()->can('role.index'))

                            <li><a class="@yield('admin_roles_active')" href="{{ route('admin.roles.index') }}" data-key="t-product-detail"><i data-feather="user"></i>Roles</a></li>
                            @endif

                        </ul>
                    </li>
                @endif
                @if (Auth::guard('admin')->user()->can('generalSettings.index') || Auth::guard('admin')->user()->can('configSettings.index'))
                    <li class="@yield('settings_active')">
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="settings"></i>
                            <span data-key="t-ecommerce">Settings</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @if (Auth::guard('admin')->user()->can('generalSettings.index'))

                            <li><a class="@yield('settings_general_active')" href="{{ route('admin.settings.general') }}"> <i data-feather="corner-down-right"></i>General</a></li>
                            @endif
                            @if (Auth::guard('admin')->user()->can('configSettings.index'))
                            <li><a class="@yield('settings_config_active')" href="{{ route('admin.settings.config') }}"> <i data-feather="corner-down-right"></i>Config</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
