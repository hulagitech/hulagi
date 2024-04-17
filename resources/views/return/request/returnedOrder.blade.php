@extends('return.layout.master')

@section('title', 'Inbound Orders')

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
                    <div class="col-md-12">
                        <h5 class="mb-1"> <i class="fa fa-recycle"></i> Returned Order </h5>
                    </div>
                </div>
            </div>
        </div>
</div>        
<div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
                    @if (count($return_orders) > 0)
                        <table id="datatable" class="table table-bordered"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>User</th>
                            <th>Pickup Add.</th>
                            <th>Pickup No.</th>
                            <th>Return Rider</th>
                            <th>No. Of Orders</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($return_orders as $index => $return_order)
                            <tr id="dataRow{{$index}}">
                                <td>
                                    @if($return_order->updated_at)
                                        <span class="text-muted">{{$return_order->updated_at->format('Y-m-d')}}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($return_order->user->first_name)
                                        {{ @$return_order->user->first_name }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if($return_order->s_address)
                                        {{ @$return_order->s_address }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$return_order->user->mobile)
                                        {{ @$return_order->user->mobile }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$return_order->returnRider->first_name)
                                        {{ @$return_order->returnRider->first_name }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$return_order->count)
                                        {{ @$return_order->count }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    <div style="display:flex;">
                                        <a href="#" class="complete btn btn-success" name="status-{{$return_order->user_id}}">Completed</a>
                                        <span style="color: orange; display:none;" class="checkinbound"><i class="fa fa-check"></i></span>
                                        &nbsp;
                                        <a href="#"  name="incomplete-{{$return_order->user_id}}" class="btn btn-danger incomplete">Incompleted</a>
                                        <span style="color: orange; display:none;" class="checkinbound1"><i class="fa fa-check"></i></span>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Date</th>
                            <th>User</th>
                            <th>Pickup Add.</th>
                            <th>Pickup No.</th>
                            <th>Return Rider</th>
                            <th>No. Of Orders</th>
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
<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
        $(document).ready(function(){
            $(".complete").click(function(){
                if(confirm('Are you sure, order returned successfully ?')){ 
                    $(this).hide();
                    $(this).next(".checkinbound").show();
                    var id = this.name;
                    var split_data = id.split("-");
                    //var req_field = split_data[0];
                    var req_id = split_data[1];
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    
                    $.ajax({
                        url: "{{url('return/returnCompleted')}}/"+req_id,
                        type: 'post',
                        success:function(response){
                            console.log(response);
                        },
                        error: function (request, error) {
                            console.log(request);
                            alert(" Can't do!! Error"+error);
                        }
                    });               
                }else{
                    console.log('cancel');
                }
            });
        });
        $(document).ready(function(){
            $(".incomplete").click(function(){
                if(confirm('Are you sure, order returned unsuccessful ?')){ 
                    $(this).hide();
                    $(this).next(".checkinbound1").show();
                    var id = this.name;
                    var split_data = id.split("-");
                    var req_id = split_data[1];
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    
                    $.ajax({
                        url: "{{url('return/returnInCompleted')}}/"+req_id,
                        type: 'post',
                        success:function(response){
                            console.log(response);
                        },
                        error: function (request, error) {
                            console.log(request);
                            alert(" Can't do!! Error"+error);
                        }
                    });               
                }else{
                    console.log('cancel');
                }
            });
        });
</script>
@endsection
