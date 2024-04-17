@extends('admin.layout.master')

@section('title', 'Rider Documents ')

@section('content')
<div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Rider Document and Vehicle Info</h4>
                    </div>
                    <div class="col-md-4">
                        <div class="float-right">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
                @if($ProviderService->count() > 0)
                    
                    <h6>Vehicle Allocated Services :  </h6>
                    <table id="datatable" class="table table-bordered"
                        								style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Vehicle Name</th>
                                <th>Number Plate</th>
                                <th>Vehicle Model</th>
                              
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ProviderService as $service)
                             
                            <tr>
                                <td>{{ $service['service_type']['name'] }}</td>
                                <td>{{ $service['service_number'] }}</td>
                                <td>{{ $service['service_model'] }}</td>
                              
                                <td>
                                    <form action="{{ route('admin.provider.document.service', [$Provider->id, $service->id]) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-danger btn-large btn-block">Delete</a>
                                    </form>
                                </td>
                            </tr>
                            
                            @endforeach
                           
                        </tbody>
                       
                    </table>
                    
                    @else
                    
                    <div>Data Not Found</div>
                    @endif
                </div>
                

            </div>
        </div>
    </div>
<div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
                   @if( $pr_documents )
                    <h6>Documents :  </h6>
				
				 <table id="datatable" class="table table-bordered"
                        								style="border-collapse: collapse; border-spacing: 0; width: 100%;">
					<thead>
						<tr>
							<th>Document</th>
							<th>Name</th>
							<th>status</th>
							<th>Expiry Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					    
						@foreach($pr_documents as $document )
						
						<tr>
							<td>{{ $document['type'] }}</td>
							<td>{{ $document['name'] }}</td>
							<td>{{ $document['status'] }}</td>
						
							<td>{{ $document['expires_at'] }}</td>
							<td>
								
									@if( $document['status'] == 'MISSING' )
                                        N/A
									
									<!-- <a href="{{ url('admin/provider/'.$document['provider_id'].'/document/'.$document['id'].'/upload') }}" style="margin-left: 1em;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add Doccument</a> -->
									
									@else 
                                    <img src="{{ asset('storage/'.$document['url']) }}" alt="" width="300px" height="300px">
                                    <div class="pt-1">
                                    <form  style="display:inline-block; margin-left:20px;" action="{{ route('admin.provider.document.update', [$document['provider_id'], $document['id'] ]) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('PATCH') }}
                                        <button class="btn btn-block btn-primary" type="submit">Approve</button>
                                    </form>
										<!-- <a href="{{ route('admin.provider.document.edit', [$document['provider_id'], $document['id']]) }}"><span class="btn btn-success btn-large">View</span></a>
										<a href="{{ url('admin/provider/'.$document['provider_id'].'/document/'.$document['id'].'/update') }}"><span class="btn btn-success btn-large">Edit</span></a> -->
										<form style="display:inline-block; margin-left:20px;" action="{{ route('admin.provider.document.destroy', [$document['provider_id'], $document['id']]) }}" method="POST" id="form-delete">
											<button class="btn btn-danger btn-large" form="form-delete">Decline</button>
											{{ csrf_field() }}
											{{ method_field('DELETE') }}
										</form>
                                    </div>
										
									@endif
							
							</td>
						</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<th>Document Type</th>
							<th>Name</th>
							<th>status</th>
							<th>Expiry Date</th>
							<th>Action</th>
						</tr>
					</tfoot>
				</table>
				@else
				<div>Data Not Found</div>
			@endif
                

            </div>
        </div>
    </div>
</div>
{{---<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <h5 class="mb-1">Vehicle Allocation</h5>
            <div class="row">
                <div class="col-xs-12">
                    
                   @if( $pr_documents )
				
				 <table id="datatable" class="table table-bordered"
                        								style="border-collapse: collapse; border-spacing: 0; width: 100%;">
					<thead>
						<tr>
							<th>Document</th>
							<th>Name</th>
							<th>status</th>
							<th>Expiry Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					    
						@foreach($pr_documents as $document )
						
						<tr>
							<td>{{ $document['type'] }}</td>
							<td>{{ $document['name'] }}</td>
							<td>{{ $document['status'] }}</td>
						
							<td>{{ $document['expires_at'] }}</td>
							<td>
								
									@if( $document['status'] == 'MISSING' )
									
									<a href="{{ url('admin/provider/'.$document['provider_id'].'/document/'.$document['id'].'/upload') }}" style="margin-left: 1em;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add Doccument</a>
									
									@else
										<a href="{{ route('admin.provider.document.edit', [$document['provider_id'], $document['id']]) }}"><span class="btn btn-success btn-large">View</span></a>
										<a href="{{ url('admin/provider/'.$document['provider_id'].'/document/'.$document['id'].'/update') }}"><span class="btn btn-success btn-large">Edit</span></a>
										<form style="display:inline-block; margin-left:20px;" action="{{ route('admin.provider.document.destroy', [$document['provider_id'], $document['id']]) }}" method="POST" id="form-delete">
											<button class="btn btn-danger btn-large" form="form-delete">Decline</button>
											{{ csrf_field() }}
											{{ method_field('DELETE') }}
										</form>
										
									@endif
							
							</td>
						</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<th>Document Type</th>
							<th>Name</th>
							<th>status</th>
							<th>Expiry Date</th>
							<th>Action</th>
						</tr>
					</tfoot>
				</table>
				@else
				<div>Data Not Found</div>
			@endif
                </div>
                <form action="{{ route('admin.provider.document.store', $Provider->id) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="col-xs-3">
                        <select class="form-control input" name="service_type" required>
                            @forelse($ServiceTypes as $Type)
                            <option value="{{ $Type->id }}">{{ $Type->name }}</option>
                            @empty
                            <option>- Please Create a Service Type -</option>
                            @endforelse
                        </select>
                    </div>
                     <div class="col-xs-3">
                        <input type="text" required name="service_number" class="form-control" placeholder="Vehicle Number">
                    </div>
                    <div class="col-xs-3" style="width: 17%;">
                        <input type="text" required name="service_model" class="form-control" placeholder="Vehicle Model" >
                    </div>

                    

                    <div class="col-xs-3" style="width: 12%;">
                        <button class="btn btn-primary btn-block" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
<div class="content-area py-1">
    <div class="">
        <div class="box box-block bg-white">
            <h5 class="mb-1">Drivers Documents</h5>
			
			@if( $pr_documents )
				
				 <table id="datatable" class="table table-bordered"
                        								style="border-collapse: collapse; border-spacing: 0; width: 100%;">
					<thead>
						<tr>
							<th>Document</th>
							<th>Name</th>
							<th>status</th>
							<th>Expiry Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					    
						@foreach($pr_documents as $document )
						
						<tr>
							<td>{{ $document['type'] }}</td>
							<td>{{ $document['name'] }}</td>
							<td>{{ $document['status'] }}</td>
						
							<td>{{ $document['expires_at'] }}</td>
							<td>
								
									@if( $document['status'] == 'MISSING' )
									
									<a href="{{ url('admin/provider/'.$document['provider_id'].'/document/'.$document['id'].'/upload') }}" style="margin-left: 1em;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add Doccument</a>
									
									@else
										<a href="{{ route('admin.provider.document.edit', [$document['provider_id'], $document['id']]) }}"><span class="btn btn-success btn-large">View</span></a>
										<a href="{{ url('admin/provider/'.$document['provider_id'].'/document/'.$document['id'].'/update') }}"><span class="btn btn-success btn-large">Edit</span></a>
										<form style="display:inline-block; margin-left:20px;" action="{{ route('admin.provider.document.destroy', [$document['provider_id'], $document['id']]) }}" method="POST" id="form-delete">
											<button class="btn btn-danger btn-large" form="form-delete">Decline</button>
											{{ csrf_field() }}
											{{ method_field('DELETE') }}
										</form>
										
									@endif
							
							</td>
						</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<th>Document Type</th>
							<th>Name</th>
							<th>status</th>
							<th>Expiry Date</th>
							<th>Action</th>
						</tr>
					</tfoot>
				</table>
				@else
				<div>Data Not Found</div>
			@endif
        </div>
    </div>
    
</div>---}}
<!--<style>
    input[type="file"] {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    opacity: 0;
    filter: alpha(opacity=0);
    font-size: 23px;
    height: 100%;
    width: 100%;
    direction: ltr;
    cursor: pointer;
}
</style>-->
@endsection