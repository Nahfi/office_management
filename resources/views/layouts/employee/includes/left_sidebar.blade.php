<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="@yield('home_active')">
                    <a href="{{ route('employee.home') }}">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>
                <li class="@yield('attendance_active')">
                    <a href="{{ route('employee.attendance.index') }}">
                        <i data-feather="check-square"></i>
                        <span data-key="t-dashboard">Attendance</span>
                    </a>
                </li>



                <li  class="@yield('leave_active')">
                    <a href="javascript: void(0);" class="has-arrow">
                        <i style="font-size: 15px !important;" class="fas fa-tasks"></i>
                        <span data-key="t-tasks">Leave</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li >
                            <a class="@yield('leave_list_active')" href="{{ route('employee.leave.index') }}" key="t-task-list">
                                <i data-feather="corner-down-right"></i>   Leave List
                            </a>
                        </li>

                        <li >
                            <a  class="@yield('leave_request_active')"   href="{{ route('employee.leaveRequest.index') }}" key="t-create-task">
                                <i data-feather="corner-down-right"></i> Request Leave list
                           </a>
                       </li>
                    </ul>
                </li>
                <li  class="@yield('work_reports_active')">
                    <a href="javascript: void(0);" class="has-arrow">
                        <i style="font-size: 15px !important;" class="fas fa-tasks"></i>
                        <span data-key="t-tasks">Work Reports</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li >
                            <a class="@yield('work_reports_index_active')" href="{{ route('employee.workReport.index') }}" key="t-task-list">
                                <i style="font-size: 15px !important;" class="fas fa-columns">
                                </i>   Reports
                            </a>
                        </li>

                        <li >
                            <a  class="@yield('work_reports_create_active')"   href="{{ route('employee.workReport.create') }}" key="t-create-task">
                                <i style="font-size: 15px !important;" class="fas fa-plus-square">
                                </i> Create
                           </a>
                       </li>
                    </ul>
                </li>

                <li class="@yield('meeting_reports_active')" >
                    <a href="javascript: void(0);" class="has-arrow">
                        <i style="font-size: 18px !important;" class=" fab fa-meetup"></i>
                        <span data-key="t-tasks">Meeting Reports</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li >
                            <a class="@yield('meeting_reports_index_active')"  href="{{ route('employee.meetingReport.index') }}"key="t-task-list">
                                <i style="font-size: 15px !important;" class="fas fa-columns">
                                </i>   Reports
                            </a>
                        </li>

                        <li >
                            <a class="@yield('meeting_reports_create_active')"   href="{{ route('employee.meetingReport.create') }}" key="t-create-task">
                                <i style="font-size: 15px !important;" class="fas fa-plus-square">
                                </i> Create
                           </a>
                       </li>
                    </ul>
                </li>

                <li  class="@yield('project_active')">
                    <a href="javascript: void(0);" class="has-arrow">
                        <i style="font-size: 18px !important;" class=" fab fa-unity"></i>
                        <span data-key="t-tasks">Project</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="@yield('work_order_active')" >
                            <a href="{{ route('employee.workOrder.index') }}" >
                                <i style="font-size: 18px !important;" class=" fab fa-unity"></i>
                                <span data-key="t-tasks">Project</span>
                            </a>
                        </li>
                        <li class="@yield('test_active')" >
                            <a href="{{ route('employee.testReport.index') }}" >
                                <i style="font-size: 18px !important;" class=" fas fa-bong"></i>
                                <span data-key="t-tasks">Test Report</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="@yield('salary_active')">
                    <a href="{{ route('employee.salary.index') }}">
                        <i data-feather="smile"></i>
                        <span data-key="t-dashboard">Salary</span>
                    </a>
                </li>

                <li class="@yield('email_active')">
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="mail"></i>
                        <span data-key="t-ecommerce">Email</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">

                            <li><a class="@yield('email_index_active')" href="{{ route('employee.email.index') }}"> <i data-feather="corner-down-right"></i>Inbox</a></li>
                    </ul>
                </li>


            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
