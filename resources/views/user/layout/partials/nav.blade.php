
<div class="site-sidebar"> <!-- style="height: 100%;position: fixed;" -->
    <div class="custom-scroll custom-scroll-light">
         <div class="user-img">
            <?php $profile_image = img(Auth::user()->picture); ?>
            <div class="pro-img" style="background-image: url({{$profile_image}});margin-top: 15px;"></div>
            <!--@if(Auth::user()->Agreement=="YES")
            <h4 style="color: #ffffff;text-align: center;"><span>&#9989;</span>{{Auth::user()->first_name}} </h4>
            @else
            <h4 style="color: #ffffff;text-align: center;">{{Auth::user()->first_name}} </h4>
            @endif-->
            
                    <a href="{{url('profile')}}" class="waves-effect waves-light" style="text-decoration:none">
                        <span class="s-icon"><i class="ti-user user-sidebaricon" style="font-size:25px;"></i></span>
                        @if(Auth::user()->Agreement=="YES")
                        <span class="s-text user-dashboard" style="font-size:18px;">{{Auth::user()->first_name}}</span><span>&#9989;</span>
                        @else
                        <span class="s-text user-dashboard" style="font-size:18px;">{{Auth::user()->first_name}}</span>
                        @endif
                    </a>
                

        </div>
        <div style="margin-top: 30px;">
            <ul class="sidebar-menu">

                <li>
                    <a href="{{url('dashboard')}}" class="waves-effect waves-light" style="text-decoration:none">
                        <span class="s-icon"><i class="ti-control-record" style="color:rgba(255, 255, 255, 0.7); font-size:25px;"></i></span>
                        <span class="s-text user-dashboard" style="font-size:18px;">@lang('user.dashboard')</span>
                    </a>
                </li>

                <li>
                    <a href="{{url('new_trips')}}" class="waves-effect waves-light" style="text-decoration:none">
                        <span class="s-icon"><i class="ti-car user-sidebaricon" style="font-size:25px;"></i></span>
                        <span class="s-text user-dashboard" style="font-size:18px;">@lang('user.my_rides')</span>
                    </a>
                </li>
                <li >
                    <a href="{{url('mytrips')}}" class="waves-effect waves-light" style="text-decoration:none">
                        <span class="s-icon" ><i class="ti-pie-chart" style="color:rgba(255, 255, 255, 0.7); font-size:25px; "></i></span>
                        <span class="s-text user-dashboard" style="font-size:18px;">@lang('user.list_ride')</span>
                    </a>
                </li>


                <li>
                    <a href="{{url('multiTrips')}}" class="waves-effect waves-light" style="text-decoration:none">
                        <span class="s-icon"><i class="ti-car user-sidebaricon" style="font-size:25px;"></i></span>
                        <span class="s-text user-dashboard" style="font-size:18px;">Bulk Order</span>
                    </a>
                </li>
    
                <li>
                    <a href="{{url('upcoming/trips')}}" class="waves-effect waves-light" style="text-decoration:none">
                        <span class="s-icon"><i class="ti-calendar user-sidebaricon" style="font-size:25px;"></i></span>
                        <span class="s-text user-dashboard" style="font-size:18px;">@lang('user.upcoming_rides')</span>
                    </a>
                </li>
                <li class="with-sub">
                    <a href="#" class="waves-effect  waves-light" style="text-decoration:none">
                       <span class="s-caret"><i class="fa fa-angle-down user-sidebaricon" style="font-size:25px;"></i></span>
                       <span class="s-icon"><i class="fa fa-comment user-sidebaricon" style="font-size:25px;"></i></span>
                       <span class="s-text user-dashboard" style="font-size:18px;">Comment</span>
                    </a>
                    <ul>
                        <li><a href="{{url('/comments')}}"  style="font-size:16px;">New Comment</a></li>
                       <li><a href="{{url('/all_comments')}}"  style="font-size:16px;">All Comment</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{url('/ticket')}}" class="waves-effect waves-light">
                        <span class="s-icon"><i class="ti-ticket user-sidebaricon" style="font-size:25px;"></i></span>
                        <span class="s-text user-dashboard" style="font-size:18px;">Ticket</span>
                    </a>
                </li>
                <li>
                    <a href="{{url('/payment_history')}}" class="waves-effect waves-light">
                        <span class="s-icon"><i class="ti-list user-sidebaricon" style="font-size:25px;"></i></span>
                        <span class="s-text user-dashboard" style="font-size:18px;">Payment History</span>
                    </a>
                </li>
               
               
                <!---
                <li>
                    <a href="{{url('profile')}}" class="waves-effect waves-light" style="text-decoration:none">
                        <span class="s-icon"><i class="ti-user user-sidebaricon"></i></span>
                        <span class="s-text user-dashboard" style="font-size:18px;">@lang('user.profile.profile')</span>
                    </a>
                </li>--->


                <li>
                    <a href="{{url('/wallet')}}" class="waves-effect waves-light">
                        <span class="s-icon"><i class="ti-wallet user-sidebaricon" style="font-size:25px;"></i></span>
                        <span class="s-text user-dashboard" style="font-size:18px;">@lang('user.my_wallet')</span>
                    </a>
                </li>

                <li>
                    <a href="{{url('/promotions')}}" class="waves-effect waves-light" style="text-decoration:none">
                        <span class="s-icon"><i class="ti-bookmark-alt" style="color:rgba(255, 255, 255, 0.7); font-size:25px;"></i></span>
                        <!--span class="s-text user-dashboard">@lang('user.promotion')</span-->
                        <span class="s-text user-dashboard" style="font-size:18px;">@lang('user.promocode')</span>
                    </a>
                </li>
				
               

              
<!--
				
                <li>
                    <a href="{{url('/faq')}}" class="waves-effect waves-light">
                        <span class="s-icon"><i class="ti-menu-alt user-sidebaricon"></i></span>
                        <span class="s-text user-dashboard">FAQ</span>
                    </a>
                </li>

                <li>
                    <a href="{{url('/terms')}}" class="waves-effect waves-light">
                        <span class="s-icon"><i class="ti-info user-sidebaricon"></i></span>
                        <span class="s-text user-dashboard">Terms and Condition</span>
                    </a>
                </li>

                <li>
                    <a href="{{url('/help')}}" class="waves-effect waves-light">
                        <span class="s-icon"><i class="ti-help user-sidebaricon"></i></span>
                        <span class="s-text user-dashboard">Help</span>
                    </a>
                </li>
				
				-->
                <li>
                    <a href="{{ url('/logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();" class="waves-effect waves-light" style="text-decoration:none">
                    <span class="s-icon"><i class="ti-power-off user-sidebaricon" style="font-size:25px;"></i></span>
                    <span class="s-text user-dashboard" style="font-size:18px;">@lang('user.profile.logout')</span>
                    </a>
                </li>
                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                <!--li><a href="{{url('dashboard')}}">@lang('user.dashboard')</a></li-->
                <!--li><a href="{{url('trips')}}">@lang('user.my_trips')</a></li-->
                <!--li><a href="{{url('upcoming/trips')}}">@lang('user.upcoming_trips')</a></li-->
                <!--li><a href="{{url('profile')}}">@lang('user.profile.profile')</a></li-->
                <!--li><a href="{{url('change/password')}}">@lang('user.profile.change_password')</a></li-->
                <!--li><a href="{{url('/payment')}}">@lang('user.payment')</a></li-->
                <!--li><a href="{{url('/promotions')}}">@lang('user.promotion')</a></li-->
                <!--li><a href="{{url('/wallet')}}">@lang('user.my_wallet') <span class="pull-right" style="color: #ffffff;">{{currency(Auth::user()->wallet_balance)}}</span></a></li-->
                <!--li><a href="{{ url('/logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">@lang('user.profile.logout')</a></li>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form-->
            </ul>
        </div>
    </div>
</div>


<!--div class="col-md-3">
    <div class="dash-left">
        <div class="user-img">
            <?php $profile_image = img(Auth::user()->picture); ?>
            <div class="pro-img" style="background-image: url({{$profile_image}});"></div>
            <h4>{{Auth::user()->first_name}} {{Auth::user()->last_name}}</h4>
        </div>
        <div class="side-menu">
             <ul>
                <li><a href="{{url('dashboard')}}">@lang('user.dashboard')</a></li>
                <li><a href="{{url('trips')}}">@lang('user.my_trips')</a></li>
                <li><a href="{{url('upcoming/trips')}}">@lang('user.upcoming_trips')</a></li>
                <li><a href="{{url('profile')}}">@lang('user.profile.profile')</a></li>
                <li><a href="{{url('change/password')}}">@lang('user.profile.change_password')</a></li>
                <li><a href="{{url('/payment')}}">@lang('user.payment')</a></li>
                <li><a href="{{url('/promotions')}}">@lang('user.promotion')</a></li>
                <li><a href="{{url('/wallet')}}">@lang('user.my_wallet') <span class="pull-right">{{currency(Auth::user()->wallet_balance)}}</span></a></li>
                <li><a href="{{ url('/logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">@lang('user.profile.logout')</a></li>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
            </ul>
        </div>
    </div>
</div-->