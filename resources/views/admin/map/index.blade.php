@extends('admin.layout.master')
@section('title', 'Live Tracking ')
@section('content')
<div class="row">
   <div class="col-sm-12">
      <div class="page-title-box">
            <div class="row align-items-center">
               <div class="col-md-8">
                  <h4 class="page-title m-0">Live Location </h4>
               </div>
               <div class="col-md-4">
                  {{-- <div class="float-right">
                        <a href="{{ url('/ticket/create') }}" class="btn btn-primary" type="button">
                           <i class="ti-plus mr-1"></i> Add New Ticket
                        </a>
                  </div> --}}
               </div>
            </div>

      </div>
   </div>
</div>
 <div class="card">
        <div class="card-body">
            <div class="row">
               
                <div class="col-md-2">
                     <div class="form-check">
                         <input class="form-check-input" type="radio" value="all" checked="true" class="custom-control-input" name="type">

                         <label class="form-check-label text-danger" for="pending">

                             All
                         </label>
                     </div>

                </div>
                 <div class="col-md-2">
                      <div class="form-check">
                          <input class="form-check-input" type="radio" value="user"  class="custom-control-input" name="type">
                          <label class="form-check-label text-warning" for="pending">
                              User
                          </label>
                      </div>
                </div>
                <div class="col-md-2">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="driver" class="custom-control-input" name="type">
                        <label class="form-check-label text-success" for="delivering">
                            Driver

                        </label>
                    </div>

                </div>
                <div class="col-md-2">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="ongoing" class="custom-control-input" name="type">


                        <label class="form-check-label text-danger" for="ongoing">


                            Ongoing Trip


                        </label>
                    </div>

                    
                </div>
                <div class="col-md-2">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="complete" class="custom-control-input" name="type">



                        <label class="form-check-label " for="return">

                           Completed Trip



                        </label>
                    </div>

                    {{-- <label class="custom-control ">
                        <input type="radio" value="return" class="custom-control-input" name="type">
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">Return Remaining</span>
                    </label> --}}
                </div>
            </div>

        </div>
    </div>
      <div id="map" style="width: 100%; height: 450px;"></div>
@endsection
@section('styles')
<style type="text/css">
   #map {
   height: 100%;
   min-height: 500px;
   }
   #legend {
   font-family: Arial, sans-serif;
   background: rgba(255,255,255,0.8);
   padding: 10px;
   margin: 10px;
   border: 2px solid #f3f3f3;
   }
   #legend h3 {
   margin-top: 0;
   font-size: 16px;
   font-weight: bold;
   text-align: center;
   }
   #legend img {
   vertical-align: middle;
   margin-bottom: 5px;
   }
</style>
@endsection
@section('scripts')
<script>
   var map;
   var users;
   var providers;
   var ajaxMarkers = [];
   var Markers = [];
   var mapIcons = {
        user: '{{ asset("asset/img/marker-user.png") }}',
        complete: '{{ asset("asset/img/marker-home.png") }}',
        riding: '{{ asset("asset/img/car-active.png") }}',
        active: '{{ asset("asset/img/marker-car.png") }}',
        //unactivated: '{{ asset("asset/img/marker-plus.png") }}'
   }
   
   function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            minZoom: 1,
            center: {lat: 27.7172, lng: 85.3240}
            //center: {lat: 28.57427, lng: 77.3558}
        });
        $(":radio").click(()=>{
          getData(map)
        })
        getData(map)
        setInterval(() => {
          getData(map);
        }, 15000);
      }

        // var beaches = [
        //   ['Kathmandu',27.7172, 85.3240, 2],
        //   ['Nagarjun', 27.7325, 85.2567, 1],
        // ];

      function getData(map){
        var type = $(":checked").val();
        $.get('{{url("admin/get-locations")}}/'+type).then(res=>{
            clearMarkers();
            setMarkers(map, res)
        })
      }
      
    function setMarkers(map, beaches) {
        //var image = {
        //   url: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png',
        //   size: new google.maps.Size(20, 32),
        //   origin: new google.maps.Point(0, 0),
        //   anchor: new google.maps.Point(0, 32)
        //};
        
        var shape = {
          coords: [1, 1, 1, 20, 18, 20, 18, 1],
          type: 'poly'
        };
        var infowindow = new google.maps.InfoWindow({
          content: 'contentString'
        });
        for (var i = 0; i < beaches.length; i++) {
          var beach = beaches[i];
          var marker = new google.maps.Marker({
            position: {lat: beach.latitude, lng: beach.longitude},
            map: map,
            icon: {url: mapIcons[beach.icon]},
            shape: shape,
            // id:'id'+i,
            // title: beach.icon,
            zIndex: 5
          });
          
          Markers.push(marker);
          var content = 'Content not found.';
          
            var infowindow = new google.maps.InfoWindow()

            google.maps.event.addListener(marker,'click', (function(marker,content,infowindow,beach){ 
            return function() {
               var url1 = '{{url("admin/get-details")}}/'+beach.icon+"/"+beach.id;
               $.get(url1).then(res=>{
                  if(res) content = res
                  infowindow.setContent(content);
                   infowindow.open(map,marker);
               })
               
            };
            })(marker,content,infowindow,beach));
        }
    }
    function clearMarkers() {
        for (var i = 0; i < Markers.length; i++) {
         Markers[i].setMap(null);
        }
        Markers = [];
    }
</script>
<script src="//maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY_WEB') }}&libraries=places&callback=initMap" async defer></script>
@endsection