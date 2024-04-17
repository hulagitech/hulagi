@extends('dispatcher.layout.base')



@section('title', 'Recent Trips ')



@section('content')

<div class="content-area py-1" id="dispatcher-panel">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<h4 style="text-transform:uppercase;">Out Going</h4>
			</div>
		</div> 

		<div class="row">
			<div class="col-md-12">
				 <nav class="navbar navbar-light bg-white b-a mb-2">
					<button class="navbar-toggler hidden-md-up" data-toggle="collapse" data-target="#process-filters" aria-controls="process-filters" aria-expanded="false" aria-label="Toggle Navigation"></button>



					<div class="collapse navbar-toggleable-sm" id="process-filters">
						<ul class="nav navbar-nav dispatcher-nav">
							<li class="nav-item dispatcher-tab active">
								<a href={{route("dispatcher.dispatchList.index")}}><span class="nav-link dispatcher-link">New Dispatch</span></a>
							</li>

							<li class="nav-item dispatcher-tab">

								<a href={{route("dispatcher.dispatchList.myDispatch")}}><span class="nav-link dispatcher-link">My Dispatch</span></a>

							</li>

							<li class="nav-item dispatcher-tab">

								<a href={{route("dispatcher.dispatchList.pending")}}><span class="nav-link dispatcher-link">Pending Receive</span></a>

							</li>

							

						</ul>

					</div>

				</nav>

			</div>

		</div>
		<div class="content-area py-1">
			<div class="container-fluid">
				<div class="box box-block bg-white">
					<h5 class="mb-1"> <i class="fa fa-recycle"></i> Order History</h5>
					<hr/>
		
					@if(isset($dates))
						<form class="form-inline pull-right" method="POST" action={{url('admin/dateSearch')}}>
							{{csrf_field()}}
							<div class="form-group">
								<input type="text" class="form-control" name="searchField" placeholder="Full Search">
							</div>
							<div class="form-group">
								<select class="form-control" name="date">
									<option>All</option>
								@foreach ($dates as $date)
									<option {{(isset($current) && $current['date']==$date)? "selected": ""}} value={{$date}}>{{$date}}</option>
								@endforeach
								</select>
							</div>
							<div class="form-group">
								<select class="form-control" name="status">
									<option {{(isset($current) && $current['status']=="All")? "selected": ""}}>All</option>
									<option {{(isset($current) && $current['status']=="PENDING")? "selected": ""}}>PENDING</option>
									<option {{(isset($current) && $current['status']=="SCHEDULED")? "selected": ""}}>SCHEDULED</option>
									<option {{(isset($current) && $current['status']=="COMPLETED")? "selected": ""}}>COMPLETED</option>
									<option {{(isset($current) && $current['status']=="REJECTED")? "selected": ""}}>REJECTED</option>
								</select>
							</div>
							<div class="form-group">
								<button name="search" class="btn btn-success">Search</button>
							</div>
						</form>
					@endif
		
					@if(count($requests) != 0)
					<table class="table table-striped table-bordered dataTable" id="table-2" style="width:100%;">
						<thead>
							<tr>
								<th>Date</th>
								<th>ID</th>
								<th>Last Update</th>
								<th>User</th>
								<th>Pickup Add.</th>
								<th>Pickup Number</th>
								<th>DropOff Add.</th>
								<th>DropOff Name</th>
								<th>DropOff Number</th>
								<th>Vendor Remarks</th>
								<th>Dispatch</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
					   <script> var req_id=[];</script>
						@foreach($requests as $index => $request)
							<tr id="dataRow{{$index}}">
								<td>
									@if($request->created_at)
										<span class="text-muted">{{$request->created_at}}</span>
									@else
										-
									@endif
								</td>
								<td>{{ $request->booking_id }}</td>
								<td>
									@if($request->updated_at)
										<span class="text-muted">{{$request->updated_at}}</span>
									@else
										-
									@endif
								</td>
								<td>
									@if(@$request->user)
										{{ @$request->user->first_name }} 
									@else
										N/A
									@endif
								</td>
								<td>
									@if($request->s_address)
										{{ @$request->s_address }} 
									@else
										N/A
									@endif
								</td>
								<td>
									@if(@$request->user->mobile)
										{{ @$request->user->mobile }} 
									@else
										N/A
									@endif
								</td>
								<td>
									@if($request->d_address)
										{{ @$request->d_address }} 
									@else
										N/A
									@endif
								</td>
								 <td>
									@if(@$request->item->rec_name)
										{{ @$request->item->rec_name}} 
									@else
										N/A
									@endif
								</td>
								<td>
									@if(@$request->item->rec_mobile)
										{{ @$request->item->rec_mobile }} 
									@else
										N/A
									@endif
								</td>
								<td>
									@if($request->special_note)
										{{ @$request->special_note}} 
									@else
										N/A
									@endif
								</td>
								<td>
									<input type="checkbox" class="form-control dispatch" id="{{$request->id}}">
								</td>
								<td>
									<div class="btn-group" role="group">
										<button type="button" class="btn btn-secondary btn-rounded btn-black waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
											Action
										</button>
										<div class="dropdown-menu">
											{{-- <a href="{{ route('admin.requests.show', $request->id) }}" class="dropdown-item">
												<i class="fa fa-search"></i> More Details
											</a> --}}
											{{--<a href="{{ route('admin.requests.edit', $request->id) }}" class="dropdown-item">
											<i class="fa fa-pencil"></i>  Edit
											</a>--}}
											{{--<form action="{{ route('admin.requests.destroy', $request->id) }}" method="POST">
												{{ csrf_field() }}
												{{ method_field('DELETE') }}
												<button type="submit" class="dropdown-item">
													<i class="fa fa-trash"></i> Delete
												</button>
											</form>--}}
										</div>
									</div>
								</td>
							</tr>
						@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>Date</th>
								<th>ID</th>
								<th>Last Update</th>
								<th>User</th>
								<th>Pickup Add.</th>
								<th>Pickup Number</th>
								<th>DropOff Add.</th>
								<th>DropOff Name</th>
								<th>DropOff Number</th>
								<th>Vendor Remarks</th>
								<th>Dispatch</th>
								<th>Action</th>
							</tr>
						</tfoot>
					</table>
					<button class="btn btn-primary dispatch-button">Dispatch</button>
					@else
					<h6 class="no-result">No results found</h6>
					@endif 
				</div>
			</div>
		</div>
		
		<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<script>
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
			$('.dispatch-button').click(function(){
				if(id.length<=0){
					return;
				}
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
				$.ajax({
					url: "{{url('admin/zonedispatch')}}",
					type: 'post',
					data: {id:id},
					success:function(response){
						console.log(response); 
						if(response.showError){
							location.reload();
							// alert(response.error);
						}
					},
					error: function (request, error) {
						console.log(request);
						alert("Error"+error);
					}
				});
			})
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

	.pac-container {

        z-index: 10000 !important;

    }

	

	.items-list .media {

		position: relative;

		height: 250px;

	}

	

	div#logs {

		background-color: #000;

		color: #fff;

		padding: 1em;

		font-weight: bold;

		font-size: 14px;

	}



	ul.log_ul li {

		padding: 10px 0;

		border-bottom: 1px solid gray;

	}

	

	.has-error .form-control {

		border-color: red;

	}

	

	.help-block {

		font-weight: bold;

		color: red;

	}

	

	#create-ride  {

		padding: 0;

	}



	.items-list .il-item {

		padding:  0.8rem;

	}





	.create_ride_li_btn {

		position: absolute;

		bottom: 0;

		left: 0;

		z-index: 1;

	

	}

	

	

	.create_ride_li_btn .btn {

		margin-bottom: 10px;

	}



	

	#assign_manual-modal .form-group  {

		margin-bottom: 0.5rem;

	}

	

	#assign_manual-modal .form-group {

		font-weight: bold;

	}



	#assign_manual-modal  select, #assign_manual-modal  .control-label {

		text-transform: uppercase;

	}

	

	.user_detail ul {

		list-style: none;

		padding: 0;

		margin: 0;

	}



	

	.user_detail ul li {

		display: block;

		padding: 5px 20px;

		font-weight: bold;

		font-size: 14pX;

	}

	

	.user_detail ul li span:first-child {

		text-transform: uppercase;

	}





	#create-ride .card-title.text-uppercase {

		padding: 1.25rem;

		border-bottom: 1px solid whitesmoke;

	}



	.no_data {

		padding: 20px;

		text-align: center;

		font-weight: bold;

	}

	

	

    .my-card input{

        margin-bottom: 10px;

    }

    .my-card label.checkbox-inline{

        margin-top: 10px;

        margin-right: 5px;

        margin-bottom: 0;

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



    .dispatcher-nav li span {

        background-color: transparent;

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

	

</style>

@endsection