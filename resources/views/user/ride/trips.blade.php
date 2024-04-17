@extends('user.layout.base')
@section('title', 'My Orders ')
@section('content')
<style type="text/css">
	.fontsize{
		font-size: 14px;
	}
    .car-radio{
        width: 125px !important;
    }
    .modal_image img{
    width:20%;
}
</style>

<div class="content-area py-1">

    <div class="row row-md">

        <div class="col-lg-12 col-md-6 col-xs-12">

            <div class="box box-block bg-warning mb-2">

                <div class="t-content">



                    <h4 class="text-uppercase mb-1"><b> Dhangadhi Update : Supervisor's relative passed away and we might experience delay in delivery for 4/4/2021 inside Dhangadhi & attariya</h4>


                </div>

            </div>

            <div class="content-area py-1">

    <div class="row row-md">

        <div class="col-lg-12 col-md-6 col-xs-12">

            <div class="box box-block bg-warning mb-2">

                <div class="t-content">



                    <h4 class="text-uppercase mb-1"><b> New Location Added : Dhading. </h4>


                </div>

            </div>

            <div class="row row-md">

        <div class="col-lg-12 col-md-6 col-xs-12">

            <div class="box box-block bg-warning mb-2">

                <div class="t-content">



                    <h4 class="text-uppercase mb-1"><b> Upcoming Location : Mugling, Gorkha</h4>


                </div>

            </div>
     
<div class="col-md-12" style="margin-bottom: 20px;">

    <div class="dash-content">
        <div class="row no-margin">
            <div class="col-md-12">
                <h4 class="page-title"><!--@lang('user.ride.ride_now')--><span class="s-icon"></span>&nbsp; New Order</h4>
            </div>
        </div>
        @include('common.notify')
        <div class="row no-margin pricing_left">
            <div class="col-md-6">
                <!--confirm/ride-->
                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
                <form action="{{url('confirm/ride')}}" method="GET" id="confirm_ride" onkeypress="return disableEnterKey(event);" class="tripsform">
                    
                    <div class="input-group dash-form" style="max-width:inherit">
                        <div class="input-group-addon"><span class="ti-control-record"></span></div>
                        {{-- <input type="text" class="form-control fontsize" id="origin-input" name="s_address"  placeholder="Enter pickup location" value="{{ session('s_address') }}"> --}}
                        @if (session('s_address_old'))
                        <input type="text" class="form-control fontsize" id="origin-input" name="s_address"  placeholder="Enter pickup location" value="{{ session('s_address_old') }}">
                        @else
                        <input type="text" class="form-control fontsize" id="origin-input" name="s_address"  placeholder="Enter pickup location" value="{{ session('s_address') }}">
                        @endif
                    </div>
                    <div class="pickup_location">
                        </div>
                    <div class="input-group dash-form" style="max-width:inherit">
                        <div class="input-group-addon"><span class="ti-location-pin"></span></div>
                        <input type="text" class="form-control fontsize" id="destination-input" name="d_address"  placeholder="Enter drop location" value="{{ session('d_address') }}">
                    </div>
                    <div class="destination">
                        </div>
                    {{-- added fields --}}
                    <div class="input-group dash-form" style="max-width:inherit">
                        <div class="input-group-addon"><span class="ti-location-record"></span></div>
                        <input type="text" class="form-control fontsize" id="destination-name" name="d_name"  placeholder="Enter Receiver's Name">
                    </div>
                    <div class="destination-name-error">
                        </div>
                    <div class="input-group dash-form" style="max-width:inherit">
                        <div class="input-group-addon"><span class="ti-location-record"></span></div>
                        <input type="text" class="form-control fontsize" id="destination-phone" name="d_phone"  placeholder="Enter Receiver's Phone">
                    </div>
                    <div class="destination-phone-error">
                        </div>
                    <div class="input-group dash-form" style="max-width:inherit">
                        <div class="input-group-addon"><span class="ti-location-record"></span></div>
                        <input type="number" step="0.01" class="form-control fontsize" id="cod" name="cod"  placeholder="Cash Handle on Delivery (if applicable)">
                    </div>
                    <div class="input-group dash-form" style="max-width:inherit">
                        <div class="input-group-addon"><span class="ti-location-record"></span></div>
                        <textarea name="special_note" id="special_note" class="form-control" placeholder="Enter Remarks(if any)"></textarea>
                    </div>
                    @if (session('s_latitude_old'))
                    <input type="hidden" name="s_latitude" id="origin_latitude" value="{{ session('s_latitude_old') }}">
                    @else
                    <input type="hidden" name="s_latitude" id="origin_latitude" value="{{ session('s_latitude') }}">
                    @endif
                    @if (session('s_longitude_old'))
                    <input type="hidden" name="s_longitude" id="origin_longitude" value="{{ session('s_longitude_old') }}">
                    @else
                    <input type="hidden" name="s_longitude" id="origin_longitude" value="{{ session('s_longitude') }}">
                    @endif
                    {{-- <input type="hidden" name="s_latitude" id="origin_latitude" value="{{ session('s_latitude') }}"> --}}
                    {{-- <input type="hidden" name="s_longitude" id="origin_longitude" value="{{ session('s_longitude') }}"> --}}
                    <input type="hidden" name="d_latitude" id="destination_latitude" value="{{ session('d_latitude') }}">
                    <input type="hidden" name="d_longitude" id="destination_longitude" value="{{ session('d_longitude') }}">
                    <input type="hidden" name="current_longitude" id="long" value="{{ @$_GET['current_longitude'] }}">
                    <input type="hidden" name="current_latitude" id="lat" value="{{ @$_GET['current_latitude'] }}">
                    <input type="hidden" name="promo_code" id="promo_code" />
                    <input type="hidden" name="item_id" id="item_id" />

                    <div class="car-detail">
                        @foreach($services as $service)
                        <?php $i = 0;  ?>
                        <input type="hidden" value="{{$service->name}}" name="serType" id="serType_{{$service->id}}">
                        <div class="car-radio">
                            <input type="radio" 
                                name="service_type"
                                value="{{ $service->id }}"
                                id="service_{{ $service->id }}"
                                @if (session('service_type') == $service->id || $loop->index==0) checked="checked" @endif>
                                
                            <label for="service_{{$service->id}}">
                                <div class="car-radio-inner">
                                    <div class="img"><img src="{{image($service->image)}}"  class="{{ $i== 0 ? 'img_color ': ''}}"></div>
                                    <div class="name"><span class="{{ $i== 0 ? 'car_ser_type': ''}}">{{$service->name}}</span></div>
                                </div>
                            </label>
                        </div>
                        <?php $i++; ?>
                        @endforeach
                    </div>
                    <!--<button type="submit"  class="full-primary-btn btn-success box-shadow fare-btn">@lang('user.ride.order_now')</button>-->
                    <!--<button type="submit" class="half-primary-btn btn-success btn-secondary fare-btn" style="width: 100% !important;">@lang('user.ride.order_now')</button>-->
                    <input type="submit" id="send" name="send" value="" style="display:none;"/>
                    <button type="button" id="estimated_btn" class="full-primary-btn fare-btn">@lang('user.ride.order')</button>
                    <!-- <button type="button" class="half-secondary-btn fare-btn btn-secondary" data-toggle="modal" data-target="#schedule_modal">@lang('user.ride.schedule_order')</button> -->
                </form>
            </div>

            <div class="col-md-6">
                <div class="map-responsive">
                    <div id="map" style="width: 100%; height: 450px;"></div>
                </div> 
            </div>
        </div>
    </div>

    {{-- <div class="dash-content" style="margin-top: 20px;">
        <div class="row no-margin">
            <div class="col-md-12">
                <h4 class="page-title">Recent Ride</h4>
            </div>
        </div>

        <div class="row no-margin ride-detail">
            <div class="col-md-12">
            @if($trips->count() > 0)

                <table class="table table-condensed" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                            <!--th>&nbsp;</th-->
                            <th>@lang('user.booking_id')</th>
                            <th>@lang('user.date')</th>
                            <th>@lang('user.profile.name')</th>
                            <th>@lang('user.amount')</th>
                            <th>@lang('user.type')</th>
                            <th>@lang('user.payment')</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($trips as $trip)

                        <tr data-toggle="collapse" data-target="#trip_{{$trip->id}}" class="accordion-toggle collapsed">
                            <!--td><span class="arrow-icon fa fa-chevron-right"></span></td-->
                            <td>{{ $trip->booking_id }}</td>
                            <td>{{date('d-m-Y',strtotime($trip->assigned_at))}}</td>
                            @if($trip->provider)
                                <td>{{$trip->provider->first_name}} {{$trip->provider->last_name}}</td>
                            @else
                                <td>-</td>
                            @endif
                            @if($trip->payment)
                                <td>{{currency($trip->payment->total)}}</td>
                            @else
                                <td>-</td>
                            @endif
                            @if($trip->service_type)
                                <td>{{$trip->service_type->name}}</td>
                            @else
                                <td>-</td>
                            @endif
                            <td>@lang('user.paid_via') {{$trip->payment_mode}}</td>
                            <td>
                                <form action ="{{url('/mytrips/detail')}}">
                                    <input type="hidden" value="{{$trip->id}}" name="request_id">
                                    <button type="submit" style="margin-top: 0px;" class="full-primary-btn fare-btn">Detail</button>
                                </form>
                            </td>
                        </tr>
                       
                        @endforeach


                    </tbody>
                </table>
                @else
                    <hr>
                    <p style="text-align: center;">No Orders Available</p>
                @endif
            </div>
        </div>

    </div> --}}
</div>
<!-- Schedule Modal -->
<!--<div id="schedule_modal" class="modal fade schedule-modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Schedule a Order</h4>
      </div>
		<form>
			<div class="modal-body">
				<label>Date</label>
				<input value="{{date('m/d/Y')}}" type="text" id="datepicker" placeholder="Date" name="schedule_date">
				<label>Time</label>
				<input value="{{date('H:i')}}" type="text" id="timepicker" placeholder="Time" name="schedule_time">
			  </div>
			  <div class="modal-footer">
				<button type="button" id="schedule_button" class="half-primary-btn btn-success btn-secondary" data-dismiss="modal" style="width: 522px;margin-right: 24px;">Schedule Order</button>
			</div>
		</form>
    </div>
  </div>
</div>-->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
      <div class="content-area py-1">
        <div class="container-fluid">
    	  <div class="">
		   <form action="{{url('create/item')}}" method="POST" id="item_create" enctype="multipart/form-data">
		     <input type="hidden" name="user_id" id="user_id" value="<?php echo Auth::user()->id; ?>" >
		  <div class="form-group row">
					<label for="name" class="col-xs-4 col-form-label label_name"></label>
					<div class="col-xs-8">
						<input class="form-control" type="text" value="" name="name" required id="name" placeholder="Name" required />
					</div>
				</div>

				<div class="form-group row row_qty">
					<label for="email" class="col-xs-4 col-form-label label_qty"></label>
					<div class="col-xs-8">
						<input class="form-control" type="number"  name="qty" value="" id="qty" placeholder="Quantity" required />
					</div>
				</div>
				
				
				<div class="form-group row">
					<label for="name" class="col-xs-4 col-form-label label_weight"></label>
					<div class="col-xs-8">
						<input type="text" name="discription"  id="discription" class="form-control"  placeholder="Weight" required />
					</div>
				</div>
				<div class="form-group row">
					<label for="name" class="col-xs-4 col-form-label label_desc label_size"></label>
					<div class="col-xs-4">
					<label for="name" class="col-form-label label_desc">Height*</label>
					<input class="form-control" type="text"  name="height" value="" id="height" placeholder="Height" required />
					</div>
					<div class="col-xs-4">
					<label for="name" class="col-form-label label_desc">Width*</label>
					<input class="form-control" type="text"  name="width" value="" id="width" placeholder="Width" required />
					</div>
				</div>
				
				<div class="form-group row">
					<label for="email" class="col-xs-4 col-form-label label_img">Images</label>
					<div class="col-xs-8"> 
						<input type="file" name="image" accept="image/*" id="files" form="form-control" onselect="onSelect()" multiple>
					</div>
				</div>
				<div class="form-group row modal_image" id="selectedFiles"></div>
				{{-- <div class="form-group row">
					<label for="email" class="col-xs-4 col-form-label label_note">Special Note(If Any)</label>
					<div class="col-xs-8"> 
						<textarea name="special_note" id="special_note" class="form-control" placeholder="Enter Text Here..."></textarea>
				    </div>
				</div> --}}
                
                
				<h3>Receiver Information</h3>
                <div class="form-group row">
                    <div class="form-check form-check-inline" >
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" checked="" onchange="valueChangedSelf()">
                          <label class="form-check-label" for="inlineRadio1">Self</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2" onchange="valueChanged()"/>
                          <label class="form-check-label" for="inlineRadio2">Other</label>
                    </div>
                </div>
                <div class="otherDiv" style="display:none;"> 
                    <div class="form-group row">
                        <label for="email" class="col-xs-2 col-form-label label_note">Name*</label>
                        <div class="col-xs-10"> 
                            <input type="text"  name="rec_name" id="rec_name" class="form-control" placeholder="Name" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-xs-2 col-form-label label_note">Mobile*</label>
                        <div class="col-xs-10"> 
                            <input type="text"  name="rec_mobile" id="rec_mobile" class="form-control" placeholder="Mobile" required />
                            <p id="rec_mobile_validate"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-xs-2 col-form-label label_note">Email</label>
                        <div class="col-xs-10"> 
                            <input type="email"  name="rec_email" id="rec_email" class="form-control" placeholder="Email"  />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-xs-2 col-form-label label_note">Address</label>
                        <div class="col-xs-10"> 
                            <input type="text"  name="rec_address" id="rec_address" class="form-control" placeholder="Address" />
                        </div>
                    </div>
                </div>
                <!-- <div class="form-group row">
                    <div class="col-xs-6"> 
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Self</a>
                        <div id="collapse1" class="panel-collapse collapse">
                            
                        </div>
                    </div>
                    <div class="col-xs-6"> 
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Other</a>
                        <div id="collapse2" class="panel-collapse collapse">
                           <div class="form-group row">
                            <label for="email" class="col-xs-2 col-form-label label_note">Name*</label>
                                <div class="col-xs-10"> 
                                    <input type="text"  name="rec_name" id="rec_name" class="form-control" placeholder="Name" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-xs-2 col-form-label label_note">Mobile*</label>
                                <div class="col-xs-10"> 
                                    <input type="text"  name="rec_mobile" id="rec_mobile" class="form-control" placeholder="Mobile" required />
                                    <p id="rec_mobile_validate"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-xs-2 col-form-label label_note">Email</label>
                                <div class="col-xs-10"> 
                                    <input type="email"  name="rec_email" id="rec_email" class="form-control" placeholder="Email"  />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-xs-2 col-form-label label_note">Address</label>
                                <div class="col-xs-10"> 
                                    <input type="text"  name="rec_address" id="rec_address" class="form-control" placeholder="Address" />
                                </div>
                            </div>
                        </div>
                    </div>
                  </div> -->

				
				<div class="form-group row">
				     <div class="col-xs-6"> 
						<button type="button" style="margin-top: 0px;" onclick="itemSubmit()" id="item_submit" class="full-primary-btn fare-btn">ok</button>
					 </div>
					<div class="col-xs-6">
						<button type="button" style="margin-top: 0px;" class="full-primary-btn fare-btn" data-dismiss="modal">Cancel</button>
					</div>
                </div>
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
<script type="text/javascript" src="{{ asset('asset/front/js/map.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places&callback=initMap" async defer></script>
<script type="text/javascript">
    var current_latitude = 43.653908;
    var current_longitude = 85.2770152;
	var counter = 2;
	//var categories = <?php //echo json_encode( $categories );  ?>;
</script>

<script type="text/javascript">
$('#estimated_btn').click(function(e) {
    e.preventDefault();
    form = $(this).closest('form');
    var origion                 = form.find('#origin-input');
    var destinated              = form.find('#destination-input');
    var service_type            = $("input[name='service_type']:checked").val();
    var origin_longitude        =   form.find('#origin_longitude').val();
    var origin_latitude        =   form.find('#origin_latitude').val();
    var destination_latitude    =   form.find('#destination_latitude').val();
    var destination_longitude   =   form.find('#destination_longitude').val();
    var destination_name= form.find("#destination-name");
    var destination_phone= form.find("#destination-phone");
    var cod= form.find("#cod");
    var special_note= form.find("#special_note");
    var formData = form.serializeArray();
    if( origion.val().length === 0 ) {
        form.find('.pickup_location').append('<span class="help-block text-danger">Please add a pick up location! </span>');
        return false;
    }
    
    if( destinated.val().length === 0 ) {
        form.find('.destination').append('<span class="help-block text-danger">Please add a final location! </span>');
        return false;
    }
    if( destination_name.val().length === 0 ) {
        form.find('.destination-name-error').append('<span class="help-block text-danger">Please add a receiver\'s name! </span>');
        return false;
    }
    if( destination_phone.val().length === 0 ) {
        form.find('.destination-phone-error').append('<span class="help-block text-danger">Please add a receiver\'s phone! </span>');
        return false;
    }
    
    if( origin_latitude.length !== 0 &&  origin_latitude.length !== 0  && origin_latitude.length !== 0  && origin_latitude.length !==  0 ) {
        
        // $("#myModal").modal("show");
                    
                    
                
        
            
            service_type = $('#confirm_ride input[type=radio]:checked').val();
            var service_name = $('#serType_'+service_type).val();
            // $(".modal-title").text(service_name+' Details');
            // $(".label_name").text(service_name+' Name');
            // $(".label_qty").text(service_name+' Quantity');
            // $(".label_weight").text(service_name+' Weight');
            // $(".label_size").text(service_name+' Size');
            itemSubmit();
            

        
    }
});
/*$('#myModal').on('show.bs.modal', function (event) {
	var model = $('#myModal');
	service_type = $('#confirm_ride input[type=radio]:checked').val();
    var service_name = $('#serType_'+service_type).val();
    $(".modal-title").text(service_name+' Details');
    $(".label_name").text(service_name+' Name');
    $(".label_qty").text(service_name+' Quantity');
    $(".label_weight").text(service_name+' Weight');
    $(".label_size").text(service_name+' Size');
    

});*/
function valueChanged()
{
    if($('#inlineRadio2').is(":checked"))   
        $(".otherDiv").show();
    else
        $(".otherDiv").hide();
}
function valueChangedSelf()
{
    if($('#inlineRadio1').is(":checked"))   
        $(".otherDiv").hide();
    else
        $(".otherDiv").hide();
}
function  itemSubmit(){ 

        var  url     ="<?php echo url('create/item');?>";
		//var extension = $('#files').val().split('.').pop().toLowerCase();
		var service_type = $('#confirm_ride input[type=radio]:checked').val();
		var name          = $('#name').val();
		var qty           = $('#qty').val();
		var discription   = $('#discription').val();
		var special_note  = $('#special_note').val();
		var user_id       = $('#user_id').val();

		var height       = $('#height').val();
		var width       =  $('#width').val();

		var rec_name       = $('#destination-name').val();
		var rec_mobile       = $('#destination-phone').val();
		var rec_email       = $('#rec_email').val();
		var rec_address       = $('#rec_address').val();
				
			var form_data = new FormData(); 
			var TotalImages = $('#files')[0].files.length;  //Total Images
    		var images = $('#files')[0];  
			
   			for (var i = 0; i < TotalImages; i++) {
    				form_data.append('image'+i, images.files[i]);
				}
				form_data.append('TotalImages', TotalImages);
				form_data.append('name', name);
				form_data.append('qty', qty);
				form_data.append('discription', discription);
				form_data.append('special_note', special_note);
				form_data.append('service_type', service_type);
				form_data.append('user_id', user_id);
				form_data.append('rec_name', rec_name);
				form_data.append('rec_mobile', rec_mobile);
				form_data.append('rec_email', rec_email);
				form_data.append('rec_address', rec_address);
				form_data.append('height', height);
				form_data.append('width', width);
				
				$.ajax({
					type: "POST",
					url: url,
					headers: {
						'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
					},
					dataType : 'json',
					cache       : false,
					contentType : false,
					processData : false,
					data:form_data, 
					success: function (data) {
					    
                        $('#item_id').val(data.item_id);
						// $("#myModal").modal("hide");
						$('#confirm_ride').submit();
						
					},
					error: function(data){
						alert("error in ajax form submission");
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
   if($(':radio[name=service_type]:checked, :radio[name=service_type]:checked').length >= 1){
   $('input[name=service_type]').attr('checked', false); 

   } if($(':radio[name=service_type]:checked, :radio[name=service_type]:checked').length==0){
   	   $(this).find('input[type=radio]').attr('checked', 'checked');
   }
   
   });
//alert(document.getElementById('long').value);

    var ip_details = <?php echo json_encode( $ip_details );  ?>;

    var current_latitude = parseFloat(ip_details.geoplugin_latitude);
    var current_longitude = parseFloat(ip_details.geoplugin_longitude);

    if( navigator.geolocation ) {
        navigator.geolocation.getCurrentPosition( success);
    } else {
        console.log('Sorry, your browser does not support geolocation services');
        initMap();
    }

    function success(position)
    {
        document.getElementById('long').value = position.coords.longitude;
        document.getElementById('lat').value = position.coords.latitude;

        if(position.coords.longitude != "" && position.coords.latitude != ""){
            current_longitude = position.coords.longitude;
            current_latitude = position.coords.latitude;
          
        }
		
        initMap();
    }
</script> 
    
    <script type="text/javascript">	
        var date = new Date();
        date.setDate(date.getDate()-1);
        $('#datepicker').datepicker({  
            startDate: date
        });	

		
        $('#timepicker').timepicker({showMeridian : false});		
        function card(value){
            if(value == 'CARD'){
                $('#card_id').fadeIn(300);
            }else{
                $('#card_id').fadeOut(300);
            }
        }	
        
        $('#schedule_button').click(function(){
            alert("ride script");
            $("#datepicker").clone().attr('type','hidden').appendTo($('#create_ride'));
            $("#timepicker").clone().attr('type','hidden').appendTo($('#create_ride'));
            alert("ride script before submit");
            document.getElementById('create_ride').submit();
        }); 		

    </script>
    
<script type="text/javascript">
    function disableEnterKey(e)
    {
        var key;
        if(window.e)
            key = window.e.keyCode; // IE
        else
            key = e.which; // Firefox

        if(key == 13)
            return e.preventDefault();
    }

/* For Multiple Image Show */

	var selDiv = "";
		
	document.addEventListener("DOMContentLoaded", init, false);
	
	function init() {
		document.querySelector('#files').addEventListener('change', handleFileSelect, false);
		selDiv = document.querySelector("#selectedFiles");
	}
		
	function handleFileSelect(e) {
		
		if(!e.target.files || !window.FileReader) return;

		selDiv.innerHTML = "";
		
		var files = e.target.files;
		var filesArr = Array.prototype.slice.call(files);
	
	
		
		filesArr.forEach(function(f) {
		
			if(!f.type.match("image.*")) {
				return;
			}
			var reader = new FileReader();
			reader.onload = function (e) {
				var html = "<img src=\"" + e.target.result + "\" hspace='10'>";// + f.name + "<br clear=\"left\"/>";
				selDiv.innerHTML += html;				
			}
		
			reader.readAsDataURL(f); 
		
		});
		
	}
</script>

@endsection