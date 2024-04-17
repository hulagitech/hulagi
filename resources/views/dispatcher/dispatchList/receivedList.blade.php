@extends('dispatcher.layout.base')

@section('title', 'Recent Trips ')

@section('content')

<div class="content-area py-1" id="dispatcher-panel">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<h4 style="text-transform:uppercase;"><i class="fa fa-arrow-up"></i> Out Going</h4>
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
								<a href={{route("dispatcher.dispatchList.myDispatch")}}><span class="nav-link dispatcher-link">Dispatched</span></a>
							</li>
							<li class="nav-item dispatcher-tab">
								<a href={{route("dispatcher.dispatchList.completeReached")}}><span class="nav-link dispatcher-link">Complete Reached</span></a>
							</li>
                            <li class="nav-item dispatcher-tab">
								<a href={{route("dispatcher.dispatchList.incompleteReached")}}><span class="nav-link dispatcher-link">Incomplete Reached</span></a>
							</li>
							<li class="nav-item dispatcher-tab">
								<a href={{route("dispatcher.dispatchList.draft")}}><span class="nav-link dispatcher-link">Draft</span></a>
							</li>
                            <li class="nav-item dispatcher-tab">
								<a href={{route("dispatcher.dispatchList.return")}}><span class="nav-link dispatcher-link">Return</span></a>
							</li>
                            <li class="nav-item dispatcher-tab">
								<a href={{route("dispatcher.dispatchList.returnedDispatched")}}><span class="nav-link dispatcher-link">Return Dispatched</span></a>
							</li>
						</ul>
					</div>
				</nav>
			</div>

		</div>
		<div class="content-area py-1">
            <div class="container-fluid">
                <div class="box box-block bg-white">
                    <h5 class="mb-1"> <i class="fa fa-truck" ></i> Reached </h5>
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
                                <th>Remarks</th>
                                {{-- <th>Bill Image</th>
                                <th>Dispatch</th> --}}
                                <th>Number of Orders</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                       <script> var req_id=[];</script>
                        @foreach($requests as $index => $request)
                            <tr id="dataRow{{$index}}">
                                <td>
                                    @if(@$request->created_at)
                                        <span class="text-muted">{{@$request->created_at}}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{@$request->zone2->zone_name}}#{{@$request->id}}</td>
                                <td>
                                    @if(@$request->updated_at)
                                        <span class="text-muted">{{@$request->updated_at}}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <input type="text" placeholder="Dispatch Remarks" value="{{@$request->remarks}}" class="form-control" id="remarks-{{@$request->id}}">
                                </td>
                                {{-- <td>
                                    <button class="btn btn-primary dispatch" value={{@$request->id}}>Update</button>
                                </td> --}}
                                <td>
                                    {{@$request->count}}
                                </td>
                                <td>
                                    {{-- <a href="{{ route('dispatcher.dispatchList.showDispatch', @$request->id) }}" class="btn btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('dispatcher.dispatchList.showDispatch', @$request->id) }}" class="btn btn-warning">
                                        <i class="fa fa-pencil"></i>
                                    </a> --}}
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-secondary btn-rounded btn-black waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            Action
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="{{ route('dispatcher.dispatchList.showDispatch', @$request->id) }}" class="dropdown-item">
                                                <i class="fa fa-search"></i> More Details
                                            </a>
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
                                <th>Remarks</th>
                                {{-- <th>Bill Image</th>
                                <th>Dispatch</th> --}}
                                <th>Number of Orders</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                    @else
                    <h6 class="no-result">No results found</h6>
                    @endif 
                </div>
            </div>
        </div>
        
        <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>
            $('.dispatch').click(function(){
                var val=$(this).val();
                var remarks=$("#remarks-"+val).val();
                var file=$("#file-"+val)[0].files[0];
                var fd = new FormData();
                if(file){
                    fd.append('file', file);
                }
                fd.append('remarks',remarks);
                fd.append('id',val);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{url('dispatcher/dispatchList/myDispatch')}}",
                    type: 'post',
                    processData: false,
                    contentType: false,
                    data: fd,
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
@endsection


@section('styles')
    <style type="text/css">
        .dispatcher-nav li span {
            /* // background-color: transparent; */
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
    </style>
@endsection