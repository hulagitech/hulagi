@extends('fulfillment.layout.base')

@section('title', 'Dashboard ')

@section('content')

<div class="content-area py-1">
	<div class="container-fluid">
		<div class="row row-md">
			<div class="col-lg-4 col-md-6 col-xs-12">
				<div class="box box-block bg-success mb-2 btn-secondary">
					<div class="t-content">
						<h5 class="text-uppercase mb-1">All Orders Today</h5>
						<h5 class="mb-1">{{$rides->count()}}</h5>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-xs-12">
				<div class="box box-block bg-primary mb-2 btn-secondary">
					<div class="t-content">
						<h5 class="text-uppercase mb-1">Pending Orders</h5>
						<h5 class="mb-1">{{$pending_rides}}</h5>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-xs-12">
				<div class="box box-block bg-warning mb-2 btn-secondary">
					<div class="t-content">
						<h5 class="text-uppercase mb-1">Completed Orders</h5>
						<h5 class="mb-1">{{$completed_rides}}</h5>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-xs-12">
				<div class="box box-block bg-warning mb-2 btn-secondary">
					<div class="t-content">
						<h5 class="text-uppercase mb-1">Pickedup Orders</h5>
						<h5 class="mb-1">{{$picked_rides}}</h5>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-xs-12">
				<div class="box box-block bg-success mb-2 btn-secondary">
					<div class="t-content">
						<h5 class="text-uppercase mb-1">Rejected Orders</h5>
						<h5 class="mb-1">{{$rejected_rides}}</h5>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-xs-12">
					<div class="box box-block bg-primary mb-2 btn-secondary">
						<div class="t-content">
							<h5 class="text-uppercase mb-1">Accepted Orders</h5>
							<h5 class="mb-1">{{$accepted_rides}}</h5>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')

	<script type="text/javascript">
		$(document).ready(function(){

		});
	</script>

@endsection