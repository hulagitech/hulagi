
@extends('dispatcher.layout.base')

@section('title', 'Order details ')

@section('content')
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <h5 style="margin-bottom: 2em;"><span class="s-icon"><i class="ti-pie-chart"></i></span> Order Details</h5>
            <hr>
            <div class="row">
                <div class="col-md-7">
                    {{-- <div id="map"></div> --}}
                </div>

                <div class="col-md-5">
                    <dl class="row">
                        
                        <dt class="col-sm-4">Name :</dt>
                        <dd class="col-sm-8">{{ @$request->user->first_name }}</dd>
                        

                        <dt class="col-sm-4">Driver :</dt>
                        @if($request->provider)
                        <dd class="col-sm-8">{{ @$request['provider']['first_name'] }}</dd>
                        @else
                        <dd class="col-sm-8">Provider not yet assigned!</dd>
                        @endif
                        
                        {{-- @if($request['status'] == 'SCHEDULED')
                        <dt class="col-sm-4">Order Scheduled Time :</dt>
                        <dd class="col-sm-8">
                            @if($request['schedule_at'] != "0000-00-00 00:00:00")
                                {{ date('jS \of F Y h:i:s A', strtotime($request->schedule_at)) }} 
                            @else
                                - 
                            @endif
                        </dd>
                        
                        @else
                        <dt class="col-sm-4">Order Start Time :</dt>
                        <dd class="col-sm-8">
                            @if($request['started_at'] != NULL)
                                {{ date('jS \of F Y h:i:s A', strtotime($request->created_at)) }} 
                            @else
                                - 
                            @endif
                         </dd>
                         
                        <dt class="col-sm-4">Order End Time :</dt>
                        <dd class="col-sm-8">
                            @if($request['finished_at'] != NULL) 
                                {{ date('jS \of F Y h:i:s A', strtotime($request->finished_at)) }}
                            @else
                                - 
                            @endif
                        </dd>
                        
                        @endif --}}

                        <dt class="col-sm-4">Pickup Address :</dt>
                        <dd class="col-sm-8">{{ $request['s_address'] ? $request->s_address : '-' }}</dd>
                        
                        <dt class="col-sm-4">Delivery Address :</dt>
                        <dd class="col-sm-8">{{ $request['d_address'] ? $request->d_address : '-' }}</dd>
                        
                        <dt class="col-sm-4">Total Distance :</dt>
                        <dd class="col-sm-8">{{ @$request['distance'] ? round($request->distance) : '-' }} KM</dd>
                        
                        <dt class="col-sm-4">Distance Price :</dt>
                        <dd class="col-sm-8">{{ currency(@$request['amount_customer']) }}</dd>
                        
                        <dt class="col-sm-4">Delivery Type :</dt>
                        <dd class="col-sm-8">{{ @$request['service_type']['name'] }}</dd>
                        
                        {{-- <dt class="col-sm-4">{{@$request['service_type']['name']}} Name :</dt>
                        <dd class="col-sm-8">{{ @$request['item']['name'] }}</dd>
                        
                        <dt class="col-sm-4">{{@$request['service_type']['name']}} Quantity :</dt>
                        <dd class="col-sm-8">{{ @$request['item']['qty'] }}</dd> --}}
                        
                        @if($request['item']['special_notes'])
                        <dt class="col-sm-4">Special Notes :</dt>
                        <dd class="col-sm-8">{{ $request['item']['special_notes'] }}</dd>
                        
                        @endif
                        {{-- <dt class="col-sm-4">{{$request['service_type']['name']}} Weight :</dt>
                        <dd class="col-sm-8">{{ $request['item']['weight'] }}</dd>
                        
                        <dt class="col-sm-4">{{$request['service_type']['name']}} Height :</dt>
                        <dd class="col-sm-8">{{ $request['item']['height'] }}</dd>
                        
                        <dt class="col-sm-4">{{$request['service_type']['name']}} Width :</dt>
                        <dd class="col-sm-8">{{ $request['item']['width'] }}</dd> --}}
                        
                        @if($request['item']['rec_name'])
                        <dt class="col-sm-4">Receiver Name :</dt>
                        <dd class="col-sm-8">{{ $request['item']['rec_name'] }}</dd>
                        
                        @endif
                        @if($request['item']['rec_email'])
                        <dt class="col-sm-4">Receiver Email :</dt>
                        <dd class="col-sm-8">{{ $request['item']['rec_email'] }}</dd>
                        
                        @endif
                        @if($request['item']['rec_mobile'])
                        <dt class="col-sm-4">Receiver Mobile :</dt>
                        <dd class="col-sm-8">{{ $request['item']['rec_mobile'] }}</dd>
                       
                        @endif
                        @if($request['item']['rec_address'])
                        <dt class="col-sm-4">Receiver Address :</dt>
                        <dd class="col-sm-8">{{ $request['item']['rec_address'] }}</dd>
                        
                        @endif
                        @if($request->payment)
                        <dt class="col-sm-4">Base Price :</dt>
                        <dd class="col-sm-8">{{ currency($request['payment']['fixed']) }}</dd>
                       
                        <dt class="col-sm-4">Tax Price :</dt>
                        <dd class="col-sm-8">{{ currency($request['payment']['tax']) }}</dd>
                        
                        <dt class="col-sm-4">Total Amount :</dt>
                        <dd class="col-sm-8">{{ currency($request['payment']['total']) }}</dd>                        
                        
                        @endif

                        <dt class="col-sm-4">Order Status : </dt>
                        <dd class="col-sm-8">
                            {{ $request['status'] }}
                        </dd>
                        @if(!empty($promocode['promocode']))
                        <dt class="col-sm-12"></dt>
                        <dt class="col-sm-12"><h4>Promocode </h4></dt>
                        
                        
                        <dt class="col-sm-4">Promo Code : </dt>
                        <dd class="col-sm-8">
                            {{$promocode['promocode']['promo_code']}}
                        </dd>
                        <dt class="col-sm-4">Discount : </dt>
                        <dd class="col-sm-8">
                            {{$promocode['promocode']['discount']}}
                        </dd>
                        <dt class="col-sm-4">Applied Date :</dt>
                        <dd class="col-sm-8">
                            @if($promocode['created_at'] != "0000-00-00 00:00:00") 
                                {{ date('jS \of F Y h:i:s A', strtotime($promocode->created_at)) }}
                            @else
                                - 
                            @endif
                        </dd>
                        @endif
   
                    </dl>
                    
                    
                    <br><br>
                    <!-- Admin Comment Section -->
                    <div class="row">
                        <div class="col-lg-12" style="overflow-y:auto;"> <b><i style="font-weight:bold; font-size:14px;">Comments:</i></b> </div>
                        
                        {{-- <!-- @foreach($comments as $comment)
                            <div class="col-lg-12">
                                {{$comment->authorised_type}}: {{ $comment->comments }}
                            </div>
                        @endforeach --> --}}
                        @foreach($comments as $comment)
                            <div class="col-lg-12" style="margin:5px 0px;">
                                <div class="col-lg-12" style="background-color: #F5F5F5; padding:8px;">
                                    <div style="display:flex; flex:1; justify-content:space-between;">
                                        <div> <b>{{$comment->authorised_type}}</b> </div>
                                        <!-- <div>{{$comment->created_at}}</div> -->
                                        <div> {{ $comment->created_at->diffForHumans() }} </div>
                                        <!-- <b> </b>
                                        <b></b> -->
                                    </div>
                                    <div style="padding-top:7px;">
                                        - {{ $comment->comments }}
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- <div class="col-lg-12"> -->
                        {{-- <!-- <form method="POST" action="{{ url('dispatcher/comments/'.$request->booking_id) }}"> --> --}}
                        <form method="POST" action="{{ url('dispatcher/comments/'.$request->id) }}">
                            {{ csrf_field() }}
                            <div class="col-lg-10">
                                <input type="text" name="dispatcher_comment" id="dispatcher_comment" class="form-control" placeholder="Add Your Comment ...">
                            </div>
                            <div class="col-lg-2">
                                <button type="submit" class="btn btn-primary form-control">Post</button>
                            </div>
                        </form>
                        <!-- </div> -->

                        
                    </div> <!-- End of Comment Section -->
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style type="text/css">
    #map {
        height: 550px;
    }
</style>
@endsection

@section('scripts')
<script type="text/javascript">
    var map;
    var zoomLevel = 11;

    function initMap() {

        map = new google.maps.Map(document.getElementById('map'));
        var base_url =  window.location.origin;
        var simage = base_url+'/mycourier/asset/front/img/source.png';
        var dimage = base_url+'/mycourier/asset/front/img/destination.png';
        var marker = new google.maps.Marker({
            map: map,
            icon: simage,
            anchorPoint: new google.maps.Point(0, -29)
        });

         var markerSecond = new google.maps.Marker({
            map: map,
            icon: dimage,
            anchorPoint: new google.maps.Point(0, -29)
        });

        var bounds = new google.maps.LatLngBounds();

        source = new google.maps.LatLng({{ $request->s_latitude }}, {{ $request->s_longitude }});
        destination = new google.maps.LatLng({{ $request->d_latitude }}, {{ $request->d_longitude }});

        marker.setPosition(source);
        markerSecond.setPosition(destination);

        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true, preserveViewport: true});
        directionsDisplay.setMap(map);

        directionsService.route({
            origin: source,
            destination: destination,
            travelMode: google.maps.TravelMode.DRIVING
        }, function(result, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                console.log(result);
                directionsDisplay.setDirections(result);

                marker.setPosition(result.routes[0].legs[0].start_location);
                markerSecond.setPosition(result.routes[0].legs[0].end_location);
            }
        });

        @if($request->provider && $request->status != 'COMPLETED')
        var markerProvider = new google.maps.Marker({
            map: map,
            icon: "/asset/img/marker-car.png",
            anchorPoint: new google.maps.Point(0, -29)
        });

        provider = new google.maps.LatLng({{ $request->provider->latitude }}, {{ $request->provider->longitude }});
        markerProvider.setVisible(true);
        markerProvider.setPosition(provider);
        console.log('Provider Bounds', markerProvider.getPosition());
        bounds.extend(markerProvider.getPosition());
        @endif

        bounds.extend(marker.getPosition());
        bounds.extend(markerSecond.getPosition());
        map.fitBounds(bounds);
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places&callback=initMap" async defer></script>
@endsection