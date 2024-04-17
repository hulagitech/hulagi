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
    .switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 34px;
    }
    
    .switch input { 
      opacity: 0;
      width: 0;
      height: 0;
    }
    
    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }
    
    .slider:before {
      position: absolute;
      content: "";
      height: 26px;
      width: 26px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }
    
    input:checked + .slider {
      background-color: #2196F3;
    }
    
    input:focus + .slider {
      box-shadow: 0 0 1px #2196F3;
    }
    
    input:checked + .slider:before {
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(26px);
    }
    
    /* Rounded sliders */
    .slider.round {
      border-radius: 34px;
    }
    
    .slider.round:before {
      border-radius: 50%;
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
                        @if(isset($dates))
                            <form class="form-inline pull-right" method="POST" action={{url('admin/outsidevalley')}}>
                                {{csrf_field()}}
                                <!-- <div class="form-group">
                                    <input type="text" class="form-control" name="searchField" placeholder="Full Search">
                                </div> -->
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
                                        <option {{(request()->status && request()->status=="ASSIGNED")? "selected": ""}}>ASSIGNED</option>
                                        <option {{(request()->status && request()->status=="CANCELLED")? "selected": ""}}>CANCELLED</option>
                                        <option {{(request()->status && request()->status=="DELIVERING")? "selected": ""}}>DELIVERING</option>
                                        <option {{(request()->status && request()->status=="DISPATCHED")? "selected": ""}}>DISPATCHED</option>
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
            <table id="datatable" class="table table-bordered"
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
                        <th>Cargo</th>
                        <th style="width:4%;">Kg</th>
                        <th>Fare</th>
                        <th>COD(Rs)</th>
                        <th>Remarks</th>
                        <th>Rider Remarks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
              
                @foreach($requests as $index => $request)
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
                            @else
                                N/A
                               
                            @endif
                        </td>

                        <td style="width:4%;">
                            @if($request->cargo)
                                <label class="switch" >
                                    <input type="checkbox" class="cargo" @if(isset($request->cargo)) @if(@$request->cargo=='1') checked @endif @endif id='cargo-{{$index}}' disabled>
                                    <span class="slider round"></span>
                                </label>
                            @else
                                <label class="switch">
                                    <input type="checkbox" value="{{$request->cargo}}" class="cargo" id='cargo-{{$request->id}}' disabled>
                                    <span class="slider round"></span>
                                </label>
                            @endif
                        </td>

                        <td style="width:4%;">
                            @if(@$request->item->weight)
                                
                                    {{ @$request->weight}} 
                                
                            @else
                                
                                0
                               
                            @endif
                        </td>
                        {{--<td>
                            {{@$request->fare}}
                        </td>--}}
                       
                        <td>
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
                                
                            @endif 
                        </td>
                        <td>
                            @if($request->special_note)

                                    {{ @$request->special_note}} 
                               
                            @else
                               
                                N/A
                                
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
                                    <a href="{{ url('/admin/requests/'.$request->id.'/logs') }}" class="dropdown-item">
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
                        <th>Cargo</th>
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
@endsection
@section('scripts')

    @include('user.layout.partials.datatable')

@endsection
