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

                <a href="{{ url('dashboard') }}" class="logo">
                    <img src="{{ url(Setting::get('white_site_logo', asset('logo-black.png'))) }}" alt="" height="26">
                </a>

                <!-- End Logo-->

                <div class="menu-extras  topbar-custom navbar p-0">
                    <ul class="list-inline d-none d-lg-block  mb-0">
                        <li class="list-inline-item dropdown notification-list">
                            <a class="nav-link dropdown-toggle arrow-none waves-effect" href="{{ url('new_trips') }}"
                                role="button" aria-haspopup="false" aria-expanded="false">
                                Place New Order <i class="mdi mdi-plus"></i>
                            </a>
                            <!-- <div class="dropdown-menu dropdown-menu-animated">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Separated link</a>
                                </div> -->
                        </li>
                        <li class="list-inline-item notification-list">
                            <a href="{{ url('/ticket/create') }}" class="nav-link waves-effect">
                                Add new Ticket
                            </a>
                        </li>

                    </ul>


                    <!-- Search input -->
                    <div class="d-none search-wrap" id="search-wrap">
                        <div class="search-bar">
                            <input class="search-input" type="search" placeholder="Search" />
                            <a href="#" class="close-search toggle-search" data-target="#search-wrap">
                                <i class="mdi mdi-close-circle"></i>
                            </a>
                        </div>
                    </div>

                    <ul class="list-inline ml-auto mb-0">

                        <!-- notification-->

                        <!-- <li class="list-inline-item dropdown notification-list">
                                <a class="nav-link waves-effect toggle-search" href="#" data-target="#search-wrap">
                                    <i class="mdi mdi-magnify noti-icon"></i>
                                </a>
                            </li> -->

                        <li class="list-inline-item dropdown notification-list  ">

                            <a class="nav-link dropdown-toggle arrow-none waves-effect pr-1 pl-1" data-toggle="dropdown"
                                href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="mdi mdi-plus noti-icon d-sm-none d-inline"></i>

                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown">
                                <!-- item-->
                                <a class="dropdown-item" href="{{ url('new_trips') }}"><i
                                        class="mdi mdi-plus-one text-muted"></i>
                                    Place New Order </a>
                                <a class="dropdown-item" href="{{ url('/ticket/create') }}"><i
                                        class="mdi mdi-table-column-plus-after"></i>
                                    Add New Ticket</a>

                            </div>
                        </li>
                        <!-- <li class="list-inline-item dropdown notification-list"><a href="{{ url('/wallet') }}"
                            style="color: white;"> My Wallet : {{ currency($user_wallet) }}</a></li> -->
                        <li class="list-inline-item dropdown notification-list pr-1 d-sm-inline d-none "><a
                                href="{{ url('/wallet') }}" style="color: white;"> My wallet : {{ currency($user_wallet)
                                }}</a>
                        </li>

                        <li class="list-inline-item dropdown notification-list noti-button noti-icon">
                            <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#"
                                role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="mdi mdi-bell-outline noti-icon"></i>
                                @if (count(auth()->user()->unreadNotifications) > 0)
                                <span class="badge badge-pill noti-icon-badge noti-count">{{
                                    count(auth()->user()->unreadNotifications) }}</span>
                                @else
                                <span class="badge badge-pill noti-icon-badge"></span>
                                @endif
                            </a>
                            <div
                                class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg dropdown-menu-animated">
                                <!-- item-->
                                <div class="dropdown-item noti-title">
                                    <h5>Notification
                                        <span class="noti-count">({{ count(auth()->user()->unreadNotifications) > 0 ?
                                            count(auth()->user()->unreadNotifications) : 0 }})</span>
                                    </h5>
                                </div>

                                <div class="slimscroll-noti">
                                    <!-- item-->



                                </div>


                                <!-- All-->
                                <a href="{{ url('notice') }}" class="dropdown-item notify-all">
                                    View All
                                </a>

                            </div>
                        </li>


                        <!-- User-->
                        <li class="list-inline-item dropdown notification-list nav-user">

                            <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#"
                                role="button" aria-haspopup="false" aria-expanded="false">
                                @if(Auth::user()->picture)
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
                                <img src="{{ asset('asset/img/dummy.png') }}" alt="user" class="rounded-circle"
                                    style="border-style: solid; color:red">
                                @endif
                                <span class="d-none d-md-inline-block ml-1">{{ Auth::user()->first_name }} <i
                                        class="mdi mdi-chevron-down"></i> </span>
                                @endif

                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown">
                                <a class="dropdown-item" href="{{ url('profile') }}"><i
                                        class="dripicons-user text-muted"></i>
                                    Profile</a>
                                <a class="dropdown-item" href="{{ url('/wallet') }}"><i
                                        class="ti-wallet user-sidebaricon"></i> My
                                    Wallet</a>
                                {{-- <a class="dropdown-item" href="#"><span
                                        class="badge badge-success float-right m-t-5">5</span><i
                                        class="dripicons-gear text-muted"></i> Settings</a>
                                <a class="dropdown-item" href="#"><i class="dripicons-lock text-muted"></i> Lock
                                    screen</a> --}}
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ url('/logout') }}"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                                        class="dripicons-exit text-muted"></i>
                                    Logout</a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST"
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
                            <a href="{{ url('dashboard') }}"><i class="dripicons-home"></i>
                                @lang('user.dashboard')</a>
                        </li>
                        <li class="has-submenu">
                            <a href="#"><i class="dripicons-suitcase"></i>New Orders<i
                                    class="mdi mdi-chevron-down mdi-drop"></i></a>
                            <ul class="submenu megamenu">
                                <li>
                                    <ul>
                                        <li><a href="{{ url('new_trips') }}">Place New Order</a></li>
                                        <li><a href="{{ url('multiTrips') }}">Bulk Order</a></li>

                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="has-submenu">
                            <a href="#"><i class="dripicons-suitcase"></i>My Orders<i
                                    class="mdi mdi-chevron-down mdi-drop"></i></a>
                            <ul class="submenu megamenu">
                                <li>
                                    <ul>
                                        <li><a href="{{ url('searchOrder') }}">Search Orders</a></li>
                                        <li><a href="{{ url('mytrips') }}">Recent Orders</a></li>
                                        <li><a href="{{ url('trip/pending') }}">Pending Order</a></li>
                                        <li><a href="{{ url('trip/processing') }}">Processing Order</a></li>
                                        <li><a href="{{ url('trip/schedule') }}">@lang('user.upcoming_rides')</a>
                                        <li><a href="{{ url('trip/complete') }}">Completed Order</a></li>
                                        <li><a href="{{ url('trip/reject') }}">Rejected Order</a></li>
                                        <li><a href="{{ url('trip/cancel') }}">Cancelled Order</a></li>
                                        <li><a href="{{ url('trip/returned') }}" }}>Returned Order</a></li>
                                        <li><a href="{{ url('trip/return') }}">Return Remaining </a></li>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    </li>
                    <li class="has-submenu">
                        <a href="{{ url('/trips/map') }}"><i class="ti-location-pin user-sidebaricon"></i>
                            Live Map</a>
                    </li>

                    <li class="has-submenu">
                        <a href="#"><i class="fa fa-comment user-sidebaricon"></i> Comment <span
                                class="badge badge-danger comment-count"
                                style="position: relative; bottom:12px;">{{Auth::user()->unreadComments(Auth::user()->id)}}</span>
                            <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                        <ul class="submenu megamenu">
                            <li>
                                <ul>
                                    <li><a href="{{ url('/comments') }}">Open Comment</a></li>
                                    <li><a href="{{ url('/all_comments') }}">Close Comment</a></li>

                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a href="{{ url('/ticket') }}"><i class="ti-ticket user-sidebaricon"></i>
                            Ticket
                            <span class="badge badge-danger"
                                style="position: relative; bottom:12px;">{{Auth::user()->openTicket()}}</span>
                        </a>
                    </li>
                    <li class="has-submenu">
                        <a href="#"><i class="fab fa-cc-amazon-pay"></i> Payment History <i
                                class="mdi mdi-chevron-down mdi-drop"></i></a>
                        <ul class="submenu megamenu">
                            <li>
                                <ul>
                                    <li><a href="{{ url('/payment_history') }}">Request Payment History</a></li>
                                    <li><a href="{{url('/esewa')}}">Esewa Payment History</a></li>
                                    <!-- <li><a href="{{url('/khalti')}}">Khalti Payment History</a></li> -->
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a href="#"><i class="far fa-address-card"></i> Resources <i
                                class="mdi mdi-chevron-down mdi-drop"></i></a>
                        <ul class="submenu megamenu">
                            <li>
                                <ul>
                                    <li><a href="{{ url('/office') }}">Office Contacts</a></li>
                                    <li><a href="{{ url('/resource') }}">Branch Contacts</a></li>
                                    <!-- <li><a href="{{ url('/national') }}">National Location</a></li>
                                    <li><a href="{{url('internationalquote')}}" target="_blank"  >International Location</a></li> -->
                                    <li><a href="{{url('fare')}}">Fare Plan List</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
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