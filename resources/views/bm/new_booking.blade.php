<?php 
	$total_zones =	count( $all_zones ); 
	$width 		 =	$total_zones * 	200;
?>

@extends('bm.layout.base')

@section('title', 'New Trip')

@section('content')
<div class="content-area py-1" id="bm-panel">
	<div class="container-fluid">
		<!--<div class="row">
			<div class="col-md-12">
				<h4>New Trip</h4>
			</div>
		</div>-->
		<div class="row">
			<div class="col-md-4">
				<div class="box card card-block" id="create-ride">
					<form id="form-create-ride" method="POST">
						<div class="row">
							<div style="display: none" class="<?php echo ( count( $corporates ) > 0 ) ? 'col-xs-6' : 'col-xs-12'; ?>">
								<div class="form-group">
									<label class="btn btn-secondary btn_corporate active btn-block"><input type="radio" id="booking_typeq" name="booking_type" value="1" checked class="booking_type" style="float:left;"><h7>Indivisual</h7></label>
								</div>
							</div>
							@if( count( $corporates ) > 0 )
							<div class="col-xs-6" style="display: none">
								<div class="form-group">
									<label class="btn btn-secondary btn_corporate btn-block"><input type="radio" id="booking_type" name="booking_type" value="2" class="booking_type" style="float:left;"><h7>Corporate</h7></label>
								</div>
							</div>
							@endif
							<div class="col-xs-12">
								<div class="form-group">
									<label for="first_name">Name</label>
									<input type="text" class="form-control" name="first_name" id="first_name" placeholder="Name" required />
								</div>
									<input type="hidden" class="form-control" name="last_name" id="last_name" placeholder="Last Name" value="" />
						
							</div>
							<div class="col-xs-6">
								<div class="form-group">
									<label for="email">Email</label>
									<input type="email" class="form-control" name="email" id="email" placeholder="Email" />
								</div>
							</div>
							<div class="col-xs-6">
								<div class="form-group">
									<label for="mobile">Phone</label>
									<input type="text" class="form-control" name="mobile" id="mobile" placeholder="Phone" required />
								</div>
							</div>
							<div class="col-xs-12">
								<div class="form-group">
									<label for="s_address">Pickup Location</label>
									<input type="text" name="s_address" class="form-control" id="s_address" placeholder="Pickup Location" required></input>
									<input type="hidden" name="s_latitude" id="s_latitude"></input>
									<input type="hidden" name="s_longitude" id="s_longitude"></input>
								</div>
								<div class="form-group">
									<label for="d_address">Delivery Location</label>
									<input type="hidden" name="bm_id" id="bm_id" value="{{ $user_id }}">
									<input type="text"  name="d_address" class="form-control" id="d_address" placeholder="Delivery Location" required></input>
									<input type="hidden" name="d_latitude" id="d_latitude" {{ session('d_latitude') }}"></input>
									<input type="hidden" name="d_longitude" id="d_longitude" {{ session('d_longitude') }}"></input>
									<input type="hidden" name="request_id" id="request_id" {{ session('request_id') }}"/>
								</div>
								<div class="form-group">
									<label for="schedule_time">Schedule Time</label>
									<input type="text" class="form-control form_datetime" name="schedule_time" id="schedule_time" placeholder="Date" autocomplete="off"/>
								</div>
								@if( $payment_methods->count() )
									<div class="form-group">
										<label for="service_types">Payment Method</label>
										<select name="payment_method" id="payment_method" class="form-control">	
											@foreach( $payment_methods as $method )
												<option value="{{ $method->id }}">{{ $method->name }}</option>
											@endforeach
										</select>
									</div> 
								@endif
								
								@if( count( $services) > 0 )
									<div class="form-group">
										<label for="service_types">Delivery Type</label>
										<select name="service_type" id="service_type" class="form-control">
											@foreach( $services as $service )
												<option value="{{ $service->id }}">{{ $service->name }}</option>
											@endforeach
										</select>
									</div> 
								@else
									<div class="form-group">
										<div  class="bg-danger">Service type not added by admin. Please contact to admin first to add a service type then create a request</div>
									</div>								
								@endif
							</div>
							<!--div class="col-xs-12">
								<div class="form-group">
									<label for="req_cars">No. of car required</label>
									<select name="req_cars" id="req_cars" class="form-control">
										@for($i = 1; $i < 6; $i++ )
											<option value="{{ $i }}">{{ $i}} <i class="fa fa-car"></i></option>
										@endfor
									</select>
								</div> 
							</div-->
							<div class="col-xs-12">
								<div class="form-group">
									<label for="distance">Distance(KM)</label>
									<input type="text" class="form-control" readonly name="distance" id="distance"></input>
								</div>
							</div>
							<div class="col-xs-12">
								<div class="form-group">
									<label for="distance">Add Note</label>
									<textarea class="form-control" rows="4" id="special_note" name="special_note"></textarea>
								</div>
							</div>
							@if( count( $corporates ) > 0 )
								<div id="corporate_list" class="hide">
									<div class="col-xs-12">
										<div class="form-group">
											<label htmlfor="provider_id">Corporate Name</label>
											<select name="corporate_id" class="form-control">
												@foreach( $corporates as $corporate )
													<option value="{{ $corporate->id }}">{{ $corporate->corporate_name }}</option>
												@endforeach
											</select>
										</div> 
									</div>
									<div class="col-xs-12">
										<div class="form-group">
											<label htmlfor="provider_id">Fare (Driver)</label>
											<input type="text" readonly class="form-control" name="estimated_price" id="estimated_price"></input>
										</div> 
									</div>
									<div class="col-xs-12">
										<div class="form-group">
											<label htmlfor="provider_id">Fare (Customer)</label>
											<input type="text"  class="form-control" name="amount_customer" id="amount_customer"></input>
										</div> 
									</div>
								</div>
							@endif
							<div class="col-xs-12">
								<div class="form-group">
									<label for="provider_auto_assign">Auto Assign Driver</label>
									<br />
									<input  type="checkbox" id="provider_auto_assign" name="provider_auto_assign" class="js-check-change" data-color="#f59345" checked="checked" />
								</div>
								<div class="form-group hide" id="provider_list">
									<label htmlfor="provider_id">Select Driver</label>
									<input name="provider_id" type="hidden"/>
									
									<div class="provider_fl_wrapper">
										<div class="form-control" id="provider_wrapper">
											<div class="dr_search_txt">Select Driver</div>
											<div class="dr_icon"><i class="fa fa-sort-down" aria-hidden="true"></i></div>
										</div>
										<div id="dr_list_wrapper">
											<div id="input_wrapper">
												<input type="text" placeholder="Search..." id="dr_seach_input" class="form-control" onkeyup="filterFunction()" />
											</div>
											<div id="dr_list"></div>
										</div>
									</div>
								 </div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								<button type="button" class="btn btn-lg btn-danger btn-block waves-effect  waves-light form_create_ride_reset_btn">RESET</button>
							</div>
							<div class="col-xs-6">
								<button type="button"  class="btn btn-lg btn-success btn-block waves-effect waves-light">@lang('user.ride.order')</button>
								<!-- <button class="btn btn-lg btn-success btn-block waves-effect waves-light">Next</button> -->
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="col-md-8">
				<div class="card my-card">
					<div class="box card-header">								
					<div class="col-md-3">						        
					<div style="margin-top:5px;font-size: 16px;">
						<input type="checkbox" name="vehicle1" value="ongoing" id="ongoing" class="vehicle1" onclick="rideOn()"> On Going Order</div>
					</div>								
					<div class="col-md-3">						        
					<div style="margin-top:5px;font-size: 16px;">
						<input type="checkbox" name="vehicle1" value="driver" id="driver" class="
						vehicle1" onclick="rideOn();"> Active Driver</div>
					</div>								
					<!-- <div class="col-md-6">						        
					<input type="text" class="form-control form_datetime" id="searchid" name="schedule_time" placeholder="Search Location"/>							
					</div> -->					
					</div>
					<div class="card-body" style="height: 500px;">
						<div id="map"></div>
					</div>
				</div>
				<div class="main_inner">
					<ul class="ul" style="width:{{$width}}px">
						@foreach(  $all_zones as $zone )
							<li  class="zone">
								<div class="header">{{ $zone['zone_name'] }}</div>
                                <div class="driver_list zone_{{ $zone['id'] }}" data-zone_id="{{ $zone['id'] }}"  id="zone_{{ $zone['id'] }}">	
									@if( $zone['drivers'] )
										@foreach( $zone['drivers'] as $driver )
												<div class="driver <?php echo ( $driver->provider_status == 'riding' ) ? 'bg-warning' : ''; ?>  driver_{{ $driver->id }}" id="position_{{ $driver->driver_position }}">
													<div class="vehicle_no">{{ strtoupper( $driver->service_number ) }}</div>
													<div class="timeOut">In Time:{{ $driver->enter_time }}</div>
												</div>
										@endforeach
									@endif
								</div>												
							</li>
						@endforeach
					</ul>
				</div>
	
				<div id="fareMap"></div>
				
			</div>
		</div>
	</div>
</div>
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
		   <form action="{{url('/bm/bm/create/item')}}" method="POST" id="item_create" enctype="multipart/form-data">
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
				<div class="form-group row">
					<label for="email" class="col-xs-4 col-form-label label_note">Special Note(If Any)</label>
					<div class="col-xs-8"> 
						<textarea name="special_note" id="special_note" class="form-control" placeholder="Enter Text Here..."></textarea>
				    </div>
				</div>
                
                
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
                
				<div class="form-group row">
					<div class="col-xs-6">
						<button type="button" style="margin-top: 0px;" class="btn btn-lg btn-danger btn-block waves-effect  waves-light form_create_ride_reset_btn" data-dismiss="modal">Cancel</button>
					</div>
				     <div class="col-xs-6">
						<button type="button" style="margin-top: 0px;" onclick="itemSubmit()" id="item_submit" class="btn btn-lg btn-success btn-block waves-effect waves-light">ok</button>
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
@include('bm.layout.partials.wait_model')
 
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.full.min.js"></script>

<!--script src="https://cdnjs.cloudflare.com/ajax/libs/react/15.5.0/react.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/react/15.5.0/react-dom.js"></script>
<script src="https://unpkg.com/babel-standalone@6.24.0/babel.min.js"></script-->

@php 

 //$latAndLong =getLatAndLongByLocation('Country');
 $provider_select_timeout =providerTimeout(); 
@endphp

<script type="text/javascript">
var counter =60;

var current_lat		 =	28.535517;
var current_long     =	77.391029;

var schedule_req_time =  {{ Setting::get('schedule_req_time', 0) }};

var zones  = <?php echo json_encode( $all_zones ); ?>;
var mapIcons = {
//user: '{{ asset("asset/front/img/marker-user.png") }}',
	active: '{{ asset("asset/front/img/48-x-48-n.png") }}',
	riding: '{{ asset("asset/front/img/car-active.png") }}',
	//offline: '{{ asset("asset/front/img/car-offline.png") }}',
	//unactivated: '{{ asset("asset/front/img/car-unactivated.png") }}'
};

<?php if( $ip_details ) { ?>

	var current_lat  =	"<?php echo $ip_details->geoplugin_latitude; ?>";
	var current_long =	"<?php echo $ip_details->geoplugin_longitude; ?>";
	
<?php }?>

var provider_select_timeout = "<?php echo $provider_select_timeout; ?>";
var bm_user_id = "<?php echo $user_id; ?>" ;
var site_url           ="<?php echo  url('/'); ?>"; 
var countdown_number   = provider_select_timeout;
var countdown;

// Init Checkbox
var mySwitch = new Switchery(document.querySelector('.js-check-change'));

window.Tranxit = {!! json_encode([
	"minDate" => \Carbon\Carbon::today()->format('Y-m-d\TH:i'),
	"maxDate" => \Carbon\Carbon::today()->addDays(30)->format('Y-m-d\TH:i'),
	"map" => false,
]) !!}


//Document ready function define here
$(function () {       
	$('#schedule_time').datetimepicker();
	
	$('#provider_wrapper').on('click', function() {
		$('#dr_list_wrapper').slideToggle('slow');
	});
	
	$(document).on('click','#dr_list .dr_item',function() {
		$('#provider_list input[name=provider_id]').val($(this).attr('pr_id'));
		$('#provider_list .dr_search_txt').text($(this).text());
		$('#dr_list_wrapper').slideUp('slow');
	});
	
});
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
$('#myModal').on('show.bs.modal', function (event) {
	var model = $('#myModal');
	service_name = $('#service_type option:selected').text();
    
    /*var service_name = $('#serType_'+service_type).val();*/
    $(".modal-title").text(service_name+' Details');
    $(".label_name").text(service_name+' Name');
    $(".label_qty").text(service_name+' Quantity');
    $(".label_weight").text(service_name+' Weight');
    $(".label_size").text(service_name+' Size');
    

});
function  itemSubmit(){ 

        var  url     ="<?php echo url('/bm/bm/create/item');?>";
        
		//var extension = $('#files').val().split('.').pop().toLowerCase();
		var service_type = $('#service_type option:selected').val();
		var name          = $('#name').val();
		var qty           = $('#qty').val();
		var discription   = $('#discription').val();
		var special_note  = $('#special_note').val();
		var user_id       = $('#user_id').val();

		var height       = $('#height').val();
		var width       =  $('#width').val();

		var rec_name       = $('#rec_name').val();
		var rec_mobile       = $('#rec_mobile').val();
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
						$("#myModal").modal("hide");
						createRide();
						/*$('#form-create-ride').submit();*/
						
					},
					error: function(){
						alert("error in ajax form submission");
					}
				});
		}

function filterFunction() {
  var input, filter, ul, li, a, i;
  input = document.getElementById("dr_seach_input");
  filter = input.value.toUpperCase();
  div = document.getElementById("dr_list");
  a = div.getElementsByTagName("a");
  for (i = 0; i < a.length; i++) {
    if (a[i].innerHTML.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
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
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY_WEB') }}&libraries=places,geometry&callback=initMap" async defer></script>
<script type="text/javascript" src="{{ asset('asset/front/js/bm-map.js') }}"></script>
@endsection
@section('styles')
<style type="text/css">

/* by sid */

.provider_fl_wrapper {
    position: relative;
}

div#provider_wrapper {
    position: relative;
	cursor: pointer;
}

.dr_icon {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
}

#dr_list_wrapper {
	display: none;
    position: absolute;
    left: 0;
    right: 0;
    top: 100%;
    width: 100%;
    z-index: 99;
    padding: 20px;
	border: 1px solid #c1c1c1;
    border-radius: 0 0 5px 5px;
    background-color: #f1f1f1;
}

#dr_list_wrapper input {
    border-radius: 6px;
}

#dr_list .dr_item {
    display: block;
    padding: 5px 0;
    cursor: pointer;
    font-weight: bold;
}

div#dr_list {
    height: 180px;
    margin-top: 20px;
    overflow-y: scroll;
}


/* by sid end here */

html, body, #map{
  height: 100%;
  margin: 0px;
  padding: 0px
}

#form-create-ride .has-error  .help-block{
	color: red;
	font-weight: bold;
}

#infowindow{
  padding: 10px;
}
    .my-card input{
        margin-bottom: 10px;
    }
    .my-card label.checkbox-inline{
        margin-top: 10px;
        margin-right: 5px;
        margin-bottom: 0;
    }
    .modal_image img{
    width:20%;
}
    .my-card label.checkbox-inline input{
        position: relative;
        top: 3px;
        margin-right: 3px;
    }
    .my-card .card-header .btn{
        font-size: 10px;
        padding: 3px 7px;   
    }
    .tag.my-tag{
        padding: 10px 15px;
        font-size: 11px;
    }

    .add-nav-btn{
        padding: 5px 15px;
        min-width: 0;
    }

    .bm-nav li span {
        background-color: transparent;
        color: #000!important;
        padding: 5px 12px;
    }

    .bm-nav li span:hover,
    .bm-nav li span:focus,
    .bm-nav li span:active {
        background-color: #20b9ae;
        color: #fff!important;
        padding: 5px 12px;
    }

    .bm-nav li.active span,
    .bm-nav li span:hover,
    .bm-nav li span:focus,
    .bm-nav li span:active {
        background-color: #20b9ae;
        color: #fff!important;
        padding: 5px 12px;
    }

    @media (max-width:767px){
        .navbar-nav {
            display: inline-block;
            float: none!important;
            margin-top: 10px;
            width: 100%;
        }
        .navbar-nav .nav-item {
            display: block;
            width: 100%;
            float: none;
        }
        .navbar-nav .nav-item .btn {
            display: block;
            width: 100%;
        }
        .navbar .navbar-toggleable-sm {
            padding-top: 0;
        }
    }

    .items-list {
        height: 450px;
        overflow-y: scroll;
    }
	
	#corporate_list {
		display: none;
	}
	
	#countdown {
		margin: 0 auto;
		width: 140px;
		height: 150px;
		font-size: 90px;
		line-height: 140px;
		text-align: center;
		border-radius: 50%;
	}

	.ride_fn_btn .btn-block {
		margin-bottom: 20px;
	}

	.ongoing_trips {
		margin-top: 30px;
		background-color: #fff;
		padding: 5px;
	}
	
	.main_inner {
	    background: #fff;
	}
	
	.zone .header {
		background-color: #f1f1f1;
	}

</style>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.min.css" />
@endsection