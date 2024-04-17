@extends('account.layout.base')

@section('title', $page)

@section('content')
<style>
    .txtedit{
        display: none;
        width: 99%;
        height: 30px;
    }
</style>
    <div class="content-area py-1">
        <div class="container-fluid">
            <div class="box box-block bg-white">
            	<h3> <i class="fa fa-car"></i> Banned {{$page}} </h3>

            	<div class="row">

						<div class="row row-md mb-2" style="padding: 15px;">
							<div class="col-md-12">
									<div class="">
										<div class="box-block clearfix">
											{{-- <h5 class="float-xs-left">Earnings</h5> --}}
											<div class="float-xs-right">
												<form class="form-inline pull-right" method="POST" action={{url('account/bannedStatement')}}>
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

										@if(count($Providers) != 0)
								            <table class="table table-striped table-bordered dataTable" id="table-2" width="100%">
								                <thead>
								                   <tr>
														<td>Driver Name</td>
														<td>Mobile</td>
														<td>Status</td>
														<td>Total Rides</td>
														<td>Total Earning</td>
														<td>Total Payable</td>
														<td>Joined at</td>
														<td>Details</td>
													</tr>
								                </thead>
								                <tbody>
								                <?php $diff = ['-success','-info','-warning','-danger']; ?>
														@foreach($Providers as $index => $provider)
															<tr>
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
																<td>
																	@if($provider->rides_count)
																		{{$provider->rides_count}}
																	@else
																	 	-
																	@endif
																</td>
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
																<td>
																	@if($provider->created_at)
																		<span class="text-muted">{{$provider->created_at}}</span>
																	@else
																	 	-
																	@endif
																</td>
																<td>
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
																	{{-- <a href="{{route('account.provider.statement', $provider->id)}}">View by Ride</a> --}}
																</td>
															</tr>
														@endforeach
															
								                <tfoot>
								                    <tr>
														<td>Provider Name</td>
														<td>Mobile</td>
														<td>Status</td>
														<td>Total Rides</td>
														<td>Total Earning</td>
														<td>Total Payable</td>
														<td>Joined at</td>
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
