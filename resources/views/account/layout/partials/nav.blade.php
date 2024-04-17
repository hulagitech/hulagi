<div class="site-sidebar">
	<div class="custom-scroll custom-scroll-light">
		<ul class="sidebar-menu">
			<li class="active">
				<a href="{{ route('account.dashboard') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="fa fa-dashboard"></i></span>
					<span class="s-text">Dashboard</span>
				</a>
			</li>

			{{-- <li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
					<span class="s-caret"><i class="fa fa-angle-down"></i></span>
					<span class="s-icon"><i class="ti-stats-up"></i></span>
					<span class="s-text">Settlement</span>
				</a>
            	<ul> --}}
               		{{-- <li class="with-sub">
						<a href="#" class="waves-effect  waves-light">
						<span class="s-text">Account Info</span>
						<span class="s-caret"><i class="fa fa-angle-down"></i></span></a>
						<ul>
							<li><a href="{{ url('account/new_account') }}">New Account</a></li>
							<li><a href="{{ url('account/approved_account') }}">Approved Account</a></li>
						</ul>
					</li>  --}}
					{{-- <li class="with-sub">
						<a href="#" class="waves-effect  waves-light">
							<span class="s-text">Withdraw Info</span>
							<span class="s-caret"><i class="fa fa-angle-down"></i></span>
						</a>
						<ul>
							<li><a href="{{ url('account/new_withdraw') }}">Withdraw Requests</a></li>
							<li><a href="{{ url('account/approved_withdraw') }}">Approved Withdraw</a></li>
						</ul>
					</li>
				</ul>
        	</li>
			
			<!--<li class="menu-title">Accounts Statements</li>-->
			{{-- <li>
				<a href="{{ route('account.ride.statement') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="ti-harddrives"></i></span>
					<span class="s-text">Ride Statments</span>
				</a>
			</li> --}}
			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
				   <span class="s-caret"><i class="fa fa-angle-down"></i></span>
				   <span class="s-icon"><i class="fa fa-car"></i></span>
				   <span class="s-text">User Statement</span>
				</a>
				<ul>
				   <li><a href="{{ route('account.ride.statement.user') }}">Requested</a></li>
				   {{-- <li><a href="{{ route('account.ride.banned.statement') }}">Banned</a></li> --}}
				   <li><a href="{{ route('account.ride.allNagative') }}">Negative Wallet</a></li>
				</ul>
			</li>
			
			{{-- <li><a href="{{ route('admin.minizone.track') }}">Track Rider</a></li> --}}
			{{-- <li>
				<a href="{{ route('account.ride.statement.provider') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="fa fa-car"></i></span>
					<span class="s-text">Rider Statement</span>
				</a>
			</li> --}}
			
			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
				   <span class="s-caret"><i class="fa fa-angle-down"></i></span>
				   <span class="s-icon"><i class="fa fa-car"></i></span>
				   <span class="s-text">Rider Statement</span>
				</a>
				<ul>
				   <li><a href="{{ route('account.ride.statement.provider') }}">Approved</a></li>
				   {{-- <li><a href="{{ route('account.ride.banned.statement') }}">Banned</a></li> --}}
				   <li><a href="{{ route('account.bannedStatement') }}">Banned</a></li>
				   <li><a href="{{url('account/rider/settled')}}">Settled</a></li>
				   
				</ul>
			</li>
			<li class="with-sub">
				   <a href="#" class="waves-effect  waves-light">
				   <span class="s-caret"><i class="fa fa-angle-down"></i></span>
				   <span class="s-icon"><i class="fa fa-car"></i></span>
				   <span class="s-text">Rider Bill Statement</span>
					</a>
						<ul>
							<li ><a href="{{ route('account.ride.bill') }}"> Verified Rider Payment Bill </a></li>
							<li ><a href="{{ route('account.ride.bill.unverified') }}"> Unverified Rider Payment Bill </a></li>
						</ul>
			</li>
			<li class="with-sub">
				   <a href="{{ route('account.ride.allrequested') }}" class="waves-effect  waves-light" target="_blank">
				   <span class="s-caret"></span>
				   <span class="s-icon"><i class="fa fa-money "></i></span>
				   <span class="s-text">Total Request</span>
					</a>
			</li>
			
			{{-- <li>
				<a href="{{ route('account.ride.statement.today') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="ti-layers-alt"></i></span>
					<span class="s-text">Daily Statement</span>
				</a>
			</li>
			
			<li>
				<a href="{{ route('account.ride.statement.monthly') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="fa fa-pie-chart"></i></span>
					<span class="s-text">Monthly Statement</span>
				</a>
			</li> --}}
			
			{{-- <li>
				<a href="{{ route('account.ride.statement.yearly') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="ti-package"></i></span>
					<span class="s-text">Yearly Statement</span>
				</a>
			</li> --}}
			
			<!--<li class="menu-title">Account</li>-->
			<li>
				<a href="{{ route('account.minizone.track') }}" class="waves-effect  waves-light">
					<span class="s-icon"><i class="ti-zoom-in"></i></span>
					<span class="s-text">Track Rider</span>
				</a>
			</li>
			<li>
				<a href="{{ route('account.dateSearch') }}" class="waves-effect  waves-light">
					<span class="s-icon"><i class="fa fa-pie-chart"></i></span>
					<span class="s-text">Order By Date</span>
				</a>
			</li>
			<li>
				<a href="{{ route('account.unsolve_comments') }}" class="waves-effect  waves-light">
					<span class="s-icon"><i class="fa fa-comment"></i></span>
					<span class="s-text">Account Comments</span>
				</a>
			</li>

			{{-- <li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
					<span class="s-caret"><i class="fa fa-angle-down"></i></span>
					<span class="s-icon"><i class="fa fa-comments"></i></span>
					<span class="s-text">Order Comments</span>
				</a>
				<ul>
					<li><a href="{{ route('account.unsolve_comments') }}">Account Comments</a></li>
					{{-- <li><a href="{{ route('account.solved_comments') }}">Solved Comments</a></li> --}}
				{{-- </ul>
			</li> --}} 
			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
				   <span class="s-caret"><i class="fa fa-angle-down"></i></span>
				   <span class="s-icon"><i class="fa fa-ticket"></i></span>
				   <span class="s-text">Completed Orders</span>
				</a>
				<ul>
					<li><a href="{{ route('account.rider.completed') }}">Rider Wise</a></li>
					<li><a href="{{ route('account.vendor.completed') }}">Vendor Wise</a></li>
				</ul>
			</li>

			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
				   <span class="s-caret"><i class="fa fa-angle-down"></i></span>
				   <span class="s-icon"><i class="fa fa-ticket"></i></span>
				   <span class="s-text">Tickets</span>
				</a>
				<ul>
				   {{-- <li><a href="{{ route('account.todaytickets') }}">Today's Tickets</a></li> --}}
				   <li><a href="{{ route('account.opentickets') }}">All Tickets</a></li>
				</ul>
			</li>

			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
				   <span class="s-caret"><i class="fa fa-angle-down"></i></span>
				   <span class="s-icon"><i class="fa fa-bell"></i></span>
					<span class="s-text">Queries</span>
				</a>
				<ul>
				   <li><a href="{{ route('account.openTicket','new') }}">New Query</a></li>
				   <li><a href="{{ route('account.openTicket','open') }}">Open Query</a></li>
				   <li><a href="{{ route('account.closeTicket') }}">Closed Query</a></li>
				</ul>
			</li>
			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
				   <span class="s-caret"><i class="fa fa-angle-down"></i></span>
				   <span class="s-icon"><i class="fa fa-list-alt"></i></span>
				   <span class="s-text">Invoice</span>
				</a>
				<ul>
				   <li><a href="{{ route('account.userInvoice') }}">User Invoice</a></li>
				   <li><a href="{{ route('account.riderInvoice') }}">Rider Invoice</a></li>

				   {{-- <li><a href="{{ route('account.ride.banned.statement') }}">Banned</a></li> --}}
				   {{-- <li><a href="{{ route('account.ride.negative.wallet') }}">Negative Wallet</a></li> --}}
				</ul>
			</li>
			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
				   <span class="s-caret"><i class="fa fa-angle-down"></i></span>
				   <span class="s-icon"><i class="fa fa-list-alt"></i></span>
				   <span class="s-text">Payment History</span>
				</a>
				<ul>
				   <li><a href="{{ route('account.esewa') }}">Esewa History</a></li>
				</ul>
			</li>

			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
				   <span class="s-caret"><i class="fa fa-angle-down"></i></span>
				   <span class="s-icon"><i class="fa fa-money"></i></span>
				   <span class="s-text"> User A/C Details</span>
				</a>
				<ul>
				   <li><a href="{{ route('account.bank_infos') }}">Bank Details</a></li>
				   <li><a href="{{ route('account.khalti_infos') }}">Khalti Details</a></li>
				</ul>
			</li>
			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
					<span class="s-caret"><i class="fa fa-angle-down"></i></span>
					<span class="s-icon"><i class="fa fa-user"></i></span>
					<span class="s-text"> Profile</span>
				</a>
				<ul>
				   <li><a href="{{ route('account.profile') }}">Change Profile</a></li>
				   <li><a href="{{ route('account.password') }}">Change Password</a></li>
				</ul>
			</li>
			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
				   <span class="s-caret"><i class="fa fa-angle-down"></i></span>
				   <span class="s-icon"><i class="fa fa-money"></i></span>
				   <span class="s-text">Wallet</span>
				</a>
				<ul>
				<li>
				<a href="{{ route('account.user.user') }}" class="waves-effect  waves-light">
					<span class="s-icon"><i class="fa fa-user"></i></span>
					<span class="s-text">User wallet</span>
				</a>
				</li>
				<li><a href="{{ route('account.providers.providerwallet') }}"><i class="fa fa-motorcycle"></i> Provider Wallet</a></li>
				<li><a href="{{url('account/payableUserAndVendor') }}"> <i class="fa fa-plane"></i> Amount Data </a></li>
				</ul>
			</li>
			<li>
				<a href="{{ route('account.order') }}" class="waves-effect  waves-light">
					<span class="s-icon"><i class="ti-exchange-vertical"></i></span>
					<span class="s-text">Oder before 31 Ashar</span>
				</a>
			</li>
			
			<li>
				<a href="{{ route('account.password') }}" class="waves-effect  waves-light">
					<span class="s-icon"><i class="ti-exchange-vertical"></i></span>
					<span class="s-text">Change Password</span>
				</a>
			</li>
			
			<li class="compact-hide">
				<a href="{{ url('/account/logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
					<span class="s-icon"><i class="fa fa-power-off"></i></span>
					<span class="s-text">Logout</span>
                </a>

                <form id="logout-form" action="{{ url('/account/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
			</li>	
		</ul>
	</div>
</div>