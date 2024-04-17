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

    @yield('styles')


</head>


<body>

    

    @include('user.layout.partials.topbar')
    <!-- header-bg -->

    <div class="wrapper">
    @if ($user_wallet < 0)
            <div class="alert alert-danger alert-dismissible fade show mb-0 noprint text-center" role="alert">
                <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
                <strong>Dear Customers, You have RS.{{abs($user_wallet)}} to pay.
                    
                </strong> <a
                    href="{{url('wallet')}}">Click
                    here to Pay the Amount .</a>
            </div>
        @endif
        @if(Auth::user()->Business_Person=="Business")
        @if (Auth::user()->Agreement == 'NO')
            <div class="alert alert-danger alert-dismissible fade show mb-0 noprint text-center mt-1" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Dear Customers, You have not signed an agreement. Please Visit our office and sign an
                    agreement.
                    Don't be late
                </strong> <a
                    href="https://docs.google.com/forms/d/e/1FAIpQLSfrFVE05hRn1F95OHB3EYQ5eesaXxAy-KyFKkHVydAnf7_PkQ/viewform">Click
                    here to request agreement .</a>
            </div>
        @endif
        @endif
       
        <div class="container-fluid">
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
                    © 2022 Hulagi Logisticss
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
    @yield('scripts')
    <script>
        gtag('event', 'page_view', {
            'send_to': 'AW-969836617',
            'value': 'replace with value',
            'items': [{
                'id': 'replace with value',
                'location_id': 'replace with value',
                'google_business_vertical': 'custom'
            }]
        });
    </script>
<script src="https://js.pusher.com/3.0.0/pusher.min.js"></script>
<script>
$('.noti-icon').click(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/get-notification',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'html',
        success: function (data) {
           $('.slimscroll-noti').html(data)
        },
        error: function (error) {
            console.log("error");
        },
    });
});
 
</script>
 <script type="text/javascript" src="{{ asset('js/firebase.js') }}"></script> 

</body>

</html>
