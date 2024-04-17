@extends('account.layout.master')

@section('title', 'Drivers')

@section('content')
<style>
    .switch {
        display: inline-block;
        height: 34px;
        position: relative;
        width: 60px;
    }

    .switch input {
        display: none;
    }

    .slider {
        background-color: #ccc;
        bottom: 0;
        cursor: pointer;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        transition: .4s;
    }

    .slider:before {
        background-color: #fff;
        bottom: 4px;
        content: "";
        height: 26px;
        left: 4px;
        position: absolute;
        transition: .4s;
        width: 26px;
    }

    input:checked+.slider {
        background-color: #66bb6a;
    }

    input:checked+.slider:before {
        transform: translateX(26px);
    }

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
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Provider Log</h4>
                    </div>
                </div>

            </div>
        </div>
    </div>
<div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Total Orders(Today)</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $countToday }}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-info"></span><span class="ml-2">
                            </span>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-info mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Processing Order</h6>
                        <h4 class="mb-3 mt-0 float-right">{{$process}}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-danger"></span><span class="ml-2"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-pink mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Scheduled Order</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $scheduled }}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-primary"></span> <span class="ml-2">
                             </span>
                    </div>
                </div>
               
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-success mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Completed Order</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $completed }}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-info"></span> <span class="ml-2"></span>
                    </div>
                </div>
                
            </div>
        </div>
         <div class="col-xl-3 col-md-6">
            <div class="card bg-success mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">TOTAL PAYABLE</h6>
                        <h4 class="mb-3 mt-0 float-right">{{$totalPayable->payable}}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-info"></span> <span class="ml-2">
                            </span>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-pink mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">NEW PAYABLE</h6>
                        <h4 class="mb-3 mt-0 float-right">{{$Providers->newPayable}}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-primary"></span> <span class="ml-2">
                            </span>
                    </div>
                </div>   
            </div>
        </div>
         <div class="col-xl-3 col-md-6">
            <div class="card bg-info mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">City Cargo Payment</h6>
                        <h4 class="mb-3 mt-0 float-right">{{$Providers->cityCargo}}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-danger"></span><span class="ml-2"></span>
                    </div>
                </div>
            </div>
        </div>
</div>
<div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
                    <form action="{{route('account.provider.update.log')}}" method="post">
                {{ csrf_field() }}
                <h5 class="mb-1"><span class="s-icon"><i class="ti-infinite"></i></span>&nbsp; Rider Logs</h5>
                <hr />
                <table id="datatable-buttons" class="table table-bordered"
                        								style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>Created Date</th>
                            <th>Booking Id</th>
                            <th>User</th>
                            {{-- <th>Pickup Add.</th>
                            <th>Pickup Number</th>
                            <th>Pickup Rider</th>
                            <th>Pickup Remarks</th> --}}
                            {{-- <th>Completed Date</th> --}}
                            <th>DropOff Name</th>
                            <th>DropOff Add.</th>
                            <th>DropOff Number</th>
                            <th>DropOff Rider</th>
                            {{-- <th>DropOff Remarks</th> --}}
                            <th>COD</th>
                            {{-- <th>Fare</th> --}}
                            <th>Status</th>
                            <th>Payment Received<br>
                                {{-- @if($role=="account")
                                (All: <input type="checkbox" id="checkAll"> )
                            @endif --}}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sum = 0;   
                    ?>
                        @if(count($logs)>0)
                        @foreach($logs as $index => $log)
                        <tr>
                            <td>{{@$log->created_at}}</td>
                            <td>{{ $log->request->booking_id }}</td>
                            <td>{{ @$log->request->user->first_name }}</td>
                            {{-- <td>{{ @$log->request->s_address }}</td>
                            <td>{{ @$log->request->user->mobile }}</td>
                            <td>{{ @$log->pickup->first_name }}</td>
                            <td>{{ @$log->pickup_remarks }}</td> --}}
                            <td>{{ @$log->request->item->rec_name }}</td>
                            <td>{{ @$log->request->d_address }}</td>
                            <td>{{ @$log->request->item->rec_mobile }}</td>
                            <td>
                                @if(@$log->complete_id)
                                {{ @$log->complete->first_name}}
                                @else
                                N/A
                                @endif
                            </td>
                            {{-- <td>
                                @if(@$log->complete_remarks)
                                {{ @$log->complete_remarks}}
                                @else
                                N/A
                                @endif
                            </td> --}}
                            <td>
                                @if(@$log->request)
                                {{$log->request->cod}}
                                @else
                                N/A
                                @endif
                            </td>
                            {{-- <td>
                                @if(@$log->request)
                                {{$log->request->amount_customer}}
                                @else
                                N/A
                                @endif
                            </td> --}}
                            <td>{{@$log->request->status}}</td>
                            <td>
                                @if($role=="account")
                                <label class="switch" for="checkbox{{$log->id}}">
                                    <input type="checkbox" class="check_box amount#{{$log->request->cod}}"
                                        id="checkbox{{$log->id}}" name="log_id[]" value="{{ $log->id }}" checked>
                                    <div class="slider round"></div>
                                    <?php
                                    $sum += $log->request->cod
                                ?>
                                    @else
                                    {{$log->payment_received? "Yes":"No"}}
                                    @endif
                            </td>
                        </tr>
                        @endforeach
                        <tr class="font-weight-bold">
                            <td colspan="9s">Total</td>
                            <td class="total">Rs. {{ $sum }}</td>
                        </tr>
                        @else
                        <h6 class="no-result">No Data found</h6>
                        @endif
                    </tbody>

                </table>
                <input type=hidden name=paid value="{{ $sum }}" class="paid_amount" />
                <input type=hidden name=provider_id value="{{ request()->route('id') }}" />
                {{-- <span class="pay"></span> --}}
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="pay_remarks">Remarks <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="pay_remarks" name="pay_remarks" rows="5"></textarea>
                        </div>
                        <button type="submit" class=" mr-1 btn btn-lg btn-success mt-4" name="submit" value="pay">
                            Pay</button>
                    </div>
                    <div class=" offset-md-2 col-md-5 px-4">
                        <div class="form-group">
                            <label for="settle_remarks">Remarks <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="settle_remarks" name="settle_remarks"
                                rows="5"></textarea>
                        </div>
                        <button type="submit" class=" mr-1 btn btn-lg btn-warning mt-4" name="submit" value="settle">
                            Settle </button>
                    </div>
                </div>
            </form>
                </div>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{asset('asset/admin/vendor/jquery/jquery-1.12.3.min.js')}}"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    //  $(document).ready(function(){
    //     $("#checkAll").change(function(){
    //         if(this.checked){
    //             $(".payment_received").prop('checked',true);
    //             $(".payment_received").trigger('change');
    //         }
    //         else{
    //             $(".payment_received").prop('checked',false);
    //             $(".payment_received").trigger('change');
    //         }
    //     })
    //  });
    // $(document).ready(function(){
    //     $("#checkAll").change(function(){
    //         if(this.checked){
    //             $(".payment_received").prop('checked',true);
    //             $(".payment_received").trigger('change');
    //         }
    //         else{
    //             $(".payment_received").prop('checked',false);
    //             $(".payment_received").trigger('change');
    //         }
    //     })
    //     $(".payment_received").change(function(){
    //         var id = this.name;
    //         var split_id = id.split("-");
    //         var field_name = split_id[0];
    //         var edit_id = split_id[1];
    //         var value=false;
    //         if(this.checked){
    //             value=true;
    //         }
    //         $.ajaxSetup({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             }
    //         });
    //         $.ajax({
    //             // url: "{{url($role.'/provider/log')}}/"+edit_id,
    //             url: "{{url('account/provider/log')}}/"+edit_id,
    //             type: 'post',
    //             data: field_name+"="+value,
    //             success:function(response){
    //                 if(response.success)
    //                 {
    //                     toastr.success(response.message)
    //                 }
    //                 toastr.error(response.message)
    //             },
    //             error: function (request, error) {
    //                 console.log(request);
    //                 toastr.error(" Can't do!! Error"+error);
    //             }
    //         });
    //     })
    // });
   
</script>
<script>
    var selectedFinal = [];
        $(document).on("change", ".check_box", function () { 
            selectedFinal = $('.check_box:checked').map((i,el) =>{
                return $(el).attr('class').split('#')[1];
            }).get();
            console.log(selectedFinal)
        var sum  = selectedFinal.reduce(function (a, b) {
            return parseInt(a) + parseInt(b);
            },0);
            var email = $('.paid_amount').val(sum);
            $('.total').html('Rs. ' + sum )
        });
</script>
@endsection