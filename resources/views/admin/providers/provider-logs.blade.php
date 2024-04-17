@extends('admin.layout.master')

@section('title', 'Drivers')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-1">
                        <i class="fas fa-user"></i> &nbsp;Rider Logs
                    </h5>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-4 col-md-6 col-xs-12">
        <div class="card bg-primary mini-stat text-white">
            <div class="p-3 mini-stat-desc">
                <div class="clearfix">
                    <h6 class="text-uppercase mt-0 float-left text-white-50">Total Order</h6>
                    <h4 class="mb-3 mt-0 float-right">{{ count($totalLog) }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-xs-12">
        <div class="card bg-success mini-stat text-white">
            <div class="p-3 mini-stat-desc">
                <div class="clearfix">
                    <h6 class="text-uppercase mt-0 float-left text-white-50">Processimg Orders</h6>
                    <h4 class="mb-3 mt-0 float-right">{{ $process }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-xs-12">
        <div class="card bg-info mini-stat text-white">
            <div class="p-3 mini-stat-desc">
                <div class="clearfix">
                    <h6 class="text-uppercase mt-0 float-left text-white-50">Completed Order</h6>
                    <h4 class="mb-3 mt-0 float-right">{{ $completed }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-xs-12">
        <div class="card bg-info mini-stat text-white">
            <div class="p-3 mini-stat-desc">
                <div class="clearfix">
                    <h6 class="text-uppercase mt-0 float-left text-white-50">Scheduled Orders</h6>
                    <h4 class="mb-3 mt-0 float-right">{{ $scheduled }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-xs-12">
        <div class="card bg-pink mini-stat text-white">
            <div class="p-3 mini-stat-desc">
                <div class="clearfix">
                    <h6 class="text-uppercase mt-0 float-left text-white-50">Returnd Order</h6>
                    <h4 class="mb-3 mt-0 float-right">{{ $returnOrder }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-xs-12">
        <div class="card bg-primary mini-stat text-white">
            <div class="p-3 mini-stat-desc">
                <div class="clearfix">
                    <h6 class="text-uppercase mt-0 float-left text-white-50">Return Remaning</h6>
                    <h4 class="mb-3 mt-0 float-right">{{ $returnRemaining }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-xs-12">
        <div class="card bg-danger mini-stat text-white">
            <div class="p-3 mini-stat-desc">
                <div class="clearfix">
                    <h6 class="text-uppercase mt-0 float-left text-white-50">Payment Remaning</h6>
                    <h4 class="mb-3 mt-0 float-right">{{ $totalPayable->payable }}</h4>
                </div>
            </div>
        </div>
    </div>
    
</div>



{{-- <div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body table-responsive">
                @if (count($totalLog) > 0)
                <table id="datatable" class="table table-bordered"
    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>Pickup Date</th>
                <th>User</th>
                <th>Pickup Add.</th>
                <th>Pickup Number</th>
                <th>Pickup Rider</th>
                <th>Pickup Remarks</th>
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
                    <input type="checkbox" class="payment_received" name="payment_received-{{$log->id}}"
                        {{$log->payment_received? "checked":""}}>
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
                @else
                <h6 class="no-result">No results found</h6>
                @endif
            </div>
        </div>
    </div>
</div>
        
        @section('scripts')
        
        @include('user.layout.partials.datatable')
        
        @endsection --}}
       
     
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