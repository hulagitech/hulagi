@extends('account.layout.master')

@section('title', $page)

@section('content')
<style>
    .txtedit{
        display: none;
        width: 99%;
        height: 30px;
    }
</style>
<div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h4 class="page-title m-0">{{ $page }}</h4>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end">
                        <form class="form-inline pull-right" method="GET" action={{url('account/statement/provider')}}>
                            {{csrf_field()}}
                            <div class="form-group">
                                <input type="text" class="form-control" name="searchField" placeholder="Full Search">
                            </div>
                            <div class="form-group">
                                <button name="search" class="btn btn-success">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>
<div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
                    @if(count($Providers) > 0)
                      <table id="datatable" class="table table-bordered"
                        								style="border-collapse: collapse; border-spacing: 0; width: 100%;">
						<thead>
							<tr>
								<td>Joined at</td>
								<td>Driver Name</td>
								<td>Mobile</td>
								<td>Status</td>
								{{-- <td>Total Rides</td> --}}
								<td>Total Earning</td>
								<td>Total Payable</td>
								{{-- <td>New Earning</td>
								<td>New Payable</td> --}}
								<td>Details</td>
							</tr>
						</thead>
						<tbody>
						<?php $diff = ['-success','-info','-warning','-danger']; ?>
								@foreach($Providers as $index => $provider)
									<tr>
										<td>
											@if($provider->created_at)
												<span class="text-muted">{{$provider->created_at}}</span>
											@else
												-
											@endif
										</td>
										<td>
											<a href="{{url('account/statement/provider/'.$provider->id.'/request')}}">
											{{$provider->first_name}} 
											{{$provider->last_name}}
											</a>
										</td>
										<td>
											{{$provider->mobile}}
										</td>
										<td>
											@if($provider->status == "approved")
												<span class="tag tag-success">Approved</span>
											@elseif($provider->status == "banned")
												<span class="tag tag-danger">Banned</span>
											@else
												<span class="tag tag-info">{{$provider->status}}</span>
											@endif
										</td>
										{{-- <td>
											@if($provider->rides_count)
												{{$provider->rides_count}}
											@else
												-
											@endif
										</td> --}}
										<td>
											@if(isset($provider->earning))
												<div class='edit'>
													{{$provider->earning}}
												</div>
												<input type='text' class='txtedit' placeholder="Decrease this amount" id='earning-{{$provider->id}}'>
												<input type='text' class='txtedit' placeholder="Remarks" id='remarks-{{$provider->id}}-first'>
												<button class="buttonUpdate txtedit">Submit</button>
											@else
												-
											@endif
										</td> 
										<td>
											@if(isset($provider->payable))
												<div class='edit'>
													{{$provider->payable}}
												</div>
												<input type='text' class='txtedit' placeholder="Decrease this amount" id='payable-{{$provider->id}}'>
												<input type='text' class='txtedit' placeholder="Remarks" id='remarks-{{$provider->id}}'>
												<button class="buttonUpdate txtedit">Submit</button>
											@else
												-
											@endif
										</td>
										{{-- <td>
											@if(isset($provider->newEarning))
												{{$provider->newEarning}}
											@else
												-
											@endif
										</td>

										<td>
											@if(isset($provider->newPayable))
												{{$provider->newPayable}}
											@else
												-
											@endif
										</td> --}}

										<td style="text-align:center">
										<div class="row">
											<div class="col-md-3">
												@if(@$provider->status == 'approved')
																		<a   onclick="return confirm('Are you sure, you want to ban this rider?')" href="{{ route('account.provider.disapprove', $provider->id ) }}"><span class="btn btn-secondary btn-success "><i class="fa fa-ban"></i></span></a>
																		@else
																		<a  onclick="return confirm('Are you sure, you want to unban this rider?')" href="{{ route('account.provider.approve', $provider->id ) }}"><span class="btn btn-secondary btn-success "><i class="fa fa-check"></i></span></a>
																		@endif
											</div>
											<div class="col-md-3">
												<div class="btn-group" role="group">
													<button type="button" class="btn btn-secondary btn-rounded btn-black waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
														Action
													</button>
													<div class="dropdown-menu">
														<a class="dropdown-item" href="{{route('account.provider.statement', $provider->id)}}">View by Ride</a>
														<a class="dropdown-item" href="{{url('account/statement/provider/'.$provider->id.'/log')}}">Payment Logs</a>
														<a class="dropdown-item" href="{{route('account.provider.logs', $provider->id)}}">Edit Paid Orders</a>
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<a href="{{ url('account/statement/rider/settle/'.$provider->id) }} " onclick="return confirm('Are you sure, you want to Settle this rider?')" class= "btn btn-danger btn-rounded">Settlement</a>
											</div>
										</div>
										</td>
									</tr>
								@endforeach
									
						<tfoot>
							<tr>
									<td>Joined at</td>
								<td>Driver Name</td>
								<td>Mobile</td>
								<td>Status</td>
								{{-- <td>Total Rides</td>--}}
								<td>Total Earning</td> 
								<td>Total Payable</td>
								{{-- <td>New Earning</td>
								<td>New Payable</td> --}}
								<td>Details</td>
							</tr>
						</tfoot>
					</table>
                     {{$Providers->links('vendor.pagination.bootstrap-4')}}
                    @else
                    <h6 class="no-result">No results found</h6>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
	<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<script>
		
		$(document).ready(function(){
	 
			// Show Input element
			$('.edit').click(function(){
				$('.txtedit').hide();
				$(this).next('.txtedit').show().focus();
				$(this).next('.txtedit').next('.txtedit').show();
				$(this).next('.txtedit').next('.txtedit').next('.txtedit').show();
				// $(this).hide();
			});
	
			// Save data
			/*$(".txtedit").focusout(function(){
			
				// Get edit id, field name and value
				var id = this.id;
				var split_id = id.split("-");
				var field_name = split_id[0];
				var edit_id = split_id[1];
				var sendValue=$(this).val();
				var value = $(this).prev('.edit').text()-$(this).val();
				$(this).val("");
				// Hide Input element
				$(this).hide();
				$('.txtedit').hide();
	
				// Hide and Change Text of the container with input elmeent
				// $(this).prev('.edit').show();
				if($(this).is('select')){
					var val=$(this).find("option:selected").text();
					$(this).prev('.edit').text(val);    
				}
				else{
					$(this).prev('.edit').text(value);
				}
	
				// Sending AJAX request
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
				$.ajax({
					url: "{{url('account/statement/provider')}}/"+edit_id,
					type: 'post',
					data: field_name+"="+sendValue,
					success:function(response){
						console.log(response); 
					},
					error: function (request, error) {
						console.log(request);
						alert(" Can't do!! Error"+error);
					}
				});
				// console.log($(this).html());
			
			});*/

			$(".buttonUpdate").click(function(){
			
			// Get edit id, field name and 
			var amount=$(this).prev('.txtedit').prev('.txtedit');
			var remarks=$(this).prev('.txtedit');
			var id = amount[0].id;
			var split_id = id.split("-");
			var field_name = split_id[0];
			var edit_id = split_id[1];
			var sendValue=amount.val();
			var remarksText=remarks.val();
			var value = amount.prev('.edit').text()-amount.val();
			amount.val("");
			remarks.val("");
			// Hide Input element
			// $(this).hide();
			$('.txtedit').hide();

			amount.prev('.edit').text(value);

			// Sending AJAX request
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				url: "{{url('account/statement/provider')}}/"+edit_id,
				type: 'post',
				data: field_name+"="+sendValue+"&remarks="+remarksText,
				success:function(response){
					console.log(response); 
				},
				error: function (request, error) {
					console.log(request);
					alert(" Can't do!! Error"+error);
				}
			});
			// console.log($(this).html());
		
		});
	
		});
	</script>

@endsection
