@extends('account.layout.master')

@section('title', 'Payment')

@section('content')
<style type="text/css">
    
    @media print {
        .noprint,#topnav {
            visibility: hidden;
        }
        
    }
</style>

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-print-none">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0">Invoice</h4>
                </div>
                
            </div>
            
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body">

                <div class="row">
                    <div class="col-12">
                        <div class="invoice-title">
                             <div style="text-align:center" >
                                                <h2>
                                                   Hulagi Delivery
                                                </h2>
                                        </div>
                                        <div style="text-align:center">
                                            <small>Sankhamul; Kathmandu</small>
                                        </div>
                            <h4 class="float-right font-16"><strong>PAY : {{$payments->invoice_no}}</strong></h4>
                            <h3 class="m-t-0">
                                <img src="{{ asset('asset/user/images/Puryau-logo-black.png') }}" alt="logo" height="28"/>
                            </h3>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <address>
                                    <strong>FROM:</strong><br>
                                    
                                            Hulagi Delivery<br>
                                            Dillibazar, Kathmandu<br>
                                    Nepal<br>
                                    Phone: 01-15912257<br>
                                    Email: hulagidelivery@gmail.com
                                </address>
                            </div>
                            <div class="col-6 text-right">
                                <address>
                              
                                    <strong>TO :</strong><br>
                                    {{$payments->userRequest[0]->user->first_name}}<br>
                                    {{$payments->userRequest[0]->user->company_name}}<br>
                                    Phone : {{$payments->userRequest[0]->user->mobile}}<br>
                                    Email : {{$payments->userRequest[0]->user->email}}
                                </address>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 m-t-30">
                                <!-- <address>
                                    <strong>Payment Method:</strong><br>
                                    Visa ending **** 4242<br>
                                    jsmith@email.com
                                </address> -->
                            </div>
                            <div class="col-6 m-t-30 text-right">
                                <address>
                                    <strong>Payment Date:</strong><br>
                                    {{$payments->updated_at->format('Y-m-d')}}<br><br>
                                </address>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="panel panel-default">
                            <div class="p-2">
                                <h3 class="panel-title font-20"><strong>Order summary</strong></h3>
                            </div>
                            <div class="">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                                
                                            <td><strong>S.N</strong></td>

                                            <td class="text-center"><strong>Item</strong></td>
                                            <td class="text-center"><strong>Receiver Name</strong></td>

                                            <td class="text-center"><strong>Status</strong></td>
                                            <td class="text-center"><strong>COD</strong>
                                            </td>
                                            <td class="text-center"><strong>Fare</strong></td>
                                            <td class="text-center"><strong>Total Payable</strong></td>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                        @foreach($payments->userRequest as $payment)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td  class="text-center">{{$payment->booking_id}}</td>
                                                    <td class="text-center">{{$payment->item->rec_name?$payment->item->rec_name:"N/A"}}</td>
                                                    <td class="text-center">{{$payment->status}}</td>
                                                    <td class="text-center">{{$payment->status=="COMPLETED"?$payment->cod:"0"}}</td>
                                                    <td class="text-center">{{$payment->amount_customer}}</td>
                                                    <td class="text-center">{{$payment->status=="COMPLETED"?$payment->cod-$payment->amount_customer:-$payment->amount_customer}}</td>
                                                </tr>
                                                
                                            @endforeach
                                            <tr>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line text-center">
                                                <strong>Total</strong></td>
                                            <td class="no-line text-center"><h4 class="m-0">Rs. {{ $payments->paid_amount }}</h4></td>
                                        </tr>
                                       
                                        <!-- <tr>
                                            <td class="thick-line"></td>
                                            <td class="thick-line"></td>
                                            <td class="thick-line text-center">
                                                <strong>Subtotal</strong></td>
                                            <td class="thick-line text-right">$670.99</td>
                                        </tr>
                                        <tr>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line text-center">
                                                <strong>Shipping</strong></td>
                                            <td class="no-line text-right">$15</td>
                                        </tr> -->
                                       
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-print-none mo-mt-2">
                                    <div class="float-right">
                                        <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>
                                        <!-- <a href="#" class="btn btn-primary waves-effect waves-light">Send</a> -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div> <!-- end row -->

            </div>
        </div>
    </div> <!-- end col -->
</div>
    
    <script>
        function myFunction() {
        window.print();
}
    </script>
@endsection

@section('scripts')
    <script>
        var selectedFinal = [];
        $(document).on("click", ".check_box", function () { 
            selectedFinal = $('.check_box:checked').map((i,el) =>{
                return $(el).attr('class').split('-')[1];
            }).get();
        var sum  = selectedFinal.reduce(function (a, b) {
            return parseInt(a) + parseInt(b);
            },0);
            var email = $('<input type=hidden name=paid />').val(sum);
            $('.total').html('Rs. ' + sum )
            $('.pay').html(email)
        });
    </script>
@endsection