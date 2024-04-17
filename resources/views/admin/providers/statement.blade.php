

@extends('admin.layout.master')

@section('title', $page)

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="row align-items-center">
				<div class="col-md-4">
					<h4 class="page-title m-0">{{$page}}</h4>
				</div>
				<div class="col-md-8 d-flex justify-content-end">
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
                        <h4 class="mb-3 mt-0 float-right">{{$rides}} </h4>
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
                        <h4 class="mb-3 mt-0 float-right">{{currency($Provider->payable)}}</h4>
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
                        <h4 class="mb-3 mt-0 float-right">{{$Provider->earning}}</h4>
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
					@if(count($logs) != 0)
						<table id="datatable-buttons" class="table table-bordered"
								style="border-collapse: collapse; border-spacing: 0; width: 100%;">
							<thead>
								<tr>
									<td>Date</td>
									<!-- <td>Transaction Type</td>
									<td>Amount</td> -->
									<td>Rider Earning</td> 
									<td>COD Collected</td>
									<td>Remarks</td>
								</tr>
							</thead>
							<tbody>
							<?php $diff = ['-success','-info','-warning','-danger']; ?>
								@foreach($logs as $index => $log)
									<tr>
										<td>{{ $log->created_at }}</td>
										<!-- <td>
											@if($log->transaction_type=="earning")
												<span class="tag tag-success">{{ $log->transaction_type }}</span>
											@else
												<span class="tag tag-danger">{{ $log->transaction_type }}</span>
											@endif
										</td>
										<td>{{ $log->amount }}</td> -->
										<td>
											@if($log->transaction_type=="earning")
												<span style="color:green; font-size:14px;">{{ $log->amount }}</span>
											@else
												<span> -- </span>
											@endif
										</td>
										<td>
										<a href="{{url('admin/provider/payment-edit/'.$log->id)}}">
											@if($log->transaction_type=="earning")
												<span> -- </span>
											@else
												<span style="color:red; font-size:14px;"> {{ $log->amount }} </span>
											@endif
											</a>
										</td>
										<td>
											@if($log->remarks)
												{{$log->remarks}}
											@else
												-
											@endif
										</td>
									</tr>
								@endforeach
									
							<tfoot>
								<tr>
									<td>Date</td>
									<!-- <td>Transaction Type</td>
									<td>Amount</td> -->
									<td>Rider Earning</td> 
									<td>COD Collected</td>
									<td>Remarks</td>
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


{{--@extends('admin.layout.base')

@section('title', $page)

@section('content')

    <div class="content-area py-1">
        <div class="container-fluid">
            <div class="box box-block bg-white">
            	<h3><i class="ti-infinite"></i>&nbsp;{{str_replace("Providers","Driver",$page)}}</h3><hr>
                <hr/>

            	<div class="row">
                    <div class="col-lg-4 col-md-6 col-xs-12">
						<div class="box box-block bg-danger mb-2 btn-secondary">
							<div class="t-content">
								<h6 class="text-uppercase mb-1">Total Order</h6>
								<h1 class="mb-1">{{$rides->count()}}</h1>
							
							</div>
						</div>
					</div>

					<div class="col-lg-4 col-md-6 col-xs-12">
						<div class="box box-block bg-success mb-2 btn-secondary">
							
							<div class="t-content">
								<h6 class="text-uppercase mb-1">Revenue</h6>
								<h1 class="mb-1">{{currency($revenue[0]->overall+$revenue[0]->commission-$revenue[0]->discount+$revenue[0]->tax)}}</h1>
							
							</div>
						</div>
					</div>
	            	<div class="col-lg-4 col-md-6 col-xs-12">
						<div class="box box-block bg-danger mb-2 btn-secondary">
				
							<div class="t-content">
								<h6 class="text-uppercase mb-1">All Comission</h6>
								<h1 class="mb-1">{{currency($revenue[0]->commission-$revenue[0]->discount)}}</h1>
							
							</div>
						</div>
					</div>

					<div class="col-lg-4 col-md-6 col-xs-12">
						<div class="box box-block bg-success mb-2 btn-secondary">
							
							<div class="t-content">
								<h6 class="text-uppercase mb-1">All Earning</h6>
								<h1 class="mb-1">{{currency($revenue[0]->overall)}}</h1>
							
							</div>
						</div>
					</div>

					<div class="col-lg-4 col-md-6 col-xs-12">
						<div class="box box-block bg-warning mb-2 btn-secondary">
							<div class="t-content">
								<h6 class="text-uppercase mb-1">Cancelled Orders</h6>
								<h1 class="mb-1">{{$cancel_rides}}</h1>
							</div>
						</div>
					</div>

						<div class="row row-md mb-2" style="padding: 15px;">
							<div class="col-md-12">
									<div class="">
										<div class="box-block clearfix">
											<div class="float-xs-right">
											</div>
										</div>

										@if(count($rides) != 0)
								            <table class="table table-striped table-bordered dataTable" id="table-2" style="width:100%;">
								                <thead>
								                   <tr>
														<td>ID</td>
														<td>Picked up</td>
														<td>Delivery</td>
														<td>Order</td>
														<td>Commission</td>
														<td>Discount</td>
														<td>Date</td>
														<td>Status</td>
														<td>Earned</td>
													</tr>
								                </thead>
								                <tbody>
								                <?php $diff = ['-success','-info','-warning','-danger']; ?>
														@foreach($rides as $index => $ride)
															<tr>
																<td>{{$ride->booking_id}}</td>
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
																		<a class="text-primary" href="{{route('admin.requests.show',$ride->id)}}"><span class="underline"> Details</span></a>
																	@else
																		<span>No Details Found </span>
																	@endif									
																</td>
																<td>{{currency(@$ride->payment['commision']-$ride->payment['discount'])}}</td>
																
																@if($ride->payment['discount'])
																    <td>{{currency($ride->payment['discount'])}}</td>
																@else
																	<td>$0.00</td>
																	@endif	
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
																<td>{{currency($ride->payment['fixed'] + $ride->payment['distance'])}}</td>

															</tr>
														@endforeach
															
								                <tfoot>
								                    <tr>
														<td>ID</td>
														<td>Picked up</td>
														<td>Delivery</td>
														<td>Order</td>
														<td>Commission</td>
														<td>Discount</td>
														<td>Date</td>
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
        </div>
    </div>

@endsection --}}
