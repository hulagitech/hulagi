@extends('dispatcher.layout.base')

@section('title', 'Recent Trips ')

@section('content')


<style>
    .txtedit{
        display: none;
        width: 99%;
        height: 30px;
    }
</style>


<div class="content-area py-1" id="dispatcher-panel">

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<h4>All Orders</h4>
			</div>
		</div> 
	</div>

    <div class="row">
        <div class="col-md-12">
             <nav class="navbar navbar-light bg-white b-a mb-2">
                <button class="navbar-toggler hidden-md-up" data-toggle="collapse" data-target="#process-filters" aria-controls="process-filters" aria-expanded="false" aria-label="Toggle Navigation"></button>

                <div class="collapse navbar-toggleable-sm" id="process-filters">
                    <ul class="nav navbar-nav dispatcher-nav">
                        <li class="nav-item dispatcher-tab active">
                            <a href={{ route('dispatcher.index') }}><span class="nav-link dispatcher-link"> All Order </span></a>
                        </li>
                        <li class="nav-item dispatcher-tab">
                            <a href={{ route('dispatcher.sortcenter') }}><span class="nav-link dispatcher-link"> Sortcenter </span></a>
                        </li>
                        <li class="nav-item dispatcher-tab">
                            <a href={{ route('dispatcher.delivering') }}><span class="nav-link dispatcher-link"> Delivering </span></a>
                        </li>
                        <li class="nav-item dispatcher-tab">
                            <a href={{ route("dispatcher.scheduled") }}><span class="nav-link dispatcher-link">Scheduled</span></a>
                        </li>
                        {{-- <li class="nav-item dispatcher-tab">
                            <a href={{route("dispatcher.dispatchList.draft")}}><span class="nav-link dispatcher-link">Draft</span></a>
                        </li> --}}
                    </ul>
                </div>
            </nav>
        </div>
    </div>

    
    <div class="container-fluid">
        <div class="box box-block bg-white">
            @if(isset($dates))
                <form class="form-inline pull-right" method="POST" action={{url('dispatcher/recent-trips')}}>
                    {{csrf_field()}}
                    <div class="form-group">
                        <input type="text" class="form-control" name="searchField" placeholder="Full Search">
                    </div>
                    {{-- <div class="form-group">
                        <input type="date" class="form-control" name="date">
                        <!-- <select class="form-control" name="date">
                            <option>All</option>
                        @foreach ($dates as $date)
                            <option {{(isset(request()->date) && request()->date==$date)? "selected": ""}} value={{$date}}>{{$date}}</option>
                        @endforeach
                        </select> -->
                    </div> --}}
                    <div class="form-group">
                        <label for="from_date" style="padding-top:5px;"> From: <label>
                        <input type="date" class="form-control" name="from_date">
                    </div>
                    <div class="form-group">
                        <label for="to_date" style="padding-top:5px;"> To: <label>
                        <input type="date" class="form-control" name="to_date">
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="status">
                            <option {{(request()->status && request()->status=="All")? "selected": ""}}>All</option>
                            <option {{(request()->status && request()->status=="PENDING")? "selected": ""}}>PENDING</option>
                            <option {{(request()->status && request()->status=="PICKEDUP")? "selected": ""}}>PICKEDUP</option>
                            <option {{(request()->status && request()->status=="CANCELLED")? "selected": ""}}>CANCELLED</option>
                            <option {{(request()->status && request()->status=="DELIVERING")? "selected": ""}}>DELIVERING</option>
                            <option {{(request()->status && request()->status=="ACCEPTED")? "selected": ""}}>ACCEPTED</option>
                            <option {{(request()->status && request()->status=="SORTCENTER")? "selected": ""}}>SORTCENTER</option>
                            <option {{(request()->status && request()->status=="SCHEDULED")? "selected": ""}}>SCHEDULED</option>
                            <option {{(request()->status && request()->status=="COMPLETED")? "selected": ""}}>COMPLETED</option>
                            <option {{(request()->status && request()->status=="REJECTED")? "selected": ""}}>REJECTED</option>
                            <option {{(request()->status && request()->status=="TOBERETURNED")? "selected": ""}}>TOBERETURNED</option>
                            <option {{(request()->status && request()->status=="RETURNED")? "selected": ""}}>RETURNED</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button name="search" class="btn btn-success">Search</button>
                    </div>
                </form>
            @endif
            <br>
            <h5 class="mb-1"> <i class="fa fa-recycle"></i> Order History</h5>
            <hr/>

            @if(count($requests) != 0)
            <table class="table table-striped table-bordered dataTable" id="table-2" style="width:100%;">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Last Update</th>
                        <th>User</th>
                        <th>Pickup Add.</th>
                        <th>Pickup Number</th>
                        <th>DropOff Add.</th>
                        <th>DropOff Name</th>
                        <th>DropOff Number</th>
                        <th>Rider</th>
                        <th>Status</th>
                        {{-- <th>Km</th>
                        <th>Fare</th> --}}
                        <th>COD(Rs)</th>
                        <th>Remarks</th>
                        <th>Rider Remarks</th>
                        <th> Action </th>
                    </tr>
                </thead>
                <tbody>
               <script> var req_id=[];</script>
                @foreach($requests as $index => $request)
                <script> req_id.push(<?php echo $request->id; ?>);</script>
                    <tr id="dataRow{{$index}}">
                        <td>
                            @if($request->created_at)
                                <span class="text-muted">{{$request->created_at}}</span>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $request->booking_id }}</td>
                        <td>
                            @if($request->created_at)
                                <span class="text-muted">{{$request->created_at->diffForHumans()}}</span>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($request->updated_at)
                                @if($request->status=="PENDING" || $request->status=="ACCEPTED")
                                    <span class="text-muted">{{$request->updated_at->diffForHumans()}}</span>
                                @else
                                    <span class="text-muted">{{$request->updated_at}}</span>
                                @endif
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
                            @if($request->s_address)
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
                            @if($request->d_address)
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
                        {{-- <td>
                            @if(@$request->distance)
                                {{ @$request->distance }} 
                            @else
                                N/A
                            @endif
                        </td> --}}
                        <td>
                            @if($request->provider)
                                <div class='edit'>
                                    {{ @$request->provider->first_name}} 
                                </div>
                                <select class='txtedit' id='provider-{{$index}}'>
                                    <option>N/A</option>
                                    @foreach($totalRiders as $rider)
                                        <option value={{$rider['id']}} <?php if($request->provider==$rider['first_name']){echo 'selected';} ?>>{{$rider['first_name']}}</option>
                                    @endforeach
                                </select>
                                {{--<input type='text' class='txtedit' value="{{@$request->status}}" id='status-{{$index}}'>--}}
                            @else
                                <div class='edit'>
                                N/A
                                </div>
                                <select class='txtedit' id='provider-{{$index}}'>
                                    <option>Select Rider</option>
                                    @foreach($totalRiders as $rider)
                                        <option value={{$rider['id']}} <?php if($request->provider==$rider['first_name']){echo 'selected';} ?>>{{$rider['first_name']}}</option>
                                    @endforeach
                                </select>
                            @endif
                        </td>
                        <td>
                            @if($request->status)
                                <div class='edit'>
                                    @if($request->status=="REJECTED")
                                        @if($request->returned)
                                            RETURNED (Rejected)
                                        @else
                                            TOBERETURNED (Rejected)
                                        @endif
                                    @elseif($request->status=="CANCELLED")
                                        @if($request->returned)
                                            RETURNED (Cancelled)
                                        @else
                                            TOBERETURNED (Cancelled)
                                        @endif
                                    @else
                                        {{ @$request->status}} 
                                    @endif
                                </div>
                                <select class='txtedit' id='status-{{$index}}'>
                                    <option <?php if($request->status=="PENDING"){echo 'selected';} ?>>PENDING</option>
                                    <option <?php if($request->status=="CANCELLED"){echo 'selected';} ?>>CANCELLED</option>
                                    <option <?php if($request->status=="ACCEPTED"){echo 'selected';} ?>>ACCEPTED</option>
                                    <option <?php if($request->status=="PICKEDUP"){echo 'selected';} ?>>PICKEDUP</option>
                                    <option <?php if($request->status=="SORTCENTER"){echo 'selected';} ?>>SORTCENTER</option>
                                    <option <?php if($request->status=="DELIVERING"){echo 'selected';} ?>>DELIVERING</option>
                                    <option <?php if($request->status=="COMPLETED"){echo 'selected';} ?>>COMPLETED</option>
                                    <option <?php if($request->status=="SCHEDULED"){echo 'selected';} ?>>SCHEDULED</option>
                                    <option <?php if($request->status=="REJECTED"){echo 'selected';} ?>>REJECTED</option>
                                    @if($request->status=="REJECTED" || $request->status=="TOBERETURNED" || $request->status=="RETURNED" || $request->status=="CANCELLED")
                                    <option <?php if($request->status=="TOBERETURNED"){echo 'selected';} ?>>TOBERETURNED</option>
                                    <option <?php if($request->status=="RETURNED"){echo 'selected';} ?>>RETURNED</option>
                                    @endif
                                </select>
                                {{--<input type='text' class='txtedit' value="{{@$request->status}}" id='status-{{$index}}'>--}}
                            @else
                                <div class='edit'>
                                N/A
                                </div>
                                <select class='txtedit' id='status-{{$index}}'>
                                    <option <?php if($request->status=="PENDING"){echo 'selected';} ?>>PENDING</option>
                                    <option <?php if($request->status=="CANCELLED"){echo 'selected';} ?>>CANCELLED</option>
                                    <option <?php if($request->status=="ACCEPTED"){echo 'selected';} ?>>ACCEPTED</option>
                                    <option <?php if($request->status=="PICKEDUP"){echo 'selected';} ?>>PICKEDUP</option>
                                    <option <?php if($request->status=="SORTCENTER"){echo 'selected';} ?>>SORTCENTER</option>
                                    <option <?php if($request->status=="DELIVERING"){echo 'selected';} ?>>DELIVERING</option>
                                    <option <?php if($request->status=="COMPLETED"){echo 'selected';} ?>>COMPLETED</option>
                                    <option <?php if($request->status=="SCHEDULED"){echo 'selected';} ?>>SCHEDULED</option>
                                    <option <?php if($request->status=="REJECTED"){echo 'selected';} ?>>REJECTED</option>
                                    @if($request->status=="REJECTED" || $request->status=="TOBERETURNED" || $request->status=="RETURNED" || $request->status=="CANCELLED")
                                    <option <?php if($request->status=="TOBERETURNED"){echo 'selected';} ?>>TOBERETURNED</option>
                                    <option <?php if($request->status=="RETURNED"){echo 'selected';} ?>>RETURNED</option>
                                    @endif
                                </select>
                            @endif
                        </td>
                        {{-- <td>
                            @if($request->amount_customer)
                                <div class='edit'>
                                    {{ @$request->amount_customer}} 
                                </div>
                                <input type='text' class='txtedit' value="{{@$request->amount_customer}}" id='amount_customer-{{$index}}'>
                            @else
                                <div class='edit'>
                                0
                                </div>
                                <input type='text' class='txtedit' value="0" id='amount_customer-{{$index}}'>
                            @endif
                        </td> --}}
                        <td>
                            @if($request->cod)
                                <div class='edit'>
                                    {{ @$request->cod}} 
                                </div>
                                <input type='text' class='txtedit' value="{{@$request->cod}}" id='cod-{{$index}}'>
                            @else
                                <div class='edit'>
                                0
                                </div>
                                <input type='text' class='txtedit' value="0" id='cod-{{$index}}'>
                            @endif{{--
                            @if($request->cod != "")
                            {{ currency($request->cod) }}
                            @else
                                N/A
                            @endif--}}  
                        </td>
                        
                        {{--
                        <td>{{ $request->payment_mode }}</td>
                        <td>
                            @if($request->paid)
                                Paid
                            @else
                                Not Paid
                            @endif
                        </td> --}}
                        
                        <td>
                            @if($request->special_note)
                                <div class='edit'>
                                    {{ @$request->special_note}} 
                                </div>
                                <input type='text' class='txtedit' value="{{@$request->special_note}}" id='special_note-{{$index}}'>
                            @else
                                <div class='edit'>
                                N/A
                                </div>
                                <input type='text' class='txtedit' value="N/A" id='special_note-{{$index}}'>
                            @endif
                        </td>
                        @if(@$request->log->complete_remarks)
                            <td>{{@$request->log->complete_remarks}}</td>    
                        @else
                            <td>{{@$request->log->pickup_remarks}}</td>
                        @endif

                        <td style="position:relative;">
                            <a href="{{ route('dispatcher.order_detail', @$request->id) }}" class="btn btn-success btn-secondary"> <i class="ti-comment"></i> </a>
                            
                            {{-- Count Comment Notification --}}
                            @if(@$request->noComment != '0')
                                <span class="tag tag-danger" style="position:absolute; top:0px;">{{@$request->noComment}}</span>
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
                        <th>Date</th>
                        <th>Last Update</th>
                        <th>User</th>
                        <th>Pickup Add.</th>
                        <th>Pickup Number</th>
                        <th>DropOff Add.</th>
                        <th>DropOff Name</th>
                        <th>DropOff Number</th>
                        <th>Rider</th>
                        <th>Status</th>
                        {{-- <th>Km</th>
                        <th>Fare</th> --}}
                        <th>COD(Rs)</th>
                        <th>Remarks</th>
                        <th>Rider Remarks</th>
                        <th> Action </th>
                    </tr>
                </tfoot>
            </table>
            <div style="display: flex;justify-content: center;"> 
                <b>Load More (Total: {{$requests->total()}})</b>
            </div>
            <div style="display: flex;justify-content: center;"> 
                {{$requests->links('vendor.pagination.bootstrap-4') }}
            </div>
            @else
            <h6 class="no-result">No results found</h6>
            @endif 
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
            
            if(field_name=="provider" && !confirm("Are you sure to assign \""+$("option:selected", this).text()+"\"?")){
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
                url: "{{url('admin/requests')}}/"+req_id[edit_id],
                type: 'put',
                data: field_name+"="+value,
                success:function(response){
                    console.log(response); 
                    if(response.showError){
                        alert(response.error);
                    }
                },
                error: function (request, error) {
                    console.log(request);
                    alert("Error! Please refresh page and check if rider is unset.");
                }
            });
            // console.log($(this).html());
            if(field_name=="status" && value=="CANCELLED"){
                if(!confirm("Add this item to return list?")){
                    $.ajax({
                        url: "{{url('admin/requests')}}/"+req_id[edit_id],
                        type: 'put',
                        data: field_name+"=RETURNED",
                        success:function(response){
                            console.log(response); 
                            if(response.showError){
                                alert(response.error);
                            }
                        },
                        error: function (request, error) {
                            console.log(request);
                            alert("Error! Please refresh page and check if rider is unset.");
                        }
                    });
                }
                else{
                    $.ajax({
                        url: "{{url('dispatcher/requests')}}/"+req_id[edit_id],
                        type: 'put',
                        data: field_name+"=TOBERETURNED",
                        success:function(response){
                            console.log(response); 
                            if(response.showError){
                                alert(response.error);
                            }
                        },
                        error: function (request, error) {
                            console.log(request);
                            alert("Error! Please refresh page and check if rider is unset.");
                        }
                    });
                }
            }
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