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

                <a href="{{ url('/return/dashboard') }}" class="logo">
                    <img src="{{ url(Setting::get('site_logo', asset('logo-black.png'))) }}" alt="" height="26">
                </a>

                <!-- End Logo-->

                <div class="menu-extras  topbar-custom navbar p-0">
                    <ul class="list-inline ml-auto mb-0">
                        <!-- User-->
                        <li class="list-inline-item dropdown notification-list nav-user">

                            <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#"
                                role="button" aria-haspopup="false" aria-expanded="false">
                                <img src="{{ asset('asset/img/dummy.png') }}" alt="user" class="rounded-circle"
                                style="border-style: solid; color:red">
                                <span class="d-none d-md-inline-block ml-1">{{ Auth::user()->first_name }} <i
                                        class="mdi mdi-chevron-down"></i> </span>

                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown">
                                <a class="dropdown-item" href="{{ route('return.profile') }}"><i
                                        class="dripicons-user text-muted"></i>
                                    Profile</a>


                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ url('/return/logout') }}"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                                        class="dripicons-exit text-muted"></i>
                                    Logout</a>
                                <form id="logout-form" action="{{ url('/return/logout') }}" method="POST"
                                    style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
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
                            <a href="{{ route('return.dashboard') }}"><i class="dripicons-home"></i>
                                Dashboard</a>
                        </li>
                        <li class="has-submenu">
                            <a href="#"><i class="fa fa-motorcycle"></i>
                                Rider</a>
                            <ul class="submenu megamenu">
                                <li>
                                    <ul>
                                        <li><a href="{{ route('return.inside.rider') }}"> Inside Valley </a></li>
                                        <li><a href="{{ route('return.outside.rider') }}">Outside Valley </a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="has-submenu">
                            <a href="#"><i class="dripicons-suitcase"></i>Order<i
                                    class="mdi mdi-chevron-down mdi-drop"></i></a>
                            <ul class="submenu megamenu">
                                <li><a href="{{ route('return.dateSearch') }}">Order By Date</a></li>
                            </ul>
                        </li>
                        <li class="has-submenu">
                            <a href="#"><i class="mdi mdi-briefcase"></i>
                                Return Orders<i class="mdi mdi-chevron-down mdi-drop"></i></a>
                            <ul class="submenu megamenu">
                                <li>
                                    <ul>
                                        <li><a href="{{ route('return.tobereturn') }}"> Inbound Remaining </a></li>
                                        <li><a href="{{ route('return.allOrder_inHub') }}"> Returned Warehouse </a></li>
                                        <li><a href="{{ route('return.returnedOrder') }}"> Returned </a></li>
                                        <li><a href="{{ route('return.return_inbound') }}"> Return Inbound </a></li>
                                        <li><a href="{{ route('return.returndelay') }}"> Return Delay </a></li>
                                        <li><a href="{{route('return.returOutside')}}">Outside Return Order</a></li>
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
                                        <li><a href="{{ route('return.newticket') }}">New Tickets</a></li>
                                        <li><a href="{{ route('return.opentickets') }}">Pickup Tickets</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="has-submenu">
                            <a href="{{ url('/return/returnUnsolveComment') }}"><i class="mdi mdi-comment"></i>
                                Return Comment</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div> <!-- end navbar-custom -->

    </header>

    <!-- End Navigation Bar-->

</div>