@extends('user.layout.master')
@section('content')
    <style type="text/css">
        .fontsize {
            font-size: 14px;
        }

        .car-radio {
            width: 125px !important;
        }

        .modal_image img {
            width: 20%;
        }

    </style>
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Bulk Order</h4>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="row">
        @include('common.notify')
        <div class="col-md-6">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <form action="{{ url('confirm/ride') }}" method="GET" id="confirm_ride"
                onkeypress="return disableEnterKey(event);" class="tripsform">
                <input type="hidden" name="user_id" id="user_id" value="<?php echo Auth::user()->id; ?>">
                <div class="form-group">
                    @if (session('s_address_old'))
                        <input type="text" class="form-control form-control-lg fontsize" id="origin-input" name="s_address"
                            placeholder="Enter pickup location" value="{{ session('s_address_old') }}">
                    @else
                        <input type="text" class="form-control  form-control-lg fontsize" id="origin-input" name="s_address"
                            placeholder="Enter pickup location" value="{{ session('s_address') }}">
                    @endif
                    <div class="pickup_location">
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control form-control-lg fontsize" id="destination-input" name="d_address"
                        placeholder="Enter drop location" value="{{ session('d_address') }}">
                    <div class="destination">
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control form-control-lg fontsize" id="destination-name" name="d_name"
                        placeholder="Enter Receiver's Name">
                    <div class="destination-name-error">
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control form-control-lg fontsize" id="destination-phone" name="d_phone"
                        placeholder="Enter Receiver's Phone">
                    <div class="destination-phone-error">
                    </div>
                </div>
                <div class="form-group">
                    <input type="number" step="0.01" class="form-control  form-control-lg fontsize" id="cod" name="cod"
                        placeholder="Cash Handle on Delivery (if applicable)">
                </div>
                <div class="form-group">
                    <textarea name="special_note" id="special_note" class="form-control form-control-lg "
                        placeholder="Enter Remarks(if any)"></textarea>
                </div>
                @if (session('s_latitude_old'))
                    <input type="hidden" name="s_latitude" id="origin_latitude" value="{{ session('s_latitude_old') }}">
                @else
                    <input type="hidden" name="s_latitude" id="origin_latitude" value="{{ session('s_latitude') }}">
                @endif
                @if (session('s_longitude_old'))
                    <input type="hidden" name="s_longitude" id="origin_longitude"
                        value="{{ session('s_longitude_old') }}">
                @else
                    <input type="hidden" name="s_longitude" id="origin_longitude" value="{{ session('s_longitude') }}">
                @endif
                <input type="hidden" name="d_latitude" id="destination_latitude" value="{{ session('d_latitude') }}">
                <input type="hidden" name="d_longitude" id="destination_longitude" value="{{ session('d_longitude') }}">
                <input type="hidden" name="current_longitude" id="long" value="{{ @$_GET['current_longitude'] }}">
                <input type="hidden" name="current_latitude" id="lat" value="{{ @$_GET['current_latitude'] }}">
                <input type="hidden" name="promo_code" id="promo_code" />
                <input type="hidden" name="item_id" id="item_id" />
                <div class="car-detail d-none">
                    @foreach ($services as $service)
                        <?php $i = 0; ?>
                        <input type="hidden" value="{{ $service->name }}" name="serType"
                            id="serType_{{ $service->id }}">
                        <div class="car-radio">
                            <input type="radio" name="service_type" value="{{ $service->id }}"
                                id="service_{{ $service->id }}" @if (session('service_type') == $service->id || $loop->index == 0) checked="checked" @endif>

                            <label for="service_{{ $service->id }}">
                                <div class="car-radio-inner">
                                    <div class="img"><img src="{{ image($service->image) }}"
                                            class="{{ $i == 0 ? 'img_color ' : '' }}"></div>
                                    <div class="name"><span
                                            class="{{ $i == 0 ? 'car_ser_type' : '' }}">{{ $service->name }}</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <?php $i++; ?>
                    @endforeach
                </div>
                <div class="form-group">
                    <input type="submit" id="send" name="send" value="" style="display:none;" />
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="invoice" checked>
                        <label class="custom-control-label" for="invoice">
                            <h4>Invoice</h4>
                        </label>
                    </div>
                    <p>Orders placed before 12 PM will be delivered within same day. Order placed after 12 PM will be
                        delivered within same day or 24 hours.</p>

                </div>
                <div class="form-group">
                    <button type="button" id="estimated_btn" class="full-primary-btn fare-btn">Add Order</button>
                </div>
                <div class="form-group">
                    <br>
                    <label for="fileUpload">OR Upload via excel (Download excel template <a
                            href="{{ asset('public/puryau.xlsx') }}">here</a>)</label>
                    <input class="form-control form-control-lg" type="file" id="fileUpload" />
                    <br>
                    <input class="form-control form-control-lg btn btn-primary" type="button" id="upload" value="Upload" />
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <div class="map-responsive">
                <div id="map" style="width: 100%; height: 450px;"></div>
            </div>
        </div>
    </div>

    <meta name="_token" content="{!! csrf_token() !!}" />
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('asset/front/js/map.js') }}"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places&callback=initMap"
        async defer></script>
    <script type="text/javascript">
        var current_latitude = 27.6932302;
        var current_longitude = 85.2770152;
        var counter = 2;
        //var categories = <?php //echo json_encode( $categories );
?>;
    </script>
    <script type="text/javascript" src="{{ asset('asset/front/js/spin.js') }}"></script>

    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous"> --}}
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> --}}
    <script type="text/javascript" src="{{ asset('asset/front/js/jnoty.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/front/css/jnoty.min.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> --}}

    <script type="text/javascript" src="{{ asset('asset/front/js/jspdf.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset/front/js/invoice.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset/front/js/jsPdf_Plugins.js') }}"></script>


    {{-- This is for excel reading --}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>
    {{-- End --}}
    <script type="text/javascript">
        var excelRows;
        var current = 0;
        $("#upload").click(function() {
            //Reference the FileUpload element.
            var fileUpload = document.getElementById("fileUpload");

            //Validate whether File is valid Excel file.
            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx)$/;
            if (regex.test(fileUpload.value.toLowerCase())) {
                if (typeof(FileReader) != "undefined") {
                    var reader = new FileReader();

                    //For Browsers other than IE.
                    if (reader.readAsBinaryString) {
                        reader.onload = function(e) {
                            ProcessExcel(e.target.result);
                        };
                        reader.readAsBinaryString(fileUpload.files[0]);
                    } else {
                        //For IE Browser.
                        reader.onload = function(e) {
                            var data = "";
                            var bytes = new Uint8Array(e.target.result);
                            for (var i = 0; i < bytes.byteLength; i++) {
                                data += String.fromCharCode(bytes[i]);
                            }
                            ProcessExcel(data);
                        };
                        reader.readAsArrayBuffer(fileUpload.files[0]);
                    }
                } else {
                    alert("This browser does not support HTML5.");
                }
            } else {
                alert("Please upload a valid Excel file.");
            }
        });

        function ProcessExcel(data) {
            //Read the Excel File data.
            var workbook = XLSX.read(data, {
                type: 'binary'
            });

            //Fetch the name of First Sheet.
            var firstSheet = workbook.SheetNames[0];

            //Read all rows from First Sheet into an JSON array.
            excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[firstSheet]);
            var right = "pickup_address" in excelRows[current];
            if (excelRows.length > 0 && right) {
                sendAnotherRequest();
            } else {
                $.jnoty("Invalid or Empty file", {
                    life: 5000,
                    header: 'Error',
                    theme: 'jnoty-danger',
                    icon: 'fa fa-check-circle fa-2x'
                });
            }

        };

        function sendAnotherRequest() {
            row = excelRows[current];
            $('#origin-input').val(row['pickup_address']);
            $('#destination-input').val(row['destination_address']);
            $('#origin_longitude').val(row['pickup_longitude']);
            $('#origin_latitude').val(row['pickup_latitude']);
            $('#destination_latitude').val(row['destination_latitude']);
            $('#destination_longitude').val(row['destination_longitude']);
            $("#destination-name").val(row['receiver_name']);
            $("#destination-phone").val(row['receiver_phone']);
            $("#cod").val(row['cod']);
            $("#special_note").val(row['special_note']);
            $('#estimated_btn').click();
            current += 1;
        }
    </script>
    <script type="text/javascript">
        function showPleaseWait() {

            if (document.querySelector("#pleaseWaitDialog") == null) {
                var modalLoading =
                    '<div class="modal" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false" role="dialog">\
                                                                                                                                                                                                                <div class="modal-dialog">\
                                                                                                                                                                                                                    <div class="modal-content" style="margin-top:40%">\
                                                                                                                                                                                                                        <div class="modal-header">\
                                                                                                                                                                                                                            <h4 class="modal-title">Please wait...</h4>\
                                                                                                                                                                                                                        </div>\
                                                                                                                                                                                                                        <div class="modal-body">\
                                                                                                                                                                                                                            <div class="progress">\
                                                                                                                                                                                                                              <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar"\
                                                                                                                                                                                                                              aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%; height: 40px">\
                                                                                                                                                                                                                              </div>\
                                                                                                                                                                                                                            </div>\
                                                                                                                                                                                                                        </div>\
                                                                                                                                                                                                                    </div>\
                                                                                                                                                                                                                </div>\
                                                                                                                                                                                                            </div>';
                $(document.body).append(modalLoading);
            }

            // $("#pleaseWaitDialog").modal("show");
            $(".preloader").show();
            $("#estimated_btn").attr("disabled", true);
        }

        /**
         * Hides "Please wait" overlay. See function showPleaseWait().
         */
        function hidePleaseWait() {
            $(".preloader").hide();
            $("#estimated_btn").attr("disabled", false);
            // $("#pleaseWaitDialog").modal("hide");
        }
        $('#estimated_btn').click(function(e) {
            e.preventDefault();
            form = $(this).closest('form');
            var origion = form.find('#origin-input');
            var destinated = form.find('#destination-input');
            var service_type = $("input[name='service_type']:checked").val();
            var origin_longitude = form.find('#origin_longitude').val();
            var origin_latitude = form.find('#origin_latitude').val();
            var destination_latitude = form.find('#destination_latitude').val();
            var destination_longitude = form.find('#destination_longitude').val();
            var destination_name = form.find("#destination-name");
            var destination_phone = form.find("#destination-phone");
            var cod = form.find("#cod").val();
            var special_note = form.find("#special_note").val();
            var formData = form.serializeArray();
            if (origion.val().length === 0) {
                form.find('.pickup_location').append(
                    '<span class="help-block text-danger">Please add a pick up location! </span>');
                return false;
            }

            if (destinated.val().length === 0) {
                form.find('.destination').append(
                    '<span class="help-block text-danger">Please add a final location! </span>');
                return false;
            }
            if (destination_name.val().length === 0) {
                form.find('.destination-name-error').append(
                    '<span class="help-block text-danger">Please add a receiver\'s name! </span>');
                return false;
            }
            if (destination_phone.val().length === 0) {
                form.find('.destination-phone-error').append(
                    '<span class="help-block text-danger">Please add a receiver\'s phone! </span>');
                return false;
            }

            if (origin_latitude.length !== 0 && origin_latitude.length !== 0 && origin_latitude.length !== 0 &&
                origin_latitude.length !== 0) {
                service_type = $('#confirm_ride input[type=radio]:checked').val();
                var service_name = $('#serType_' + service_type).val();
                itemSubmit();
            }
        });

        function valueChanged() {
            if ($('#inlineRadio2').is(":checked"))
                $(".otherDiv").show();
            else
                $(".otherDiv").hide();
        }

        function valueChangedSelf() {
            if ($('#inlineRadio1').is(":checked"))
                $(".otherDiv").hide();
            else
                $(".otherDiv").hide();
        }

        function itemSubmit() {
            showPleaseWait();
            var url = "<?php echo url('create/item'); ?>";
            //var extension = $('#files').val().split('.').pop().toLowerCase();
            var service_type = $('#confirm_ride input[type=radio]:checked').val();
            var special_note = $('#special_note').val();
            var user_id = $('#user_id').val();

            var rec_name = $('#destination-name').val();
            var rec_mobile = $('#destination-phone').val();
            var form_data = new FormData();
            form_data.append('special_note', special_note);
            form_data.append('service_type', service_type);
            form_data.append('user_id', user_id);
            form_data.append('rec_name', rec_name);
            form_data.append('rec_mobile', rec_mobile);
            $.ajax({
                type: "POST",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(data) {

                    $('#item_id').val(data.item_id);
                    console.log("Item created");
                    // $('#confirm_ride').submit();
                    get_fare().done(function(data) {
                        orderSubmit(data)
                    });

                },
                error: function(data) {
                    hidePleaseWait();
                    // alert("Error in form submission. Retry");
                    $.jnoty("Note: Please make sure to click on the location from the options available while searching.", {
                        life: 5000,
                        header: 'Error',
                        theme: 'jnoty-danger',
                        icon: 'fa fa-check-circle fa-2x'
                    });
                }
            });
        }

        function get_fare() {
            var url = "<?php echo url('/get_fare'); ?>";
            var s_latitude = $("#origin_latitude").val();
            var s_longitude = $("#origin_longitude").val();
            var d_latitude = $("#destination_latitude").val();
            var d_longitude = $("#destination_longitude").val();
            var service_type = $('#confirm_ride input[type=radio]:checked').val();

            var form_data = new FormData();
            form_data.append('s_latitude', s_latitude);
            form_data.append('s_longitude', s_longitude);
            form_data.append('d_latitude', d_latitude);
            form_data.append('d_longitude', d_longitude);
            form_data.append('service_type', service_type);


            return $.ajax({
                type: "POST",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(data) {
                    console.log("Fare returned");
                    // return data;

                },
                error: function(data) {
                    hidePleaseWait();
                    // alert("Error in form submission. Retry"+data);
                    $.jnoty("Note: Please make sure to click on the location from the options shown while searching.", {
                        life: 5000,
                        header: 'Error',
                        theme: 'jnoty-danger',
                        icon: 'fa fa-check-circle fa-2x'
                    });
                }
            });
        }

        function orderSubmit(getFare) {
            var url = "<?php echo url('/create/ride'); ?>";

            var s_latitude = $("#origin_latitude").val();
            var s_longitude = $("#origin_longitude").val();
            var d_latitude = $("#destination_latitude").val();
            var d_longitude = $("#destination_longitude").val();

            var s_address = $("#origin-input").val();
            var d_address = $("#destination-input").val();
            var cod = $("#cod").val();

            var fare = getFare.estimated_fare;
            var distance = getFare.distance;
            var payment_mode = "CASH";
            var item_id = $('#item_id').val();

            var service_type = $('#confirm_ride input[type=radio]:checked').val();
            var special_note = $('#special_note').val();

            var form_data = new FormData();
            form_data.append('s_latitude', s_latitude);
            form_data.append('s_longitude', s_longitude);
            form_data.append('d_latitude', d_latitude);
            form_data.append('d_longitude', d_longitude);
            form_data.append('s_address', s_address);
            form_data.append('d_address', d_address);
            form_data.append('cod', cod);
            form_data.append('fare', fare);
            form_data.append('distance', distance);
            form_data.append('payment_mode', payment_mode);
            form_data.append('item_id', item_id);
            form_data.append('special_note', special_note);
            form_data.append('service_type', service_type);

            $.ajax({
                type: "POST",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(data) {
                    console.log("Order Placed");

                    //generate invoice if requested
                    if ($('#invoice').is(":checked")) {
                        var pickupDetails = {
                            CustomerName: "<?php echo Auth::user()->first_name; ?>",
                            CustomerAddressLine1: s_address,
                            CustomerPhno: "<?php echo Auth::user()->mobile; ?>",
                        };
                        var diff = cod - fare;
                        var customer_BillingInfoJSON = {
                            CustomerName: $('#destination-name').val(),
                            CustomerAddressLine1: d_address,
                            CustomerPhno: $('#destination-phone').val(),
                            Cod: "Rs. " + cod,
                            Distance: distance + " km",
                            Fare: "Rs. " + fare,
                            Remarks: special_note,
                            Amount: "Rs. " + diff,
                        };
                        var invoiceJSON = {
                            InvoiceNo: data.booking_id,
                            InvoiceDate: data.date,
                        }
                        generate_invoice(invoiceJSON, pickupDetails, customer_BillingInfoJSON);
                    }

                    $("#destination-input").val("");
                    $("#destination-name").val("");
                    $("#destination_latitude").val("");
                    $("#destination_longitude").val("");
                    $("#destination-phone").val("");
                    $("#cod").val(0);
                    $('#special_note').val("");
                    hidePleaseWait();
                    $.jnoty("Your order is placed successfully", {
                        life: 5000,
                        header: 'Success',
                        theme: 'jnoty-success',
                        icon: 'fa fa-check-circle fa-2x'
                    });
                    if (excelRows.length > 0 && current < excelRows.length) {
                        sendAnotherRequest();
                    } else {
                        current = 0;
                    }
                },
                error: function(data) {
                    hidePleaseWait();
                    // alert("Error in form submission. Retry");
                    $.jnoty("Note: Please make sure to click on the location from the options shown while searching.", {
                        life: 5000,
                        header: 'Error',
                        theme: 'jnoty-danger',
                        icon: 'fa fa-check-circle fa-2x'
                    });
                }
            });
        }
    </script>
    <script type="text/javascript">
        $('.pricing_left .car-radio').on('click', function() {
            var detail = $('.car-detail');
            detail.find('input[type=radio]').attr('checked');
            detail.find('.car_ser_type').removeClass('car_ser_type');
            detail.find('.img_color').removeClass('img_color');
            $(this).find('img').addClass('img_color');
            $(this).find('span').addClass('car_ser_type');
            if ($(':radio[name=service_type]:checked, :radio[name=service_type]:checked').length >= 1) {
                $('input[name=service_type]').attr('checked', false);

            }
            if ($(':radio[name=service_type]:checked, :radio[name=service_type]:checked').length == 0) {
                $(this).find('input[type=radio]').attr('checked', 'checked');
            }

        });
        //alert(document.getElementById('long').value);

        var ip_details = <?php echo json_encode($ip_details); ?>;

        var current_latitude = parseFloat(ip_details.geoplugin_latitude);
        var current_longitude = parseFloat(ip_details.geoplugin_longitude);

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(success);
        } else {
            console.log('Sorry, your browser does not support geolocation services');
            initMap();
        }

        function success(position) {
            document.getElementById('long').value = position.coords.longitude;
            document.getElementById('lat').value = position.coords.latitude;

            if (position.coords.longitude != "" && position.coords.latitude != "") {
                current_longitude = position.coords.longitude;
                current_latitude = position.coords.latitude;

            }

            initMap();
        }
    </script>

    <script type="text/javascript">
        var date = new Date();
        date.setDate(date.getDate() - 1);
        $('#datepicker').datepicker({
            startDate: date
        });


        $('#timepicker').timepicker({
            showMeridian: false
        });

        function card(value) {
            if (value == 'CARD') {
                $('#card_id').fadeIn(300);
            } else {
                $('#card_id').fadeOut(300);
            }
        }
    </script>

    <script type="text/javascript">
        function disableEnterKey(e) {
            var key;
            if (window.e)
                key = window.e.keyCode; // IE
            else
                key = e.which; // Firefox

            if (key == 13)
                return e.preventDefault();
        }

        /* For Multiple Image Show */

        var selDiv = "";

        document.addEventListener("DOMContentLoaded", init, false);

        function init() {
            // document.querySelector('#files').addEventListener('change', handleFileSelect, false);
            // selDiv = document.querySelector("#selectedFiles");
        }

        function handleFileSelect(e) {

            if (!e.target.files || !window.FileReader) return;

            selDiv.innerHTML = "";

            var files = e.target.files;
            var filesArr = Array.prototype.slice.call(files);



            filesArr.forEach(function(f) {

                if (!f.type.match("image.*")) {
                    return;
                }
                var reader = new FileReader();
                reader.onload = function(e) {
                    var html = "<img src=\"" + e.target.result +
                        "\" hspace='10'>"; // + f.name + "<br clear=\"left\"/>";
                    selDiv.innerHTML += html;
                }

                reader.readAsDataURL(f);

            });

        }
    </script>

@endsection
