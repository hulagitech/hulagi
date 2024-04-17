<!DOCTYPE html>
<html class="no-js">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
	
    <title>{{ Setting::get('site_title') }}</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset(Setting::get('site_icon')) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="ZZYnRN5MMSoZZ1zVPmwHQnu2x5n-0gcTCtC9qQ4URnw" />

    <link rel="shortcut icon" type="image/png" href="{{ Setting::get('site_icon') }}"/>
	<link href="{{asset('asset/front/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('asset/front/css/index.css')}}" rel="stylesheet">
    <link href="{{asset('asset/front_dashboard/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{asset('asset/front_dashboard/css/custom.css') }}" rel="stylesheet">  
    <link href="{{asset('asset/front_dashboard/css/hamburgers.css') }}" rel="stylesheet">
    <link href="{{asset('asset/front_dashboard/css/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{asset('asset/front_dashboard/css/owl.theme.css') }}" rel="stylesheet">
	<link href="{{asset('asset/front/css/slick.css')}}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{asset('asset/front/css/slick-theme.css')}}"/>
	<link href="{{asset('asset/front/css/dashboard-style.css')}}" rel="stylesheet">
    <link href="{{asset('asset/front/css/ismael.css')}}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> --}}
  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
<!-- Latest compiled and minified JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
   @yield('styles')
   <link rel="stylesheet" href="{{asset('asset/front/css/styles.css')}}">
</head>
<body>
<div class="index">
	
	@include('website.header')
    
	@yield('content')
	
	@include('website.footer')
</div>
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script>
		base_url = "{{ env('APP_URL') }}"; 
	</script>
    <script src="{{ asset('asset/front_dashboard/js/jquery.min.js') }}"></script>
    <script src="{{ asset('asset/front_dashboard/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('asset/front_dashboard/js/owl.carousel.js') }}"></script>
    <script src="{{ asset('asset/front/js/livechat.js') }}"></script>
    <script>
        $("#left_menu_open").click(function(){
            $("#left_menu").addClass("open");
        });
        $(".close").click(function(){
            $("#left_menu").removeClass("open");
        });
        
        $(".hamburger").click(function(){
            $(".side_menu").toggleClass("open");
			$(this).toggleClass("is-active");
        }); 
         $(document).click(function(event) {    

          //if you click on anything except the modal itself or the "open modal" link, close the modal
          if (!$(event.target).closest(".hamburger,.is-active").length) {
            $("body").find("#left_menu").removeClass("open");
            $("body").find(".hamburger").removeClass("is-active");
          }
        });
		var forEach=function(t,o,r){if("[object Object]"===Object.prototype.toString.call(t))for(var c in t)Object.prototype.hasOwnProperty.call(t,c)&&o.call(r,t[c],c,t);else for(var e=0,l=t.length;l>e;e++)o.call(r,t[e],e,t)};

		var	site_url ="{{url('/')}}";
  
</script>

@yield('scripts')
<!-- Global site tag (gtag.js) - Google Ads: 969836617 --> <script async src="https://www.googletagmanager.com/gtag/js?id=AW-969836617"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-969836617'); </script>
<!-- Global site tag (gtag.js) - Google Ads: 969836617 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-969836617"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-969836617');
</script>
</body>
</html>

