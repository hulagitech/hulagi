@extends('user.layout.user-auth')
@section('content')
<style>
    #business{
            display:none;
        }
    .bussiness1{
        display:none,
    }
</style>
    <div class="card mb-0">
        <div class="card-body">
            <div class="p-2">
                <h4 class="text-muted float-right font-18 mt-4">Register</h4>
                <div>
                    <a href="/" class="logo logo-admin"><img src="{{ asset('asset/user/images/Puryau-logo-black.png') }}"
                            height="28" alt="logo"></a>
                </div>
            </div>

            <div class="p-2">
                <form class="form-horizontal m-t-20" method="POST" action="{{ url('/register') }}">
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <div class="col-12">
                            <input id="name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}"
                                placeholder="{{ trans('passengersignin.name') }}" required>
                            @if ($errors->has('first_name'))
                                <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <input type="number" autofocus="" id="mobile" class="form-control"
                                placeholder="{{ trans('passengersignin.phone') }}" name="mobile" value="{{ old('mobile') }}" required>
                            @if ($errors->has('mobile'))
                                <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('mobile') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <input id="email" type="email" class="form-control" name="email" value=""
                                placeholder="{{ trans('passengersignin.email_addr') }}" required>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12">
                            <input id="password" type="password" class="form-control" name="password"
                                placeholder="{{ trans('passengersignin.password') }}" required>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                            <label>Are you a buisness or a person?</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="BORP" id="person" value="Person" checked>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Personal purpose
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="BORP" id="BUSS" value="Business">
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Business purpose
                                </label>

                            </div>

                        </div>
                        <div class="form-group row col-12" id="business">
                            <div class="form-group row">
                            <div class="col-12">
                                <input id="name" type="text" class="form-control" name="company_name" value="{{ old('company_name') }}"
                                    placeholder="Company Name" autofocus="">
                                @if ($errors->has('company_name'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('company_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-12 ">
                                <input id="name" type="text" class="form-control" name="VAT/PAN" value="{{ old('VAT/PAN') }}"
                                    placeholder="VAT/PAN NUMBER" autofocus="" >
                                @if ($errors->has('VAT/PAN'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('VAT/PAN') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                                <div class="info" style="background-color: #e7f3fe;border-left: 6px solid #2196F3;">
                                    <p style="padding:1rem;"><strong>Info!</strong> You can proceed even if you don't have PAN/VAT number right now. Please update Your PAN/VAT from your profile after you sign up.
                                    </p>
                                </div>
                        </div>

                    </div>
                    <input id="referral_code" type="hidden" class="form-control" name="referral_code" value=""
                        placeholder="Referral Code" autofocus="">

                    <div class="form-group row">
                        <div class="col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck1"
                                    name="terms_conditions" required>
                                <label class="custom-control-label font-weight-normal" for="customCheck1">I accept <a
                                        href="/vendor-terms-and-conditions" class="text-primary">Terms
                                        and Conditions</a></label>
                                @if ($errors->has('terms_conditions'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('terms_conditions') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-center row m-t-20">
                        <div class="col-12">
                            <button class="btn btn-primary btn-block waves-effect waves-light"
                                type="submit">Register</button>
                        </div>
                    </div>

                    <div class="form-group m-t-10 mb-0 row">
                        <div class="col-12 m-t-20 text-center">
                            <a href="{{ url('/UserSignin') }}" class="text-muted">Already have
                                account?</a>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>
<script>
         $(document).ready(function() {
            $("#BUSS").click(function() {
                $("#business").show();
                $("#business1").show();
            });
            $("#person").click(function() {
                $("#business").hide();
                $("#business1").hide();
            });
        });
       
</script>


@endsection

@section('noscripts')


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.js"></script>
    <script>
        $("#left_menu_open").click(function() {
            $("#left_menu").addClass("open");
        });
        $(".close").click(function() {
            $("#left_menu").removeClass("open");
        });

        $(".hamburger").click(function() {
            $(".side_menu").toggleClass("open");
        });
    </script>
    <script>
        var forEach = function(t, o, r) {
            if ("[object Object]" === Object.prototype.toString.call(t))
                for (var c in t) Object.prototype.hasOwnProperty.call(t, c) && o.call(r, t[c], c, t);
            else
                for (var e = 0, l = t.length; l > e; e++) o.call(r, t[e], e, t)
        };

        var hamburgers = document.querySelectorAll(".hamburger");
        if (hamburgers.length > 0) {
            forEach(hamburgers, function(hamburger) {
                hamburger.addEventListener("click", function() {
                    this.classList.toggle("is-active");
                }, false);
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            
            $("#owl-demo2").owlCarousel({
                autoPlay: 3000,
                items: 3,
                autoPlay: true,
                navigation: true,
                navigationText: true,
                pagination: true,
                itemsDesktop: [1350, 3],
                itemsDesktop: [1199, 1],
                itemsDesktopSmall: [991, 1],
                itemsTablet: [767, 1],
                itemsMobile: [560, 1]
            });
         

        });
    </script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

    <script type="text/javascript">
        // When the window has finished loading create our google map below
        google.maps.event.addDomListener(window, 'load', init);

        function init() {
            // Basic options for a simple Google Map
            // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
            var mapOptions = {
                // How zoomed in you want the map to start at (always required)
                zoom: 11,

                // The latitude and longitude to center the map (always required)
                center: new google.maps.LatLng(40.6700, -73.9400), // New York

                // How you would like to style the map. 
                // This is where you would paste any style found on Snazzy Maps.
                styles: [{
                    "featureType": "all",
                    "elementType": "all",
                    "stylers": [{
                        "hue": "#e7ecf0"
                    }]
                }, {
                    "featureType": "poi",
                    "elementType": "all",
                    "stylers": [{
                        "visibility": "simplified"
                    }]
                }, {
                    "featureType": "poi",
                    "elementType": "labels.text",
                    "stylers": [{
                        "visibility": "off"
                    }]
                }, {
                    "featureType": "poi",
                    "elementType": "labels.icon",
                    "stylers": [{
                        "visibility": "on"
                    }]
                }, {
                    "featureType": "poi.park",
                    "elementType": "geometry.fill",
                    "stylers": [{
                        "color": "#8ed863"
                    }]
                }, {
                    "featureType": "road",
                    "elementType": "all",
                    "stylers": [{
                        "saturation": -70
                    }]
                }, {
                    "featureType": "transit",
                    "elementType": "all",
                    "stylers": [{
                        "visibility": "off"
                    }]
                }, {
                    "featureType": "water",
                    "elementType": "all",
                    "stylers": [{
                        "visibility": "simplified"
                    }, {
                        "saturation": -60
                    }]
                }, {
                    "featureType": "water",
                    "elementType": "geometry.fill",
                    "stylers": [{
                        "color": "#8abdec"
                    }]
                }, {
                    "featureType": "water",
                    "elementType": "geometry.stroke",
                    "stylers": [{
                        "color": "#9cbbf0"
                    }]
                }, {
                    "featureType": "water",
                    "elementType": "labels.text",
                    "stylers": [{
                        "visibility": "off"
                    }]
                }]
            };

            // Get the HTML DOM element that will contain your map 
            // We are using a div with id="map" seen below in the <body>
            var mapElement = document.getElementById('map');

            // Create the Google Map using our element and options defined above
            var map = new google.maps.Map(mapElement, mapOptions);

            // Let's also add a marker while we're at it
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(40.6700, -73.9400),
                map: map,
                title: 'Snazzy!'
            });
        }
    </script>


    <script src="https://sdk.accountkit.com/en_US/sdk.js"></script>
    <script>
        // initialize Account Kit with CSRF protection
        AccountKit_OnInteractive = function() {
            AccountKit.init({
                appId: {{ env('FB_APP_ID') }},
                state: "state",
                version: "{{ env('FB_APP_VERSION') }}",
                fbAppEventsEnabled: true
            });
        };

        // login callback
        function loginCallback(response) {
            if (response.status === "PARTIALLY_AUTHENTICATED") {
                var code = response.code;
                var csrf = response.state;
                // Send code to server to exchange for access token
                $('#mobile_verfication').html("<p class='helper'> * Phone Number Verified </p>");
                $('#mobile').attr('readonly', true);
                $('#country_code').attr('readonly', true);
                $('#second_step').fadeIn(400);

                $.post("{{ route('account.kit') }}", {
                    code: code
                }, function(data) {
                    $('#mobile').val(data.phone.national_number);
                    $('#country_code').val('+' + data.phone.country_prefix);
                });

            } else if (response.status === "NOT_AUTHENTICATED") {
                // handle authentication failure
                $('#mobile_verfication').html("<p class='helper'> * Authentication Failed </p>");
            } else if (response.status === "BAD_PARAMS") {
                // handle bad parameters
            }
        }

        // phone form submission handler
        function smsLogin() {
            var countryCode = document.getElementById("country_code").value;
            var phoneNumber = document.getElementById("mobile").value;

            $('#mobile_verfication').html("<p class='helper'> Please Wait... </p>");
            $('#mobile').attr('readonly', true);
            $('#country_code').attr('readonly', true);

            AccountKit.login(
                'PHONE', {
                    countryCode: countryCode,
                    phoneNumber: phoneNumber
                }, // will use default values if not specified
                loginCallback
            );
        }
    </script>
    

@endsection
