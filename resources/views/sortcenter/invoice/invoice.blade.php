<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="icon" href="favicon.ico">
    <link rel="stylesheet" href="/projects/qwcrm/src/themes/default/css/template.css">
    <link rel="stylesheet" href="{{ asset('asset/admin/vendor/font-awesome/css/font-awesome.min.css') }}">
</head>

<body>

    <style>
        .p-invoice {
            padding-left: 50px;
            padding-top: 25px;
        }

        #p-barcode {
            padding-top: 50px;
        }

        #invoice_header ul li {
            list-style: none;
        }

        .puryau_details tr td {
            font-size: 18px;
            /* padding: 0%; */
        }

        .vr_details tr td {
            font-size: 18px;
            /* padding: 0%; */
        }

        .puryau-logo {
            width: 12%;
            background: none;
            /* width: 150px; height:55px; */
        }

        /* #logo {
            background: none; }
        #logo img {
            display: block; } */

        @media print {

            html,
            body {
                display: block;
                font-family: "Calibri";
                margin: 0;
            }

            .puryau_details tr td {
                color: black;
                font-size: 36px;
                /* padding: 0%; */
            }

            .vr_details tr td {
                color: black;
                font-size: 36px;
                /* padding: 0%; */
            }

            @page {
                /* size: 11.59mm 10.10mm; */
                size: 21.59cm 13.97cm;
            }

            /* size: 14.59cm 12.97cm; */
            /* size: 32.59cm 23.97cm; */
            /* size: 13.59cm 10.97cm; */
            /* size: 11.59mm 10.10mm; */


            /* size: 13.59cm 10.97cm; */

            /* size: 14.59cm 12.97cm; */
            /* size: 21.59cm 13.97cm; */
            /* size: 21.59cm 15.97cm; */

            .puryau-logo {
                width: 95px !important;
                top: 5px !important;
            }

            #p-barcode {
                padding-top: 0px;
            }

            .p-invoice {
                padding-left: 50px;
                padding-top: 5px;
                page-break-inside:avoid;
 
            }

        }

    </style>

    @foreach($orders as $order)
        <div class="p-invoice">

            <div class="col-md-12">
                <div class="col-lg-12">
                    <table width="100%" class="vr_details" style="position:relative;">
                        <tr>
                            <td width="60%"> <img class="puryau-logo" style="position:absolute;top:-5px;left:0cm;" src="{{ url(Setting::get('site_logo', asset('logo-black.png'))) }}"> </> </td>
                            </td>
                            <td width="20%"></td>
                            <td width="22%">
                                <div style="font-size:18px;"> <b> {{ $order->created_at->format('Y-m-d') }}</></div>
                            </td>
                        </tr>
                    </table>
                </div>


                <div style="width: 100%; margin-top:10px; display:flex;">
                    <table style="width: 100%; " class="puryau_details">
                        <tr>
                            <td width="60%">
                            <div class> <i class="fa fa-globe"></i> &nbsp; <b>www.hulagi.com</b> </div>
                            <div> <i class="fa fa-map-marker"></i> &nbsp;&nbsp; Dillibazar, Kathmandu </div>
                            <div> <i class="fa fa-envelope-o"></i> &nbsp; hulagilogistics@gmail.com </div>
                            <div> <i class="fa fa-phone"></i> &nbsp; 01-5912256/57 @if($order->cargo)
                                        &nbsp;<span style="border:solid black 1px;padding:1px 3px ;">**Cargo**</span>  
                                    @endif
                            </td>
                            <td width="40%" style="text-align: right; padding-right:50px;">
                                <div class="row">
                                    <div> <b> ID : </b> {{ $order->booking_id }} </div>
                                    <div width="30%" id="Qrcode"> {!! QrCode::size(132)->generate($order->booking_id) !!}</div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="col-lg-10" style="margin-top:-10px">
                <table width="100%" class="vr_details">
                    <tr>
                        <td width="40%"> <b> Vendor Detail </b> </td>
                        <td width="60%"> <b> Receiver Detail </b> </td>
                    </tr>

                    <tr>
                        <td width="40%" style="vertical-align: top;">
                            <div> <i class="fa fa-industry"></i> &nbsp;&nbsp; {{ $order->user->first_name }} </div>
                            <div> <i class="fa fa-phone"></i> &nbsp;&nbsp; {{ $order->user->mobile }} </div>
                            <div> <b>COD</b> &nbsp; : <b>Rs. {{ $order->cod }} </div>

                        </td>
                        <td width="60%" style="padding-left: 10px;">
                            <div> <i class="fa fa-user"></i> &nbsp; : {{ $order->item->rec_name }} </div>
                            <div> <i class="fa fa-phone"></i> &nbsp; : {{ $order->item->rec_mobile }} </div>

                            <div style="widt:50px;"> <i class="fa fa-map-marker"></i> &nbsp; :
                                {{ $order->d_address }} </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" width="100%" id="p-barcode"> <?php echo DNS1D::getBarcodeSVG($order->booking_id, 'C39', 3, 55); ?> </td>
                    </tr>
                </table>
            </div>
        </div>
    @endforeach

    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.onload = function() {
            this.print();
        }
        window.onbeforeprint = function() {
            console.log('This will be called before the user prints.');
        };

    </script>
</body>

</html>
