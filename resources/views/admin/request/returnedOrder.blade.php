@extends('admin.layout.base')

@section('title', 'Inbound Orders')

@section('content')
<style>
    .txtedit{
        display: none;
        width: 99%;
        height: 30px;
    }
</style>
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <h5 class="mb-1"> <i class="fa fa-recycle"></i> Returned Order </h5>
            {{-- <div style="display: flex;">
                <form class="form-inline pull-right" method="POST" action={{url('admin/dateSearch')}}>
                    {{csrf_field()}}
                    <div class="form-group">
                        <input type="text" class="form-control" name="searchField" placeholder="Full Search">
                    </div>
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
                            <option {{(request()->status && request()->status=="ACCEPTED")? "selected": ""}}>ACCEPTED</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button name="search" class="btn btn-success">Search</button>
                    </div>
                </form>
            </div> --}}
            
            <hr/>
            

            @if(count($return_orders) != 0)
                <table class="table table-striped table-bordered dataTable" id="table-2" style="width:100%;">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>ID</th>
                            <th>User</th>
                            <th>Pickup Add.</th>
                            <th>Pickup No.</th>
                            <th>DropOff Add.</th>
                            <th>DropOff Name</th>
                            <th>DropOff No.</th>
                            <th>Rider</th>
                            <th>Return Rider</th>
                            <th>Status</th>
                            {{-- <th>COD(Rs)</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach(@$return_orders as $index => $return_order)
                            <tr id="dataRow{{$index}}">
                                <td>
                                    @if(@$return_order->created_at)
                                        <span class="text-muted">{{$return_order->created_at->format('Y-m-d')}}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ @$return_order->booking_id }}</td>
                                <td>
                                    @if(@$return_order->user)
                                        {{ @$return_order->user->first_name }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$return_order->s_address)
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
                                    @if(@$return_order->d_address)
                                        {{ @$return_order->d_address }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$return_order->item->rec_name)
                                        {{ @$return_order->item->rec_name}} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$return_order->item->rec_mobile)
                                        {{ @$return_order->item->rec_mobile }} 
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(@$return_order->provider->first_name)
                                        {{ @$return_order->provider->first_name }} 
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
                                    @if(@$return_order->status)
                                        {{ @$return_order->status }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                {{-- <td>
                                    @if($return_order->cod)
                                        {{ @$return_order->cod}}
                                    @else
                                        -
                                    @endif 
                                </td> --}}

                                <td>
                                    <div style="display:flex;">
                                        <a href="#" class="btn btn-primary"> <i class="fa fa-eye"></i> </a>
                                        {{-- <a href="#" class="allinbound btn btn-warning" name="status-{{$return_order->id}}">Back to Vendor</a>
                                        <span style="color: orange; display:none;" class="checkinbound"><i class="fa fa-check"></i></span>
                                        &nbsp;
                                        <a href="{{url('admin/printInvoice/'.$return_order->id)}}" target="_blank" class="btn btn-primary">Returned</a> --}}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Date</th>
                            <th>ID</th>
                            <th>User</th>
                            <th>Pickup Add.</th>
                            <th>Pickup No.</th>
                            <th>DropOff Add.</th>
                            <th>DropOff Name</th>
                            <th>DropOff No.</th>
                            <th>Rider</th>
                            <th>Return Rider</th>
                            <th>Status</th>
                            {{-- <th>COD(Rs)</th> --}}
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


<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
        $(document).ready(function(){
            $(".allinbound").click(function(){
                if(confirm('Are you sure, you want to Inbound ?')){ 
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
                        url: "{{url('admin/inbound_order')}}/"+req_id,
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

