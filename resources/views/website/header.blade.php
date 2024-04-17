<?php 
$services = get_all_service_types();
?>
<style>
    .logo{
        margin: -5px 0px 10px 80px;
    }
    .navbar-default .navbar-nav>li>a{
        color:black;
    }
    .navbar-default .navbar-nav>li>a:hover{
        color:#777;
    }
    .navbar-default .navbar-nav>li>a.driver-btn{
        color:white;
        background: black;
    }
    .navbar-default .navbar-nav>li>a.driver-btn:hover{
        color:black;
        background: #777;
    }
    .navbar{
        margin-bottom: 0px;
        padding-top: 4px;
    }
</style>
<header>
    
    <nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <div class="logo" >                        

            <a href="{{ url('/') }}"><img src="{{ url(Setting::get('site_logo')) }}" height="100%" style="margin-top: 4%;"/></a>                    

            </div>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
            @if(Auth::user())
                <li class="dropdown">
                    <form id="logout-user" action="{{ url('/logout') }}" method="POST" class="d-none">

                        {{ csrf_field() }}

                        </form>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{Auth::user()->first_name}} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                    <li><a href="{{url('dashboard')}}">Dashboard</a></li>
                    <li><a href="{{url('profile')}}">Profile</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="#" id="logout">Logout</a></li>
                    </ul>
                    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
                    <script>
                        $(document).ready(function(){
                            $("#logout").click(function(){
                                console.log('asd');
                                $("#logout-user").submit();
                            });
                        });
                    </script>
                </li>
            @elseif(Auth::guard('provider')->user())
                <li class="dropdown">
                    <form id="logout-user" action="{{ url('provider/logout') }}" method="POST" class="d-none">

                        {{ csrf_field() }}

                        </form>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{Auth::guard('provider')->user()->first_name}} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                    <li><a href="{{url('provider/dashboard')}}">Dashboard</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="#" id="logout">Logout</a></li>
                    </ul>
                    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
                    <script>
                        $(document).ready(function(){
                            $("#logout").click(function(){
                                console.log('asd');
                                $("#logout-user").submit();
                            });
                        });
                    </script>
                </li>
            @else
                <li><a href="{{ url('/trackMyOrder') }}">Track Order</a></li>
                <!-- <li><a href="{{ url('/register') }}">Sign Up</a></li> -->
            @endif 
            @if(!Auth::check())
                @if(!Auth::guard('provider')->user())
                    <li>
                        <a href="{{url('/UserSignin')}}" class="driver-btn" style="border-radius:5px;">Place an Order{{-- strtoupper(trans('header.li_sign_in')) --}}</a>
                    </li>
                @endif  
            @endif  
        </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
    </nav>
</header>