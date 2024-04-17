<div class="site-sidebar">
	<div class="custom-scroll custom-scroll-light">
		<ul class="sidebar-menu">
			<li class="active">
				<a href="{{ route('support.dashboard') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="fa fa-dashboard"></i></span>
					<span class="s-text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="{{ route('support.user.index') }}" class="waves-effect  waves-light">
					<span class="s-icon"><i class="ti-user"></i></span>
					<span class="s-text">User</span>
				</a>  
			</li>
			<li>
				<a href="{{ route('support.provider.index') }}" class="waves-effect  waves-light">
					<span class="s-icon"><i class="fa fa-car"></i></span>
					<span class="s-text">Partner</span>
				</a>  
			</li>
			<li>
				<a href="{{ route('support.fare') }}" class="waves-effect  waves-light">
					<span class="s-icon"><i class="fa fa-money"></i></span>
					<span class="s-text">Fare List</span>
				</a>  
			</li>

			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
					<span class="s-caret"><i class="fa fa-angle-down"></i></span>
					<span class="s-icon"><i class="fa fa-pie-chart"></i></span>
					<span class="s-text">Orders</span>
				</a>
				<ul>
					<li><a href="{{ route('support.requests.dateSearch') }}">Order By Date</a></li>
					{{-- <li><a href="#">Add New Order</a></li> --}}
				</ul>
			</li>
			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
					<span class="s-caret"><i class="fa fa-angle-down"></i></span>
					<span class="s-icon"><i class="fa fa-ticket"></i></span>
					<span class="s-text">Tickets</span>
				</a>
				<ul>
					<li><a href="{{ url('support/add_newticket') }}">New Ticket</a></li>
					<li><a href="{{ url('support/todaytickets') }}">Today's Tickets</a></li>
					<li><a href="{{ url('support/opentickets') }}">Open Tickets</a></li>
					<li><a href="{{ url('support/closetickets') }}">Closed Tickets</a></li>
				</ul>
			</li>
			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
					<span class="s-caret"><i class="fa fa-angle-down"></i></span>
					<span class="s-icon"><i class="fa fa-comments"></i></span>
					<span class="s-text">Order Comments</span>
				</a>
				<ul>
					<li><a href="{{ url('/support/supportComment') }}">Support Comments</a></li>
					<li><a href="{{ url('support/allorder/comment') }}">Unsolve Comments</a></li>
					<li><a href="{{ url('support/solved_comment') }}">Solved Comments</a></li>
				</ul>
			</li>
			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
					<span class="s-caret"><i class="fa fa-angle-down"></i></span>
					<span class="s-icon"><i class="ti-receipt"></i></span>
					<span class="s-text">Queries</span>
				</a>
				<ul>
					{{-- <li><a href="{{ route('support.openTicket', 'new') }}" >New Queries</a></li> --}}
						<li><a href="{{ route('support.openTicket', 'open') }}" >Open Queries</a></li>
						<li><a href="{{ route('support.closeTicket') }}" >Close Queries</a></li>
				</ul>
			</li>
		
			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
				<span class="s-caret"><i class="fa fa-angle-down"></i></span>
					<span class="s-icon"><i class="fa fa-user"></i></span>
					<span class="s-text">Profile</span>
				</a>  
				<ul>
				<li><a href="{{ route('support.profile') }}" >Profile</a></li>
				<li><a href="{{ route('support.password') }}" >Change Password</a></li>
				</ul>
			</li>

			<li class="compact-hide" style="margin-bottom: -16px;">
				<a href="{{ url('/support/logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
					<span class="s-icon"><i class="fa fa-power-off"></i></span>
					<span class="s-text">Logout</span>
                </a>

                <form id="logout-form" action="{{ url('/support/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
			</li>
			
		</ul>
	</div>
</div>