@extends('pickup.layout.base')

@section('title', 'Order History')

@section('content')
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <h5 class="mb-1"> <i class="fa fa-recycle"></i> Order History</h5>
            <br>
            <!-- <h5 class="mb-1"></h5><span class="s-icon"><i class="ti-user"></i></span>&nbsp;Users Info</h5> -->
            
            {{-- @if(isset($type))
                @if($type == "user")
                    <form class="form-inline pull-right" method="POST" action={{url('admin/userdetailSearch/'.$id)}}>
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
                            <button name="search"  class="btn btn-success">Search</button>
                        </div>
                    </form>
                @elseif($type == "rider")
                    <form class="form-inline pull-right" method="POST" action={{url('admin/riderdetailSearch/'.$id)}}>
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
                            <button name="search"  class="btn btn-success">Search</button>
                        </div>
                    </form>                   
                @endif
                <br>
                <hr/>
            @endif --}}

            {{-- @if(isset($dates))
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
            @endif --}}

            @if(count($requests) != 0)
            <table class="table table-striped table-bordered dataTable" id="table-20" style="width:100%;">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>ID</th>
                        <th>Last Update</th>
                        <th>User</th>
                        <th>Pickup Add.</th>
                        <th>Pickup Number</th>
                        <th>DropOff Add.</th>
                        <th>DropOff Name</th>
                        <th>DropOff Number</th>
                        <th>Km</th>
                        <th>Rider</th>
                        <th>Status</th>
                        <th>Fare</th>
                        <th>COD(Rs)</th>
                        <th>Remarks</th>
                        
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
                            @if($request->updated_at)
                                <span class="text-muted">{{$request->updated_at}}</span>
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
                                {{ @$request->status}} 
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            {{-- @if($request->payment != "")
                            {{ currency($request->payment->total) }} --}}
                            @if($request->amount_customer)
                                {{ @$request->amount_customer}} 
                            @else
                                0
                            @endif
                        </td>
                        <td>
                            @if($request->cod)
                                {{ @$request->cod}} 
                            @else
                                0
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
                            @if($request->special_note)
                                {{ @$request->special_note}} 
                            @else
                                N/A
                            @endif
                        </td>
                       
                       
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-secondary btn-rounded btn-black waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Action
                                </button>
                                <div class="dropdown-menu">
                                    <a href="{{ route('pickup.order_details', $request->id) }}" class="dropdown-item">
                                        <i class="fa fa-search"></i> More Details
                                    </a>
                                   {{--<a href="{{ url('/admin/requests/'.$request->id.'/logs') }}" class="dropdown-item">
                                        <i class="fa fa-search"></i> Logs
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
                        <th>Last Update</th>
                        <th>User</th>
                        <th>Pickup Add.</th>
                        <th>Pickup Number</th>
                        <th>DropOff Add.</th>
                        <th>DropOff Name</th>
                        <th>DropOff Number</th>
                        <th>Km</th>
                        <th>Rider</th>
                        <th>Status</th>
                        <th>Fare</th>
                        <th>COD(Rs)</th>
                        <th>Remarks</th>
                        
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
@endsection