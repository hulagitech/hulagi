@extends('return.layout.master')

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
                    <div class="col-md-12">
                        <br>
                        <h5 class="mb-1"> <i class="fa fa-recycle"></i> Outside Valley Order History</h5>
                    </div>
                </div>
            </div> 
        </div>
</div>
    
            <hr/>
<div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
                    @if (count($Order) > 0)
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
                            @foreach($Order as $index => $request)
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
                                            {{--<div class="dropdown-menu">
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
                        @else
                        <h6 class="no-result">No results found</h6>
                        @endif 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
