<div class="site-sidebar">
    <div class="custom-scroll custom-scroll-light">
        <ul class="sidebar-menu">
            <li class="active">
                <a href="{{ route('admin.dashboard') }}" class="waves-effect waves-light">
                    <span class="s-icon"><i class="fa fa-dashboard"></i></span>
                    <span class="s-text">Dashboard</span>
                </a>
            </li>
            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="fa fa-list-alt"></i></span>
                    <span class="s-text">Notice</span>
                </a>
                <ul>
                    <li><a href="{{ route('admin.notices.index') }}">All Notice</a></li>
                    <li><a href="{{ route('admin.notices.create') }}">Add Notice</a></li>
                </ul>
            </li>
            <!--<li class="active">
            <a href="{{ route('admin.notices.index') }}" class="waves-effect waves-light">
               <span class="s-icon"><i class="fa fa-list-alt"></i></span>
               <span class="s-text">Notice</span>
            </a>
         </li>-->

            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="ti-stats-up"></i></span>
                    <span class="s-text">Settlement</span>
                </a>
                <ul>
                    <li class="with-sub">
                        <a href="#" class="waves-effect  waves-light">
                            <span class="s-text">Account Info</span>
                            <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                        </a>
                        <ul>
                            <li><a href="{{ url('admin/new_account') }}">New Account</a></li>
                            <li><a href="{{ url('admin/approved_account') }}">Approved Account</a></li>
                        </ul>
                    </li>
                    <li class="with-sub">
                        <a href="#" class="waves-effect  waves-light">
                            <span class="s-text">Withdraw Info</span>
                            <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                        </a>
                        <ul>
                            <li><a href="{{ url('admin/new_withdraw') }}">Withdraw Requests</a></li>
                            <li><a href="{{ url('admin/approved_withdraw') }}">Approved Withdraw</a></li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="ti-zoom-in"></i></span>
                    <span class="s-text">Zone</span>
                </a>
                <ul>
                    <li><a href="{{url('admin/zone/showAll')}}">Show ALl Zone</a></li>
                    <li><a href="{{ route('admin.zone.index') }}">All Zone</a></li>
                    <li><a href="{{ route('admin.subzone.index') }}">Manage SubZone</a></li>
                    <li><a href="{{ route('admin.zone.create') }}">Add Zone</a></li>
                </ul>
            </li>

            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="ti-zoom-in"></i></span>
                    <span class="s-text">TrackZone</span>
                </a>
                <ul>
                    <!--- <li><a href="{{ route('admin.minizone.index') }}">All Mini Zone</a></li>
               <li><a href="{{ route('admin.minizone.create') }}">Add Mini Zone</a></li>
               <li><a href="{{ route('admin.minizone.track') }}">Track Rider</a></li> --->
                </ul>
                </>

            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="ti-comments"></i></span>
                    <span class="s-text">Push Notification</span>
                </a>
                <ul>
                    <li><a href="{{ route('admin.pushnotification.index') }}">All Push Notification</a></li>
                    <li><a href="{{ route('admin.pushnotification.create') }}">Add Push Notification</a></li>
                </ul>
            </li>

            <li>
                <a href="{{ route('admin.heatmap') }}" class="waves-effect waves-light">
                    <span class="s-icon"><i class="ti-flickr-alt"></i></span>
                    <span class="s-text">Bird Eye</span>
                </a>
            </li>

            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="ti-user"></i></span>
                    <span class="s-text">Users</span>
                </a>
                <ul>
                    <li><a href="{{ route('admin.user.index') }}">All User</a></li>
                    <li><a href="{{ route('admin.user.wallet') }}">Negative wallet User</a></li>
                    <li><a href="{{ route('admin.user.create') }}">Add User</a></li>
                </ul>
            </li>

            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="fa fa-ticket"></i></span>
                    <span class="s-text">Tickets</span>
                </a>
                <ul>
                    <li><a href="{{ route('admin.todaytickets') }}">Today's Ticket</a></li>
                    <li><a href="{{ route('admin.opentickets') }}">All Ticket</a></li>
                </ul>
            </li>

            <li class="with-sub">
                <a href="{{ route('admin.contact') }}" class="waves-effect  waves-light">
                    <span class="s-icon"><i class="fa fa-bell"></i></span>
                    <span class="s-text">Queries</span>
                </a>
            </li>

            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="fa fa-car"></i></span>
                    <span class="s-text">Partner</span>
                </a>
                <ul>
                    <li><a href="{{ route('admin.provider.index') }}">All KTM Partner</a></li>
                    <li><a href="{{ route('admin.provider.outerprovider') }}">All Outer Partner</a></li>
                    <li><a href="{{ route('admin.provider.active-driver') }}">Active Partner</a></li>
                    <li><a href="{{ route('admin.provider.create') }}">Add Partner</a></li>
                </ul>
            </li>

            {{-- <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="ti-headphone"></i></span>
                    <span class="s-text">Dispatcher</span>
                </a>
                <ul>
                    <li><a href="{{ route('admin.dispatch-manager.index') }}">All Dispatcher</a></li>
                    <li><a href="{{ route('admin.dispatch-manager.create') }}">Add Dispatcher</a></li>
                </ul>
            </li> --}}

            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="ti-rocket"></i></span>
                    <span class="s-text">Delivery Agency</span>
                </a>
                <ul>
                    <li><a href="{{ route('admin.fleet.index') }}">List Delivery Agency</a></li>
                    <li><a href="{{ route('admin.fleet.create') }}">Add New</a></li>
                </ul>
            </li>

            {{-- <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="ti-layout-grid2-thumb"></i></span>
                    <span class="s-text">Account</span>
                </a>
                <ul>
                    <li><a href="{{ route('admin.account-manager.index') }}">All Accounts</a></li>
                    <li><a href="{{ route('admin.account-manager.create') }}">Add Account</a></li>
                </ul>
            </li> --}}

            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="ti-files"></i></span>
                    <span class="s-text">Finance</span>
                </a>
                <ul>
                    <li><a href="{{ route('admin.ride.statement') }}">Order Revenue</a></li>
                    <li><a href="{{ route('admin.payment', 'ride') }}">Order History</a></li>
                    <li><a href="{{ route('admin.ride.statement.provider') }}">Driver Earning</a></li>
                    <li><a href="{{ route('admin.ride.statement.today') }}">Daily Revenue</a></li>
                    <li><a href="{{ route('admin.ride.statement.monthly') }}">Monthly Revenue</a></li>
                    <li><a href="{{ route('admin.ride.statement.yearly') }}">Yearly Revenue</a></li>
                </ul>
            </li>

            <li>
                <a href="{{ route('admin.map.index') }}" class="waves-effect waves-light">
                    <span class="s-icon"><i class="ti-map-alt"></i></span>
                    <span class="s-text">Live Location</span>
                </a>
            </li>

            <!-- <li>
            <a href="{{ route('admin.lost-management') }}" class="waves-effect waves-light">
            <span class="s-icon"><i class="fa fa-sitemap"></i></span>
            <span class="s-text">Lost Management</span>
            </a>
         </li> -->

            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="ti-star"></i></span>
                    <span class="s-text">Ratings &amp; Reviews</span>
                </a>
                <ul>
                    <li><a href="{{ route('admin.user.review') }}">User Ratings</a></li>
                    <li><a href="{{ route('admin.provider.review') }}">Driver Ratings</a></li>
                </ul>
            </li>

            <!-- <li>
            <a href="{{ route('admin.requests.index') }}" class="waves-effect  waves-light">
               <span class="s-icon"><i class="ti-pie-chart"></i></span>
               <span class="s-text">All Ride</span>
            </a>
         </li> -->

            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="fa fa-pie-chart"></i></span>
                    <span class="s-text">All Orders</span>
                </a>
                <ul>
                    <li><a href="{{ route('admin.requests.dateSearch') }}">Orders By Date</a></li>
                    <li><a href="{{ route('admin.requests.insidevalley') }}">Inside Valley</a></li>
                    <li><a href="{{ route('admin.requests.outsidevalley') }}">Outside Valley</a></li>
                    <li><a href="{{ route('admin.requests.bulkAssign') }}">Bulk Assign</a></li>
                    <li><a href="{{ route('admin.requests.pending') }}">Pending Order</a></li>
                    <li><a href="{{ route('admin.requests.accepted') }}">Accepted Order</a></li>
                    <li><a href="{{ route('admin.requests.index') }}">Ongoing Order</a></li>
                    <li><a href="{{ route('admin.requests.cancel') }}">Cancelled Order</a></li>
                    <li><a href="{{ route('admin.requests.completed') }}">Completed Order</a></li>
                    <li><a href="{{ route('admin.requests.allinbound') }}">Inbound Order</a></li>
                    <li><a href="{{ route('admin.requests.delaySearch') }}">Delayed Order</a></li>
                    <li><a href="{{ route('admin.pending.map') }}">Pending Map</a></li>
                    <li><a href="{{ route('admin.dispatcher.page') }}">NDispatch</a></li>
                    <li><a href="{{ route('admin.ktm.delivery.remaining') }}">Ktm Delivery Remaining </a></li>
                    <li><a href="{{ route('admin.requests.track') }}">Old Track </a></li>
                    <li><a href="{{ route('admin.requests.InactiveOrder') }}">Inactive Order </a></li>
                    <li><a href="{{ route('admin.requests.dateSearchSettle') }}">Settle Order</a></li>


                </ul>
            </li>

            {{-- <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="fa fa-undo"></i></span>
                    <span class="s-text">Return Order</span>
                </a>
                <ul>
                    <li><a href="{{ route('admin.requests.tobereturn') }}"> To Be Return List </a></li>
                    <li><a href="{{ route('admin.requests.allOrder_inHub') }}"> Returned to Sortcenter </a></li>
                    <li><a href="{{ route('admin.requests.returnedOrder') }}"> Return Completed </a></li>
                </ul>
            </li> --}}

            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="fa fa-user"></i></span>
                    <span class="s-text">Department Users</span>
                </a>
                <ul>
                    <li><a href="{{ route('admin.account-manager.index') }}"> Accountant </a></li>
                    <li><a href="{{ route('admin.branch-manager.index') }}"> Branch Managers </a></li>
                    <li><a href="{{ route('admin.dispatch-manager.index') }}"> Dispatcher </a></li>
                    <li><a href="{{ route('admin.return-manager.index') }}"> Return Users </a></li>
                    <li><a href="{{ route('admin.support-manager.index') }}"> Support Users </a></li>
                    <li><a href="{{ route('admin.sortcenter-user.index') }}"> Sortcenter Users </a></li>
                    <li><a href="{{ route('admin.pickup-user.index') }}"> Pickup Users </a></li>

                </ul>
            </li>

            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="ti-pie-chart"></i></span>
                    <span class="s-text">Zone Dispatch</span>
                </a>
                <ul>
                    <li><a href="{{ route('admin.zonedispatch.index') }}">Dispatch</a></li>
                    <li><a href="{{ route('admin.zonedispatch.view') }}">Ongoing Dispatch</a></li>
                </ul>
            </li>

            <li>
                <a href="{{ route('admin.requests.scheduled') }}" class="waves-effect  waves-light">
                    <span class="s-icon"><i class="ti-timer"></i></span>
                    <span class="s-text">Scheduled Order</span>
                </a>
            </li>

            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="fa fa-envelope-o"></i></span>
                    <span class="s-text">Delivery Type</span>
                </a>
                <ul>
                    <li><a href="{{ route('admin.service.index') }}">All Delivery</a></li>
                    <li><a href="{{ route('admin.service.create') }}">Add Delivery</a></li>
                </ul>
            </li>

            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="fa fa-motorcycle"></i></span>
                    <span class="s-text">Order Type</span>
                </a>
                <ul>
                    <li><a href="{{ route('admin.ridetype.index') }}">All Ride Type</a></li>
                    <li><a href="{{ route('admin.ridetype.create') }}">Add Ride type</a></li>
                </ul>
            </li>

            <li class="with-sub">

                <a href="#" class="waves-effect  waves-light">

                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>

                    <span class="s-icon"><i class="ti-layout-media-overlay-alt-2"></i></span>

                    <span class="s-text">Delivery Mapping</span>

                </a>

                <ul>

                    <li><a href="{{ url('admin/allocation_list') }}">Mapped Delivery</a></li>

                    <li><a href="{{ url('admin/allocation') }}">New Map</a></li>

                </ul>

            </li>

            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="fa fa-money"></i></span>
                    <span class="s-text">Fare Settings</span>
                </a>
                <ul>
                    <li><a href="{{ route('admin.fare.index') }}">Fare Plan List</a></li>
                    <li><a href="{{ route('admin.fare.create') }}">Add New Fare</a></li>
                </ul>
            </li>

            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="fa fa-sitemap"></i></span>
                    <span class="s-text">Dept. Settings</span>
                </a>
                <ul>
                    <li><a href="{{ route('admin.dept.index') }}">Dept. List</a></li>
                    <li><a href="{{ route('admin.dept.create') }}">Add New Dept.</a></li>
                </ul>
            </li>

            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="ti-exchange-vertical"></i></span>
                    <span class="s-text">Support</span>
                </a>
                <ul>
                    <li><a href="{{ route('admin.support-manager.index') }}">All Executive</a></li>
                    <li><a href="{{ route('admin.support-manager.create') }}">Add New Executive</a></li>
                </ul>
                <ul>
                    <!-- <li><a href="#">Notification</a></li> -->
                    <li><a href="{{ url('admin/support/open-ticket') }}">Open Ticket</a></li>
                    <li><a href="{{ url('admin/support/close-ticket') }}">Close Ticket</a></li>
                    <!-- <li><a href="#">Activity</a></li> -->
                </ul>
            </li>

            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="ti-layout-tab"></i></span>
                    <span class="s-text">Documents</span>
                </a>
                <ul>
                    <li><a href="{{ route('admin.document.index') }}">All Documents</a></li>
                    <li><a href="{{ route('admin.document.create') }}">Add Document</a></li>
                </ul>
            </li>

            <li class="with-sub">

                <a href="#" class="waves-effect  waves-light">

                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>

                    <span class="s-icon"><i class="ti-map"></i></span>

                    <span class="s-text">Location</span>

                </a>

                <ul>

                    <li><a href="{{ route('admin.country.index') }}">All Countries</a></li>

                    <li><a href="{{ route('admin.state.index') }}">All States</a></li>

                    <li><a href="{{ route('admin.city.index') }}">All Cities</a></li>

                    <li><a href="{{ route('admin.location.create') }}">Add New</a></li>

                </ul>

            </li>

            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="ti-layout-media-left-alt"></i></span>
                    <span class="s-text">CMS</span>
                </a>
                <ul>
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
            </li>

            <li class="with-sub">

                <a href="#" class="waves-effect  waves-light">

                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>

                    <span class="s-icon"><i class="ti-layout-media-right"></i></span>

                    <span class="s-text">CRM</span>

                </a>

                <ul>

                    <li><a href="{{ route('admin.crm-manager.index') }}">CRM Executive</a></li>

                    <li><a href="{{ route('admin.crm-manager.create') }}">Add New Executive</a></li>

                    <li><a href="{{ url('admin/crm/open-ticket/all') }}">All Ticket</a></li>

                    <li><a href="{{ url('admin/crm/open-ticket/open') }}">Open Ticket</a></li>

                    <li><a href="{{ url('admin/crm/close-ticket') }}">Close Ticket</a></li>

                    <!-- <li><a href="#">Activity</a></li> -->

                </ul>

            </li>
            <li>

                <a href="{{ url('admin/Quotes') }}" class="waves-effect  waves-light">

                    <span class="s-icon"><i class="fa fa-quote-right"></i></span>

                    <span class="s-text">Quote Request</span>

                </a>

            </li>

            <li class="with-sub">

                <a href="#" class="waves-effect  waves-light">

                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>

                    <span class="s-icon"><i class="ti-bookmark-alt"></i></span>

                    <span class="s-text">Promo Code</span>

                </a>

                <ul>

                    <li><a href="{{ route('admin.promocode.index') }}">List Promo Code</a></li>

                    <li><a href="{{ route('admin.promocode.create') }}">Add New Promo Code</a></li>

                    <li><a href="{{ route('admin.promocode.users') }}">Promo Code User</a></li>

                    <!--<li><a href="{{ route('admin.reward.index') }}">Reward Rule</a></li>
               <li><a href="{{ route('admin.referral.index') }}">Referral Rule</a></li>-->

                </ul>

            </li>
            <!--<li class="with-sub">

            <a href="#" class="waves-effect  waves-light">

            <span class="s-caret"><i class="fa fa-angle-down"></i></span>

            <span class="s-icon"><i class="fa fa-star-o"></i></span>

            <span class="s-text">Reward & Referral</span>

            </a>

            <ul>

               

               <li><a href="{{ route('admin.reward.index') }}">Rewarded User</a></li>
               <li><a href="{{ route('admin.reward.create') }}">Reward Rule</a></li>
               <li><a href="{{ route('admin.reward.create') }}">Update Reward Rule</a></li>
               <li><a href="{{ route('admin.referral.index') }}">Referral User</a></li>
               <li><a href="{{ route('admin.referral.create') }}">Referral Rule</a></li>
               <li><a href="{{ route('admin.referral.create') }}">Update Referral Rule</a></li>

            </ul>

         </li>-->


            <li>

                <a href="{{ route('admin.payment', 'payment') }}" class="waves-effect  waves-light">

                    <span class="s-icon"><i class="ti-download"></i></span>

                    <span class="s-text">Payment History</span>

                </a>

            </li>

            <li>

                <a href="{{ route('admin.settings.payment') }}" class="waves-effect  waves-light">

                    <span class="s-icon"><i class="ti-money"></i></span>

                    <span class="s-text">Payment Settings</span>

                </a>

            </li>

            <li>

                <a href="{{ route('admin.settings') }}" class="waves-effect  waves-light">

                    <span class="s-icon"><i class="ti-settings"></i></span>

                    <span class="s-text">Business Settings</span>

                </a>

            </li>

            <li class="with-sub">

                <a href="#" class="waves-effect  waves-light">

                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>

                    <span class="s-icon"><i class="ti-themify-favicon"></i></span>

                    <span class="s-text">Testimonials</span>

                </a>

                <ul>

                    <li><a href="{{ route('admin.testimonial.index') }}">List Testimonials</a></li>

                    <li><a href="{{ route('admin.testimonial.create') }}">Add New Testimonial</a></li>

                </ul>

            </li>

            <li class="compact-hide">

                <a href="{{ url('/admin/logout') }}" onclick="event.preventDefault();

               document.getElementById('logout-form').submit();">

                    <span class="s-icon"><i class="ti-power-off"></i></span>

                    <span class="s-text">Logout</span>

                </a>

                <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">

                    {{ csrf_field() }}

                </form>

            </li>

        </ul>

    </div>

</div>