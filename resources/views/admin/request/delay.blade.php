@extends('admin.layout.master')

@section('title', 'Order History')

@section('content')
<style>
    .txtedit{
        display: none;
        width: 99%;
        height: 30px;
    }

    #weight{
        display: none;
    }
</style>
<div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h4 class="page-title m-0">Delay Order </h4>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end">
                            <form class="form-inline pull-right" method="POST" action={{url('admin/delaySearch')}}>
                {{csrf_field()}}
                {{-- <div class="form-group">
                    <input type="text" class="form-control" name="searchField" placeholder="Full Search">
                </div> --}}
                <div class="form-group">
                    <select class="form-control" name="zone">
                        <option>All</option>
                        @foreach ($zones as $zone)
                            <option value="{{$zone->id}}" {{(request()->zone && request()->zone==$zone->id)? "selected": ""}}>{{$zone->zone_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control" name="status">
                        <option {{(request()->status && request()->status=="Delayed")? "selected": ""}}>Delayed</option>
                        <option {{(request()->status && request()->status=="Extremely Delayed")? "selected": ""}}>Extremely Delayed</option>
                    </select>
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
              
              @if(count($requests) != 0)
             <table id="datatable-buttons" class="table table-bordered"
                        								style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Last Update</th>
                        <th>User</th>
                        <th>Pickup Add.</th>
                        <th>Pickup No.</th>
                        <th>DropOff Add.</th>
                        <th>DropOff Name</th>
                        <th>DropOff No.</th>
                        <th>Km</th>
                        <th>Rider</th>
                        <th>Status</th>
                        <th style="width:4%;">Kg</th>
                        <th>Fare</th>
                        <th>COD(Rs)</th>
                        <th>Remarks</th>
                        <th>Rider Remarks</th>
                        <th>Action</th>
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
                        <td>
                            @if(@$request->distance)
                                {{ @$request->distance }} 
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if($request->provider)
                                {{ @$request->provider->first_name}} 
                            @else
                                N/A
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
                                    @elseif($request->status=="SORTCENTER")
                                        {{ @$request->status}} 
                                        @if($request->dispatched)
                                            ({{ @$request->zone_2->zone_name }})
                                        @else
                                            ({{ @$request->zone_1->zone_name }})
                                        @endif
                                    @else
                                        {{ @$request->status}} 
                                    @endif
                                </div>
                                <select class='txtedit' id='status-{{$index}}'>
                                    <option <?php if($request->status=="PENDING"){echo 'selected';} ?>>PENDING</option>
                                    <option <?php if($request->status=="CANCELLED"){echo 'selected';} ?>>CANCELLED</option>
                                    <option <?php if($request->status=="ACCEPTED"){echo 'selected';} ?>>ACCEPTED</option>
                                    <option <?php if($request->status=="ASSIGNED"){echo 'selected';} ?>>ASSIGNED</option>
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
                                    <option <?php if($request->status=="ASSIGNED"){echo 'selected';} ?>>ASSIGNED</option>
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
                        <td style="width:4%;">
                            @if($request->weight)
                                <div class='edit'>
                                    {{ @$request->weight}} 
                                </div>
                                <input type='text' class='txtedit' value="{{@$request->weight}}" id='weight-{{$index}}'>
                            @else
                                <div class='edit'>
                                0
                                </div>
                                <input type='text' class='txtedit' value="0" id='weight-{{$index}}'>
                            @endif
                        </td>
                        {{--<td>
                            {{@$request->fare}}
                        </td>--}}
                        <td>
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
                        </td>
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
                            @endif 
                        </td>
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
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-secondary btn-rounded btn-black waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Action
                                </button>
                                <div class="dropdown-menu">
                                    <a href="{{ route('admin.requests.show', $request->id) }}" class="dropdown-item">
                                        <i class="fa fa-search"></i> More Details
                                    </a>
                                    {{--<a href="{{ route('admin.requests.edit', $request->id) }}" class="dropdown-item">
                                    <i class="fa fa-pencil"></i>  Edit
                                    </a>--}}
                                    {{--<form action="{{ route('admin.requests.destroy', $request->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="dropdown-item">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </form>--}}
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
                        <th>Date</th>
                        <th>Last Update</th>
                        <th>User</th>
                        <th>Pickup Add.</th>
                        <th>Pickup No.</th>
                        <th>DropOff Add.</th>
                        <th>DropOff Name</th>
                        <th>DropOff No.</th>
                        <th>Km</th>
                        <th>Rider</th>
                        <th>Status</th>
                        <th>Kg</th>
                        <th>Fare</th>
                        <th>COD(Rs)</th>
                        <th>Remarks</th>
                        <th>Rider Remarks</th>
                        <th>Action</th>
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
    </div>
</div>




<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
{{--<meta name="csrf-token" content="{{ csrf_token() }}">--}}

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
                        url: "{{url('admin/requests')}}/"+req_id[edit_id],
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
<script>
    var ajax_call = function() {
        $.ajax({
          url: 'searchingajax',
          type: 'get',
          success: function(data){
          }
        });
        $.ajax({
          url: 'ajaxforofflineprovider',
          type: 'get',
          success: function(data){
              //alert(data);
          }
        });
        //your jQuery ajax code
    };
    var interval = 1000 * 60 * 1; // where X is your every X minutes
    setInterval(ajax_call, interval);
</script>

@endsection
@section('scripts')

    @include('user.layout.partials.datatable')

@endsection