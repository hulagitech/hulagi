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
                        <h5 class="mb-1"> <i class="fa fa-recycle"></i> Orders "To Be Return" </h5>
                        {{-- <div style="display: flex;">
                            <form class="form-inline pull-right" method="POST" action={{url('return/dateSearch')}}>
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
                @if (count($return_orders) > 0)
                    <table id="datatable-buttons" class="table table-bordered"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                       
                        <tr>
                            <th>S.N</th>
                            <th>ID</th>
                            <th>User</th>
                            <th>DropOff Name</th>
                            <th>DropOff No.</th>
                        </tr>
                    </thead>
                    <tbody>
                      
                        @foreach($return_orders as $index => $return_order)
                            <tr id="dataRow{{$index}}">
                                <td>
                                   {{$loop->iteration}}
                                </td>
                                <td>{{ $return_order->booking_id }}</td>
                                <td>
                                    @if(@$return_order->user)
                                        {{ @$return_order->user->first_name }} 
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
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>S.N</th>
                            <th>ID</th>
                            <th>User</th>
                            <th>DropOff Name</th>
                            <th>DropOff No.</th>
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

<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
        $(document).ready(function(){
            $(".returntohub").click(function(){
                //if(confirm('Are you sure, you want to Inbound ?')){ 
                    $(this).hide();
                    $(this).next(".checkinhub").show();
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
                        url: "{{url('return/order_inhub')}}/"+req_id,
                        type: 'post',
                        success:function(response){
                            console.log(response);
                        },
                        error: function (request, error) {
                            console.log(request);
                            alert(" Can't do!! Error"+error);
                        }
                    });               
                // }else{
                //     console.log('cancel');
                // }
            });
        });
    
</script>


@endsection

@section('scripts')

@include('user.layout.partials.datatable')

@endsection
