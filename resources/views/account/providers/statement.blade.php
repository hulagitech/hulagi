

@extends('account.layout.master')

@section('title', $page)

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="row align-items-center">
				<div class="col-md-6">
					<h4 class="page-title m-0">{{$page}}</h4>
				</div>
				<div class="d-flex justify-content-end col-6">
					<form class="form-inline" action="{{route('account.ride.statement.range')}}" method="GET" enctype="multipart/form-data" role="form">
						<label class="sr-only" for="inlineFormInputName2">From</label>
						<input type="date" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" name="from_date">

						<label class="sr-only" for="inlineFormInputGroupUsername2">To</label>
						<div class="input-group mb-2 mr-sm-2">
							<div class="input-group-prepend">
							</div>
							<input type="date" class="form-control" id="inlineFormInputGroupUsername2" name="to_date">
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
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Total Rides</h6>
                        <h4 class="mb-3 mt-0 float-right">{{$rides->count()}} </h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-info"></span><span class="ml-2">
                            </span>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-info mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Total Payable</h6>
                        <h4 class="mb-3 mt-0 float-right">-</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-danger"></span><span class="ml-2"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-pink mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Total Earning</h6>
                        <h4 class="mb-3 mt-0 float-right">-</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-primary"></span> <span class="ml-2">
                             </span>
                    </div>
                </div>
                
            </div>
    	</div>
</div>
<div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
					@if(count($rides) != 0)
						<table id="datatable-buttons" class="table table-bordered"
							style="border-collapse: collapse; border-spacing: 0; width: 100%;">
							<thead>
								<tr>
									<td>Booking ID</td>
									<td>Picked up</td>
									<td>Dropped</td>
									<td>Request Details</td>
									<td>COD</td>
									<td>Dated on</td>
									<td>Status</td>
									<td>Fare</td>
								</tr>
							</thead>
							<tbody>
							<?php $diff = ['-success','-info','-warning','-danger']; ?>
									@foreach($rides as $index => $ride)
										<tr>
											<td>{{ $ride->booking_id }}</td>
											<td>
												@if($ride->s_address != '')
													{{$ride->s_address}}
												@else
													Not Provided
												@endif
											</td>
											<td>
												@if($ride->d_address != '')
													{{$ride->d_address}}
												@else
													Not Provided
												@endif
											</td>
											<td>
												@if($ride->status != "CANCELLED")
													<a class="text-primary" href="{{route('account.requests.show',$ride->id)}}"><span class="underline">View Ride Details</span></a>
												@else
													<span>No Details Found </span>
												@endif									
											</td>
											<td>{{currency($ride->cod)}}</td>
											<td>
												<span class="text-muted">{{date('d M Y',strtotime($ride->created_at))}}</span>
											</td>
											<td>
												@if($ride->status == "COMPLETED")
													<span class="tag tag-success">{{$ride->status}}</span>
												@elseif($ride->status == "CANCELLED")
													<span class="tag tag-danger">{{$ride->status}}</span>
												@else
													<span class="tag tag-info">{{$ride->status}}</span>
												@endif
											</td>
											<td>{{currency($ride->amount_customer)}}</td>

										</tr>
									@endforeach
										
							<tfoot>
								<tr>
									<td>Booking ID</td>
									<td>Picked up</td>
									<td>Dropped</td>
									<td>Request Details</td>
									<td>Commission</td>
									<td>Dated on</td>
									<td>Status</td>
									<td>Earned</td>
								</tr>
							</tfoot>
						</table>
						@else
						<h6 class="no-result">No results found</h6>
						@endif 

                            
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')

    @include('user.layout.partials.datatable')

@endsection

