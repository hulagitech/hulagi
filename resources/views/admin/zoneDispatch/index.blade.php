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
                        <th>Dispatch</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
               <script> var req_id=[];</script>
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
                            @if($request->special_note)
                                {{ @$request->special_note}} 
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            <input type="checkbox" class="form-control dispatch" id="{{$request->id}}">
                        </td>
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
                        <th>Last Update</th>
                        <th>User</th>
                        <th>Pickup Add.</th>
                        <th>Pickup Number</th>
                        <th>DropOff Add.</th>
                        <th>DropOff Name</th>
                        <th>DropOff Number</th>
                        <th>Vendor Remarks</th>
                        <th>Dispatch</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
            <button class="btn btn-primary dispatch-button">Dispatch</button>
            @else
            <h6 class="no-result">No results found</h6>
            @endif 
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    var id=[];
    var index=0;
    $('.dispatch').on("change",function(){
        // if($(this).attr('checked'))
        if($(this).is(':checked')){
            id[index]=$(this).attr('id');
            index++;
            // console.log(id);
        }
        else{
            var remove=id.indexOf($(this).attr('id'));
            if(remove>-1){
                id.splice(remove,1);
                // console.log(id);
                index--;
            }
        }
    })
    $('.dispatch-button').click(function(){
        if(id.length<=0){
            return;
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/zonedispatch')}}",
            type: 'post',
            data: {id:id},
            success:function(response){
                console.log(response); 
                if(response.showError){
                    location.reload();
                    // alert(response.error);
                }
            },
            error: function (request, error) {
                console.log(request);
                alert("Error"+error);
            }
        });
    })
</script>
@endsection