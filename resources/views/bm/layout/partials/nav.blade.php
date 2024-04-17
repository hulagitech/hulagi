<div class="site-sidebar">
	<div class="custom-scroll custom-scroll-light">
		<ul class="sidebar-menu">
			<li class="active">
				<a href="{{ route('bm.dashboard') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="fa fa-dashboard"></i></span>
					<span class="s-text">Dashboard</span>
				</a>
			</li>

			<li>
				<a href="{{ route('bm.provider') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="fa fa-motorcycle"></i></span>
					<span class="s-text">Rider</span>
				</a>
			</li>

			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
					<span class="s-caret"><i class="fa fa-angle-down"></i></span>
					<span class="s-icon"><i class="fa fa-pie-chart"></i></span>
					<span class="s-text">Orders</span>
				</a>
				<ul>
					{{-- <li><a href="{{ route('bm.requests.dateSearch') }}">Order By Date</a></li> --}}
					<li><a href="{{route('bm.recenttrips')}}">Order By Date</a></li>
					<li><a href="{{route('bm.CustomerQuery')}}">Customer Query</a></li>
					<li><a href="{{route('bm.InactiveOrder')}}">Inactive Order</a></li>
					<li><a href="{{route('bm.delaySearch')}}">Delay Order</a></li>
				</ul>
			</li>

			{{-- <li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
					<span class="s-caret"><i class="fa fa-angle-down"></i></span>
					<span class="s-icon"><i class="fa fa-undo"></i></span>
					<span class="s-text">Return Orders</span>
				</a>
				<ul>
                    <li><a href="{{ route('bm.tobereturn') }}"> To Be Return List </a></li>
                    <li><a href="{{ route('bm.allOrder_inHub') }}"> Returned to Hub </a></li>
                    <li><a href="{{ route('bm.returnedOrder') }}"> Return Completed </a></li>
                 </ul>
			</li> --}}

            <li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
					<span class="s-caret"><i class="fa fa-angle-down"></i></span>
					<span class="s-icon"><i class="fa fa-undo"></i></span>
					<span class="s-text">Return Orders</span>
				</a>
				<ul>
                    <li><a href="#"> To Be Return List </a></li>
                    <li><a href="#"> Returned to Hub </a></li>
                    <li><a href="#"> Return Completed </a></li>
                 </ul>
			</li>

			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
					<span class="s-caret"><i class="fa fa-angle-down"></i></span>
					<span class="s-icon"><i class="fa fa-comments"></i></span>
					<span class="s-text">Order Comments</span>
				</a>
				<ul>
					<li><a href="{{ route('bm.unsolve_comments') }}">Unsolve Comments</a></li>
					<li><a href="{{ route('bm.solved_comments') }}">Solved Comments</a></li>
					<li><a href="{{ route('bm.branchComment') }}">Branch Comments</a></li>
				</ul>
			</li>

			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
				   <span class="s-caret"><i class="fa fa-angle-down"></i></span>
				   <span class="s-icon"><i class="fa fa-ticket"></i></span>
				   <span class="s-text">Tickets</span>
				</a>
				<ul>
				   <li><a href="{{ route('bm.todaytickets') }}">Today's Tickets</a></li>
				   <li><a href="{{ route('bm.opentickets') }}">All Tickets</a></li>
				</ul>
			</li>
		 
			<li>
				<a href="{{ route('bm.profile') }}" class="waves-effect  waves-light">
					<span class="s-icon"><i class="fa fa-user"></i></span>
					<span class="s-text">Profile</span>
				</a>  
			</li>

			<li class="compact-hide" style="margin-bottom: -16px;">
				<a href="{{ url('/bm/logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
					<span class="s-icon"><i class="fa fa-power-off"></i></span>
					<span class="s-text">Logout</span>
                </a>

                <form id="logout-form" action="{{ url('/bm/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
			</li>
			
		</ul>
	</div>
</div>