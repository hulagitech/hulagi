@extends('account.layout.base')

@section('title', 'Payment')

@section('content')
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<style type="text/css">
    body{margin-top:20px;
    background:#eee;
    }

    /*Invoice*/
    .invoice .top-left {
        font-size:65px;
        color:#3ba0ff;
    }

    .invoice .top-right {
        text-align:right;
        padding-right:20px;
    }

    .invoice .table-row {
        margin-left:-15px;
        margin-right:-15px;
        margin-top:25px;
    }

    .invoice .payment-info {
        font-weight:500;
    }

    .invoice .table-row .table>thead {
        border-top:1px solid #ddd;
    }

    .invoice .table-row .table>thead>tr>th {
        border-bottom:none;
    }

    .invoice .table>tbody>tr>td {
        padding:8px 20px;
    }

    .invoice .invoice-total {
        margin-right:-10px;
        font-size:16px;
    }

    .invoice .last-row {
        border-bottom:1px solid #ddd;
    }

    .invoice-ribbon {
        width:85px;
        height:88px;
        overflow:hidden;
        position:absolute;
        top:-1px;
        right:14px;
    }

    .ribbon-inner {
        text-align:center;
        -webkit-transform:rotate(45deg);
        -moz-transform:rotate(45deg);
        -ms-transform:rotate(45deg);
        -o-transform:rotate(45deg);
        position:relative;
        padding:7px 0;
        left:-5px;
        top:11px;
        width:120px;
        background-color:#66c591;
        font-size:15px;
        color:#fff;
    }

    .ribbon-inner:before,.ribbon-inner:after {
        content:"";
        position:absolute;
    }

    .ribbon-inner:before {
        left:0;
    }

    .ribbon-inner:after {
        right:0;
    }

    @media(max-width:575px) {
        .invoice .top-left,.invoice .top-right,.invoice .payment-details {
            text-align:center;
        }

        .invoice .from,.invoice .to,.invoice .payment-details {
            float:none;
            width:100%;
            text-align:center;
            margin-bottom:25px;
        }

        .invoice p.lead,.invoice .from p.lead,.invoice .to p.lead,.invoice .payment-details p.lead {
            font-size:22px;
        }

        .invoice .btn {
            margin-top:10px;
        }
    }

    @media print {
        .invoice {
            width:900px;
            height:800px;
        }
    }
    </style>
    <div class="content-area py-1">
        <div class="container-fluid">
            <div class="box box-block bg-white">
                <div class="container bootstrap snippets bootdeys">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default invoice" id="invoice">
                                <div class="panel-body">
                                    <div class="invoice-ribbon">
                                        <div class="ribbon-inner">PAID</div>
                                    </div>
                                        <div class="row">
                                            <div class="col-sm-6 ">
                                                <h4 class="marginright">PAY:{{$payments->invoice_no}}</h4>
                                            </div>
                                        </div>
                                        <hr>
                                    <div class="row">
                                        <div class="col-xs-4 from">
                                            <p class="lead marginbottom">From :</p>
                                            <p>Hulagi Logisitcs</p>
                                            <p>Dillibazar, Kathmandu</p>
                                            <p>Nepal</p>
                                            <p>Phone: 01-15912257</p>
                                            <p>Email: hulagidelivery@gmail.com</p>
                                        </div>

                                        <div class="col-xs-4 to">
                                            <p class="lead marginbottom">To : {{$payments->rider->first_name}}</p>
                                            <p>{{$payments->rider->address}}</p>
                                            <p>Phone: {{$payments->rider->mobile}}</p>
                                            <p>Email: {{$payments->rider->email}}</p>

                                        </div>

                                        <div class="col-xs-4 text-right payment-details">
                                            <p class="lead marginbottom payment-info">Payment date</p>
                                            <p>{{$payments->updated_at->format('Y-m-d')}}</p>
                                        </div>
                                    </div>

                                    <div class="row table-row">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                <th class="text-center" style="width:5%">S.N</th>
                                                <th style="width:30%">Item</th>
                                                <th class="text-right" style="width:15%">Status</th>
                                                <th class="text-right" style="width:15%">COD</th>
                                                <th class="text-right" style="width:15%">Fare</th>
                                                <th class="text-right" style="width:25%">Total Payable</th>
                                                </tr>
                                            </thead>
                                            @foreach($payments->riderLog as $payment)
                                            <tbody>
                                                <tr>
                                                    <td class="text-center">{{$loop->iteration}}</td>
                                                    <td>{{$payment->request->booking_id}}</td>
                                                    <td class="text-right">{{$payment->request->status}}</td>
                                                    <td class="text-right">{{$payment->request->status=="COMPLETED"?$payment->request->cod:"0"}}</td>
                                                    <td class="text-right">{{$payment->request->amount_customer}}</td>
                                                    <td class="text-right">{{$payment->request->status=="COMPLETED"?$payment->request->cod:"0"}}</td>
                                                </tr>
                                                
                                            </tbody>
                                            @endforeach
                                            <tfoot>
                                                <tr class="font-weight-bold">
                                                    <td colspan="5">Total</td>
                                                    <td>Rs. {{ $payments->paid_amount }}</td>
                                                </tr>
                                            </tfoot>
                                        </table>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 float-right margintop">
                                            <p class="lead marginbottom">THANK YOU!</p>
                                            {{-- <button class="btn btn-success" id="invoice-print"><i class="fa fa-print"></i> Print Invoice</button>
                                            <button class="btn btn-danger"><i class="fa fa-envelope-o"></i> Mail Invoice</button> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection