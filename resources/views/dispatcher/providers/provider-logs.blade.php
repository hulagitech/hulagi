@extends('dispatcher.layout.base')

@section('title', 'Drivers')

@section('content')
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="row row-md">
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="box box-block bg-success mb-2 btn-secondary">
                <div class="t-content">
                    <h5 class="text-uppercase mb-1">Total Orders (Today)</h5>
                    <h5 class="mb-1">{{$countToday}}</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="box box-block bg-warning mb-2 btn-secondary">
                <div class="t-content">
                    <h5 class="text-uppercase mb-1">Pickedup Orders</h5>
                    {{-- <h5 class="mb-1">{{$pickedup}}</h5> --}}
                </div>
            </div>
        </div> 
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="box box-block bg-primary mb-2 btn-secondary">
                <div class="t-content">
                    <h5 class="text-uppercase mb-1">Completed Orders</h5>
                    {{-- <h5 class="mb-1">{{$completed}}</h5> --}}
                </div>
            </div>
        </div>   
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="box box-block bg-primary mb-2 btn-secondary">
                <div class="t-content">
                    <h5 class="text-uppercase mb-1">Rejected Orders</h5>
                    <h5 class="mb-1">{{$rejected}}</h5>
                </div>
            </div>
        </div>   
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="box box-block bg-primary mb-2 btn-secondary">
                <div class="t-content">
                    <h5 class="text-uppercase mb-1">Scheduled Orders</h5>
                    <h5 class="mb-1">{{$scheduled}}</h5>
                </div>
            </div>
        </div>     
    </div>
        <div class="box box-block bg-white">
            <h5 class="mb-1"><span class="s-icon"><i class="ti-infinite"></i></span>&nbsp; Rider Logs</h5>
            <hr/>
            <table class="table table-striped table-bordered dataTable" id="table-2" style="width:100%;">
                <thead>
                    <tr>
                        <th>Pickup Date</th>
                        <th>User</th>
                        <th>Pickup Add.</th>
                        <th>Pickup Number</th>
                        <th>Pickup Rider</th>
                        <th>Pickup Remarks</th>
                        {{-- <th>Completed Date</th> --}}
                        <th>DropOff Add.</th>
                        <th>DropOff Name</th>
                        <th>DropOff Number</th>
                        <th>DropOff Rider</th>
                        <th>DropOff Remarks</th>
                        <th>COD</th>
                        <th>Fare</th>
                        <th>Status</th>
                        <th>Payment Received</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($logs as $index => $log)
                    <tr>
                        <td>{{@$log->created_at}}</td>
                        <td>{{ @$log->request->user->first_name }}</td>
                        <td>{{ @$log->request->s_address }}</td>
                        <td>{{ @$log->request->user->mobile }}</td>
                        <td>{{ @$log->pickup->first_name }}</td>
                        <td>{{ @$log->pickup_remarks }}</td>
                        {{-- <td>{{ $log->updated_at }}</td> --}}
                        <td>{{ @$log->request->d_address }}</td>
                        <td>{{ @$log->request->item->rec_name }}</td>
                        <td>{{ @$log->request->item->rec_mobile }}</td>
                        <td>
                            @if(@$log->complete_id)
                                {{ @$log->complete->first_name}} 
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if(@$log->complete_remarks)
                                {{ @$log->complete_remarks}} 
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if(@$log->request)
                                {{$log->request->cod}}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if(@$log->request)
                                {{$log->request->amount_customer}}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{@$log->request->status}}</td>
                        <td>
                            @if($role=="account")
                                <input type="checkbox" class="payment_received" name="payment_received-{{$log->id}}" {{$log->payment_received? "checked":""}}>
                            @else
                                {{$log->payment_received? "Yes":"No"}}
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Picked Date</th>
                        <th>User</th>
                        <th>Pickup Add.</th>
                        <th>Pickup Number</th>
                        <th>Pickup Rider</th>
                        <th>Pickup Remarks</th>
                        {{-- <th>Completed Date</th> --}}
                        <th>DropOff Add.</th>
                        <th>DropOff Name</th>
                        <th>DropOff Number</th>
                        <th>DropOff Rider</th>
                        <th>DropOff Remarks</th>
                        <th>COD</th>
                        <th>Fare</th>
                        <th>Status</th>
                        <th>Payment Received</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    $(document).ready(function(){
        $(".payment_received").change(function(){
            var id = this.name;
            var split_id = id.split("-");
            var field_name = split_id[0];
            var edit_id = split_id[1];
            var value=false;
            if(this.checked){
                value=true;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                // url: "{{url($role.'/provider/log')}}/"+edit_id,
                url: "{{url('account/provider/log')}}/"+edit_id,
                type: 'post',
                data: field_name+"="+value,
                success:function(response){
                    console.log(response); 
                },
                error: function (request, error) {
                    console.log(request);
                    alert(" Can't do!! Error"+error);
                }
            });
        })
    });
</script>
@endsection