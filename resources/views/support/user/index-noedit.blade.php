@extends('support.layout.master')

@section('title', 'Order History')

@section('content')
<div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h4 class="page-title m-0">Order History</h4>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end">
                      
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
                                    <a href="{{ route('support.order_details', $request->id) }}" class="dropdown-item">
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
</div>
@endsection
@section('scripts')

    @include('user.layout.partials.datatable')

@endsection