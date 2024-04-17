@extends('admin.layout.base')
@section('title', 'Add Zone ')
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    </head>
    <style>
        html,
        body {
            padding: 0;
            margin: 0;
            width: 100%;
            height: 100%;
        }

        #map {
            padding: 0;
            margin: 0;
            width: 100%;
            height: 80%;
        }

        #submit_zone_btn {
            background-color: #b01d23;
            color: #fff !important;
            font-weight: bold;
        }

        .intr {
            color: red;
            font-style: italic;
        }

        #panel {
            width: 200px;
            font-family: Arial, sans-serif;
            font-size: 13px;
            float: right;
            margin: 10px;
        }

        #color-palette {
            clear: both;
            display: none;
        }

        .color-button {
            width: 14px;
            height: 14px;
            font-size: 0;
            margin: 2px;
            float: left;
            cursor: pointer;
        }

        #delete-button {
            margin-top: 5px;
            display: none;
        }

        .gmnoprint>div:nth-child(4),
        .gmnoprint>div:nth-child(5) {
            display: none !important;
        }

    </style>

    <body>

        <div class="content-area py-1" style="">
            <div class="container-fluid">
            @section('content')

                <div class='box' style="background: #fff;">
                    <h5 style='padding: 10px;margin-bottom: -15px;'><span class="s-icon"><i
                                class="ti-zoom-in"></i></span>&nbsp; Add Location</h5>
                    <hr>
                    {{-- <input id="pac-input" class="form-control" type="text" placeholder="Enter Location" style="top:5px!important;width:50%;"> --}}

                    <div id="panel">
                        <div id="color-palette"></div>
                        <div>
                            <button id="delete-button">Delete Selected Shape</button>
                        </div>
                    </div>
                    <div id="map"></div>

                </div>
            </div>
        </div>


    @endsection

    @section('scripts')
        <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCX6R-_OJ0vIApCQ-mFjVzd5Xn9h-xmlrI&libraries=geometry,places,drawing&callback=initialize&ext=.js"></script> -->
        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=geometry,places,drawing&callback=initMap&ext=.js">
        </script>
        <script type="text/javascript">
        
            var locations = [
                @foreach ($totalrequest as $location)
                    [ {{$location->user_id}},{{ $location->s_latitude }}, {{ $location->s_longitude }}, "{{@$location->s_address}}", "{{@$location->user->first_name}} {{@$location->user->last_name}}","{{@$location->user->mobile}}"],
                @endforeach
            ];
            function initMap() {
                const map = new google.maps.Map(document.getElementById("map"), {
                    center: new google.maps.LatLng(27.6932302, 85.2770152),
                    zoom: 12,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });
                var infowindow = new google.maps.InfoWindow();

                var i;
                for (i = 0; i < locations.length; i++) {
                    const marker = new google.maps.Marker({
                        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                        map: map,
                    });
                    
                    console.log(locations);
                    google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {
                            var cont="<h3>"+locations[i][4]+"</h3>"+"<p>"+locations[i][3]+"</p>"+"<p>"+locations[i][5]+"</p>";
                            infowindow.setContent(cont);
                            infowindow.open(map, marker);
                        }
                    })(marker, i));
                }


            }

        </script>
    @endsection
