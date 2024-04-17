@extends('support.layout.master')

@section('title', 'Dashboard ')

@section('styles')
	<link rel="stylesheet" href="{{asset('main/vendor/jvectormap/jquery-jvectormap-2.0.3.css')}}">
@endsection





@section('content')
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
<div class="row">
	<div class="col-xl-3 col-md-6">
		<div class="card bg-primary mini-stat text-white">
			<div class="p-3 mini-stat-desc">
				<div class="clearfix">
					<h6 class="text-uppercase mt-0 float-left text-white-50">New Queries</h6>
					<h4 class="mb-3 mt-0 float-right">{{$newticket}}</h4>
				</div>

			</div>
		</div>
	</div> 
	<div class="col-xl-3 col-md-6">
		<div class="card bg-pink mini-stat text-white">
			<div class="p-3 mini-stat-desc">
				<div class="clearfix">
					<h6 class="text-uppercase mt-0 float-left text-white-50">Open Queries</h6>
					<h4 class="mb-3 mt-0 float-right">{{$open_ticket}}</h4>
				</div>

			</div>
		</div>
	</div>
	<div class="col-xl-3 col-md-6">
		<div class="card bg-success mini-stat text-white">
			<div class="p-3 mini-stat-desc">
				<div class="clearfix">
					<h6 class="text-uppercase mt-0 float-left text-white-50">Open Ticket</h6>
					<h4 class="mb-3 mt-0 float-right">{{$openTicket}}</h4>
				</div>

			</div>
		</div>
	</div>
	<div class="col-xl-3 col-md-6">
		<div class="card bg-info mini-stat text-white">
			<div class="p-3 mini-stat-desc">
				<div class="clearfix">
					<h6 class="text-uppercase mt-0 float-left text-white-50">Unsolve Comment</h6>
					<h4 class="mb-3 mt-0 float-right">{{$unsolve_comment}}</h4>
				</div>

			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xl-4">
		<div class="card">
			<div class="card-body">
				<h4 class="mt-0 header-title mb-4"><a href="{{url('notice')}}" style="color: black;">Unslove Comment</a></h4>
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
					<div class=text-right><a href="{{url('support/allorder/comment')}}">View more</a></div>
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
				<h4 class="mt-0 header-title mb-4"><a href="{{url('all_comments')}}" style="color: black;">Recent Ticket</a></h4>
				<ol class="activity-feed mb-0">
					@if(count($tickets)>0)
					@foreach($tickets as $index=>$comment)
					<li class="feed-item">
						<div class="feed-item-list">
							<span class="date text-white-50">{{$comment->created_at->diffForHumans()}}</span>
							<span class="activity-text text-white">{{ $comment->title }}</span><br>
							<div class="dotline"> <small class="activity-text text-white ">{{ $comment->description }}</small></div>
							
							<span class="activity-text text-white"><a href="{{ url('support/ticket_comment/' . $comment->id) }}"
											style="text-decoration:none;">

								<button type="submit" style="margin: top 0px;color:white;" class="btn btn-link">View detail</button></a>
								</form></span>
						</div>
					</li>
					@if ($loop->iteration == 3) 
								@break;
							@endif
					@endforeach
					<div class=text-right><a href="{{url('support/opentickets')}}">View more</a></div>
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
					<a href="https://www.facebook.com/hulagilogistics" target="_blank" rel="noopener noreferrer"><i class="mdi mdi-facebook h2 bg-primary text-white"></i></a>
					</div>
					<h5 class="font-16" class="text-dark"><a href="https://www.facebook.com/hulagilogistics" target="_blank" rel="noopener noreferrer">Facebook </a></h5>
					<p class="text-muted">Social media is not a media. The key is to listen, engage, and build relationships.</p>
					
				</div>
				<div class="row mt-5">
					<div class="col-md-4">
						<div class="social-source text-center mt-3">
							<div class="social-source-icon mb-2">
							<a href="https://www.facebook.com/hulagilogistics" target="_blank" rel="noopener noreferrer"><i class="mdi mdi-facebook h5 bg-primary text-white"></i>
							</div></i></a> 
							<p class="font-14 text-muted mb-2">4000 +</p>
							<h6><a href="https://www.facebook.com/hulagilogistics" target="_blank" rel="noopener noreferrer">Facebook</a></h6>
						</div>
					</div>
					<div class="col-md-4">
						<div class="social-source text-center mt-3">
							<div class="social-source-icon mb-2">
								<i class="mdi mdi-linkedin h5 bg-info text-white"></i>
							</div>
							<p class="font-14 text-muted mb-2">500 +</p>
							<h6><a href="https://www.linkedin.com/company/hulagilogistics/" target="_blank" rel="noopener noreferrer">linkedin</a></h6>
						</div>
					</div>
					<div class="col-md-4">
						<div class="social-source text-center mt-3">
							<div class="social-source-icon mb-2">
							<a href="https://www.instagram.com/hulagilogistics/?hl=en" target="_blank" rel="noopener noreferrer"> <i class="mdi mdi-instagram h5 bg-pink text-white"></i></a>
							</div>
							<p class="font-14 text-muted mb-2">2000 +</p>
							<h6> <a href="https://www.instagram.com/hulagilogistics/?hl=en" target="_blank" rel="noopener noreferrer">Instagram</a></h6>

						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- end col -->
</div>

@endsection