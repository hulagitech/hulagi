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
                <a href="{{ url('/admin/dashboard') }}" class="logo">
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
                                <a class="dropdown-item" href="{{ route('admin.profile') }}"><i
                                        class="dripicons-user text-muted"></i>
                                    Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ url('/logout') }}"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                                        class="dripicons-exit text-muted"></i>
                                    Logout</a>
                                <form id="logout-form" action="{{ url('admin/logout') }}" method="POST"
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
                            <a href="{{ route('admin.dashboard') }}"><i class="dripicons-home"></i>
                                Dashboard</a>
                        </li>
                        <li class="has-submenu">
                            <a href="#"><i class="far fa-user"></i>User<i class="mdi mdi-chevron-down mdi-drop"></i></a>
                            <ul class="submenu">
                                <li class="has-submenu">
                                    <a href="#">User </a>
                                    <ul class="submenu">
                                        <li><a href="{{ route('admin.user.index') }}">All User</a></li>
                                        <li><a href="{{route('admin.user.create')}}">Add User</a></li>
                                        <li><a href="{{ route('admin.user.wallet') }}">Negative wallet User</a></li>
                                    </ul>
                                </li>
                                <li class="has-submenu">
                                    <a href="#">Partner </a>
                                    <ul class="submenu">
                                        <li><a href="{{ route('admin.provider.index') }}">All  Partner</a></li>
                                        <li><a href="{{ route('admin.provider.outerprovider') }}">Outside  Partner</a></li>
                                        <li><a href="{{ route('admin.provider.active-driver') }}">Active Partner</a>
                                        <li><a href="{{ route('admin.provider.create') }}">Add Partner</a></li>
                                        </li>

                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="has-submenu">
                            <a href="#"><i class="fas fa-list"></i>Departments<i
                                    class="mdi mdi-chevron-down mdi-drop"></i></a>
                            <ul class="submenu ">
                                <li class="has-submenu">
                                    <a href="#">Dept. Settings</a>
                                    <ul class="submenu">
                                        <li><a href="{{ route('admin.dept.index') }}">Dept. List</a></li>
                                        <li><a href="{{ route('admin.dept.create') }}">Add New Dept.</a></li>

                                    </ul>
                                </li>
                                 <li>
                                    <a href="{{route('admin.nextDashboardUser.index')}}">Domain User</a>
                                </li>
                                <li class="has-submenu">
                                    <a href="#">Department Users </a>
                                    <ul class="submenu">
                                        <li><a href="{{ route('admin.account-manager.index') }}"> Accountant </a></li>
                                        <li><a href="{{ route('admin.branch-manager.index') }}"> Branch Managers </a>
                                        </li>
                                        <li><a href="{{ route('admin.dispatch-manager.index') }}"> Dispatcher </a></li>
                                        <li><a href="{{ route('admin.return-manager.index') }}"> Return Users </a></li>
                                        <li><a href="{{ route('admin.support-manager.index') }}"> Support Users </a>
                                        </li>
                                        <li><a href="{{ route('admin.sortcenter-user.index') }}"> Sortcenter Users </a>
                                        </li>
                                        <li><a href="{{ route('admin.pickup-user.index') }}"> Pickup Users </a></li>

                                    </ul>
                                </li>

                                <li class="has-submenu">
                                    <a href="#">Ratings &amp; Reviews </a>
                                    <ul class="submenu">
                                        <li><a href="{{ route('admin.user.review') }}">User Ratings</a></li>
                                        <li><a href="{{ route('admin.provider.review') }}">Driver Ratings</a></li>

                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="has-submenu">
                            <a href="#"><i class="far fa-map"></i>Map<i class="mdi mdi-chevron-down mdi-drop"></i></a>
                            <ul class="submenu ">

                                <li><a href="{{ route('admin.heatmap') }}">Bird Eye</a></li>
                                <li><a href="{{ route('admin.map.index') }}">Live Location</a></li>
                                <li class="has-submenu">
                                    <a href="#">Zone </a>
                                    <ul class="submenu">
                                        <li><a href="{{url('admin/zone/showAll')}}">Show ALl Zone</a></li>
                                        <li><a href="{{ route('admin.zone.index') }}">All Zone</a></li>
                                        <li><a href="{{ route('admin.subzone.index') }}">Manage SubZone</a></li>
                                        <li><a href="{{ route('admin.zone.create') }}">Add Zone</a></li>
                                    </ul>
                                </li>
                                <li class="has-submenu">
                                    <a href="#">Fare </a>
                                    <ul class="submenu">
                                        <li><a href="{{ route('admin.fare.index') }}">Fare Plan List</a></li>
                                        <li><a href="{{ route('admin.fare.create') }}">Add New Fare</a></li>
                
                                    </ul>
                            </ul>

                        </li>
                        <li class="has-submenu">
                            <a href="#"><i class="fab fa-first-order-alt"></i>Orders<i
                                    class="mdi mdi-chevron-down mdi-drop"></i></a>
                            <ul class="submenu">
                                <li class="has-submenu">
                                    <a href="#">Orders </a>
                                    <ul class="submenu">
                                        <li><a href="{{ route('admin.requests.dateSearch') }}">Orders By Date</a></li>
                                       
                                        <li><a href="{{ route('admin.requests.delaySearch') }}">Delayed Order</a></li>
                                        <li><a href="{{ route('admin.requests.bulkAssign') }}">Bulk Assign Order</a></li>
                                        <li><a href="{{ route('admin.requests.track') }}">Old Track </a></li>
                                        <li><a href="{{ route('admin.requests.InactiveOrder') }}">Inactive Order </a>
                                        </li>
                                        </li>

                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="has-submenu">
                            <a href="#"><i class="far fa-handshake"></i>Support<i
                                    class="mdi mdi-chevron-down mdi-drop"></i></a>
                            <ul class="submenu">
                                <li><a href="{{ url('admin/Quotes') }}">Quote Request</a></li>
                                <li><a href="{{ route('admin.contact') }}">Queries</a></li>
                                <li class="has-submenu">
                                    <a href="#">Tickets </a>
                                    <ul class="submenu">
                                        <li><a href="{{ route('admin.todaytickets') }}">Today's Ticket</a></li>
                                        {{-- <li><a href="{{ route('admin.opentickets') }}">All Ticket</a></li> --}}
                                        <li><a href="{{ route('admin.opentickets') }}">All Tickets</a></li>
                                    </ul>
                                </li>


                            </ul>
                        </li>
                        <li class="has-submenu">
                            <a href="#"><i class="far fa-bell"></i>Notice<i
                                    class="mdi mdi-chevron-down mdi-drop"></i></a>
                            <ul class="submenu">
                                <li><a href="{{ route('admin.notices.index') }}">All Notice</a></li>
                               
                            </ul>
                        </li>

                        <li class="has-submenu">
                            <a href="#"><i class="mdi mdi-settings-outline"></i>Setting<i
                                    class="mdi mdi-chevron-down mdi-drop"></i></a>
                            <ul class="submenu ">
                                <li><a href="{{ route('admin.settings') }}">Business settings</a></li>
                                <li><a href="{{ url('/admin/page') }}">Page settings</a></li>
                                <li><a href="{{ route('admin.settings.payment') }}">Payment settings</a></li>
                                {{-- <li class="has-submenu">
                                    <a href="#">CMS </a>
                                    <ul class="submenu">
                                        <li><a href="{{ url('/admin/page') }}">All Pages</a></li>
                                        <li><a href="{{ url('/admin/page/create') }}">Add Pages</a></li>
                                        <li><a href="{{ route('admin.cms-manager.index') }}">CMS Executive</a></li>
                                        <li><a href="{{ route('admin.cms-manager.create') }}">Add New Executive</a></li>
                                        <li><a href="{{ url('admin/translation') }}">Translation</a></li>
                                        <li><a href="{{ url('admin/translation') }}">Add New Translation</a></li>
                                        <li><a href="{{ url('/admin/blog') }}">All Blog</a></li>
                                        <li><a href="{{ url('/admin/page/create') }}">Add New Blogs</a></li>
                                        <li><a href="{{ url('admin/how-it-work/') }}">All How it Work</a></li>
                                        <li><a href="{{ url('admin/how-it-work/create') }}">Add How it Work</a></li>
                                        <li><a href="{{ url('admin/faqs/') }}">All FAQ</a></li>
                                        <li><a href="{{ url('admin/faqs/create') }}">Add New</a></li>
                                    </ul>
                                </li> --}}
                                <li class="has-submenu">
                                    <a href="#">Promo Code </a>
                                    <ul class="submenu">
                                        <li><a href="{{ route('admin.promocode.index') }}">List Promo Code</a></li>
                                        <li><a href="{{ route('admin.promocode.users') }}">Promo Code User</a></li>

                                    </ul>
                                </li>
                                <li class="has-submenu">
                                    <a href="#">Location </a>
                                    <ul class="submenu">

                                        <li><a href="{{ route('admin.country.index') }}">All Countries</a></li>
                                        <li><a href="{{ route('admin.state.index') }}">All States</a></li>
                                        <li><a href="{{ route('admin.city.index') }}">All Cities</a></li>
                                        <li><a href="{{ route('admin.location.create') }}">Add New</a></li>
                                    </ul>
                                </li>
                            </ul>
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



                </div>

            </div>
        </div> <!-- end navbar-custom -->

    </header>

    <!-- End Navigation Bar-->

</div>