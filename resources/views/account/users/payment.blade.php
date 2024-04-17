@extends('account.layout.master')

@section('title', 'Payment')

@section('content')
<style type="text/css">
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
                    <div class="col-md-4">
                        <h4 class="page-title m-0">Payment</h4>
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
                    <div class="row">
                        <div class="col-4">
                            <h5>Name: {{$users[0]->first_name}}</h5>
                            <h5 class="py-1">Mobile No.: {{$users[0]->mobile}}</h5>
                            <h6 class="text-grey">Remaining Payment: Rs. {{$users[0]->payment?$users[0]->wallet_balance:'-'}}</h6>

                            <h5 class="py-1">New payment:   <i class="fa fa-copy" type='submit' onclick="copyToClipboard('{{ $users[0]->newPayment }}')"></i>   Rs. {{number_format($users[0]->newPayment,2)}}
                            </h5>
                            @if (!$users[0]->payment_req)
                                <h5>Requested : <span class="tag tag-danger">No</span></h5>
                            @else
                            <h5>Requested Amount: Rs.{{$users[0]->payment_req->requested_amt}}</h5>
                            <h5 class="py-1">Requested At: {{$users[0]->requested_at->updated_at->diffForHumans()}}</h5>
                            @endif
                        </div>
                        @if ($userDetails->khaltiDetail)
                        <div class="col-md-4">
                            <h4>Khalti Details</h4>
                            <br>
                            <h5>Khalti Id: <i class="fa fa-copy" type='submit' onclick="copyToClipboard('{{$userDetails->khaltiDetail->khalti_id }}')"></i>   {{$userDetails->khaltiDetail->khalti_id}}</h5>
                            <h5>Khalti Username: <i class="fa fa-copy" type='submit' onclick="copyToClipboard('{{ $userDetails->khaltiDetail->khalti_username }}')"></i> {{$userDetails->khaltiDetail->khalti_username}}</h5>
                            
                        </div>
                        @endif
                        @if ($userDetails->bankDetail)
                        <div class="col-md-4">
                            <h4>Bank Details</h4>
                            <br>
                            <h5>Account Number: <i class="fa fa-copy " type='submit' onclick="copyToClipboard('{{$userDetails->bankDetail->ac_no }}')"></i>  {{$userDetails->bankDetail->ac_no}}</h5>
                            <h5 >Account Name: <i class="fa fa-copy" type='submit' onclick="copyToClipboard('{{$userDetails->bankDetail->ac_name }}')" ></i>  {{$userDetails->bankDetail->ac_name}}</h5>
                            <h5>Bank Name:{{$userDetails->bankDetail->bank_name}},({{$userDetails->bankDetail->branch}} )</h5>
                            <h7>Remars: Vendor Payment of {{$userDetails->first_name}}-{{$userDetails->id}}  <i class="fa fa-copy " type='submit' onclick="copyToClipboard('Vendor Payment of {{$userDetails->first_name}}-{{$userDetails->id}}')"></i></h7>
                        
                            
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
</div>
<div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
                        <form action="{{route('account.payment.statement',$users[0]->id)}}" method="post">
                                {{ csrf_field() }}
                                @if (count($orders) != 0)
                                    <table id="datatable-buttons" class="table table-bordered"
                        								style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <td>Booking ID</td>
                                                <td>COD</td>
                                                <td>Fare</td>
                                                <td>Total Payable</td>
                                                <td>Status</td>
                                                <td>Select</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $diff = ['-success', '-info', '-warning', '-danger']; $sum=0; ?>
                                            @foreach ($orders as $index => $order)
                                            <tr>
                                                <td>
                                                    {{$order->booking_id}}
                                                </td>
                                                <td>
                                                    Rs. {{$order->status=="COMPLETED"?$order->cod: '0'}}
                                                </td>
                                                <td>
                                                    Rs. {{$order->amount_customer}}
                                                </td>
                                                <td>
                                                    Rs. {{$order->status=="COMPLETED"?$order->cod - $order->amount_customer:-$order->amount_customer}}
                                                </td>
                                                <td>
                                                    {{$order->status}}
                                                </td>
                                                <?php 
                                                if($order->status=="REJECTED")
                                                {
                                                    $amount = -$order->amount_customer;
                                                }
                                                else{
                                                    $amount= $amount=$order->cod - $order->amount_customer;
                                                }
                                                    $sum = 
                                                    $sum += $amount
                                                ?>
                                                
                                                <td>
                                                    <label class="switch" for="checkbox{{$order->id}}">
                                                        <input type="checkbox" name="order_id[]" id="checkbox{{$order->id}}"
                                                            value="{{$order->id}}" class="check_box amount#{{$amount}}" checked >
                                                        <div class="slider round"></div>
                                                </td>
                                            </tr>

                                            @endforeach
                                            <hr>
                                            <tr class="font-weight-bold">
                                                <td colspan="5">Total</td>
                                                <td class="total">Rs. {{$sum}}</td>
                                            </tr>
                                        <tfoot>
                                            <tr>
                                                <td>Booking ID</td>
                                                <td>COD</td>
                                                <td>Fare</td>
                                                <td>Total Payable</td>
                                                <td>Status</td>
                                                <td>Select</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                @else
                                <h6 class="no-result">No results found</h6>
                                @endif
                                <span class="pay"></span>
                                <hr>
                                <div class="row">
                                    <input type=hidden name=paid value="{{ @$sum }}" class="paid_amount"/>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="pay_remarks">Remarks <span class="text-danger">*</span></label>
                                            <textarea class="form-control" id="pay_remarks" name="pay_remarks"
                                                rows="5"></textarea>
                                        </div>
                                        <button type="submit" class=" mr-1 btn btn-lg btn-success mt-4" name="submit"
                                            value="pay"> Pay</button>
                                    </div>
                                    <div class=" offset-md-2 col-md-5 px-4">
                                        <div class="form-group">
                                            <label for="settle_remarks">Remarks <span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control" id="settle_remarks" name="settle_remarks"
                                                rows="5"></textarea>
                                        </div> 
                                        <button type="submit" class=" mr-1 btn btn-lg btn-warning mt-4" name="submit"
                                            value="settle"> Settle </button>
                                    </div>
                                </div>
                            </form>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
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
            // console.log("sum",sum)
            var email = $('.paid_amount').val(sum);
            $('.total').html('Rs. ' + sum )
        });

</script>
<script>
    // function copyToClipboard(id) {

    //     toastr.success("Success!!")
    //     // alert(id)
    //     // document.getElementById(id).text;
    //     // document.execCommand('copy');
    // }
    function copyToClipboard(id) {
   
	const el = document.createElement('textarea');

    el.value = id;
    document.body.appendChild(el);
    el.select();
    document.execCommand('copy');
    document.body.removeChild(el);
    toastr.success("Success!!")
}
</script>
@endsection
@section('scripts')

    @include('user.layout.partials.datatable')

@endsection
