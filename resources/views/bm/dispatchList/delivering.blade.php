@extends('bm.layout.base')

@section('title', 'Recent Trips ')

@section('content')


<style>
    .txtedit{
        display: none;
        width: 99%;
        height: 30px;
    }
</style>


{{-- <div class="content-area py-1" id="bm-panel">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<h4 style="text-transform:uppercase;"><i class=""></i> Sortcenter</h4>
			</div>
		</div>  --}}

		{{-- <div class="row">
			<div class="col-md-12">
				 <nav class="navbar navbar-light bg-white b-a mb-2">
					<button class="navbar-toggler hidden-md-up" data-toggle="collapse" data-target="#process-filters" aria-controls="process-filters" aria-expanded="false" aria-label="Toggle Navigation"></button>

					<div class="collapse navbar-toggleable-sm" id="process-filters">
						<ul class="nav navbar-nav bm-nav">
                            <li class="nav-item bm-tab">
                                <a href={{url("bm/sortcenter")}}><span class="nav-link bm-link">Sortcenter</span></a>
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</div> --}}
        
        <div class="content-area py-1">
            <div class="container-fluid">
                <div class="box box-block bg-white">
                    <h5 class="mb-1"> <i class="fa fa-recycle"></i> Delivering</h5>
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
                                <th>User</th>
                                <th>Pickup Add.</th>
                                <th>Pickup No.</th>
                                <th>DropOff Add.</th>
                                <th>DropOff Name</th>
                                <th>DropOff No.</th>
                                <th>Rider</th>
                                <th>COD</th>
                                <th>Vendor Remarks</th>
                                <th> Action </th>
                                {{-- <th>Receive</th> --}}
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
                                <td>{{ @$request->booking_id }}</td>
                                <td>
                                    @if(@$request->updated_at)
                                        <span class="text-muted">{{@$request->updated_at->diffForHumans()}}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->user)
                                        {{ @$request->user->first_name }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->s_address)
                                        {{ @$request->s_address }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->user->mobile)
                                        {{ @$request->user->mobile }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->d_address)
                                        {{ @$request->d_address }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                 <td>
                                    @if(@$request->item->rec_name)
                                        {{ @$request->item->rec_name}} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->item->rec_mobile)
                                        {{ @$request->item->rec_mobile }} 
                                    @else
                                        N/A
                                    @endif
                                </td>

                                <td>
                                    @if(@$request->provider)
                                        {{ @$request->provider->first_name}} 
                                    @else
                                        N/A
                                    @endif
                                </td>

                                <td>
                                    @if(@$request->cod)
                                        {{ @$request->cod}} 
                                    @else
                                        N/A
                                    @endif
                                </td>

                                <td>
                                    @if(@$request->special_note)
                                        {{ @$request->special_note}} 
                                    @else
                                        N/A
                                    @endif
                                </td>

                                <td style="position:relative;" width="5%">
                                    <a href="{{ route('bm.order_detail', @$request->id) }}" class="btn btn-success shadow-box"> <i class="ti-comment"></i> </a>
                                    
                                    {{-- Count Comment Notification --}}
                                    @if($request->noComment != '0')
                                        <span class="tag tag-danger" style="position:absolute; top:0px;"> {{$request->noComment}}</span>
                                    @else
                                        <span>  </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Date</th>
                                <th>ID</th>
                                <th>Update On</th>
                                <th>User</th>
                                <th>Pickup Add.</th>
                                <th>Pickup No.</th>
                                <th>DropOff Add.</th>
                                <th>DropOff Name</th>
                                <th>DropOff No.</th>
                                <th>Rider</th>
                                <th>COD</th>
                                <th>Vendor Remarks</th>
                                <th> Action </th>
                                {{-- <th>Receive</th> --}}
                            </tr>
                        </tfoot>
                    </table>
                    {{$requests->links('vendor.pagination.bootstrap-4')}}
                    @else
                    <h6 class="no-result">No results found</h6>
                    @endif 
                </div>
            </div>
        </div>
	{{-- </div>
</div> --}}


<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">


<script>
    $(document).ready(function(){
 
        // Show Input element
        $('.edit').click(function(){
            $('.txtedit').hide();
            $(this).next('.txtedit').show().focus();
            $(this).hide();
        });

        // Save data
        $(".txtedit").focusout(function(){
            // Get edit id, field name and value
            var id = this.id;
            var split_id = id.split("-");
            var field_name = split_id[0];
            var edit_id = split_id[1];
            var value = $(this).val();

            //alert(edit_id+" ---> "+field_name+"="+value);
            
            if(field_name=="provider" && !confirm("Are you sure, you want to Assign \""+value+"\" rider?")){
                $(this).hide();
                $(this).prev('.edit').show();
                return;
            }
            // Hide Input element
            $(this).hide();

            // Hide and Change Text of the container with input elmeent
            $(this).prev('.edit').show();
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
                url: "{{url('/bm/rider_assign/')}}"+"/"+edit_id,
                type: 'post',
                data: field_name+"="+value,
                success:function(response){
                    console.log(response); 
                    if(response.showError){
                        alert(response.error);
                    }
                },
                error: function (request, error) {
                    console.log(request);
                    alert("Error! Please refresh page");
                }
            });
        });
    });
</script>


@endsection

@section('styles')
    <style type="text/css">
        .bm-nav li span {
            /* // background-color: transparent; */
            color: #000!important;
            padding: 5px 12px;
        }

        .bm-nav li span:hover,
        .bm-nav li span:focus,
        .bm-nav li span:active {
            background-color: #20b9ae;
            color: #fff!important;
            padding: 5px 12px;
        }

        .bm-nav li.active span,
        .bm-nav li span:hover,
        .bm-nav li span:focus,
        .bm-nav li span:active {
            background-color: #20b9ae;
            color: #fff!important;
            padding: 5px 12px;
        }
    </style>
@endsection