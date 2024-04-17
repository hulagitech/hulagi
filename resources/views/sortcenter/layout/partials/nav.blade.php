<div class="site-sidebar">
    <div class="custom-scroll custom-scroll-light">
        <ul class="sidebar-menu">
            <li class="active">
                <a href="{{ route('return.dashboard') }}" class="waves-effect waves-light">
                    <span class="s-icon"><i class="fa fa-dashboard"></i></span>
                    <span class="s-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('sortcenter.rider') }}" class="waves-effect  waves-light">
                    <span class="s-icon"><i class="fa fa-motorcycle "></i></span>
                    <span class="s-text">Rider details</span>
                </a>
            </li>
             <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="fa fa-pie-chart"></i></span>
                    <span class="s-text">Order Inbound</span>
                </a>
                <ul>
                    <li><a href="{{ route('sortcenter.inbound') }}">Print Invoice</a></li>
                    <li><a href="{{ route('sortcenter.bulk_inbound') }}">Bulk Inbound</a></li>
                   
                </ul>
            </li>

            
            <li>
                <a href="{{ route('sortcenter.outbound') }}" class="waves-effect  waves-light">
                    <span class="s-icon"><i class="fa fa-paper-plane"></i></span>
                    <span class="s-text">Outbound Order</span> 
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
                    <li><a href="{{ route('sortcenter.dateSearch') }}">Order By Date</a></li>
                    <li><a href="{{ route('sortcenter.inside_valley') }}">Inside Valley</a></li>
                    {{-- <li><a href="#">Accepted Order</a></li>
                    <li><a href="#">Deliverying Order</a></li>
                    <li><a href="#">Rejected Order</a></li>
                    <li><a href="#">Scheduled Order</a></li>
                    <li><a href="#">Delayed Order</a></li> --}}
                    {{-- <li><a href="{{ url('return/todaytickets') }}">Add New Order</a></li> --}}
                </ul>
            </li>

            {{-- <li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
					<span class="s-caret"><i class="fa fa-angle-down"></i></span>
					<span class="s-icon"><i class="fa fa-comments"></i></span>
					<span class="s-text">Order Comments</span>
				</a>
				<ul>
					<li><a href="{{ url('return/allorder/comment') }}">Unsolve Comments</a></li>
					<li><a href="{{ url('return/solved_comment') }}">Solved Comments</a></li>
				</ul>
			</li> --}}

            {{-- <li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
					<span class="s-caret"><i class="fa fa-angle-down"></i></span>
					<span class="s-icon"><i class="fa fa-undo"></i></span>
					<span class="s-text">Return Orders</span>
				</a>
				<ul>
                    <li><a href="{{ route('return.tobereturn') }}"> To Be Return List </a></li>
                    <li><a href="{{ route('return.allOrder_inHub') }}"> Returned to Sortcenter </a></li>
                    <li><a href="{{ route('return.returnedOrder') }}"> Return Completed </a></li>
                 </ul>
			</li> --}}

            {{-- <li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
					<span class="s-caret"><i class="fa fa-angle-down"></i></span>
					<span class="s-icon"><i class="fa fa-comments"></i></span>
					<span class="s-text">Order Comments</span>
				</a>
				<ul>
					<li><a href="{{ route('return.unsolve_comments') }}">Unsolve Comments</a></li>
					<li><a href="{{ route('return.solved_comments') }}">Solved Comments</a></li>
				</ul>
			</li> --}}

            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="fa fa-ticket"></i></span>
                    <span class="s-text">Tickets</span>
                </a>
                <ul>
                    <li><a href="{{ route('sortcenter.newticket') }}">New Tickets</a></li>
                    <li><a href="{{ route('sortcenter.opentickets') }}">Sortcenter Tickets</a></li>
                </ul>
            </li>
            <li>
				<a href="{{ url('/sortcenter/sortcenterUnsolveComment') }}" class="waves-effect  waves-light">
					<span class="s-icon"><i class="fa fa-comment"></i></span>
					<span class="s-text">Sortcenter Comment</span>
				</a>  
			</li>
            <li>
				<a href="{{ url('/sortcenter/ktmdeliveryreamining') }}" class="waves-effect  waves-light">
					<span class="s-icon"><i class="fa fa-pie-chart"></i></span>
					<span class="s-text">Ktm Delivery Remaining</span>
				</a>  
			</li>
            <li>
                <a href="{{ url('sortcenter/inbound') }}" class="waves-effect  waves-light">
                    <span class="s-icon"><i class="fa fa-pie-chart"></i></span>
                    <span class="s-text">Search Inbound Order</span>
                </a>
            </li>

            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="fa fa-user"></i></span>
                    <span class="s-text">Profile</span>
                </a>
                <ul>
                   <li><a href="{{ route('sortcenter.profile') }}">Profile</a></li>
                   <li><a href="{{ route('sortcenter.password') }}">Change Password</a></li>
                </ul>
            </li>

            <li class="compact-hide" style="margin-bottom: -16px;">
                <a href="{{ url('/sortcenter/logout') }}" onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                    <span class="s-icon"><i class="fa fa-power-off"></i></span>
                    <span class="s-text">Logout</span>
                </a>

                <form id="logout-form" action="{{ url('/sortcenter/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>

        </ul>
    </div>
</div>
