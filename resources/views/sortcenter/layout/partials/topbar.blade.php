<style>
    .notification-dropdown {
        width: 500px !important;
    }

</style>

<div class="header-bg">
    <!-- Navigation Bar-->
    <header id="topnav">

        <div class="topbar-main">
            <div class="container-fluid" >


                <!-- Logo-->

                <a href="{{ url('/sortcenter/dashboard') }}" class="logo">
                    <img src="{{ url(Setting::get('white_site_logo', asset('logo-black.png'))) }}" alt="" height="26" >
                </a>

                <!-- End Logo-->

                <div class="menu-extras  topbar-custom navbar p-0">
                    <ul class="list-inline ml-auto mb-0">
                        <!-- User-->
                        <li class="list-inline-item dropdown notification-list nav-user">

                            <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#"
                                role="button" aria-haspopup="false" aria-expanded="false">
                                {{-- @if (Auth::user()->picture)
                                    @if (Auth::user()->Agreement == 'YES')
                                        
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
                                @endif --}}
                                <img src="{{ asset('asset/img/dummy.png') }}" alt="user"
                                            class="rounded-circle" style="border-style: solid; color:red">

                            </a>

                           
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown">
                                <a class="dropdown-item" href="{{ route('sortcenter.profile') }}"><i
                                        class="dripicons-user text-muted"></i>
                                    Profile</a>
                                {{-- <a class="dropdown-item" href="{{ route('pickup.password') }}"><i
                                        class="dripicons-lock text-muted"></i>
                                    Change Password</a> --}}

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ url('sortcenter/logout') }}"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                                        class="dripicons-exit text-muted"></i>
                                    Logout</a>
                                <form id="logout-form" action="{{ url('sortcenter/logout') }}" method="POST"
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
                            <a href="{{ route('sortcenter.dashboard') }}"><i class="dripicons-home"></i>
                                Dashboard</a>
                        </li>
                        <li class="has-submenu">
                            <a href="{{ route('sortcenter.rider') }}">
                                <i class="mdi mdi-bike"></i>
                                Rider</a>
                        </li>
                        <!-- <li class="has-submenu">
                            <a href="{{ route('pickup.user.index') }}"><i class="dripicons-home"></i>
                                User</a>
                        </li> -->

                        <li class="has-submenu">
                            <a href="#"><i class="dripicons-suitcase"></i>Order Inbound<i
                                    class="mdi mdi-chevron-down mdi-drop"></i></a>
                            <ul class="submenu megamenu">
                                <li>
                                    <ul>
                                    <li><a href="{{ route('sortcenter.inbound') }}">Print Invoice</a></li>
                                    <li><a href="{{ route('sortcenter.bulk_inbound') }}">Bulk Inbound</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="has-submenu">
                            <a href="{{ route('sortcenter.outbound') }}"><i class="fas fa-briefcase"></i>
                                Outbound Orders </a>
                        </li>
                        <li class="has-submenu">
                            <a href="#"><i class="dripicons-suitcase"></i>All Order<i
                                    class="mdi mdi-chevron-down mdi-drop"></i></a>
                            <ul class="submenu megamenu">
                                <li>
                                    <ul>
                                    <li><a href="{{ route('sortcenter.dateSearch') }}">Order By Date</a></li>
                                     <li><a href="{{ route('sortcenter.inside_valley') }}">Inside Valley</a></li>
                                     <li><a href="{{ url('sortcenter/ktmdeliveryreamining') }}">Ktm Delivering Remaining</a></li>
                                     <li><a href="{{ url('sortcenter/inbound') }}">Search Inbound Order</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="has-submenu">
                            <a href="#"><i class="mdi mdi-ticket-confirmation"></i>Tickets<i
                                    class="mdi mdi-chevron-down mdi-drop"></i></a>
                            <ul class="submenu megamenu">
                                <li>
                                    <ul>
                                    <li><a href="{{ route('sortcenter.newticket') }}">New Tickets</a></li>
                                    <li><a href="{{ route('sortcenter.opentickets') }}">Sortcenter Tickets</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="has-submenu">
                            <a href="{{ url('/sortcenter/sortcenterUnsolveComment') }}"><i class="fas fa-comment"></i>
                                Sortcenter Comment</a>
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
