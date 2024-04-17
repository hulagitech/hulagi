@extends('dispatcher.layout.master')

@section('title', 'Recent Trips ')


@section('content')
{{-- CSS and JS for tagsinput and typeahead --}}
<link rel="stylesheet" type="text/css" href="{{asset('asset/front/css/bootstrap-tagsinput.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('asset/front/css/typeaheadjs.css')}}">
  @include('common.notify')
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="row align-items-center">
				<div class="col-md-4">
					<h4 class="page-title m-0">Return Order</h4>
				</div>
				<div class="col-md-8 d-flex justify-content-end">
				</div>
			</div>
		</div>
	</div>
</div>
	@if(session()->has('message'))
			<div class="alert alert-success">
				{{ session()->get('message') }}
			</div>
		@endif
   	<div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-box bg-white">
					@if(count($requests)>0)
                    <div class="row align-items-center">
                        <div class="col-md-1"></div>
                        <h2 class="col-md-4">{{ date('d M Y') }}</h2>
                        <h2 class="col-md-4">Return Order</h1>
                            <h3 class="col-md-2"><span id="dispatchCount">0</span>/{{$requests->count()}}</h3>
                            <div class="col-md-1"></div>
                    </div>
                   	<form id="dispatchForm" method="POST" action="{{url('dispatcher/dispatchList/return')}}" method="POST"
                        class="px-2">
                        {{ csrf_field() }}
                        <label>Orders</label>
                        <div class="form-group row">
                            <div class="col-10">
                                <input class="form-control form-control-lg typeahead" type="text"
                                    style="background-color:none;" value="{{ old('data') }}"
                                    placeholder="Type in booking id" name="data" required id="data" autofocus>
                            </div>
                            <div class="col-2">
                               <select class="form-control" name="dispatcher">
									@foreach ($dispatchers as $d)
										<option value="{{$d->id}}">{{$d->name}}</option>
									@endforeach
								</select>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success" id="btn1">Dispatch Return</button>
						<input type="hidden" name="btn1" id="btn1value"/>
						<button type="button" class="btn btn-warning" id="btn2">Save in Draft</button>
						<input type="hidden" name="btn2" id="btn2value"/>
                </div>
                </form>
				@else
						No Orders for the dispatcher to Return
					@endif
            </div>

        </div>

    </div>

		
		<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		
		<script>
			$('#btn1,#btn2').click(function(){
				var id=$(this).attr('id');
				if(id=="btn1"){
					$('#btn1value').val('1');
					$('#btn2value').val('0');
				}
				else{
					$('#btn2value').val('1');
					$('#btn1value').val('0');
				}
				$('#dispatchForm').submit();
			})
			var id=[];
			var index=0;
			$('.dispatch').on("change",function(){
				// if($(this).attr('checked'))
				if($(this).is(':checked')){
					id[index]=$(this).attr('id');
					index++;
					// console.log(id);
				}
				else{
					var remove=id.indexOf($(this).attr('id'));
					if(remove>-1){
						id.splice(remove,1);
						// console.log(id);
						index--;
					}
				}
			})
		</script>

		<script type="text/javascript" src="{{asset('asset/front/js/typeahead.min.js')}}"></script>
		<script type="text/javascript" src="{{asset('asset/front/js/bootstrap-tagsinput.js')}}"></script>
		<script>
			var zones = new Bloodhound({
				datumTokenizer: Bloodhound.tokenizers.whitespace,
				queryTokenizer: Bloodhound.tokenizers.whitespace,
				// url points to a json file that contains an array of country names, see
				// https://github.com/twitter/typeahead.js/blob/gh-pages/data/countries.json
				prefetch: {
					url: "{{url('/dispatcher/dispatchOrdersrReturn')}}",
					cache: false
				},
			});
			zones.initialize();
			$('.typeahead').tagsinput({
			typeaheadjs: {
				name: 'zones',
				source: zones.ttAdapter()
			}
			});
			$('.typeahead').change(function(){
				$("#dispatchCount").text($('.typeahead').val().split(",").length);
			});
			$('#submit').click(function(){
				console.log($('.typeahead').val());
			});
		</script>

	</div>

</div>

    

    @include('dispatcher.layout.partials.booking')

    

    @endsection

@section('scripts')
<script type="text/javascript">
    window.mylift = {!! json_encode([
    	"minDate" => \Carbon\Carbon::today()->format('Y-m-d\TH:i'),
    	"maxDate" => \Carbon\Carbon::today()->addDays(30)->format('Y-m-d\TH:i'),
    	"map" => false,
    ]) !!}
    
    var base_url	 =	'{{ url("/") }}';
   
    var zones  = <?php echo json_encode( $all_zones ); ?>;
    var services = {!!  json_encode($services) !!};
    var mapIcons = {
    //user: '{{ asset("asset/img/marker-user.png") }}',
    	active: '{{ asset("asset/front/img/source.png") }}',
    	riding: '{{ asset("asset/front/img/source.png") }}',
    	//offline: '{{ asset("asset/front/img/car-offline.png") }}',
    	//unactivated: '{{ asset("asset/front/img/car-unactivated.png") }}'
    };
	var current_lat = 27.7172;
    var current_long = 85.3240;
    <?php if( $ip_details ) { ?>
    	var current_lat  =	"<?php echo $ip_details->geoplugin_latitude; ?>";
    	var current_long =	"<?php echo $ip_details->geoplugin_longitude; ?>";
    <?php } ?>
    $(document).ready(function () {
            getUpdateFilterData('');
    });
</script>

 

<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY_WEB') }}&libraries=places,geometry&callback=initMap" async defer></script>
<script type="text/javascript" src="{{ asset('asset/front/js/dispatcher-map.js') }}"></script>
<!--script type="text/babel" src="{{ asset('asset/front/js/dispatcher.js') }}"></script-->

@endsection



@section('styles')
    <style type="text/css">
        .dispatcher-nav li span {
            /* // background-color: transparent; */
            color: #000!important;
            padding: 5px 12px;
        }
        .dispatcher-nav li span:hover,
        .dispatcher-nav li span:focus,
        .dispatcher-nav li span:active {
            background-color: #20b9ae;
            color: #fff!important;
            padding: 5px 12px;
        }
        .dispatcher-nav li.active span,
        .dispatcher-nav li span:hover,
        .dispatcher-nav li span:focus,
        .dispatcher-nav li span:active {
            background-color: #20b9ae;
            color: #fff!important;
            padding: 5px 12px;
        }
    </style>
@endsection