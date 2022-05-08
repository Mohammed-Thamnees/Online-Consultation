<!--- Sidemenu -->
<div id="sidebar-menu">
    <!-- Left Menu Start -->
    <ul class="metismenu list-unstyled" id="side-menu">
        <li class="menu-title" key="t-menu">Menu</li>

        <li>
            <a href="{{ route('home') }}" class="waves-effect">
                <i class="bx bx-home-circle"></i><span class="badge rounded-pill bg-info float-end"></span>
                <span key="t-dashboards">Dashboards</span>
            </a>
        </li>

        <li class="menu-title" key="t-apps">Appointments Section</li>

        @canany('appointment_today','appointment_new','appointment_history','appointment_create')
        <li>
            <a href="javascript: void(0);">
                <i class="fas fa-address-book"></i>
                <span key="t-layouts">Appointments</span>
                <span class="fas fa-arrow-circle-down"></span>
            </a>
            <ul class="sub-menu" aria-expanded="true">
                @can('appointment_today')
                <li>
                    <a href="{{ route('appointments.today') }}" key="t-vertical">Today's Appointments</a>
                </li>
                @endcan
                @can('appointment_new')
                <li>
                    <a href="{{ route('appointment.index') }}" key="t-vertical">New Appointments</a>
                </li>
                @endcan
                @can('appointment_history')
                <li>
                    <a href="{{ route('appointments.history') }}" key="t-vertical">Appointments History</a>
                </li>
                @endcan
                @can('appointment_create')
                <li>
                    <a href="{{ route('appointment.create') }}" key="t-vertical">Add Appointment</a>
                </li>
                @endcan
            </ul>
        </li>
        @endcanany

        <li class="menu-title" key="t-apps">Doctors Section</li>

        @can('category_list')
        <li>
            <a href="{{ route('category.index') }}" class="waves-effect">
                <i class="fas fa-sitemap"></i>
                <span key="t-chat">Category</span>
            </a>
        </li>
        @endcan
        @canany('doctor_list','doctor_create')
        <li>
            <a href="javascript: void(0);">
                <i class="fas fa-plus-square"></i>
                <span key="t-layouts">Doctors</span>
                <span class="fas fa-arrow-circle-down"></span>
            </a>
            <ul class="sub-menu" aria-expanded="true">
                @can('doctor_list')
                <li>
                    <a href="{{ route('doctor.index') }}" key="t-vertical">Doctors List</a>
                </li>
                @endcan
                @can('doctor_create')
                <li>
                    <a href="{{ route('doctor.create') }}" key="t-vertical">Add Doctors</a>
                </li>
                @endcan
            </ul>
        </li>
        @endcanany
        
        @canany('doctor_availability_list','doctor_availability_create')
        <li>
            <a href="javascript: void(0);">
                <i class="fas fa-clipboard-list"></i>
                <span key="t-layouts">Doctors Availability</span>
                <span class="fas fa-arrow-circle-down"></span>
            </a>
            <ul class="sub-menu" aria-expanded="true">
                @can('doctor_availability_list')
                <li>
                    <a href="{{ route('availability.index') }}" key="t-vertical">Doctors Availability List</a>
                </li>
                @endcan
                @can('doctor_availability_create')
                <li>
                    <a href="{{ route('availability.create') }}" key="t-vertical">Add Doctors Availability</a>
                </li>
                @endcan
            </ul>
        </li>
        @endcanany

        <li class="menu-title" key="t-apps">Medicine Section</li>

        @can('medicine_type_list')
        <li>
            <a href="{{ route('medicinetype.index') }}" class="waves-effect">
                <i class="fas fa-sitemap"></i>
                <span key="t-chat">Medicine Type</span>
            </a>
        </li>
        @endcan
        @canany('medicine_list','medicine_create')
        <li>
            <a href="javascript: void(0);">
                <i class="fas fa-tablets"></i>
                <span key="t-layouts">Medicines</span>
                <span class="fas fa-arrow-circle-down"></span>
            </a>
            <ul class="sub-menu" aria-expanded="true">
                @can('medicine_list')
                <li>
                    <a href="{{ route('medicine.index') }}" key="t-vertical">Medicines List</a>
                </li>
                @endcan
                @can('medicine_create')
                <li>
                    <a href="{{ route('medicine.create') }}" key="t-vertical">Add Medicines</a>
                </li>
                @endcan
            </ul>
        </li>
        @endcanany

        <li class="menu-title" key="t-apps">General Options</li>

        @canany('leave_type_list','leave_define_list','leave_approve','leave_pending')
        <li>
            <a href="javascript: void(0);">
                <i class="fas fa-bed"></i>
                <span key="t-layouts">Leave Manage</span>
                <span class="fas fa-arrow-circle-down"></span>
            </a>
                
            <ul class="sub-menu" aria-expanded="true">
                @can('leave_type_list')
                <li>
                    <a href="{{ route('leave.index') }}" key="t-vertical"> Leave Type</a>
                </li>
                @endcan
                @can('leave_define_list')
                <li>
                    <a href="{{ route('leavedefine.index') }}" key="t-vertical"> Leave Define</a>
                </li>
                @endcan
                @can('leave_approve')
                <li>
                    <a href="{{ route('leaveapprove.index') }}" key="t-vertical">Approve Leave Request</a>
                </li>
                @endcan
                @can('leave_pending')
                <li>
                    <a href="{{ route('pendingleaves.index') }}" key="t-vertical">Pending Leave</a>
                </li>
                @endcan
            </ul>
        </li>
        @endcanany

        @canany('banner_list','banner_create')
        <li>
            <a href="javascript: void(0);">
                <i class="fas fa-image"></i>
                <span key="t-layouts">Banners</span>
                <span class="fas fa-arrow-circle-down"></span>
            </a>
            <ul class="sub-menu" aria-expanded="true">
                @can('banner_list')
                <li>
                    <a href="{{ route('banners.index') }}" key="t-vertical">Banner List</a>
                </li>
                @endcan
                @can('banner_create')
                <li>
                    <a href="{{ route('banners.create') }}" key="t-vertical">Add Banners</a>
                </li>
                @endcan
            </ul>
        </li>
        @endcanany
        @canany('story_list','story_create')
        <li>
            <a href="javascript: void(0);">
                <i class="fas fa-icons"></i>
                <span key="t-layouts">Stories</span>
                <span class="fas fa-arrow-circle-down"></span>
            </a>
            <ul class="sub-menu" aria-expanded="true">
                @can('story_list')
                <li>
                    <a href="{{ route('story.index') }}" key="t-vertical">Stories List</a>
                </li>
                @endcan
                @can('story_create')
                <li>
                    <a href="{{ route('story.create') }}" key="t-vertical">Add Stories</a>
                </li>
                @endcan
            </ul>
        </li>
        @endcanany
        
        @can('chat')
        <li>
            <a href="{{ route('chatify') }}">
                <i class="fab fa-rocketchat"></i>
                <span key="t-layouts">Chat</span>
            </a>
        </li>
        @endcan

        @can('ticket_list')
        <li>
            <a href="{{ route('complaint.index') }}">
                <i class="fas fa-headset"></i>
                <span key="t-layouts">Tickets</span>
            </a>
        </li>
        @endcan

        <li class="menu-title" key="t-apps">User Management</li>

        @canany('role_list','permission_assign')
        <li>
            <a href="javascript: void(0);">
                <i class="fas fa-user-shield"></i>
                <span key="t-layouts">Roles & Permissions</span>
                <span class="fas fa-arrow-circle-down"></span>
            </a>
            <ul class="sub-menu" aria-expanded="true">
                @can('role_list')
                <li>
                    <a href="{{ route('roles.index') }}" key="t-vertical">Roles</a>
                </li>
                @endcan
                @can('permission_assign')
                <li>
                    <a href="{{ route('role.lists') }}" key="t-vertical">Assign Permission</a>
                </li>
                @endcan
            </ul>
        </li>
        @endcanany

        @can('user_list')
        <li>
            <a href="{{ route('users.index') }}" class="waves-effect">
                <i class="fa fa-users"></i>
                <span key="t-chat">Users</span>
            </a>
        </li>
        @endcan

        <li class="menu-title" key="t-apps">Settings</li>

        @can('web_settings')
        <li>
            <a href="javascript: void(0);">
                <i class="fas fa-cogs"></i>
                <span key="t-layouts">Web Settings</span>
                <span class="fas fa-arrow-circle-down"></span>
            </a>
            <ul class="sub-menu" aria-expanded="true">
                <li>
                    <a href="{{ route('settings.index') }}" key="t-vertical">General</a>
                </li>
                <li>
                    <a href="{{ route('settings.smtp') }}" key="t-vertical">Mail Config</a>
                </li>
                <li>
                    <a href="{{ route('settings.sms') }}" key="t-vertical">SMS Config</a>
                </li>
            </ul>
        </li>
        @endcan

    </ul>
</div>
<!-- Sidebar -->