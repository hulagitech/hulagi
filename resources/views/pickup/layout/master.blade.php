<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{ Setting::get('site_title') }}</title>
    <meta content="{{ csrf_token() }}" name="csrf-token" />
    <link rel="shortcut icon" type="image/png" href="{{ asset(Setting::get('site_icon')) }}">


    <!-- morris css -->
    <link rel="stylesheet" href="{{ asset('asset/user/plugins/morris/morris.css') }}">

    <!-- App css -->
    <link href="{{ asset('asset/user/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('asset/user/css/icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('asset/user/css/style.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('asset/user/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('asset/user/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <script src="https://www.gstatic.com/firebasejs/8.9.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.9.0/firebase-messaging.js"></script>


    <link rel="manifest" href="/manifest.json">
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/front/css/jnoty.min.css') }}">
    

    @yield('styles')


</head>


<body>



    @include('pickup.layout.partials.topbar')
    <!-- header-bg -->

    <div class="wrapper">

        <div class="container-fluid">
            @include('common.notify')
            @yield('content')

            <!-- end row -->
        </div> <!-- end container-fluid -->
    </div>
    <!-- end wrapper -->


    <!-- Footer -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    © 2022 Hulagi Logistics
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer -->


    <!-- jQuery  -->
    <script src="{{ asset('asset/user/js/jquery.min.js') }}"></script>
    <script src="{{ asset('asset/user/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('asset/user/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('asset/user/js/waves.js') }}"></script>
    <script src="{{ asset('asset/user/js/jquery.slimscroll.js') }}"></script>

    <!--Morris Chart-->
    <script src="{{ asset('asset/user/plugins/morris/morris.min.js') }}"></script>
    <script src="{{ asset('asset/user/plugins/raphael/raphael.min.js') }}"></script>

    <!-- dashboard js -->
    <script src="{{ asset('asset/user/pages/dashboard.int.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('asset/user/js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset/front/js/jnoty.min.js') }}"></script>

    @yield('scripts')
    

</body>

</html>
