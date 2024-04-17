
@extends('account.layout.master')

@section('title', 'Order details ')
@section('styles')
    <link rel="stylesheet" href="{{ asset('main/vendor/jvectormap/jquery-jvectormap-2.0.3.css') }}">
    <link href="{{ asset('asset/user/plugins/bootstrap-rating/bootstrap-rating.css') }}" rel="stylesheet" type="text/css">

    <style>
        .content__card {
            border: 1px solid #000;
            margin-top: 2rem;
        }

        .content__heading {
            text-transform: uppercase;
        }

        .track {
            position: relative;
            background-color: #ddd;
            height: 7px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            margin-bottom: 75px;
            margin-top: 50px
        }

        .track .step {
            -webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
            width: 25%;
            margin-top: -18px;
            text-align: center;
            position: relative
        }

        .track .step.active:before {
            background: #FF5722
        }

        .track .step::before {
            height: 7px;
            position: absolute;
            content: "";
            width: 100%;
            left: 0;
            top: 18px
        }

        .track .step.active .icon {
            background: #ee5435;
            color: #fff
        }

        .track .icon {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            position: relative;
            border-radius: 100%;
            background: #ddd
        }

        .track .step.active .text {
            font-weight: 400;
            color: #000
        }

        .track .text {
            display: block;
            margin-top: 7px
        }

        .card__comment .comment-date {
            font-size: 0.825rem !important;
        }

        .card__comment .comment__desc {
            text-transform: capitalize;

        }

        .card__comment__header {
            text-transform: uppercase;
            text-align: center;
        }

        .card__comment__form {
            display: flex;
        }

        .card__comment__form input {
            border-radius: 0;
        }

        .card__comment__form .btn {
            border-radius: 0;
            text-transform: uppercase;
            padding: 0.5rem 2rem;
            border: 1px solid white;
            background: #000;
            color: #fff;

            transition: all 0.5s ease-in-out;
        }

        .card__comment__form .btn:hover {
            background: #000;
            color: #fff;
            background: #fff;
            color: #000;
        }


        .cd-timeline-content {
            border: 1px solid lightgrey;
        }

    </style>
@endsection


@section('content')
  <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Order Detail</h4>
                    </div>
                    {{-- @if ($request->status == 'COMPLETED')
                        <div class="col-md-4">
                            <div class="float-right">
                                <div class="btn btn-primary" type="button" id="exchangeOrder">
                                    <i class="ti-plus mr-1"></i> Exchange Order
                                </div>

                            </div>
                        </div>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
     <div class="card">
        <div class="card-body">
            <div class='d-flex justify-content-between'>
                <h6>Booking ID: <span class='lead'> {{ $request->booking_id }}</span></h6>
                <h6>{{ $request->created_at->diffForHumans() }}</h6>
            </div>
            <article class="card content__card">

                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-4">
                            <h6 class="content__heading">Receiver Name:</h6>
                            @if ($request->item->rec_name)
                                <div class="content__desc">{{ $request->item->rec_name }}
                                </div>
                            @else
                                -
                            @endif
                        </div>
                        <div class="col-md-4">
                            <h6 class="content__heading">Receiver Location:</h6>
                            <div class="content__desc">
                                {{ $request->d_address }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h6 class="content__heading">Receiver Number:</h6>
                            <div class="content__desc">
                                {{ $request->item['rec_mobile'] }}
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-4">
                            <h6 class="content__heading">COD Amount</h6>
                            <div class="content__desc">

                                @if ($request->cod)

                                    {{ currency($request->cod) }}
                                @else
                                    -
                                @endif
                            </div>


                        </div>
                        <div class="col-md-4">
                            <h6 class="content__heading">Fare</h6>
                            <div class="content__desc">
                                @if ($request->amount_customer)

                                    {{ currency($request->amount_customer) }}
                                @else
                                    -
                                @endif
                            </div>


                        </div>
                        <div class="col-md-4">
                            <h6 class="content__heading">Status:</h6>
                            <div class="content_desc">
                                {{ $request->returned == 1 ? 'RETURNED' : $request->status }}
                            </div>
                        </div>
                    </div>
                    <hr>

                </div>
                @if (($request->status == 'ASSIGNED' || $request->status == 'DELIVERING' || $request->status == 'SCHEDULED') && $request->provider)
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <h6 class="content__heading">Rider Name</h6>
                            <div class="content__desc">
                                {{ $request->provider->first_name ? $request->provider->first_name : '' }}
                            </div>


                        </div>
                        <div class="col-md-4">
                            <h6 class="content__heading">Rider Number</h6>
                            <div class="content__desc">
                                {{ $request->provider->mobile ? $request->provider->mobile : '' }}
                            </div>


                        </div>
                    </div>
                @endif

            </article>

            <div class="track">
                <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span
                        class="text">Order
                        confirmed</span> </div>
                <div class="step" id='second'>
                    <span class="icon"> <i class="fa fa-user"></i> </span> <span class="text">
                        Picked up
                        by Hulagi</span>
                </div>
                <div class="step " id='third'>
                    <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text"> On
                        the
                        way
                    </span>
                </div>
                <div class="step" id='fourth'>
                    <span class="icon"> <i class="fa fa-box"></i> </span> <span
                        class="text">Delivery Completed</span>
                </div>
                @if (($request->status == 'REJECTED' || $request->status == 'CANCELLED') && $request->returned_to_hub == 0)
                    <div class="step" id="fifth">
                        <span class="icon"> <i class="fa fa-box"></i> </span> <span
                            class="text">Returned to vendor</span>
                    </div>
                @endif
            </div>
           
        </div>

        <div class="card" style="box-shadow:none">
            <div class="card-header"></div>
            <div class="card-body">
                <h5>Order Log</h3>
                    <hr>
                    @foreach ($logs as $log)

                        <li> {{ @$log->description }} -- {{ $log->created_at }}</li>

                    @endforeach
            </div>
        </div>


        <div class="card card__comment">
            <div class="card-header">
                {{-- <h5 class="card__comment__header">View your comments here</h5> --}}

                {{-- <form method="POST" action="{{ url('comment/' . $request->id) }}" class='card__comment__form'>
                {{ csrf_field() }}

                <input class="form-control mr-2" type="text" name="user_comment" id="user_comment"
                    placeholder="Add Your Comment ...">
                <button type="submit" class="btn">Post</button>
            </form> --}}

            </div>


            <div class="card-body pt-0 pr-0 pb-0">

                <div class="row">
                    <div class="col-md-6 pl-0 d-none d-sm-block">
                        <?php
                        
                        $smap_icon = asset('asset/front/img/source.png');
                        $dmap_icon = asset('asset/front/img/destination.png');
                        
                        $static_map = 'https://maps.googleapis.com/maps/api/staticmap?autoscale=1&size=600x450&maptype=terrain&format=png&visual_refresh=true&markers=icon:' . $smap_icon . '%7C' . $request->s_latitude . ',' . $request->s_longitude . '&markers=icon:' . $dmap_icon . '%7C' . $request->d_latitude . ',' . $request->d_longitude . '&path=color:0x191919|weight:8|enc:' . $request->route_key . '&key=' . env('GOOGLE_MAP_KEY'); ?>

                        <img src="{{ $static_map }}" class='img-fluid'>
                    </div>
                    <div class="col-md-6 ">

                        <div class="comment__container">
                            <h5 class="py-4">Comments</h5>
                            @if ($request->special_note)
                                <div class="cd-timeline-block m-5">
                                    <div class="cd-timeline-content p-3 w-100">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="text-center">
                                                    <div>
                                                        <i class="mdi mdi-account h2"></i>
                                                    </div>
                                                    <div class="cd-date comment-date mb-4">
                                                        {{ $request->created_at->diffForHumans() }}</div>

                                                </div>
                                            </div>
                                            <div class="col-lg-9">
                                                <div>
                                                    <h3>

                                                        {{ Auth::user()->first_name }}


                                                    </h3>
                                                    <p class="mb-0 comment__desc text-muted">
                                                        {{ $request->special_note ? $request->special_note : '' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @foreach ($comments as $comment)

                                <div class="cd-timeline-block m-5">
                                    <div class="cd-timeline-content p-3 w-100">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="text-center">
                                                    <div>
                                                        <i class="mdi mdi-account h2"></i>
                                                    </div>
                                                    <div class="cd-date comment-date mb-4">
                                                        {{ $comment->created_at->diffForHumans() }}</div>

                                                </div>
                                            </div>
                                            <div class="col-lg-9">
                                                <div>
                                                    <h3>
                                                        @if (@$comment->dept_id !== 0)
                                                            @if (@$comment->dept->dept == 'Dispatcher')
                                                                <div><b> Branch - {{ @$comment->zone }} </b></div>
                                                            @else
                                                                <div><b> {{ @$comment->dept->dept }} </b></div>
                                                            @endif
                                                        @elseif($comment->dept_id==0 && $comment->is_read_user==0)
                                                            <div><b> User </b></div>
                                                        @else
                                                            <div><b> {{ @$comment->authorised_type }} </b></div>
                                                        @endif

                                                        <!-- @if ($comment->dept_id == 0 && $comment->is_read_user == 0)
                                                                                                                            {{ Auth::user()->first_name }}
                                                        @elseif(@$comment->dept_id == 0)
                                                                                                                            @if (@$comment->dept->dept == 'Dispatcher')
                                                                                                                                Branch -
                                                                                                                                {{ @$comment->zone }}

                                                            @else
                                                                                                                                {{ @$comment->dept->dept }}

                                                                                                                            @endif
                                                        @else
                                                                                                                            {{ @$comment->authorised_type }}
                                                                                                                        @endif

                                                                                                                        {{-- @if (@$comment->dept_id == 0)
                                                    @if (@$comment->dept->dept == 'Dispatcher')
                                                        Branch -
                                                        {{ @$comment->zone }}

                                                    @else
                                                        {{ @$comment->dept->dept }}

                                                    @endif
                                                @elseif($comment->dept_id==0 &&
                                                    $comment->is_read_user==0)
                                                    {{ Auth::user()->first_name }}
                                                @else
                                                    {{ @$comment->authorised_type }}

                                                @endif --}} -->

                                                    </h3>
                                                    <p class="mb-0 comment__desc text-muted">{{ $comment->comments }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="m-4">
                                <form method="POST" action="{{ url('account/comments/' . $request->id) }}" class='d-flex'>
                                    {{ csrf_field() }}

                                    <input class='form-control' name="comment" id="comment"
                                        placeholder="Add Your Comment ..." required>

                                    <button type="submit" class="btn btn-outline-dark mx-4 text-uppercase">Post</button>

                                </form>
                            </div>
                        </div>

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
  <script src="{{ asset('asset/user/plugins/bootstrap-rating/bootstrap-rating.min.js') }}"></script>
    <script>
        $(function() {
           
            $('.rating').each(function() {
                $('<span class="badge badge-info"></span>')
                    .text($(this).val() || '')
                    .insertAfter(this);
            });
            $('.rating').on('change', function() {
                $(this).next('.badge').text($(this).val());
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            const request = <?php echo json_encode($request->status); ?>;
            const returned = <?php echo $request->returned; ?>;

            if (request === 'PICKEDUP' || request === 'SORTCENTER') {
                $('#second').addClass('active');
                // console.log(request);
            } else if (returned === 1) {
                $('#second').addClass('active');
                $('#third').addClass('active');
                $('#fourth').addClass('active');
                $('#fifth').addClass('active');
            } else if (request === 'COMPLETED' || request === 'REJECTED' || request === 'CANCELLED') {
                $('#second').addClass('active');
                $('#third').addClass('active');
                $('#fourth').addClass('active');
            } else if (request === 'ASSIGNED' || request === 'DELIVERING' || request === 'SCHEDULED' || request ===
                'DISPATCHED') {
                $('#second').addClass('active');
                $('#third').addClass('active');
            }
        });
    </script>
    <script>
        $("#exchangeOrder").click(function() {
            console.log("exchange clicked");

        });
    </script>
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