@extends('admin.layout.base')

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

			
					<div class="row row-md mb-2" style="padding: 15px;">
						<div class="col-md-12">
							<div>
								{{-- <form class="form-inline pull-right" method="GET" action={{url('support/searchUser')}}>
									{{ csrf_field() }}
									<div class="form-group">
										<input type="text" class="form-control" name="searchField" id="searchField" placeholder="Full Search">
									</div>
									
									<div class="form-group">
										<button name="search" class="btn btn-success">Search</button>
									</div>
								</form> --}}
								{{-- <a href="{{url('admin/printInvoice/'.$rides->id)}}" class="btn btn-primary">Print</a> --}}
							</div>

							@if(count($rides) != 0)
								<table class="table table-striped table-bordered dataTable" id="table-2" style="width:100%;">
									<thead>
										<tr>
											<td>ID</td>
											<td>Date</td>
											<td>Vendor</td>
											<td>Company Name</td>
											<td>Delivery Name</td>
											<td>Delivery</td>
											<td>Order</td>
											<td>Status</td>
											<td>Inbound</td>
											<td>Invoice</td>
										</tr>
									</thead>
									<tbody>
									<?php $diff = ['-success','-info','-warning','-danger']; ?>
											@foreach($rides as $index => $ride)
												<tr>
													<td>{{$ride->booking_id}}</td>
													<td>
														<span class="text-muted">{{date('d M Y h:i:sa',strtotime($ride->created_at))}}</span>
													</td>
													<td>
														{{$ride->user->first_name}} {{$ride->user->last_name}}
													</td>
													<td>{{$ride->user->company_name}}</td>
													<td>
														{{$ride->item->rec_name}}
													</td>
													<td>
														{{$ride->d_address}}
													</td>
													<td>
														<a class="text-primary" href="{{route('admin.requests.show',$ride->id)}}"><span class="underline"> Details</span></a>
													</td>
													<td>
														<span class="tag tag-info">{{$ride->status}}</span>
													</td>
													<td>
														<input type="checkbox" class="inbound" name="status-{{$ride->id}}">
													</td>
													<td>
														{{-- <form method="GET" action="{{url('admin/printInvoice/'.$ride->id)}}">
															<div class="col-lg-12"><button type="submit" class="btn btn-primary"> Print </button></div>
														</form> --}}
														<a href="{{url('admin/printInvoice/'.$ride->id)}}" class="btn btn-primary">Print</a>
													</td>
												</tr>
											@endforeach
												
									<tfoot>
										<tr>
											<td>ID</td>
											<td>Date</td>
											<td>Vendor</td>
											<td>Company Name</td>
											<td>Delivery Name</td>
											<td>Delivery</td>
											<td>Order</td>
											<td>Status</td>
											<td>Inbound</td>
											<td>Invoice</td>
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

<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    $(document).ready(function(){
        $(".inbound").change(function(){
            var id = this.name;
            var split_id = id.split("-");
            var field_name = split_id[0];
            var edit_id = split_id[1];
            var value=false;
            if(this.checked){
                value="SORTCENTER";
			}
			else{
				value="PICKEDUP";
			}
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
				url: "{{url('admin/requests')}}/"+edit_id,
                type: 'put',
                data: "status="+value,
                success:function(response){
                    console.log(response);
					//alert(success);
					// alert(response);
					// alert(message);
					// alert("Success Party"+response);
                },
                error: function (request, error) {
                    console.log(request);
					//alert(request);
                    alert(" Can't do!! Error"+error);
                }
            });
        })
    });
</script>

<script>
	// $(document).ready(function(){
	// 	$(".invoice").change(function(){

	// 	})
	// })
</script>
@endsection
