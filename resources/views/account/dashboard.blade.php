@extends('account.layout.master')

@section('title', 'Dashboard ')

@section('styles')
<link rel="stylesheet" href="{{asset('main/vendor/jvectormap/jquery-jvectormap-2.0.3.css')}}">
@endsection

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="row align-items-center">
				<div class="col-md-6">
					<h4 class="page-title m-0">Dashboard</h4>
				</div>
				<div class="d-flex justify-content-end col-6 ">
					<form class="form-inline" action="{{route('account.dashboard')}}">
						<label class="sr-only" for="inlineFormInputName2">From</label>
						<input type="date" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" name="from_date" value="{{ $_GET['from_date'] ?? '' }}">

						<label class="sr-only" for="inlineFormInputGroupUsername2">To</label>
						<div class="input-group mb-2 mr-sm-2">
							<div class="input-group-prepend">
							</div>
							<input type="date" class="form-control" id="inlineFormInputGroupUsername2" name="to_date" value="{{ $_GET['to_date'] ?? '' }}">
						</div>
						<button type="submit" class="btn btn-primary mb-2">Submit</button>
					</form>
				</div>
			</div>

		</div>
	</div>
</div>
<div class="row">
	<div class="col-xl-3 col-md-6">
		<div class="card bg-primary mini-stat text-white">
			<div class="p-3 mini-stat-desc">
				<div class="clearfix">
					<h6 class="text-uppercase mt-0 float-left text-white-50">Today Completed Orders</h6>
					<h4 class="mb-3 mt-0 float-right">{{ $completed_rides }}</h4>
				</div>
				<div>
					<span class="badge badge-light text-info"></span><span class="ml-2">
					</span>
				</div>

			</div>
			<div class="p-3">
				@php 
					$from_date = (isset($_GET['from_date']) ? 'from_date=' .$_GET['from_date'] : '');
					$to_date = (isset($_GET['to_date']) ? 'to_date=' .$_GET['to_date'] : '');
					if($from_date){
						$to_date = '&' .$to_date;
					}
					$extra_param = $from_date .$to_date;

				@endphp
				<div class="float-right">
					<a href="{{ route('account.completed.order', $extra_param) }}" class="text-white-50"><i class="mdi mdi-eye-outline h5"></i></a>
				</div>
				<p class="font-14 m-0"><a href="{{ route('account.completed.order', $extra_param) }}" style="color: white;">View More Details</a></p>
			</div>
		</div>
	</div>
	<div class="col-xl-3 col-md-6">
		<div class="card bg-info mini-stat text-white">
			<div class="p-3 mini-stat-desc">
				<div class="clearfix">
					<h6 class="text-uppercase mt-0 float-left text-white-50">Today Rejected Orders</h6>
					<h4 class="mb-3 mt-0 float-right">{{ $rejected_rides }}</h4>
				</div>
				<div>
					<span class="badge badge-light text-info"></span><span class="ml-2">
					</span>
				</div>

			</div>
			<div class="p-3">
				<div class="float-right">
					<a href="{{ route('account.rejected.order', $extra_param) }}" class="text-white-50"><i class="mdi mdi-eye-outline h5"></i></a>
				</div>
				<p class="font-14 m-0"><a href="{{ route('account.rejected.order', $extra_param) }}" style="color: white;">View More Details</a></p>
			</div>
		</div>
	</div>
	<div class="col-xl-3 col-md-6">
		<div class="card bg-pink mini-stat text-white">
			<div class="p-3 mini-stat-desc">
				<div class="clearfix">
					<h6 class="text-uppercase mt-0 float-left text-white-50">Today Payment</h6>
					<h4 class="mb-3 mt-0 float-right">{{currency(abs($payable))}}</h4>
				</div>
				<div>
					<span class="badge badge-light text-info"></span><span class="ml-2">
					</span>
				</div>

			</div>
			<div class="p-3">
				<div class="float-right">
					<a href="{{ route('account.today-history', $extra_param) }}" class="text-white-50"><i class="mdi mdi-eye-outline h5"></i></a>
				</div>
				<p class="font-14 m-0"><a href="{{ route('account.today-history', $extra_param) }}" style="color: white;">View More Details</a></p>
			</div>
		</div>
	</div>
	<div class="col-xl-3 col-md-6">
		<div class="card bg-success mini-stat text-white">
			<div class="p-3 mini-stat-desc">
				<div class="clearfix">
					<h6 class="text-uppercase mt-0 float-left text-white-50">Today Collection</h6>
					<h4 class="mb-3 mt-0 float-right">{{currency($collection)}}</h4>
				</div>
				<div>
					<span class="badge badge-light text-info"></span><span class="ml-2">
					</span>
				</div>

			</div>
			<div class="p-3">
				<div class="float-right">
					<a href="{{ route('account.today-rider-history', $extra_param) }}" class="text-white-50"><i class="mdi mdi-eye-outline h5"></i></a>
				</div>
				<p class="font-14 m-0"><a href="{{ route('account.today-rider-history', $extra_param) }}" style="color: white;">View More Details</a></p>
			</div>
		</div>
	</div>

</div>

@endsection

@section('scripts')
<script type="text/javascript" src="{{asset('main/vendor/jvectormap/jquery-jvectormap-2.0.3.min.js')}}"></script>
<script type="text/javascript" src="{{asset('main/vendor/jvectormap/jquery-jvectormap-world-mill.js')}}"></script>

<script type="text/javascript">
	$(document).ready(function(){

		        /* Vector Map */
		    $('#world').vectorMap({
		        zoomOnScroll: false,
		        map: 'world_mill',
		        markers: [
		        @foreach($rides as $ride)
		        	@if($ride->status != "CANCELLED")
		            {latLng: [{{$ride->s_latitude}}, {{$ride->s_longitude}}], name: '{{$ride->user->first_name}}'},
		            @endif
		        @endforeach

		        ],
		        normalizeFunction: 'polynomial',
		        backgroundColor: 'transparent',
		        regionsSelectable: true,
		        markersSelectable: true,
		        regionStyle: {
		            initial: {
		                fill: 'rgba(0,0,0,0.15)'
		            },
		            hover: {
		                fill: 'rgba(0,0,0,0.15)',
		            stroke: '#fff'
		            },
		        },
		        markerStyle: {
		            initial: {
		                fill: '#43b968',
		                stroke: '#fff'
		            },
		            hover: {
		                fill: '#3e70c9',
		                stroke: '#fff'
		            }
		        },
		        series: {
		            markers: [{
		                attribute: 'fill',
		                scale: ['#43b968','#a567e2', '#f44236'],
		                values: [200, 300, 600, 1000, 150, 250, 450, 500, 800, 900, 750, 650]
		            },{
		                attribute: 'r',
		                scale: [5, 15],
		                values: [200, 300, 600, 1000, 150, 250, 450, 500, 800, 900, 750, 650]
		            }]
		        }
		    });
		});
</script>

@endsection