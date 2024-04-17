<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{ Setting::get('site_title') }}</title>
    <meta content="{{ csrf_token() }}" name="csrf-token" />
    <link rel="shortcut icon" type="image/png" href="{{ asset(Setting::get('site_icon')) }}">

    <script src="{{ asset('asset/user/js/jquery.min.js') }}"></script>

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
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.js"
        integrity="sha256-XmdRbTre/3RulhYk/cOBUMpYlaAp2Rpo/s556u0OIKk=" crossorigin="anonymous"></script>
    <script src="https://www.gstatic.com/firebasejs/8.9.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.9.0/firebase-messaging.js"></script>
    <link rel="stylesheet" href="{{ asset('asset/admin/vendor/dropify/dist/css/dropify.min.css') }}">
    <link rel="manifest" href="/manifest.json">
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/front/css/jnoty.min.css') }}">
    <script>
        window.Laravel = <?php echo json_encode([
    'csrfToken' => csrf_token(),
]); ?>
    </script>

    @yield('styles')


</head>


<body>



    @include('admin.layout.partials.topbar')
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
    <script type="text/javascript" src="{{ asset('asset/admin/vendor/bootstrap4/js/bootstrap.min.js') }}"></script>
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
    <script src="{{ asset('asset/admin/vendor/dropify/dist/js/dropify.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('asset/front/js/jnoty.min.js') }}"></script>

    <script>
        $('.dropify').dropify();
    </script>
    <script>
        var app = new Vue({
            el: '#zoneModel',
            data: {
                country: 0,
                currency_name: 0,
                countries: '',
                state: 0,
                states: '',
                city: 0,
                cities: ''
            },
            methods: {
                getCountries: function() {
                    axios.get('{{ route('admin.getcountry') }}', {
                            params: {
                                request: 'country'
                            }
                        })
                        .then(function(response) {
                            app.countries = response.data;
                            app.states = '';
                            app.cities = '';
                            app.state = 0;
                            app.city = 0;
                        });
                },
                getStates: function() {
                    axios.get('{{ route('admin.getstate') }}', {
                            params: {
                                request: 'state',
                                country_id: this.country
                            }
                        })
                        .then(function(response) {
                            app.states = response.data;
                            app.state = 0;
                            app.cities = '';
                            app.city = 0;
                        });
                },
                getCities: function() {
                    axios.get('{{ route('admin.getcity') }}', {
                            params: {
                                request: 'city',
                                state_id: this.state
                            }
                        })
                        .then(function(response) {
                            app.cities = response.data;
                            app.city = 0;
                        });
                }
            },
            created: function() {
                this.getCountries();
            }
        });
        var promocode = new Vue({
            el: '#promocode',
            data: {
                codes: '',
                code: 0,
                codesuser: '',
            },
            methods: {
                getPromocodes: function() {
                    axios.get('{{ route('admin.promocodes') }}', {
                        params: {
                            promocode_id: this.promocode,
                        }
                    }).then(function(response) {
                        promocode.codes = response.data;
                        console.log(response.data);
                    });
                },
                getPromocodesUser: function() {
                    axios.get('{{ route('admin.promocodeusage') }}', {
                        params: {
                            promocode_id: this.code,
                        }
                    }).then(function(response) {
                        promocode.codesuser = response.data;
                        console.log(response.data);
                    });
                },
                formattedDate: function(d) {
                    let arr = d.split(/[- :]/);
                    let date = new Date(Date.UTC(arr[0], arr[1] - 1, arr[2], arr[3], arr[4], arr[5]));
                    return date.getDate() + " - " + (date.getMonth() + 1) + " - " + date.getFullYear() + " " +
                        date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds()
                }
            },
            created: function() {
                this.getPromocodes();
            }
        });
    </script>
    <script type="text/javascript">
        //play sound on new order
        // $(document.ready(function(){
        //   alert("Please act");
        // }))
        var totalOrders = 0;
        var checkNewOrders = function checkUpdate() {
            $.ajax({
                url: "{{ url('/admin/getTotalPosts') }}",
                type: "get",
                data: "",
                success: function(response) {
                    // console.log(response);  
                    if (response['data'].toString() == "true") {
                        if (totalOrders == 0) {
                            totalOrders = response['count'];
                        } else if (totalOrders < response['count']) {
                            var audio = new Audio('{{ asset('asset/front/ring.wav') }}');
                            audio.play();
                            totalOrders = response['count'];
                        }
                    }
                },
            });
        }
        setInterval(checkNewOrders, 30000);
        $('.rating').rating();
        if (jQuery.browser.mobile == false) {
            function initScroll() {
                $('.custom-scroll').jScrollPane({
                    autoReinitialise: true,
                    autoReinitialiseDelay: 100
                });
            }
            initScroll();
            $(window).resize(function() {
                initScroll();
            });
        }
        $(".hamburger").click(function() {
            $(".site-sidebar").toggleClass("open");
            $('.hamburger').toggleClass("is-active");
            $(".site-content").toggleClass("no-margin");
        });
        /* Scroll - if mobile */
        if (jQuery.browser.mobile == true) {
            $('.custom-scroll').css('overflow-y', 'scroll');
        }

        $(document).ready(function() {
            var select = $('.validation');
            $("#peak_hour").change(function() {
                if ($(this).val() === 'YES') {
                    select.attr("required", "required");
                } else {
                    select.removeAttr('required');
                }
            });
        });
        $(document).ready(function() {
            var select = $('.validation1');
            $("#night_hour").change(function() {
                if ($(this).val() === 'YES') {
                    select.attr("required", "required");
                } else {
                    select.removeAttr('required');
                }
            });
        });
        $(document).ready(function() {
            $("body").removeClass("compact-sidebar");
            $("body").on("change", "#country_name", function() {
                if ($(this).val() > 0) {
                    $(this).prop('name', 'country_name');
                    $("#country_name_input").prop('required', false).removeProp('name');
                } else {
                    $(this).removeProp('name');
                    $("#country_name_input").prop({
                        'required': true,
                        'name': 'country_name'
                    });
                }
            });
            $("body").on("change", "#state_name", function() {
                if ($(this).val() > 0) {
                    $(this).prop('name', 'state_name');
                    $("#state_name_input").prop('required', false).removeProp('name');
                } else {
                    $(this).removeProp('name');
                    $("#state_name_input").prop({
                        'required': true,
                        'name': 'state_name'
                    });
                }
            });
        });
        $("#peak_data").click(function() {
            var i = $('.peak_day').length;
            var day_p = $("#peak_day option:selected").text();
            var start_time_p = $("#peak_start_time option:selected").text();
            var end_time_p = $("#peak_end_time option:selected").text();
            var peak_fare = $("#peak_fare").val();
            // alert(day_p+' '+start_time_p+' '+end_time_p+' '+peak_fare); 
            //   console.log($("#reg-form").serialize()); 
            var data = {
                '_token': "{{ csrf_token() }}",
                'day': day_p,
                'start_time': start_time_p,
                'end_time': end_time_p,
                'fare_in_percentage': peak_fare,
                'peak_night_type': 'PEAK'
            };
            $.post("{{ route('admin.peakNight') }}", data, function(res) {
                // console.log(res);
                // var resdata = $.parseJSON(res);
                // console.log(res);
                // console.log(res.data);
                if (res.status == 1) {
                    alert('You cant create duplicate day');
                }
                // $('#peakAdded').empty();
                // alert(i);
                if (i >= 6) {
                    $("#peakAdded").append(
                        '<div class="form-group row"><p style="color:red;text-align: center">You can add maximum 7 days</p></div>'
                    );
                } else {
                    // $("#peakAdded").append('<div class="form-group row"><label for="store_link_ios" class="col-xs-2 col-form-label"></label><div class="col-xs-2"><select  class="form-control peak_day" name="peak_day[]" id="peak_day"><option>Day</option>@foreach (explode(',', env('DAY')) as $d => $dv)<option value="{{ $dv }}">{{ $dv }} </option>@endforeach</select></div><div class="col-xs-2"><select  class="form-control" name="peak_start_time[]" id="peak_start_time"><option>Start Time</option>@foreach (explode(',', env('HOUR')) as $d => $dv)<option value="{{ $dv }}">{{ $dv }} </option>                        @endforeach</select></div><div class="col-xs-2"><select  class="form-control" name="peak_end_time[]" id="peak_end_time"><option>End Time</option>@foreach (explode(',', env('HOUR')) as $d => $dv)<option value="{{ $dv }}">{{ $dv }} </option>@endforeach</select></div><div class="col-xs-2"><input class="form-control" type="text" value="" name="peak_fare[]" id="peak_fare" placeholder="Peak Fare(%)"></div><div class="col-xs-2"><button type="button" class="btn btn-primary" id="peak_data" onclick="removeRow(this)">-</button></div></div>');
                    $("#peakAdded").append(
                        '<div class="form-group row"><label for="store_link_ios" class="col-xs-2 col-form-label"></label><div class="col-xs-2"><select  class="form-control peak_day" name="peak_day[]" id="peak_day"><option>Day</option>@foreach (explode(',', env('DAY')) as $d => $dv)<option value="{{ $dv }}">{{ $dv }} </option>@endforeach</select></div><div class="col-xs-2"><input type="time" class="form-control validation" name="peak_start_time[]" id="peak_start_time"></div><div class="col-xs-2"><input type="time" class="form-control validation" name="peak_end_time[]" id="peak_end_time"></div><div class="col-xs-2"><input class="form-control validation" type="text" value="" name="peak_fare[]" id="peak_fare" placeholder="Peak Fare(%)"></div><div class="col-xs-2"><button type="button" class="btn btn-primary" id="peak_data" onclick="removeRow(this)">-</button></div></div>'
                    );
                }
            });
        });

        function removeRow(input) {
            input.parentNode.parentNode.remove()
        }
        $("#night_data").click(function() {
            var start_time_n = $("#night_start_time option:selected").text();
            var end_time_n = $("#night_end_time option:selected").text();
            var night_fare = $("#night_fare").val();
            // alert(day_p+' '+start_time_p+' '+end_time_p+' '+peak_fare); 
            //   console.log($("#reg-form").serialize()); 
            var data = {
                '_token': "{{ csrf_token() }}",
                'start_time': start_time_n,
                'end_time': end_time_n,
                'fare_in_percentage': night_fare,
                'peak_night_type': 'NIGHT'
            };
            $.post("addpeakAnight", data, function(res) {
                // console.log(res);
                // var resdata = $.parseJSON(res);
                // console.log(res.data);
                $('#nightAdded').empty();
                $.each(res.data, function(key, val) {
                    $("#nightAdded").append(
                        " <div class='form-group row'><label  class='col-xs-2 col-form-label'></label><div class='col-xs-2'><input class='form-control' type='text' value=" +
                        val.start_time +
                        "></div><div class='col-xs-2'><input class='form-control' type='text' value=" +
                        val.end_time +
                        "></div><div class='col-xs-2'><input class='form-control' type='text' value=" +
                        val.fare_in_percentage + "></div></div>");
                    // console.log(key + " : " + val.day);     
                });
            });
        });
        $("select#peak_hour").change(function() {
            var selectedd = $(this).children("option:selected").val();
            if (selectedd === 'NO') {
                $(".peakHide").hide();
            }
            if (selectedd === 'YES') {
                $(".peakHide").show();
            }
        });
        // alert($( "#peak_hour option:selected" ).text());
        $("select#night_hour").change(function() {
            var selectedd = $(this).children("option:selected").val();
            if (selectedd === 'NO') {
                $(".nightHide").hide();
            }
            if (selectedd === 'YES') {
                $(".nightHide").show();
            }
        });
        var wId = null;
        $('#accountApproved').click(function() {
            var id = $(this).attr('data');
            $.ajax({
                url: '{{ url('admin/approved_account?id=') }}' + id,
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                },
                success: function(result) {
                    location.reload();
                    $("#msg").html('you have successfully approved');
                    console.log(result);
                }
            });
        });
        // WRITE THE VALIDATION SCRIPT.
        function isValid(el, evnt) {
            var charC = (evnt.which) ? evnt.which : evnt.keyCode;
            if (charC == 46) {
                if (el.value.indexOf('.') === -1) {
                    return false;
                } else {
                    return false;
                }
            } else {
                if (charC > 31 && (charC < 48 || charC > 57))
                    return false;
            }
            return true;
        }
    </script>
    <script type="text/javascript" src="{{ asset('js/firebase.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/firebase.js') }}"></script>

</body>

</html>