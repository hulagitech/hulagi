<style>
    .notification-dropdown {
        width: 500px !important;
    }

</style>

<div class="header-bg">
    <!-- Navigation Bar-->
    <header id="topnav">

        <div class="topbar-main">
            <div class="container-fluid">


                <!-- Logo-->

                <a href="{{ url('/pickup/dashboard') }}" class="logo">
                    <img src="{{ url(Setting::get('white_site_logo', asset('logo-black.png'))) }}" alt="" height="26">
                </a>

                <!-- End Logo-->

                <div class="menu-extras  topbar-custom navbar p-0">
                    <ul class="list-inline ml-auto mb-0">
                        <!-- User-->
                        <li class="list-inline-item dropdown notification-list nav-user">

                            <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#"
                                role="button" aria-haspopup="false" aria-expanded="false">
                                @if (Auth::user()->picture)
                                    @if (Auth::user()->Agreement == 'YES')
                                        <img src=" {{ asset('storage/' . Auth::user()->picture) }}" alt="user"
                                            style="border-style: solid; color:Green;" class="rounded-circle ">
                                    @else
                                        <img src=" {{ asset('storage/' . Auth::user()->picture) }}" alt="user"
                                            class="rounded-circle" style="border-style: solid; color:red">
                                    @endif
                                    <span class="d-none d-md-inline-block ml-1">{{ Auth::user()->first_name }} <i
                                            class="mdi mdi-chevron-down"></i> </span>
                                @else
                                    @if (Auth::user()->Agreement == 'YES')
                                        <img src="{{ asset('asset/images/dummy.png') }}" alt="user"
                                            style="border-style: solid; color:Green;" class="rounded-circle ">
                                    @else
                                        <img src="{{ asset('asset/img/dummy.png') }}" alt="user"
                                            class="rounded-circle" style="border-style: solid; color:red">
                                    @endif
                                    <span class="d-none d-md-inline-block ml-1">{{ Auth::user()->first_name }} <i
                                            class="mdi mdi-chevron-down"></i> </span>
                                @endif

                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown">
                                <a class="dropdown-item" href="{{ route('pickup.profile') }}"><i
                                        class="dripicons-user text-muted"></i>
                                    Profile</a>
                                <!-- <a class="dropdown-item" href="{{ route('pickup.password') }}"><i
                                        class="dripicons-lock text-muted"></i>
                                    Change Password</a> -->

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ url('pickup/logout') }}"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                                        class="dripicons-exit text-muted"></i>
                                    Logout</a>
                                <form id="logout-form" action="{{ url('pickup/logout') }}" method="POST"
                                    style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                        <li class="menu-item list-inline-item">
                            <!-- Mobile menu toggle-->
                            <a class="navbar-toggle nav-link">
                                <div class="lines">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </a>
                            <!-- End mobile menu toggle-->
                        </li>
                    </ul>
                </div>
                <!-- end menu-extras -->


            </div> <!-- end container -->
        </div>
        <!-- end topbar-main -->

        <!-- MENU Start -->
        <div class="navbar-custom">
            <div class="container-fluid">

                <div id="navigation">

                    <!-- Navigation Menu-->
                    <ul class="navigation-menu">

                        <li class="has-submenu">
                            <a href="{{ route('pickup.dashboard') }}"><i class="dripicons-home"></i>
                                Dashboard</a>
                        </li>
                        <li class="has-submenu">
                            <a href="{{ route('pickup.rider.index') }}"><i class="mdi mdi-bike"></i>
                                Rider</a>
                        </li>
                        <li class="has-submenu">
                            <a href="#"><i class="dripicons-user"></i>
                                User</a>
                                <ul class="submenu megamenu">
                                <li>
                                    <ul>
                                        <li><a href="{{ route('pickup.user.index') }}">User</a></li>
                                        <li><a href="{{ route('pickup.user.create') }}">Add New User</a></li>

                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="has-submenu">
                            <a href="#"><i class="dripicons-suitcase"></i>Order Assign<i
                                    class="mdi mdi-chevron-down mdi-drop"></i></a>
                            <ul class="submenu megamenu">
                                <li>
                                    <ul>
                                        <li><a href="{{ route('pickup.orders.bulkassign') }}">Bulk Assign</a></li>
                                        <li><a href="{{ route('pickup.map.view') }}">Live Orders Map</a></li>
                                        <li><a href="{{ route('pickup.remaining') }}">Pickup Remaining</a></li>

                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="has-submenu">
                            <a href="{{ route('pickup.dateSearch') }}"><i class="mdi mdi-briefcase-search"></i>
                                Orders By Date</a>
                        </li>
                        <li class="has-submenu">
                            <a href="#"><i class="mdi mdi-ticket-confirmation"></i>Tickets<i
                                    class="mdi mdi-chevron-down mdi-drop"></i></a>
                            <ul class="submenu megamenu">
                                <li>
                                    <ul>
                                        <li><a href="{{ route('pickup.newticket') }}">New Tickets</a></li>
                                        <li><a href="{{ route('pickup.opentickets') }}">Pickup Tickets</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="has-submenu">
                            <a href="{{ url('/pickup/pickupUnsolveComment') }}"><i class="mdi mdi-comment-account"></i>
                                Pickup Comment</a>
                        </li>


                    </ul>

                    <!-- <li class="has-submenu">
                        <a href="#"><i class="ti-list user-sidebaricon"></i>
                           Resources</a>
                           <ul>
                               <li>Branch Contacts
                               </li>
                           </ul>
                        </li> -->
                    <!-- <li class="has-submenu">
                                <a href="{{ url('/wallet') }}"><i class="ti-wallet user-sidebaricon"></i>
                                    @lang('user.my_wallet')</a>
                            </li>
                            <li class="has-submenu">
                                <a href="{{ url('/promotions') }}"><i class="ti-bookmark-alt"></i>
                                    @lang('user.promocode')</a>
                            </li> -->


                    <!-- </ul> -->


                </div>
            </div>
        </div> <!-- end navbar-custom -->

    </header>

    <!-- End Navigation Bar-->

</div>
