<?php

   
   $locale = session()->get('locale');
   if($locale){

      $locale;

   }else{

      $locale = 'en';

   }
   $des = $locale.'_description';
   $type = $locale.'_type';
   $name = $locale.'_name';
   $meta_des = $locale.'_meta_description';
   $title = $locale.'_title';
   ?>
@extends('website.app')


@section('content')
<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
<style>

body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal {
  display: hidden; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 9999; /* Sit on top */
  padding-top: 100px; /* Location of the box */
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
   

<div class="get_there">
   
   <div class="">
      
<div class="">
    <div class="container">
      <div class="row">
         <div class="col-md-12">
            <div class="pricing_left with_97 text-center">
               <h2>50 + online business uses Hulagi for home delivery in Kathmandu.</h2>
               <br>
               <p>
                  Hulagi is revolutionary way to move parcels, share, collaborate and communicate with parcel needs.<br>
                  Hulagi simplifies complexity with one, connected cloud platform that empowers everyone across the supply chain to make smarter, faster, more informed decisions.
               </p>
               <br>
               <div class="d-inline">
                  <a href="{{url('/UserSignin')}}" class="btn btn-action" style="background:#dc1014;color:white;margin-right:15px;" >Place Order</a>
                  <a href="{{url('/contact_us')}}" class="btn btn-action" style="background:#fff;color:black;margin-left:15px;">Talk With Sales</a>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
   <div class="col-md-12" style="padding:0px;">
        <iframe width="100%" height="530cm" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.openstreetmap.org/export/embed.html?bbox=85.32802963243742%2C27.678325368870556%2C85.33807182298918%2C27.68465293750201&amp;layer=mapnik"></iframe><br/><small>
           <!-- <a href="https://www.openstreetmap.org/#map=17/27.68149/85.33305">View Larger Map</a> -->
         </small>
    </div>
</div>  
   </div>
</div>
<div class="clearfix"></div>
<div class="need_shipping text-center">
   <h1>Need shipping? Get an instant quote.</h1>
   <h3>We will email within 5 minutes</h3>
   <form class="form-inline quote-form" action="{{url('/getAQuote')}}" method="POST">
      {{ csrf_field() }}
      <input name="name" class="form-control" type="text" placeholder="Name" required>
      <input name="businessName" class="form-control" type="text" placeholder="Business Name">
      <input name="email" class="form-control" type="email" placeholder="Email" required>
      <input name="phone" class="form-control" type="text" placeholder="Phone" required> 
      <div class="form-group mt-4 mb-4">
            <div class="captcha">
               <span>{!! captcha_img() !!}</span>
               <button type="button" class="btn btn-danger" class="reload" id="reload">
                  &#x21bb;
               </button>
            </div>
      </div>
      <div class="form-group mb-4">
            <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha" required>
      </div>
      <button class="btn">Get a Quote</button>
   </form>
   @if($errors->has('name'))
      <div class="alert alert-danger">{{ $errors->first('name') }}</div>
   @endif
   @if($errors->has('businessName'))
      <div class="alert alert-danger">{{ $errors->first('businessName') }}</div>
   @endif
   @if($errors->has('email'))
      <div class="alert alert-danger">{{ $errors->first('email') }}</div>
   @endif
   @if($errors->has('phone'))
      <div class="alert alert-danger">{{ $errors->first('phone') }}</div>
   @endif
   @if ($errors->has('captcha'))
   <div class="alert alert-danger">{{ $errors->first('captcha') }}</div>
   @endif
   @if(session()->has('message'))
      <div class="alert alert-success">Quotation has been sent to mail.</div>
   @endif
</div>
<div class="jumbotron why_with_puryau text-center">
   <img class="img-fluid" src={{ asset('asset/img/chevron.png') }} style="height: 50px;">
   <h1>Why with Hulagi?</h1>
   <p>
      It’s more important than ever to deliver exceptional, personalized customer experiences – all the time, across all 
      your channels, throughout the entire customer lifecycle. Enter Hulagi's fastest logistics platform.
   </p>
   <h3>Hulagi is Nepal's fastest & reliable logistics company.</h3>
   <p>
      It’s built on our industry-leading foundation of Conversational Marketing and Conversational Sales. Learn more 
      about how it works for:
   </p>
   <div class="d-inline">
      <a href="{{url('/UserSignin')}}" class="btn btn-action" >PLACE ORDER</a>
      <a href="{{url('/contact_us')}}" class="btn btn-action" >TALK WITH SALES</a>
   </div>
</div>
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content banner" style="background-color:#F0F3F4 ">
    <span class="close">&times;</span>
      <div class="row">
      <div class="col-md-4 text-center">
            <img src={{ asset('uploads/Puryau-logo-black.png') }} style="height: 200px; width:80%;padding-top:40px;" class="center">
         </div>
         <div class="col-md-4 text-center" style=" text-size:50px; padding-top:85px;">
            <h2> <b>Hulagi Logisitcs , Cargo & Courier.</h2></b>
         </div>
         <div class="col-md-4 text-center">
            <img src={{ asset('uploads/ict-logo.png') }} style="height: 200px; padding-right:3px" >
         </div>

         
      </div>
      <div style="font-size: 20px; font-family:Poppins;">
         <p>
            <h3>
               Dear Valuable Customers,

            </h3>
            <h4>
            Hulagi has listed on the top 5 in the Sartup ICT award 2021 and all this credit goes to our Valuable Customers. We humbly request all our customer to love and support us through votes to win this Award.
            </h4>
            <br>
            Regards,
            <h4>Hulagi Team</h4>
         </p>
         <br>
         <br>
         <h3 class="text-center">How To Vote For Us ??</h3>  
         <br>
         <h4>eSewa Voting :</h4><br>
         <span style="font-size: 20px; font-family:Poppins;">
            1.Download eSewa app. <br> <br>
      </span>
         <div class="row">
            <div class="col-md-3" style="padding-top:25px;">
            <span style="font-size: 20px; font-family:Poppins;">
               2.Search for New Service and  Click on ICT Award,
               </span>
               <img src={{ asset('uploads/v1.jpg') }} style="height: 100%; width: 100% ;">
               
            </div>
            <div class="col-md-3" style="padding-top:25px;">
            <span style="font-size: 20px; font-family:Poppins;">
            3.Select Category and click on Startup ICT award 2021 
            </span>
               <img src={{ asset('uploads/v2.jpg') }} style="height: 100%; width: 100% ;">
              
            </div>
            <div class="col-md-3" style="padding-top:25px;">
            <span style="font-size: 20px; font-family:Poppins;">
            4.Select Hulagi and click on vote.
            </span>
               <img src={{ asset('uploads/v3.jpg') }} style="height: 100%; width: 100% ;">
              
            </div>
            <div class="col-md-3" style="padding-top:25px;">
            <span style="font-size: 20px; font-family:Poppins;">5.Choose Package and Vote For us.</span>
               <img src={{ asset('uploads/v4.jpg') }} style="height: 100%; width: 100% ;">
            </div>
         </div>
         <br>
         <h3>SMS Voting:</h3><br>
         <h4>
             Type ICT CA 105 and send to 33001.
         </h4> </h4>To make us win Huawei Startup Award 2021 <br>

         <br>
         
         <h4>To make us win Public Choice Award 2021</h4>
         Type ICT PC 33 and send to 33001.<br>
      </div>
  </div>

</div>

<script>
// Get the modal
var modal = document.getElementById("myModal");

var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 


// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
@endsection
@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    $('#reload').click(function () {
        $.ajax({
            type: 'GET',
            url: 'reload-captcha',
            success: function (data) {
                $(".captcha span").html(data.captcha);
            }
        });
    });
</script>
<script type="text/javascript" src="{{asset('asset/front/js/slick.min.js')}}"></script>
<script type="text/javascript">

  var  saveLocation =function() {  
   
  
	   $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type	:	'POST',
            url	    : 	site_url+'/saveLocationTemp',
            data	: 	$('#location_form').serialize(), 
        
            success	: 	function(json) {
               // form.find('.destination').after('<div class="final_estimated" style="font-weight: bold; color:black"><span class="pull-left">Estimated Fare</span><span class="pull-right">'+json.estimated_fare+'</span></div>');  
                //form.find('.car-detail').after('<div class="book_now_wrap"><button type="submit" class="btn btn-default sid_tg">Book Now <figure><img src="img/btn_arrow.png" alt="img"></figure></button></div>');
            }
          });
       }
   
   var ip_details = [];
   var current_latitude = 27.6932302;
   var current_longitude = 85.2770152;
   
   $(document).ready(function() {
     $("#owl-demo2").owlCarousel({
       autoPlay: 3000,
       items :3,
       autoPlay:true,
       navigation:true,
       navigationText:true,
       pagination:true,
       itemsDesktop : [1350,3],
       itemsDesktop : [1199,2],
       itemsDesktopSmall : [991,1],
       itemsTablet: [767,1], 
       itemsMobile : [560,1] 
     });
   
   });     
   
   function disableEnterKey(e) {
       var key;
       if(window.e) {
           key = window.e.keyCode; // IE
       } else {
           key = e.which; // Firefox
       }
   
       if(key == 13)
           return e.preventDefault();
   }
   
    $('.pricing_left .car-radio').on('click', function() {
   var detail = $('.car-detail');
   detail.find('input[type=radio]').attr('checked');
   detail.find('.car_ser_type').removeClass('car_ser_type');
   detail.find('.img_color').removeClass('img_color');
   $(this).find('img').addClass('img_color');
   $(this).find('span').addClass('car_ser_type');
   $(this).find('input[type=radio]').attr('checked', 'checked');
   
   });
   
   $('.car-detail').slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		autoplay: false,
		swipeToSlide: true,
		infinite: false
	});

   $(function() {
	   
		$('#destination-input').focusout(function(){
		   //console.log('hhhhhhhhhhhhh.....');
			saveLocation();
		});
		
		 $('.pricing_left .car-radio').on('click', function() {
			 
            var radioValue = $("input[name='service_type']:checked").val();
            if(radioValue){
                saveLocation(); 
            }
        });
	   
	    $('#origin-input,#destination-input').on('change,focusout', function() {

			//console.log('reached.....');
			saveLocation();
			
		});
   $('#estimated_btn').click(function(e) {
   	
    e.preventDefault();
    form = $(this).closest('form');
    form.find('.help-block, .final_estimated').remove();
   
    var origion                 = form.find('#origin-input');
    
	   
	   
	   
    var destinated              = form.find('#destination-input');
    var service_type            = $("input[name='service_type']:checked").val();
    
    var service_name = $('#serType_'+service_type).val();
    
    	
    var origin_longitude	    =	form.find('#origin_longitude').val();
    var destination_latitude    =   form.find('#destination_latitude').val();
    var destination_longitude   =   form.find('#destination_longitude').val();
    var formData = form.serializeArray();
   
    if( origion.val().length === 0 ) {
        form.find('.pickup_location').append('<span class="help-block text-danger">Please add a pick up location! </span>');
        return false;
    }
    
    if( destinated.val().length === 0 ) {
        form.find('.destination').append('<span class="help-block text-danger">Please add a final location! </span>');
        return false;
    }
   
   
    if( origin_latitude.length !== 0 &&  origin_latitude.length !== 0  && origin_latitude.length !== 0  && origin_latitude.length !==  0 ) {
		$('#myModalpopup').modal('show');
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type	:	'POST',
            url   : '{{ url("/get_fare") }}',
            data	: 	formData,         
            success	: 	function(json) {
            	$("#s_location").text(origion.val());
            	$("#d_location").text(destinated.val());
            	$("#service_type").text(service_name);
            	$("#estimate_fee").text(json.estimated_fare);
                /*form.find('.destination').after('<div class="final_estimated" style="font-weight: bold; color:black"><span class="pull-left">Estimated Fare</span><span class="pull-right">'+json.estimated_fare+'</span></div>');  
                form.find('.car-detail').after('<div class="book_now_wrap"><button type="submit" class="btn btn-default sid_tg">Book Now <figure><img src="asset/front_dashboard/img/btn_arrow.png" alt="img"></figure></button></div>');*/
            }
            
          });
   }
   });
   
   });
   
</script>
@endsection
