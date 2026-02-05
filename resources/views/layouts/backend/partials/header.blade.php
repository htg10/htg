 <!--[ Main Header ] start -->
 <header id="page-topbar">
     <div class="navbar-header">
         <div class="d-flex">

             <!--[ Logo ] start -->
             <div class="navbar-brand-box">
                 <a href="" class="logo logo-light">
                     <span class="logo-sm">
                         <!-- Add your small logo -->
                         <img src="{{ asset('assets/images/logo/htg_logo.png') }}" alt="Small Logo" height="32">
                     </span>
                     <span class="logo-lg">
                         <!-- Add your large logo -->
                         <img src="{{ asset('assets/images/logo/htg_logo.png') }}" alt="Large Logo" height="50">
                     </span>
                 </a>
             </div>

             <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect"
                 id="vertical-menu-btn">
                 <i class="fa fa-fw fa-bars"></i>
             </button>


         </div>

         <div class="d-flex">
             <div class="dropdown d-none d-lg-inline-block ms-1">
                 <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                     <i class="bx bx-fullscreen"></i>
                 </button>
             </div>
             <div class="dropdown d-inline-block">
                 <button type="button" class="btn header-item noti-icon waves-effect"
                     id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                     aria-expanded="false">
                     <i class="bx bx-bell bx-tada"></i>
                     {{-- @if (Auth()->user()->unreadnotifications != null)
                         <span class="badge bg-danger rounded-pill">{{ notification() }}</span>
                     @else
                         <span class="badge bg-danger rounded-pill"></span>
                     @endif --}}
                 </button>
                 <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                     aria-labelledby="page-header-notifications-dropdown">
                     <div class="p-3">
                         <div class="row align-items-center">
                             <div class="col">
                                 <h6 class="m-0" key="t-notifications"> Notifications </h6>
                             </div>
                             <div class="col-auto">
                                 <a href="javascript:void(0);" class="small" key="t-view-all"></a>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>

             <div class="dropdown d-inline-block">
                 <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                     data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <img class="rounded-circle header-profile-user" src="{{ asset('assets/admin/images/avatar.png') }}"
                         alt="Header Avatar">
                     <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ Auth::user()->name }}</span>
                     <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                 </button>
                 <div class="dropdown-menu dropdown-menu-end">
                     <!-- item-->
                     <div class="dropdown-divider"></div>
                     <a class="dropdown-item text-danger" href="{{ url('admin/logout') }}"><i
                             class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span
                             key="t-logout">Logout</span></a>
                 </div>
             </div>
         </div>
     </div>
 </header>
