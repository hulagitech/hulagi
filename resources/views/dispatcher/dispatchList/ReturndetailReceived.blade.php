@extends('dispatcher.layout.base')

@section('title', 'Recent Trips ')

@section('content')

<div class="content-area py-1" id="dispatcher-panel">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<h4 style="text-transform:uppercase;"><i class="fa fa-arrow-down"></i> In Coming</h4>
			</div>
		</div> 

		<div class="row">
			<div class="col-md-12">
				 <nav class="navbar navbar-light bg-white b-a mb-2">
					<button class="navbar-toggler hidden-md-up" data-toggle="collapse" data-target="#process-filters" aria-controls="process-filters" aria-expanded="false" aria-label="Toggle Navigation"></button>

					<div class="collapse navbar-toggleable-sm" id="process-filters">
						<ul class="nav navbar-nav dispatcher-nav">
							<li class="nav-item dispatcher-tab">
								<a href={{route("dispatcher.dispatchList.pending")}}><span class="nav-link dispatcher-link">Pending Receive</span></a>
							</li>
                            <li class="nav-item dispatcher-tab">
								<a href={{url("dispatcher/completeReceived")}}><span class="nav-link dispatcher-link">Complete Received</span></a>
							</li>
                            <li class="nav-item dispatcher-tab">
								<a href={{url("dispatcher/incompleteReceived")}}><span class="nav-link dispatcher-link">Rejected Received</span></a>
							</li>
                            <li class="nav-item dispatcher-tab">
								<a href={{route("dispatcher.dispatchList.returnDispatch")}}><span class="nav-link dispatcher-link">Pending Receive(Returns)</span></a>
							</li>
                            {{-- <li class="nav-item dispatcher-tab">
								<a href={{route("dispatcher.dispatchList.pending")}}><span class="nav-link dispatcher-link">Sortcenter</span></a>
							</li>	 --}}
						</ul>
					</div>
				</nav>
			</div>
		</div>
        
        <div class="content-area py-1">
            <div class="container-fluid">
                <div class="box box-block bg-white">
                    <h5 class="mb-1"> <i class="fa fa-truck"></i> Pending Receive / Bulk Detail</h5>
                    <hr/>
        
                    @if(count($requests) != 0)
                    <table class="table table-striped table-bordered dataTable" id="table-2" style="width:100%;">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>ID</th>
                                <th>Last Update</th>
                                <th>User</th>
                                <th>Pickup Add.</th>
                                <th>Pickup No.</th>
                                <th>DropOff Add.</th>
                                <th>DropOff Name</th>
                                <th>DropOff No.</th>
                                <th>Vendor Remarks</th>
                                <th>Receive</th>
                            </tr>
                        </thead>
                        <tbody>
                       <script> var req_id=[];</script>
                        @foreach($requests as $index => $request)
                            <tr id="dataRow{{$index}}">
                                <td>
                                    @if(@$request->request->created_at)
                                        <span class="text-muted">{{@$request->request->created_at}}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ @$request->request->booking_id }}</td>
                                <td>
                                    @if(@$request->request->updated_at)
                                        <span class="text-muted">{{@$request->request->updated_at}}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->request->user)
                                        {{ @$request->request->user->first_name }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->request->s_address)
                                        {{ @$request->request->s_address }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->request->user->mobile)
                                        {{ @$request->request->user->mobile }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->request->d_address)
                                        {{ @$request->request->d_address }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                 <td>
                                    @if(@$request->request->item->rec_name)
                                        {{ @$request->request->item->rec_name}} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->request->item->rec_mobile)
                                        {{ @$request->request->item->rec_mobile }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->request->special_note)
                                        {{ @$request->request->special_note}} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@!$request->received)
                                        <a class="received btn btn-info" style="color: #fff;" name="received-{{$request->id}}"> <i class="fa fa-arrow-down"></i> Receive</a>
                                        <span style="color: orange; display:none;" class="checkreceived"><i class="fa fa-check"></i></span>
                                    @else
                                        <a class="received btn btn-info" style="color: #fff; display:none;" name="received-{{$request->id}}"> <i class="fa fa-arrow-down"></i> Receive</a>
                                        <span style="color: orange;" class="checkreceived"><i class="fa fa-check"></i></span>
                                    @endif
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
                                <th>Pickup No.</th>
                                <th>DropOff Add.</th>
                                <th>DropOff Name</th>
                                <th>DropOff No.</th>
                                <th>Vendor Remarks</th>
                                <th>Receive</th>
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

    


<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    $(document).ready(function(){
        $(".received").click(function(){
            $(this).hide();
            $(this).next(".checkreceived").show();
            var id = this.name;
            var split_id = id.split("-");
            var field_name = split_id[0];
            var edit_id = split_id[1];
            console.log(edit_id);
            // $(this).hide();
            // $(this).next(".checkreceived").show();
            // var id = this.name;
            // var split_id = id.split("-");
            // var field_name = split_id[0];
            // var edit_id = split_id[1];
            var value=false;
            if(this.checked){
                value=true;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{url('dispatcher/dispatchList/eachReturnReceive')}}/"+edit_id,
                type: 'post',
                data: field_name+"="+value,
                success:function(response){
                    if(response.showError){
                        
                    }
                    toastr.success("Success!!")
                },
                error: function (request, error) {
                    console.log(request);
                    alert(" Can't do!! Error"+error);
                }
            });
        });
    });
</script>


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