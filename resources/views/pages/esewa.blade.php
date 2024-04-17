<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Hulagi</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- App Icons -->
    <link rel="shortcut icon" type="image/png" href="{{ asset(Setting::get('site_icon')) }}">


    <!-- App css -->
    <link href="{{ asset('asset/user/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('asset/user/css/icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('asset/user/css/style.css') }}" rel="stylesheet" type="text/css" />

</head>

<style>
  .button2:hover {
  background-color: #9CC3D5FF;
}
.button2 {
  background-color: #0063B2FF;
}
</style>


<body>

    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner">
                <div class="rect1"></div>
                <div class="rect2"></div>
                <div class="rect3"></div>
                <div class="rect4"></div>
                <div class="rect5"></div>
            </div>
        </div>
    </div>
    <style type="text/css">
    
    @media print {
        .noprint,#topnav {
            visibility: hidden;
        }
        
    }
    </style>
    
    <div class="container-fluid">

<!-- Page-Title -->
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
<!-- end page title end breadcrumb -->

<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body">

                <div class="row">
                    <div class="col-12">
                        <div class="invoice-title">
                            <h4 class="float-right font-16"><strong></strong></h4>
                            <h3 class="m-t-0">
                                <img src="{{ asset('asset/user/images/Puryau-logo-black.png') }}" alt="logo" height="28"/>
                            </h3>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <address>
                                    <strong>FROM:</strong><br>
                                    
                                            Hulagi Logistics <br>
                                            Dillibazar, Kathmandu<br>
                                    Nepal<br>
                                    Phone: 01-5912257<br>
                                    Email: hulagilogistics@gmail.com
                                </address>
                            </div>
                            <div class="col-6 text-right">
                                <address>
                              
                                    <strong>TO :</strong><br>
                                    {{$esewa->Name}}<br>
                                    Email : {{$esewa->email}}
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
                                    {{$esewa->updated_at->format('Y-m-d')}}<br><br>
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

                                            <td class="text-center"><strong>Payment Id</strong></td>
                                            <td class="text-center"><strong>Receiver Name</strong></td>
                                            <td class="text-center"><strong>Due Amount</strong></td>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                                <tr>
                                                    <td>1</td>
                                                    <td  class="text-center">{{$esewa->EsewaToken}}</td>
                                                    <td  class="text-center">{{$esewa->Name}}</td>
                                                    <td  class="text-center">{{$esewa->Amount}}</td>
                                                </tr>
                                                
                                            <tr>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line text-center">
                                                <strong>Total</strong></td>
                                            <td class="no-line text-center"><h4 class="m-0">Rs. {{ $esewa->Amount }}</h4></td>
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
                                    <div class="float-right">

                                    <form action="https://esewa.com.np/epay/main" method="POST">
                                        <input value={{ $esewa->Amount }} name="tAmt" type="hidden">
                                        <input value={{ $esewa->Amount }} name="amt" type="hidden">
                                        <input value="0" name="txAmt" type="hidden">
                                        <input value="0" name="psc" type="hidden">
                                        <input value="0" name="pdc" type="hidden">
                                        <input value={{ env('Merchant_Key') }} name="scd" type="hidden">
                                        <input value={{ $esewa->EsewaToken }} name="pid" type="hidden">
                                        <input value={{ url('esewa/payment-verify/'.$esewa->user_id.'?q=su') }} type="hidden" name="su">
                                        <input value={{ url('esewa/payment-verify/'.$esewa->user_id.'?q=fu') }} type="hidden" name="fu">
                                        <button value="Submit" type="submit" class="button2 btn btn-light btn-block mt-2">  
                                        PAY NOW <img src="{{ asset('asset/user/images/esewa.png') }}" alt="esewa" width="50"></button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div> <!-- end row -->

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->



    <!-- Begin page -->
    <div class="home-btn d-none d-sm-block">
        <a href="{{ url('/') }}" class="text-dark"><i class="mdi mdi-home h1"></i></a>
    </div>


    <!-- jQuery  -->

    <script src="{{ asset('asset/user/js/jquery.min.js') }}"></script>
    <script src="{{ asset('asset/user/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('asset/user/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('asset/user/js/waves.js') }}"></script>
    <script src="{{ asset('asset/user/js/jquery.slimscroll.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('asset/user/js/app.js') }}"></script>
 

</body>
</html>


