<!-- Header -->



<div class="site-header navbar-fixed-top">
	<nav class="navbar navbar-light">
		<div class="col-sm-1 col-xs-1">
            <div class="hamburger hamburger--elastic" style="width: 8px; height:8px;">
            {{-- <div class="hamburger hamburger--3dy-r"> --}}
                <div class="hamburger-box">
                    <div class="hamburger-inner" style="font-size: 8px;"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xs-6">
            <div class="navbar-left" style="background-color: #fff; display:flex;">
                <a class="navbar-brand" href="{{url('return/dashboard')}}" style="background:white;">
                    <div class="logo">
                        <img  style="width: 132px; height: 40px;" src=" {{ url(Setting::get('site_logo', asset('logo-black.png'))) }}">
                    </div>
                </a>
                <span style="width:200px; padding-top:20px;  font-size:22px; font-weight:bold; display:flex;"> &nbsp; - Return</span>
                {{-- <div class="toggle-button-second dark float-xs-right hidden-md-up">
                    <i class="fa fa-arrow-left"></i>
                </div>
                <div class="toggle-button dark float-xs-right hidden-md-up" data-toggle="collapse" data-target="#collapse-1">
                    <span class="more"></span>
                </div> --}}
                
            </div>
            {{-- <div class="navbar-left">
                <span> - Return User </span>
            </div> --}}
        </div>
		<div class="col-sm-5 col-xs-5">
            <div class="navbar-right navbar-toggleable-sm collapse" id="collapse-1">
               
                <ul class="nav navbar-nav float-md-right">
                    {{-- <li class="nav-item dropdown">
                        <a class="nav-link" href="#" data-toggle="dropdown" aria-expanded="false">
                            <i class="ti-bell"></i>
                            <span class="hidden-md-up ml-1">Ride</span>
                            <span class="tag tag-success top">1</span>
                        </a>
                        <div class="dropdown-tasks dropdown-menu dropdown-menu-right animated fadeInUp" style="min-width: 188px;">
                            <div class="t-item">
                            <div class="mb-0-5">
                                <a  href="{{ route('return.openTicket','new') }}">New Ticket </a>
                            </div>
                            </div>
                            <div class="t-item">
                            <div class="mb-0-5">
                                <a  href="{{ route('return.openTicket','open') }}">Open Ticket</a>
                            </div>
                            </div>
                            <div class="t-item">
                            <div class="mb-0-5">
                                <a  href="{{ route('return.closeTicket') }}">Close Ticket </a>
                            </div>
                            </div>
                            
                        </div>
                    </li> --}}
                    <li class="nav-item dropdown hidden-sm-down">
                        <a href="#" data-toggle="dropdown" aria-expanded="false">
                            <span class="avatar box-32">
                                @if(isset(Auth::guard('admin')->user()->picture))
                                    <img src="{{img(Auth::guard('return')->user()->picture)}}" alt="">
                                @else
                                    <img src="{{asset('asset/admin/avatar.jpg')}}" alt="">
                                @endif
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right animated fadeInUp">
                            <a class="dropdown-item" href="{{route('return.profile')}}">
                                <i class="ti-user mr-0-5"></i> Profile
                            </a>
                            {{-- <a class="dropdown-item" href="{{route('return.password')}}">
                                <i class="ti-settings mr-0-5"></i> Change Password
                            </a> --}}
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('/return/logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();"><i class="ti-power-off mr-0-5"></i> Sign out</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
	</nav>
</div>