@extends('account.layout.master')

@section('title', 'Order History')

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
                        <h4 class="page-title m-0">Order History</h4>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end">
                   @if(isset($type))
                @if($type == "user_statement")
                    <form class="form-inline pull-right" method="POST" action="{{url('account/userStatementDetailSearch/'.$id)}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="from_date" style="padding-top:5px;"> From: <label>
                            <input type="date" class="form-control" name="from_date">
                        </div>
                        <div class="form-group">
                            <label for="to_date" style="padding-top:5px;"> To: <label>
                            <input type="date" class="form-control" name="to_date">
                        </div>
                        <div class="form-group">
                        <div class="form-group">
                        <select class="form-control" name="status">
                            <option {{(request()->status && request()->status=="All")? "selected": ""}}>All</option>
                            <option {{(request()->status && request()->status=="INSIDEVALLEY")? "selected": ""}}>INSIDEVALLEY</option>
                            <option {{(request()->status && request()->status=="OUTSIDEVALLEY")? "selected": ""}}>OUTSIDEVALLEY</option>
                        </select>
                        </div>
                    </div>
                        <div class="form-group">
                            <button name="search"  class="btn btn-success">Search</button>
                        </div>
                </form>
                @endif
                <br>
            @endif
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
                        <th>Last Update</th>
                        <th>ID</th>
                        <th>User</th>
                        <th>Pickup Number</th>
                        <th>DropOff Add.</th>
                        <th>DropOff Name</th>
                        <th>DropOff Number</th>
                        <th>Driver</th>
                        <th>Status</th>
                        <th>Weight</th>
                        <th>COD(Rs)</th>
                        <th>Fare</th>
                        <th>Remarks</th>
                        <th>Payment Collected</th>
                        <th>Payment Done</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
               <script> var req_id=[];</script>
                @foreach($requests as $index => $request)
                <script> req_id.push(<?php echo $request->id; ?>);</script>
                    <tr id="dataRow{{$index}}" >
                        <td>
                            @if($request->created_at)
                                <span class="text-muted">{{$request->created_at}}</span>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($request->updated_at)
                                <span class="text-muted">{{$request->updated_at}}</span>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $request->booking_id }}</td>
                        <td>
                            @if(@$request->user)
                                {{ @$request->user->first_name }} 
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
                            @if($request->provider)
                                {{ @$request->provider->first_name}} 
                            @else
                                N/A
                            @endif
                        </td>                      
                        <td>
                            @if($request->status)
                                    @if($request->status=="REJECTED")
                                        @if($request->returned)
                                            RETURNED (Rejected
                                        @elseif($request->returned_to_hub == 1 && $request->returned == 0)
                                            R.WAREHOUSE
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
                                    @endif
                           
                        </td>
                        <td>{{$request->weight}}</td>
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
                        </td>{{--
                        <td>{{ $request->payment_mode }}</td>
                        <td>
                            @if($request->paid)
                                Paid
                            @else
                                Not Paid
                            @endif
                        </td> --}}
                        <td>
                            @if($request->amount_customer)
                                {{ @$request->amount_customer}} 
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if($request->special_note)
                                {{ @$request->special_note}} 
                            @else
                                N/A
                            @endif
                        </td>
                       
                        @if(@$request->log->payment_received)
                        @if(@$request->log->payment_received)
                        <td><i class="fa fa-check text-success"></i></td>
                            @endif
                        @else
                        <td><i class="fa fa-times-circle text-danger"></i></td>
                            
                        @endif
                        @if(@$request->paid==1)
                        <td><i class="fa fa-check text-success"></i></td>    
                        @else
                        <td><i class="fa fa-times-circle text-danger"></i></td> 
                        @endif
                       
                       
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-secondary btn-rounded btn-black waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Action
                                </button>
                                <div class="dropdown-menu">
                                    <a href="{{ route('account.order_details', $request->id) }}" class="dropdown-item">
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
                        <th>Last Update</th>
                        <th>ID</th>
                        <th>User</th>
                        <th>Pickup Number</th>
                        <th>DropOff Add.</th>
                        <th>DropOff Name</th>
                        <th>DropOff Number</th>
                        <th>Driver</th>
                        <th>Status</th>
                        <th>Weight</th>
                        <th>COD(Rs)</th>
                        <th>Fare</th>
                        <th>Remarks</th>
                        
                        <th>Payment Collected</th>
                        <th>Payment Done</th>
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
                url: "{{url('account/requests')}}/"+req_id[edit_id],
                type: 'put',
                data: field_name+"="+value,
                success:function(response){
                    console.log(response); 
                },
                error: function (request, error) {
                    console.log(request);
                    console.log(error);
                    alert(" Can't do!! Error"+error);
                }
            });
            // console.log($(this).html());
        
        });

    });
</script>
@endsection
@section('scripts')

    @include('user.layout.partials.datatable')

@endsection
