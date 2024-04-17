<div class="site-sidebar">
	<div class="custom-scroll custom-scroll-light">
		<ul class="sidebar-menu">
			<li class="menu-title">Fulfillment Dashboard</li>
			<li>
				<a href="{{ route('fulfillment.index') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="ti-control-record"></i></span>
					<span class="s-text">Dashboard</span>
				</a>
			</li>

			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
					<span class="s-caret"><i class="fa fa-angle-down"></i></span>
					<span class="s-icon"><i class="ti-user"></i></span>
					<span class="s-text">Customers</span>
				</a>
				<ul>
					<li>
						<a href="{{ route('fulfillment.index') }}" class="waves-effect waves-light">
							<span class="s-icon"><i class="ti-control-record"></i></span>
							<span class="s-text">All Customers</span>
						</a>
						<a href="{{ route('fulfillment.index') }}" class="waves-effect waves-light">
							<span class="s-icon"><i class="ti-control-record"></i></span>
							<span class="s-text">Link/Add Customers</span>
						</a>
					</li>
				</ul>
         	</li>

			<li>
				<a href="{{ route('fulfillment.index') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="ti-shopping-cart"></i></span>
					<span class="s-text">Place a Order</span>
				</a>
			</li>

			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
					<span class="s-caret"><i class="fa fa-angle-down"></i></span>
					<span class="s-icon"><i class="ti-menu-alt"></i></span>
					<span class="s-text">Reports</span>
				</a>
				<ul>
					<li>
						<a href="{{ route('fulfillment.index') }}" class="waves-effect waves-light">
							<span class="s-icon"><i class="ti-control-record"></i></span>
							<span class="s-text">Day wise Orders</span>
						</a>
						<a href="{{ route('fulfillment.index') }}" class="waves-effect waves-light">
							<span class="s-icon"><i class="ti-control-record"></i></span>
							<span class="s-text">Rejected Orders</span>
						</a>
					</li>
				</ul>
         	</li>

			<li class="compact-hide">
				<a href="{{ url('/fulfillment/logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
					<span class="s-icon"><i class="ti-power-off"></i></span>
					<span class="s-text">Logout</span>
                </a>

                <form id="logout-form" action="{{ url('/fulfillment/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
			</li>
			
		</ul>
	</div>
</div>