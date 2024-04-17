@extends('pickup.layout.master')

@section('title', 'Dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('main/vendor/jvectormap/jquery-jvectormap-2.0.3.css') }}">
@endsection
@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Dashboard</h4>
                    </div>
                    <div class="col-md-4">

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title end breadcrumb -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Pending Orders Today</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $pending_rides }}</h4>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Accepted Orders Today</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $accepted_rides }}</h4>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-pink mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Pickedup Orders Today</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $picked_rides }}</h4>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Cancelled Orders Today</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $cancel_rides }}</h4>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Total Pending Orders</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $total_pending_rides }}</h4>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-pink mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Total Accepted Orders</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $total_accepted_rides }}</h4>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Total Pickedup Orders</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $total_picked_rides }}</h4>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Today Total Orders</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $total_today_order }}</h4>
                    </div>

                </div>
            </div>
        </div>
    </div>
<div class="row">
	<div class="col-xl-4">
		<div class="card">
			<div class="card-body">
				<h4 class="mt-0 header-title mb-4"><a href="{{url('pickup/pickupUnsolveComment')}}" style="color: black;">Unslove Comment</a></h4>
					<ol class="activity-feed mb-0">
					@if(count($allOrderComments)>0)
					@foreach($allOrderComments as $index=>$comment)
					<li class="feed-item">
						<div class="feed-item-list">
							<span class="date text-white-50">{{$comment->created_at}}</span>
							<span class="activity-text text-white">{{ $comment->ur->booking_id }}</span><br>
							<div class="dotline"> <small class="activity-text text-white ">{{ $comment->comment->comments }}</small></div>
						</div>
					</li>
					@if ($loop->iteration == 3) 
								@break;
							@endif
					@endforeach
					<div class=text-right><a href="{{url('pickup/pickupUnsolveComment')}}">View more</a></div>
					@else
					<li class="feed-item">
						<div class="feed-item-list">
							<span class="date text-white-50"></span>
							<span class="activity-text text-white">You don't have recent Comment</span>
						</div>
					</li>
					@endif
				</ol>

			</div>
		</div>

	</div>
	<!-- end col -->

	<div class="col-xl-4">
		<div class="card">
			<div class="card-body">
				<h4 class="mt-0 header-title mb-4"><a href="{{url('pickup/opentickets')}}" style="color: black;">Recent Ticket</a></h4>
				<ol class="activity-feed mb-0">
					@if(count($tickets)>0)
					@foreach($tickets as $index=>$comment)
					<li class="feed-item">
						<div class="feed-item-list">
							<span class="date text-white-50">{{$comment->created_at->diffForHumans()}}</span>
							<span class="activity-text text-white">{{ $comment->title }}</span><br>
							<div class="dotline"> <small class="activity-text text-white ">{{ $comment->description }}</small></div>
							
							<span class="activity-text text-white"><a href="{{ url('pickup/ticket_comment/' . $comment->id) }}"
											style="text-decoration:none;">

								<button type="submit" style="margin: top 0px;color:white;" class="btn btn-link">View detail</button></a>
								</form></span>
						</div>
					</li>
					@if ($loop->iteration == 3) 
								@break;
							@endif
					@endforeach
					<div class=text-right><a href="{{url('pickup/opentickets')}}">View more</a></div>
					@else
					<li class="feed-item">
						<div class="feed-item-list">
							<span class="date text-white-50"></span>
							<span class="activity-text text-white">You don't have recent Comment</span>
						</div>
					</li>
					@endif
				</ol>

			</div>
		</div>
	</div>
	<!-- end col -->

	<div class="col-xl-4">
		<div class="card">
			<div class="card-body">
				<h4 class="mt-0 header-title mb-4">Social Source</h4>
				<div class="text-center">
					<div class="social-source-icon lg-icon mb-3">
					<a href="https://www.facebook.com/hulagidelivery" target="_blank" rel="noopener noreferrer"><i class="mdi mdi-facebook h2 bg-primary text-white"></i></a>
					</div>
					<h5 class="font-16" class="text-dark"><a href="https://www.facebook.com/hulagidelivery" target="_blank" rel="noopener noreferrer">Facebook </a></h5>
					<p class="text-muted">Social media is not a media. The key is to listen, engage, and build relationships.</p>
					
				</div>
				<div class="row mt-5">
					<div class="col-md-4">
						<div class="social-source text-center mt-3">
							<div class="social-source-icon mb-2">
							<a href="https://www.facebook.com/hulagidelivery" target="_blank" rel="noopener noreferrer"><i class="mdi mdi-facebook h5 bg-primary text-white"></i>
							</div></i></a> 
							<p class="font-14 text-muted mb-2">4000 +</p>
							<h6><a href="https://www.facebook.com/hulagidelivery" target="_blank" rel="noopener noreferrer">Facebook</a></h6>
						</div>
					</div>
					<div class="col-md-4">
						<div class="social-source text-center mt-3">
							<div class="social-source-icon mb-2">
								<i class="mdi mdi-linkedin h5 bg-info text-white"></i>
							</div>
							<p class="font-14 text-muted mb-2">500 +</p>
							<h6><a href="https://www.linkedin.com/company/hulagidelivery/" target="_blank" rel="noopener noreferrer">linkedin</a></h6>
						</div>
					</div>
					<div class="col-md-4">
						<div class="social-source text-center mt-3">
							<div class="social-source-icon mb-2">
							<a href="https://www.instagram.com/hulagidelivery/?hl=en" target="_blank" rel="noopener noreferrer"> <i class="mdi mdi-instagram h5 bg-pink text-white"></i></a>
							</div>
							<p class="font-14 text-muted mb-2">2000 +</p>
							<h6> <a href="https://www.instagram.com/hulagidelivery/?hl=en" target="_blank" rel="noopener noreferrer">Instagram</a></h6>

						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
    <!-- end col -->
</div>
<div class="row">
     <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mt-0 header-title mb-4">Recent Pending Order</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">SN.</th>
                                <th scope="col">Order Placed</th>
                                <th scope="col">Booking ID</th>
                                
                                <th scope="col">Receiver Name</th>
                                
                                <th scope="col">Status</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $diff = ['-success', '-info', '-warning', '-danger']; ?>
                        @foreach ($trips as $index => $ride)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>
                                <span class="text-muted">{{ $ride->created_at->diffForHumans() }}</span>
                            </td>
                            <td>{{$ride->booking_id}}</td>
                            <td>{{ $ride->item['rec_name'] }}</td>
                            
                            <td>
                                {{$ride->status}}
                            </td>
                            <td>
                                {{$ride->special_note}}
                            </td>
                            <td>

                                <span class="underline">
                                    <a href="{{ url('/pickup/show/'.$ride->id) }}"  class="btn btn-dark ">
                                        Details
                                    </a>
                                </span>


                            </td>   
                            </tr>
                            @if ($loop->iteration == 8) 
                                @break;
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
	

@endsection
