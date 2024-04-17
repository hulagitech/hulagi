<div class="site-sidebar">
    <div class="custom-scroll custom-scroll-light">
        <ul class="sidebar-menu">
            <li class="active">
                <a href="{{ route('return.dashboard') }}" class="waves-effect waves-light">
                    <span class="s-icon"><i class="fa fa-dashboard"></i></span>
                    <span class="s-text">Dashboard</span>
                </a>
            </li>

            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="fa fa-pie-chart"></i></span>
                    <span class="s-text">Orders</span>
                </a>
                <ul>
                    {{-- <li><a href="{{ route('return.requests.dateSearch') }}">Order By Date</a></li> --}}
                    <li><a href="{{ route('return.dateSearch') }}">Order By Date</a></li>
                    {{-- <li><a href="#">Add New Order</a></li> --}}
                    {{-- <li><a href="{{ url('return/todaytickets') }}">Add New Order</a></li> --}}
                </ul>
            </li>


            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="fa fa-motorcycle"></i></span>
                    <span class="s-text">Rider</span>
                </a>
				<ul>
                    <li><a href="{{ route('return.inside.rider') }}"> Inside Valley </a></li>
                    <li><a href="{{ route('return.outside.rider') }}">Outside Valley </a></li>
                 
                </ul>
            </li>
            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="fa fa-undo"></i></span>
                    <span class="s-text">Return Orders</span>
                </a>
                <ul>
                    <li><a href="{{ route('return.tobereturn') }}"> Inbound Remaining </a></li>
                    <li><a href="{{ route('return.allOrder_inHub') }}"> Returned Warehouse </a></li>
                    <li><a href="{{ route('return.returnedOrder') }}"> Returned </a></li>
                    <li><a href="{{ route('return.return_inbound') }}"> Return Inbound </a></li>
                    <li><a href="{{ route('return.returndelay') }}"> Return Delay </a></li>
                    <li><a href="{{route('return.returOutside')}}">Outside Return Order</a></li>
                </ul>
            </li>
            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="fa fa-ticket"></i></span>
                    <span class="s-text">Tickets</span>
                </a>
                <ul>
                    <li><a href="{{ route('return.newticket') }}">New Ticket</a></li>
                    <li><a href="{{ route('return.opentickets') }}">Return Tickets</a></li>
                </ul>
            </li>

            <li>
                <a href="{{ url('/return/returnUnsolveComment') }}" class="waves-effect  waves-light">
                    <span class="s-icon"><i class="fa fa-comment"></i></span>
                    <span class="s-text">Return Comment</span>
                </a>
            </li>



            <li class="with-sub">
            <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="fa fa-user"></i></span>
                    <span class="s-text">Profile</span>
                </a>
                <ul>
                    <li><a href="{{ route('return.profile') }}">Profile</a></li>
                    <li><a href="{{ route('return.password') }}">Password</a></li>
                </ul>
            </li>

            <li class="compact-hide" style="margin-bottom: -16px;">
                <a href="{{ url('/return/logout') }}" onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                    <span class="s-icon"><i class="fa fa-power-off"></i></span>
                    <span class="s-text">Logout</span>
                </a>

                <form id="logout-form" action="{{ url('/return/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>

        </ul>
    </div>
</div>
