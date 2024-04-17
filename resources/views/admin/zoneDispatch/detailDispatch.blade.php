@extends('admin.layout.base')

@section('title', 'Order History')

@section('content')
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <h5 class="mb-1"> <i class="fa fa-recycle"></i> Order History</h5>
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
                        <th>Pickup Number</th>
                        <th>DropOff Add.</th>
                        <th>DropOff Name</th>
                        <th>DropOff Number</th>
                        <th>Vendor Remarks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
               <script> var req_id=[];</script>
                @foreach($requests as $index => $request)
                    <tr id="dataRow{{$index}}">
                        <td>
                            @if($request->request->created_at)
                                <span class="text-muted">{{$request->request->created_at}}</span>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $request->request->booking_id }}</td>
                        <td>
                            @if($request->request->updated_at)
                                <span class="text-muted">{{$request->request->updated_at}}</span>
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
                            @if($request->request->s_address)
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
                            @if($request->request->d_address)
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
                            @if($request->request->special_note)
                                {{ @$request->request->special_note}} 
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
                                    {{-- <a href="{{ route('admin.request.show', $request->id) }}" class="dropdown-item">
                                        <i class="fa fa-search"></i> More Details
                                    </a> --}}
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
                        <th>Vendor Remarks</th>
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