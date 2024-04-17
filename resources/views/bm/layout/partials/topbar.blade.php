<div class="header-bg">
    <!-- Navigation Bar-->
    <header id="topnav">

        <div class="topbar-main">
            <div class="container-fluid">
                <!-- Logo-->
                <a href="{{ url('/bm') }}" class="logo">
                    <img src="{{ url(Setting::get('white_site_logo', asset('logo-black.png'))) }}" alt="" height="26">
                </a>
                

                <!-- End Logo-->

                <div class="menu-extras  topbar-custom navbar p-0">
                    
                    <ul class="list-inline ml-auto mb-0">
                        <!-- User-->
                        <li class="list-inline-item dropdown notification-list nav-user">

                            <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#"
                                role="button" aria-haspopup="false" aria-expanded="false">
                                <img src="{{ asset('asset/img/dummy.png') }}" alt="user" class="rounded-circle"
                                    style="border-style: solid; color:green">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown">
                                <a class="dropdown-item" href="{{ route('bm.profile') }}"><i
                                        class="dripicons-user text-muted"></i>
                                    Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{url('/bm/logout') }}"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                                        class="dripicons-exit text-muted"></i>
                                    Logout</a>
                                <form id="logout-form" action="{{url('/bm/logout') }}" method="POST"
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
                    <ul class="navigation-menu ">
                        <li class="has-submenu">
                            <li class="has-submenu">
                                <a href="#"><i
                                    class="fab fa-first-order-alt"></i>Order </a>
                                <ul class="submenu">
                                    <li><a href="{{ url('bm/recent-trips') }}"> All Order </a>
                                    </li>
                                    <li><a href="{{ route('bm.sortcenter') }}"> Sortcenter </a>
                                    </li>
                                    <li><a href="{{ route('bm.delivering') }}"> Delivering
                                    </a></li>
                                    <li><a href="{{ route('bm.scheduled') }}"> Scheduled
                                    </a></li>
                                    <li><a href="{{ route('bm.returnRemaining') }}"> Return Remaining
                                    </a></li>
                                </ul>
                            </li>
                        </li>
                         <li class="has-submenu">
                            <li class="has-submenu">
                                <a href="#"><i
                                    class="fab fa-first-order-alt"></i>Order Assign </a>
                                <ul class="submenu">
                                    <li><a href="{{ route('bm.bulkassign') }}"> BulkAssign </a>
                                    </li>
                                </ul>
                            </li>
                        </li>

                        {{-- <li class="has-submenu"><a href="{{ url('bm/recent-trips') }}"><i
                                    class="fa fa-motorcycle"></i> All Order</a></li> --}}
                        {{-- <li class="has-submenu"><a href="{{ route('bm.index') }}">All Orders </a></li> --}}
                        <li class="has-submenu"><a href="{{ url('/bm/provider') }}"><i
                                    class="fa fa-motorcycle"></i> Partners</a></li>
                           <li class="has-submenu"><a href="{{ url('/bm/user') }}"><i
                                    class="fas fa-users"></i> User</a></li>
                        <li class="has-submenu"><a href="#"><i
                                    class="fa fa-arrow-up"></i> Out
                                Going</a>
                            <ul class="submenu">
                                    <!-- <li><a href="{{ route('bm.dispatchList.index') }}"> New Dispatch </a> -->
                                    </li>
                                    <li><a href="{{route('bm.dispatchList.myDispatch')}}"> Dispatched </a>
                                    </li>
                                    <li><a href="{{route('bm.dispatchList.completeReached')}}"> Complete Reached
                                    </a></li>
                                    <li><a href="{{route('bm.dispatchList.incompleteReached')}}"> Incomplete Reached
                                    </a></li>
                                    <li><a href="{{route('bm.dispatchList.draft')}}"> Draft
                                    </a></li>
                                    <li>
                                        <!-- <a href="{{route('bm.dispatchList.return')}}">Return </a> -->
                                    </li>
                                    <li>
                                        <a href="{{route('bm.dispatchList.returnedDispatched')}}">Return Dispatch</a>
                                    </li>
                            </ul>
                        </li>
                        <li class="has-submenu"><a href="#"><i
                                    class="fa fa-arrow-down"></i>In Coming</a>
                                <ul class="submenu">
                                    <li><a href="{{ route('bm.dispatchList.pending') }}"> Pending Receive </a>
                                    </li>
                                    <li><a href="{{url('bm/completeReceived')}}"> Complete Receive </a>
                                    </li>
                                    <li><a href="{{url('bm/incompleteReceived')}}"> Incomplete Received
                                    </a></li>
                                    <li><a href="{{route('bm.dispatchList.returnDispatch')}}"> Pending Receive(Return)
                                    </a></li>
                                </ul>
                        </li>

                        <li class="has-submenu"><a href="#"> Order Comment </a>
                         <ul class="submenu">
                                    <li><a href="{{route('bm.unsolve_comments')}}"> Unsolve Comment  </a>
                                    </li>
                                    <li><a href="{{route('bm.solved_comments')}}"> Solve Comment </a>
                                    </li>
                                </ul>
                        </li>
                        <li class="has-submenu">
                            <li class="has-submenu">
                                <a href="#">Order Track </a>
                                <ul class="submenu">
                                    <li><a href="{{ route('bm.dispatchList.track') }}"> Track Order </a>
                                    </li>
                                    <li><a href="{{ route('bm.delaySearch') }}"> Delay Order </a>
                                    </li>
                                    <li><a href="{{ route('bm.InactiveOrder') }}"> Inactive Order
                                    </a></li>
                                </ul>
                            </li>
                        </li>
                        <li class="has-submenu">
                            <a href="#">Support </a>
                            <ul class="submenu">
                                <li><a href="{{ route('bm.openTicket') }}"> Ticket </a></li>
                                <li><a href="{{ route('bm.CustomerQuery') }}"> Customer Query</a></li>

                            </ul>
                        </li>
                    </ul>


                </div>

            </div>
        </div> <!-- end navbar-custom -->

    </header>

    <!-- End Navigation Bar-->

</div>