<div class="site-sidebar">
	<div class="custom-scroll custom-scroll-light">
		<ul class="sidebar-menu">
			<li class="active">
				<a href="{{ route('pickup.dashboard') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="fa fa-dashboard"></i></span>
					<span class="s-text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="{{ route('pickup.rider.index') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="fa fa-motorcycle"></i></span>
					<span class="s-text">Rider</span>
				</a>   
			</li>
			<li>
				<a href="{{ route('pickup.user.index') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="fa fa-user"></i></span>
					<span class="s-text">User</span>
				</a>   
			</li>
			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
					<span class="s-caret"><i class="fa fa-angle-down"></i></span>
					<span class="s-icon"><i class="fa fa-pie-chart"></i></span>
					<span class="s-text">Order Assign</span>
				</a>
				<ul>
					<li><a href="{{route('pickup.orders.bulkassign')}}">Bulk Assign</a></li>
					<li><a href="{{route('pickup.map.view')}}">Live Orders Map</a></li>
					<li><a href="{{route('pickup.remaining')}}">Pickup Remaining</a></li>
				</ul>
			</li>
			<li>
				<a href="{{ route('pickup.dateSearch') }}" class="waves-effect  waves-light">
					<span class="s-icon"><i class="fa fa-user"></i></span>
					<span class="s-text">Orders By Date</span>
				</a>  
			</li>
			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
				   <span class="s-caret"><i class="fa fa-angle-down"></i></span>
				   <span class="s-icon"><i class="fa fa-ticket"></i></span>
				   <span class="s-text">Tickets</span>
				</a>
				<ul>
				    <li><a href="{{ route('pickup.newticket') }}">New Tickets</a></li>
				   <li><a href="{{ route('pickup.opentickets') }}">Pickup Tickets</a></li>
				</ul>
			</li>
			<li>
				<a href="{{ url('/pickup/pickupUnsolveComment') }}" class="waves-effect  waves-light">
					<span class="s-icon"><i class="fa fa-comment"></i></span>
					<span class="s-text">Pickup Comment</span>
				</a>  
			</li>
			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
				<span class="s-caret"><i class="fa fa-angle-down"></i></span>
					<span class="s-icon"><i class="fa fa-user"></i></span>
					<span class="s-text">Profile</span>
				</a>  
				<ul>
					<li> <a href="{{ route('pickup.profile') }}">Profile</a></li>
					<li><a href="{{route('pickup.password')}}">Change password</a></li>
				</ul>
			</li>
			<li class="compact-hide" style="margin-bottom: -16px;">
				<a href="{{ url('/pickup/logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
					<span class="s-icon"><i class="fa fa-power-off"></i></span>
					<span class="s-text">Logout</span>
                </a>

                <form id="logout-form" action="{{ url('/pickup/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
			</li>
		</ul>
	</div>
</div>