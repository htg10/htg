<!--[ Left Sidebar Navigation ] start -->
<div class="vertical-menu ">
    <div data-simplebar class="h-100">

        <!--[ Sidemenu ] start -->
        <div id="sidebar-menu">

            <!--[ Left Menu ] start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li>
                    {{-- <a href="{{ auth()->user()->role_id == 1 ? route('admin.dashboard') : route('user.dashboard') }}"
                        class="waves-effect"> --}}
                    <a href="{{ auth()->user()->role_id == 1 ? route('admin.dashboard') : (auth()->user()->role_id == 2 ? route('user.dashboard') : route('telecaller.dashboard')) }}"
                        class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @if (auth()->user()->role_id == 1)
                    <!-- Admin-only Product link -->
                    <li class="nav-item">
                        <a href="{{ route('bank.index') }}" class="nav-link">
                            <i class="fas fa-university"></i>
                            <span>Banks</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('expense.index') }}" class="nav-link">
                            <i class="fas fa-wallet"></i>
                            <span>Expense</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/users" class="waves-effect">
                            <i class="bx bx-user"></i>
                            <span key="t-chat">All Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/telecaller/addnew" class="waves-effect">
                            <i class="bx bx-support"></i>
                            <span key="t-chat">Add New Telecaller</span>
                        </a>
                    </li>
                    <li>
                        <a href="/addnew" class="waves-effect">
                            <i class="bx bx-user-plus"></i>
                            <span key="t-chat">Add New Contract</span>
                        </a>
                    </li>
                    <li>
                        <a href="/renew" class="waves-effect">
                            <i class="bx bx-reset"></i>
                            <span key="t-chat">Renew Contract</span>
                        </a>
                    </li>
                    <li>
                        <a href="/index" class="waves-effect">
                            <i class="bx bx-list-ul"></i>
                            <span key="t-chat">All Contracts</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('leads') }}" class="waves-effect">
                            <i class="bx bx-phone-call"></i>
                            <span>All Assigned Leads</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/lead/create" class="waves-effect">
                            <i class="bx bx-user-plus"></i>
                            <span key="t-chat">Add New Lead</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/lead/index" class="waves-effect">
                            <i class="bx bx-list-ul"></i>
                            <span key="t-chat">All Leads</span>
                        </a>
                    </li>
                @elseif (auth()->user()->role_id == 2)
                    <li>
                        <a href="{{ route('user.leads') }}" class="waves-effect">
                            <i class="bx bx-phone-call"></i>
                            <span>Assigned Leads</span>
                        </a>
                    </li>
                    <li>
                        <a href="/user/addnew" class="waves-effect">
                            <i class="bx bx-user-plus"></i>
                            <span key="t-chat">Add New Contract</span>
                        </a>
                    </li>
                    <li>
                        <a href="/user/renew" class="waves-effect">
                            <i class="bx bx-reset"></i>
                            <span key="t-chat">Renew Contract</span>
                        </a>
                    </li>
                    <li>
                        <a href="/user/index" class="waves-effect">
                            <i class="bx bx-list-ul"></i>
                            <span key="t-chat">All Contracts</span>
                        </a>
                    </li>
                @elseif (auth()->user()->role_id == 3)
                    {{-- Telecaller  --}}
                    <li>
                        <a href="/telecaller/create" class="waves-effect">
                            <i class="bx bx-user-plus"></i>
                            <span key="t-chat">Add New Lead</span>
                        </a>
                    </li>
                    <li>
                        <a href="/telecaller/index" class="waves-effect">
                            <i class="bx bx-list-ul"></i>
                            <span key="t-chat">All Leads</span>
                        </a>
                    </li>
                @endif
            </ul>

        </div>
    </div>
</div>
