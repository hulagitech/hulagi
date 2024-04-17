<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Hulagi</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- App Icons -->
    <link rel="shortcut icon" type="image/png" href="{{ asset(Setting::get('site_icon')) }}">


    <!-- App css -->
    <link href="{{ asset('asset/user/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('asset/user/css/icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('asset/user/css/style.css') }}" rel="stylesheet" type="text/css" />

</head>


<body>

    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner">
                <div class="rect1"></div>
                <div class="rect2"></div>
                <div class="rect3"></div>
                <div class="rect4"></div>
                <div class="rect5"></div>
            </div>
        </div>
    </div>

    <!-- Begin page -->
    <div class="home-btn d-none d-sm-block">
        <a href="{{ url('/') }}" class="text-dark"><i class="mdi mdi-home h1"></i></a>
    </div>

    <div class="account-pages">

        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div>
                        <div>
                            <a href="/" class="logo logo-admin"><img
                                    src="{{ asset('asset/user/images/Puryau-logo-black.png') }}" height="28"
                                    alt="logo"></a>
                        </div>
                        {{-- <h5 class="font-14 text-muted mb-4">Hulagi Logistics</h5> --}}

                        @if (Route::is('register'))
                            <p class="text-muted mb-4">Hulagi for buisness has helped buisness delivery goods all over
                            Nepal and world with zero hastle. Grow your buisness today</p>@else <p
                                class="text-muted mb-4">A logistic solution build for your business ,4000+ merchants,
                                big and small use Hulagi for home delivery</p>
                        @endif

                        <h5 class="font-14 text-muted mb-4">Terms :</h5>





                        <div>
                            <p><i class="mdi mdi-arrow-right text-primary mr-2"></i>This Agreement is for the Courier
                                Delivery Service . </p>
                            <p><i class="mdi mdi-arrow-right text-primary mr-2"></i>Including (Cash On Delivery) COD
                                Pick Up Service for any part of Nepal. </p>
                            <p><i class="mdi mdi-arrow-right text-primary mr-2"></i>The parties hereby agree to the
                                provided <a href="{{ url('/vendor-terms-and-conditions') }}">Terms and Conditions.</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1">
                    @yield('content')
                </div>
            </div>
            <!-- end row -->
        </div>
    </div>



    <!-- jQuery  -->

    <script src="{{ asset('asset/user/js/jquery.min.js') }}"></script>
    <script src="{{ asset('asset/user/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('asset/user/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('asset/user/js/waves.js') }}"></script>
    <script src="{{ asset('asset/user/js/jquery.slimscroll.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('asset/user/js/app.js') }}"></script>

</body>

</html>
