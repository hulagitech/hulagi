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

                <a href="{{ url('/account/dashboard') }}" class="logo">
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
                                <a class="dropdown-item" href="{{ route('account.profile') }}"><i
                                        class="dripicons-user text-muted"></i>
                                    Profile</a>
                                

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ url('/account/logout') }}"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                                        class="dripicons-exit text-muted"></i>
                                    Logout</a>
                                <form id="logout-form" action="{{ url('/account/logout') }}" method="POST"
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

                <div class="clearfix"></div>

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
                            <a href="{{ route('account.dashboard') }}"><i class="dripicons-home"></i>
                                Dashboard</a>
                        </li>
                        <li class="has-submenu">
                            <a href="#"><i class="mdi mdi-book-outline"></i> Statement
                                <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                            <ul class="submenu">
                                <li class="has-submenu">
                                    <a href="#">User </a>
                                    <ul class="submenu">
                                        <li><a href="{{ route('account.ride.statement.user') }}">Requested</a></li>
                                        <li><a href="{{ route('account.ride.allrequested') }}">Total Requested</a></li>
                                        <li><a href="{{ route('account.ride.allNagative') }}">Negative Wallet</a></li>

                                    </ul>
                                </li>

                                <li class="has-submenu">
                                    <a href="#">Rider </a>
                                    <ul class="submenu">
                                        <li><a href="{{ route('account.activeProvider') }}">Active Partner</a></li>
                                        <li><a href="{{ route('account.ride.statement.provider') }}">Approved</a></li>
                                        <li><a href="{{ route('account.bannedStatement') }}">Banned</a></li>
                                        <li><a href="{{url('account/rider/settled')}}">Settled</a></li>
                                        <li><a href="{{route('account.minizone.track') }}">Track Rider</a></li>

                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="has-submenu">
                            <a href="#"><i class="dripicons-suitcase"></i> Payment History
                                <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                            <ul class="submenu">


                                <li class="has-submenu">
                                    <a href="#">Uploaded bills </a>
                                    <ul class="submenu">
                                        <li><a href="{{ route('account.ride.bill.unverified') }}"> Unverified Bill </a>
                                        </li>
                                        <li><a href="{{ route('account.ride.bill') }}"> Verified Bill </a></li>

                                    </ul>
                                </li>
                                <li>
                                    <a href="{{ route('account.esewa') }}">E-sewa </a>

                                </li>
                            </ul>
                        </li>
                        <li class="has-submenu">
                            <a href="#"><i class="dripicons-suitcase"></i> All Orders
                                <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                            <ul class="submenu">
                                <li>
                                    <a href="{{ route('account.dateSearch') }}">All orders </a>

                                </li>

                                <li class="has-submenu">
                                    <a href="#">Completed Orders </a>
                                    <ul class="submenu">
                                        <li><a href="{{ route('account.rider.completed') }}">Rider Wise</a></li>
                                        <li><a href="{{ route('account.vendor.completed') }}">Vendor Wise</a></li>

                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="has-submenu">
                            <a href="#"><i class="mdi mdi-book-outline"></i> Invoice
                                <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                            <ul class="submenu">
                                <li><a href="{{ route('account.userInvoice') }}">User </a></li>
                                <li><a href="{{ route('account.riderInvoice') }}">Rider </a></li>

                                <li class="has-submenu">
                                    <a href="#">Wallet </a>
                                    <ul class="submenu">
                                        <li><a href="{{ route('account.user.user') }}"
                                                class="waves-effect  waves-light">
                                                <span class="s-icon"><i class="fa fa-user"></i></span>
                                                <span class="s-text">User wallet</span>
                                            </a>
                                        </li>
                                        <li><a href="{{ route('account.providers.providerwallet') }}"><i
                                                    class="fa fa-motorcycle"></i> Provider Wallet</a></li>
                                        <li><a href="{{url('account/payableUserAndVendor') }}"> <i
                                                    class="fa fa-plane"></i> Amount Data </a></li>

                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="has-submenu">
                            <a href="{{ route('account.bank_infos') }}"><i class="mdi mdi-bank"></i>
                                Update Bank</a>
                        </li>

                        <li class="has-submenu">
                            <a href="#"><i class="mdi mdi-ticket-confirmation"></i>Tickets<i
                                    class="mdi mdi-chevron-down mdi-drop"></i></a>
                            <ul class="submenu megamenu">
                                <li>
                                    <ul>
                                        <li><a href="{{ route('account.opentickets') }}">All Tickets</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="has-submenu">
                            <a href="{{ route('account.unsolve_comments') }}"><i
                                    class="mdi mdi-comment-multiple-outline"></i>
                                Comment</a>
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