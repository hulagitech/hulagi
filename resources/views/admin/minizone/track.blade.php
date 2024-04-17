@extends('admin.layout.base')

@section('title', 'Locations ')

@section('content')

    <div class="content-area py-1">
        <div class="container-fluid">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @elseif (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="box box-block bg-white">
                <form class="form-inline pull-right" method="POST" action={{route('admin.minizone.track')}}>
                    {{csrf_field()}}
                    <div class="form-group">
                        <input type="text" class="form-control" name="searchField" placeholder="Booking ID">
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="zone">
                            @forelse ($zones as $zone)
                                <option value="{{$zone->id}}">{{$zone->zone_name}}</option>
                            @empty
                                <option value="-1">No Zone</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="rider">
                            <option>Select Partner</option>
                            @foreach ($riders as $rider)
                                <option value="{{$rider->id}}">{{$rider->first_name}} {{$rider->last_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="type">
                            <option value="0">Pickup</option>
                            <option value="1">Delivery</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="status">
                            <option>Both</option>
                            <option>COMPLETED</option>
                            <option>REJECTED</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button name="search" class="btn btn-success">Search</button>
                    </div>
                </form>
                <h5 class="mb-1"><span class="s-icon"><i class="ti-zoom-in"></i></span> &nbsp;Track in zone</h5>
                <br/>
                @if(count($requests)>0)
                    <h5>Total Count: {{count($requests)}}</h5>
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
                                <th>Km</th>
                                <th>Rider</th>
                                <th>Status</th>
                                <th>Fare</th>
                                <th>COD(Rs)</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($requests as $index => $request)
                            <tr>
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
                                    {{$oldQuery['type']=="0"?"Pickup":"Delivery"}}
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
                                <th>Km</th>
                                <th>Rider</th>
                                <th>Status</th>
                                <th>Fare</th>
                                <th>COD(Rs)</th>
                                <th>Type</th>
                            </tr>
                        </tfoot>
                    </table>
                @elseif($requests)
                    No Orders Found
                @endif
            </div>
            
        </div>
    </div>
@endsection