@extends('user.layout.master')
@section('content')
<style type="text/css">
    .fontsize {
        font-size: 14px;
    }
    .submit-btn {
        border-radius: 0;
        border: 2px solid #000;
        text-transform: uppercase;
    }
    #pickunumber{
        display:none;
    }
    #promocode{
        display:none;
    }
    body {font-family: Arial, Helvetica, sans-serif;}

    /* The Modal (background) */
    .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 200px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    }

    /* The Close Button */
    .close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    }

    .close:hover,
    .close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
    }
</style>

    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">New Order</h4>
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
                <div class="form-group">
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo Auth::user()->id; ?>">
                    @if (session('s_address_old'))
                        <input type="text" class="form-control form-control-lg" id="origin-input" name="s_address"
                            placeholder="Enter pickup location" value="{{ session('s_address_old') }}">
                    @else
                        <input type="text" class="form-control form-control-lg" id="origin-input" name="s_address"
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

                <div style="display:none;" id="est">
                    Estimated Distance: <span id="est_distance" style="margin-right: 40px;"> </span>
                    Estimated Fare: <span id="est_fare"> </span>
                </div>

                <div class="form-group">
                    <input type="text" class="form-control fontsize form-control-lg" id="destination-name" name="d_name"
                        placeholder="Enter Receiver's Name">
                    <div class="destination-name-error">
                    </div>
                </div>

                <div class="form-group">
                    <input type="text" class="form-control form-control-lg fontsize" id="destination-phone" name="d_phone"
                        placeholder="Enter Receiver's Phone">
                        <div class="receiver-stats"></div>
                    <div class="destination-phone-error">
                    </div>
                </div>

                <div class="form-group">
                    <input type="number" step="0.01" class="form-control fontsize form-control-lg" id="cod" name="cod"
                        placeholder="Cash Handle on Delivery (if applicable)">
                </div>
                <div class="form-group">
                    <textarea name="special_note" id="special_note" class="form-control"
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
                <!-- <input type="hidden" name="promo_code" id="promo_code" /> -->
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

                <input type="submit" id="send" name="send" value="" style="display:none;" />
                <div class="form-group">
                    <select class="form-control form-control-lg" id="destination-weight" name="weight" required>
                        <option value="1">1 kg</option>
                        <option value="2">2 kg</option>
                        <option value="3">3 kg</option>
                        <option value="4">4 kg</option>
                        <option value="5">5 kg</option>
                        <option value="6">6 kg </option>
                        <option value="7">7 kg </option>
                        <option value="8">8 kg </option>
                        <option value="9">9 kg </option>
                        <option value="10">10 kg </option>
                        <option value="11">10 kg +</option>
                    </select>
                    <div class="destination-weight-error">
                    </div>
                </div>
                <div>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="pnum">
                        <label class="custom-control-label" for="pnum">
                                    <h5 class='mt-0'>Different pickup Number</h5>
                        </label>
                    </div>
                </div>
                <div class="form-group" id="pickunumber">
                    @if (session('pickup_number'))
                        <input type="text" class="form-control form-control-lg" id="pickup_number" name="pickup"
                            placeholder="Enter pickup number" value="{{ session('pickup_number') }}">
                    @else
                        <input type="text" class="form-control form-control-lg" id="pickup_number" name="pickup"
                            placeholder="Enter pickup number" value="{{ session('pickup_number') }}">
                    @endif
                    <!-- <div class="pickup_number">
                    </div> -->
                </div>
                <div>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="ppromo">
                        <label class="custom-control-label" for="ppromo">
                                    <h5 class='mt-0'>Click here to use promocode</h5>
                        </label>
                    </div>
                </div>
                <div class="form-group" id="promocode">
                    @if (session('promo_code'))
                        <input type="text" class="form-control form-control-lg" id="promo_code" name="promo"
                            placeholder="Enter promocode" value="{{ session('promo_code') }}">
                    @else
                        <input type="text" class="form-control form-control-lg" id="promo_code" name="promo"
                            placeholder="Enter promocode" value="{{ session('promo_code') }}">
                    @endif
                    <!-- <div class="promo_code">
                    </div> -->
                </div>
                <br>

                <div class="form-group row mb-0">
                    <div class="col-md-6">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="cargo" disabled>

                            <label class="custom-control-label" for="cargo">
                                <h5 class='mt-0'>Courier (Rs.{{Setting::get('cargo_amount')}})</h5>
                            </label>
                        </div>

                        <p  id="cargo-info">For Cargo, please drop goods at our office and we will
                            contact the receiver when it reaches the regional office at destination.</p><br>
                    </div>
                    <div class="col-md-6">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="invoice" checked>
                            <label class="custom-control-label" for="invoice">
                                <h5 class='mt-0'>Invoice</h5>
                            </label>
                        </div>
                        <p>Orders placed before 12 PM will be delivered within same day. Order placed after 12 PM will be
                            delivered within same day or 24 hours.</p>
                    </div>
                </div>

                <div class="form-group d-flex justify-content-start">
                    <button type="button" id="estimated_btn" class="btn btn-outline-dark btn-lg submit-btn">Place And
                        Order</button>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <div class="map-responsive">
                <div id="map" style="width: 100%; height: 450px;"></div>
            </div>
        </div>
    </div>
<div id="myModal" class="modal">

<!-- Modal content -->
<div class="modal-content">
<div class="col-md-12 mt-3 text-right">
<span  id="closed" style="text-decoration:none;" class="btn btn-danger">&times;</span>
                    <!-- <a href="#" id="cancelload" style="text-decoration:none;" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> </a> -->
                    </div>
 
  <span class="align-middle"><h3>Your Order has been Placed. You can load your wallet through here</h3></span>
  <div class="col-md-12" id="loadWallet">
                <div class="card">
                <div class="col-md-12 mt-3 text-right">
                    <!-- <a href="#" id="cancelload" style="text-decoration:none;" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> </a> -->
                    </div>
                    <h3 class="col-md-12 text-center">Load wallet <img src="{{ asset('asset/user/images/esewa.png') }}" alt="esewa" width="70"></h3>
                    <div class="card-body">
                    <form action="https://esewa.com.np/epay/main" method="POST">
                        <input name="tAmt" type="number" id="tAmt" class='form-control' placeholder='Enter the amount'>
                        <input value="0" name="amt" type="hidden" id="amt">
                        <input value="0" name="txAmt" type="hidden">
                        <input value="0" name="psc" type="hidden">
                        <input value="0" name="pdc" type="hidden">
                        <input value={{ env('Merchant_Key') }} name="scd" type="hidden">
                        <input value={{ $esewa_id }} name="pid" type="hidden">
                        <input value={{ url('/loadPayment?q=su') }} type="hidden" name="su">
                        <input value={{ url('/loadPayment?q=fu') }} type="hidden" name="fu">
                        <button value="Submit" type="submit" class="btn btn-primary btn-block mt-2">

                            Load Wallet </button>
                    </form>
        <div class="row">
            <div class=" col-lg-3 col-sm-6">
                <form action="https://esewa.com.np/epay/main" method="POST">
                    <input value="150" name="tAmt" type="hidden">
                    <input value="150" name="amt" type="hidden">
                    <input value="0" name="txAmt" type="hidden">
                    <input value="0" name="psc" type="hidden">
                    <input value="0" name="pdc" type="hidden">
                    <input value={{ env('Merchant_Key') }} name="scd" type="hidden">
                    <input value={{ $esewa_id }} name="pid" type="hidden">
                    <input value={{ url('/loadPayment?q=su') }} type="hidden" name="su">
                    <input value={{ url('/loadPayment?q=fu') }} type="hidden" name="fu">
                    <button value="Submit" type="submit" class="btn btn-primary btn-block mt-2">150 </button>
                </form>
            </div>

            <div class=" col-lg-3 col-sm-6">
                <form action="https://esewa.com.np/epay/main" method="POST">
                    <input value="250" name="tAmt" type="hidden">
                    <input value="250" name="amt" type="hidden">
                    <input value="0" name="txAmt" type="hidden">
                    <input value="0" name="psc" type="hidden">
                    <input value="0" name="pdc" type="hidden">
                    <input value={{ env('Merchant_Key') }} name="scd" type="hidden">
                    <input value={{ $esewa_id }} name="pid" type="hidden">
                    <input value={{ url('/loadPayment?q=su') }} type="hidden" name="su">
                    <input value={{ url('/loadPayment?q=fu') }} type="hidden" name="fu">
                    <button value="Submit" type="submit" class="btn btn-primary btn-block mt-2">250 
                            </button>
                </form>
            </div>

            <div class=" col-lg-3 col-sm-6">
                <form action="https://esewa.com.np/epay/main" method="POST">
                    <input value="500" name="tAmt" type="hidden">
                    <input value="500" name="amt" type="hidden">
                    <input value="0" name="txAmt" type="hidden">
                    <input value="0" name="psc" type="hidden">
                    <input value="0" name="pdc" type="hidden">
                    <input value={{ env('Merchant_Key') }} name="scd" type="hidden">
                    <input value={{ $esewa_id }} name="pid" type="hidden">
                    <input value={{ url('/loadPayment?q=su') }} type="hidden" name="su">
                    <input value={{ url('/loadPayment?q=fu') }} type="hidden" name="fu">
                    <button value="Submit" type="submit" class="btn btn-primary btn-block mt-2">500 </button>
                </form>
            </div>

            <div class=" col-lg-3 col-sm-6">
                <form action="https://esewa.com.np/epay/main" method="POST">
                    <input value="1000" name="tAmt" type="hidden">
                    <input value="1000" name="amt" type="hidden">
                    <input value="0" name="txAmt" type="hidden">
                    <input value="0" name="psc" type="hidden">
                    <input value="0" name="pdc" type="hidden">
                    <input value={{ env('Merchant_Key') }} name="scd" type="hidden">
                    <input value={{ $esewa_id }} name="pid" type="hidden">
                    <input value={{ url('/loadPayment?q=su') }} type="hidden" name="su">
                    <input value={{ url('/loadPayment?q=fu') }} type="hidden" name="fu">
                    <button value="Submit" type="submit" class="btn btn-primary btn-block mt-2">1000 </button>
                </form>
            </div>
                </div>
            </div>
            </div>
            </div>
</div>

</div>
    <meta name="_token" content="{!! csrf_token() !!}" />

@endsection

@section('scripts')
<script>
    
var modal = document.getElementById("myModal");


// Get the <span> element that closes the modal
var span = document.getElementById("closed");


// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    console.log('close');
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
    $("#destination-phone").focusout(function (e) {
            form = $(this).closest('form');
            var destination_phone = form.find("#destination-phone").val();
        if(destination_phone){
            $.ajax({
            url: '{{ url('/check-phone') }}/'+destination_phone,
            method: "get",
            success: function(data) {
                    $('.receiver-stats').empty().html("<b class='text-danger mr-1'> Rejected : </b>" + data.rejected+"<b class='text-info ml-2'> Processing : </b>" + data.processing + "<b class='text-success ml-2'> Completed : </b>" + data.Completed);
            }
        });
        }
    });
</script>

    <script type="text/javascript" src="{{ asset('asset/front/js/map.js') }}"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places&callback=initMap"
        async defer></script>
    <script type="text/javascript">
        var current_latitude = 27.6932302;
        var current_longitude = 85.3240;
        var counter = 2;
        //var categories = <?php //echo json_encode( $categories );
        // ?>;
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
        $("#cargo").change(function() {
            if (this.checked) {
                $("#cargo-info").show();
            } else {
                $("#cargo-info").hide();
            }
        });
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
            var destination_weight =form.find('#destination-weight')
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
            if (destination_weight.val().length === 0) {
                form.find('.destination-a-error').append(
                    '<span class="help-block text-danger">Please add a a </span>');
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
            var weight = $('#destination-weight').val();
            var form_data =new FormData(); 
            form_data.append('special_note', special_note);
            form_data.append('service_type', service_type);
            form_data.append('user_id', user_id);
            form_data.append('rec_name', rec_name);
            form_data.append('weight',weight);
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
                    const obj = JSON.parse(data.responseText);
                    if(obj){

                        console.log(obj.error);
                        $.jnoty(obj.error, {
                            life: 5000,
                            header: 'Error',
                            theme: 'jnoty-danger',
                            icon: 'fa fa-check-circle fa-2x'
                        });
                    }
                    else{

                    // alert("Error in form submission. Retry");
                    $.jnoty("Note: Please make sure to click on the location from the options available while searching.", {
                        life: 5000,
                        header: 'Error',
                        theme: 'jnoty-danger',
                        icon: 'fa fa-check-circle fa-2x'
                    });
                    }
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
            var cargoData = 0;
            if ($("#cargo").is(":checked")) {
                cargoData = 1;
            }
            form_data.append('cargo', cargoData);
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
            var weight =$('#destination-weight').val();
            var phone=$('#pickup_number').val();
            var cod = $("#cod").val();
            var promo_code=$('#promo_code').val();
            if (getFare) {
                var fare = getFare.estimated_fare;
                var distance = getFare.distance;
                var payment_mode = "CASH";
                var item_id = $('#item_id').val();
                var service_type = $('#confirm_ride input[type=radio]:checked').val();
                var special_note = $('#special_note').val();
                var cargo = 0;
                if ($("#cargo").is(":checked")) {
                    if (getFare.sameZone == false) {
                        fare = 85;
                        cargo = 1;
                        special_note += " **CARGO**";
                    } else {
                        $.jnoty("Note: Cant use cargo in same area. Using default rates", {
                            life: 5000,
                            header: 'Error',
                            theme: 'jnoty-danger',
                            icon: 'fa fa-check-circle fa-2x'
                        });
                    }
                }
                var form_data = new FormData();
                form_data.append('s_latitude', s_latitude);
                form_data.append('s_longitude', s_longitude);
                form_data.append('d_latitude', d_latitude);
                form_data.append('d_longitude', d_longitude);
                form_data.append('s_address', s_address);
                form_data.append('d_address', d_address);
                form_data.append('phone', phone);
                form_data.append('cod', cod);
                form_data.append('weight',weight);
                form_data.append('fare', fare);
                form_data.append('distance', distance);
                form_data.append('payment_mode', payment_mode);
                form_data.append('item_id', item_id);
                form_data.append('special_note', special_note);
                form_data.append('cargo', cargo);
                form_data.append('service_type', service_type);
                form_data.append('promo_code',promo_code);
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
                                weight : weight +" kg",
                                Fare: "Rs. " + fare,
                                Remarks: special_note,
                                // Amount: "Rs. "+diff,
                                Amount: "As mentioned above",
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
                        // $('#destination-weight').val("");
                        $('#phone').val(phone);
                        $("#cod").val(0);
                        $('#special_note').val("");
                        $('#promo_code').val("");
                        hidePleaseWait();
                        console.log(data);
                        $.jnoty("Your order is placed successfully", {
                            life: 5000,
                            header: 'Success',
                            theme: 'jnoty-success',
                            icon: 'fa fa-check-circle fa-2x'
                        });
                        modal.style.display = "block";
                    },
                    error: function(data) {
                        hidePleaseWait();
                        console.log(data.responseText);
                        const obj = JSON.parse(data.responseText);
                        console.log(obj.error);
                        $.jnoty(obj.error, {
                            life: 5000,
                            header: 'Error',
                            theme: 'jnoty-danger',
                            icon: 'fa fa-check-circle fa-2x'
                        });
                        if(data.responseText==='{"promo_code":["The selected promo code is invalid."]}'){
                            $.jnoty("Note: Invalid promo code", {
                                life: 5000,
                                header: 'Error',
                                theme: 'jnoty-danger',
                                icon: 'fa fa-check-circle fa-2x'
                            });
                        }
                        $.jnoty("Note: Please make sure to click on the location from the options shown while searching.", {
                            life: 5000,
                            header: 'Error',
                            theme: 'jnoty-danger',
                            icon: 'fa fa-check-circle fa-2x'
                        });
                    }
                });
            } else {
                hidePleaseWait();
                // alert("Error in form submission. Retry");
                $.jnoty("Note: Please supply both locations which are currently in our service. Also, check if given location has cargo service or not.", {
                    life: 5000,
                    header: 'Error',
                    theme: 'jnoty-danger',
                    icon: 'fa fa-check-circle fa-2x'
                });
            }
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
        $('#origin-input, #destination-input').change(function() {
            var ola = $('#origin_latitude').val();
            var oli = $('#origin_longitude').val();
            var dla = $('#destination_latitude').val();
            var dli = $('#destination_longitude').val();
            if (ola.length > 0 && oli.length > 0 && dla.length > 0 && dli.length > 0) {
                get_fare().done(function(data) {
                    if (data.estimated_fare.length > 0) {
                        $('#est_fare').html(data.estimated_fare);
                        $('#est_distance').html(data.distance);
                        $('#est').show();
                    } else {
                        $.jnoty("Note: Please supply both locations which are currently in our service.", {
                            life: 5000,
                            header: 'Error',
                            theme: 'jnoty-danger',
                            icon: 'fa fa-check-circle fa-2x'
                        });
                    }
                });
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
        $(document).ready(function() {
            $("#pnum").click(function() {
                $("#pickunumber").show();
            });
        });
        $(document).ready(function() {
            $("#ppromo").click(function() {
                $("#promocode").show();
            });
        });
        $("#tAmt").focusout(function(e) {
            form = $(this).closest('form');
            var tAmt = form.find("#tAmt").val();
            $('#amt').val(tAmt);
        });
    </script>

    <script>
        gtag('event', 'conversion', {
            'send_to': 'AW-969836617/TLEMCMXkm_8BEMmQus4D'
        });
    </script>

@endsection