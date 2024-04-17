@extends('user.layout.master')


@section('content')

    <style type="text/css">
        #edit_khalti {
            display: none;
        }

        #edit_bank {
            display: none;
        }
        #loadWallet{
            display:none;
        }
        #loadkhalti{
            display:none
        }
        #payment{
            display:none
        }

    </style>
     <script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>
    @include('common.notify')

    <div class="row">
        <div class="col-12">
            @if (empty($k_infos) || empty($b_infos))
                <div class="col-md-12 mt-2">
                    <div class="alert alert-danger alert-dismissible fade show mb-0 noprint text-center" role="alert">
                        <strong class='text-white'>Dear Customer, You have not added your Khalti Details or Bank
                            Details.Please add your payment details
                        </strong>
                    </div>
                </div>
            @endif


            <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">My Wallet</h4>
                    </div>
                    <div class="col-md-2">
                        <div class="float-right">
                             <a href="#" id="load" class="btn btn-primary" type="button">
                                Pay Charge <img src="{{ asset('asset/user/images/esewa.png') }}" alt="esewa" width="50">
                            </a>
                        </div>
                    </div>
                    <!-- <div class="col-md-2">
                        <div class="float-right">
                             <a href="#" id="load-khalti" class="btn btn-primary" type="button">
                                Pay Charge <img src="{{ asset('asset/user/images/KHALTI.png') }}" alt="khalti" width="50">
                            </a>
                        </div>
                    </div> -->
                </div>

            </div>
        </div>
    </div>

        </div>
    </div>

    <div class="row">

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">

                    <h4>{{ currency($user_wallet) }}</h4>
                    <h6 class='text-muted'>Your Balance</h6>
                    @if ($user_wallet > 499)
                         @if ($after_ct != '1000')
                            @if (date('Y-m-d H:i:s') >= 499 )
                                <form action="{{ url('request/money') }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ $user_wallet }}" id="requested_amt"
                                        name="requested_amt">
                                    <button type="submit" class="btn btn-primary btn-block">Request Payment</button>
                                </form>
                            @endif
                        @endif
                    @elseif($user_wallet>0)
                    <h7 class='test-muted'>You can request balance once your balance above  Rs. 500 or More</h7>
                    
                    @elseif($user_wallet < 0) <?php $amount = abs($user_wallet);?> 
                    <div class="d-block p-2 bg-primary text-white text-center" id="pay"> <a href="#" style="color:white;"><b>Pay Your Due </b></a></div>
                    <div id ="payment">
                        <form action="https://esewa.com.np/epay/main" method="POST">
                            <input value={{ $amount }} name="tAmt" type="hidden">
                            <input value={{ $amount }} name="amt" type="hidden">
                            <input value="0" name="txAmt" type="hidden">
                            <input value="0" name="psc" type="hidden">
                            <input value="0" name="pdc" type="hidden">
                            <input value={{ env('Merchant_Key') }} name="scd" type="hidden">
                            <input value={{ $esewa_id }} name="pid" type="hidden">
                            <input value={{ url('/payment-verify?q=su') }} type="hidden" name="su">
                            <input value={{ url('/payment-verify?q=fu') }} type="hidden" name="fu">
                            <button value="Submit" type="submit" class="btn btn-light btn-block mt-2"> <img src="{{ asset('asset/user/images/esewa.png') }}" alt="esewa" width="70"></button>
                        </form>
                        <!-- <button id="payment-button" class="btn btn-light btn-block mt-2"><img src="{{ asset('asset/user/images/KHALTI.png') }}" alt="khalti" width="70"> <img src="{{ asset('asset/user/images/connect_ips.png') }}" alt="ips" width="35"> <img src="{{ asset('asset/user/images/mobile_banking.png') }}" alt="mobile" width="35"></button> -->
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4" id="loadkhalti" >
                <div class="card">
                    <div class="col-md-12">
                    <div class="col-md-12 mt-3 text-right">
                    <a href="#" id="cancelloadkhalti" style="text-decoration:none;" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> </a>
                    </div>
                    <h3 class="col-md-12 text-center">Load wallet <img src="{{ asset('asset/user/images/KHALTI.png') }}" alt="esewa" width="70"></h3>
                    
                    </div>
                    <div class="card-body">
                        <input name="tAmt" type="number" id="tAmtkhalti" class='form-control' placeholder='Enter the amount'>
                           <button class="btn btn-primary btn-block mt-2" id="khalti-wallet-load"> Load Wallet</button> </button>
        <div class="row">
            <div class=" col-lg-3 col-sm-6">
                    <button value="Submit" type="submit" class="btn btn-primary btn-block mt-2" id="150">150 </button>
            
            </div>

            <div class=" col-lg-3 col-sm-6">
                
                    <button value="Submit" type="submit" class="btn btn-primary btn-block mt-2" id="250">250 
                            </button>
            </div>

            <div class=" col-lg-3 col-sm-6">
                    <button value="Submit" type="submit" class="btn btn-primary btn-block mt-2" id="500">500 </button>
            </div>

            <div class=" col-lg-3 col-sm-6">
                    <button value="Submit" type="submit" class="btn btn-primary btn-block mt-2" id="1000">1000 </button>
            </div>
                   
                </div>
            </div>
            </div>
            </div>
        
        <div class="col-md-4" id="loadWallet" >
                <div class="card">
                <div class="col-md-12 mt-3 text-right">
                    <a href="#" id="cancelload" style="text-decoration:none;" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> </a>
                    </div>
                    <h3 class="col-md-12 text-center">Load wallet <img src="{{ asset('asset/user/images/esewa.png') }}" alt="esewa" width="70"></h3>
                    <div class="card-body">
                    <form action="https://esewa.com.np/epay/main" method="POST">
                        <input name="tAmt" type="number" id="tAmt" class='form-control' placeholder='Enter the amount'>
                        <input value="0" name="amt" type="hidden" id="amt">
                        <input value="0" name="txAmt" type="hidden">
                        <input value="0" name="psc" type="hidden">
                        <input value="0" name="pdc" type="hidden">
                        <input value={{ env('Merchant_Key') }} name="scd" type="hidden">
                        <input value={{ $esewa_id }} name="pid" type="hidden">
                        <input value={{ url('/loadPayment?q=su') }} type="hidden" name="su">
                        <input value={{ url('/loadPayment?q=fu') }} type="hidden" name="fu">
                        <button value="Submit" type="submit" class="btn btn-primary btn-block mt-2">

                            Load Wallet </button>
                    </form>
        <div class="row">
            <div class=" col-lg-3 col-sm-6">
                <form action="https://esewa.com.np/epay/main" method="POST">
                    <input value="150" name="tAmt" type="hidden">
                    <input value="150" name="amt" type="hidden">
                    <input value="0" name="txAmt" type="hidden">
                    <input value="0" name="psc" type="hidden">
                    <input value="0" name="pdc" type="hidden">
                    <input value={{ env('Merchant_Key') }} name="scd" type="hidden">
                    <input value={{ $esewa_id }} name="pid" type="hidden">
                    <input value={{ url('/loadPayment?q=su') }} type="hidden" name="su">
                    <input value={{ url('/loadPayment?q=fu') }} type="hidden" name="fu">
                    <button value="Submit" type="submit" class="btn btn-primary btn-block mt-2">150 </button>
                </form>
            </div>

            <div class=" col-lg-3 col-sm-6">
                <form action="https://esewa.com.np/epay/main" method="POST">
                    <input value="250" name="tAmt" type="hidden">
                    <input value="250" name="amt" type="hidden">
                    <input value="0" name="txAmt" type="hidden">
                    <input value="0" name="psc" type="hidden">
                    <input value="0" name="pdc" type="hidden">
                    <input value={{ env('Merchant_Key') }} name="scd" type="hidden">
                    <input value={{ $esewa_id }} name="pid" type="hidden">
                    <input value={{ url('/loadPayment?q=su') }} type="hidden" name="su">
                    <input value={{ url('/loadPayment?q=fu') }} type="hidden" name="fu">
                    <button value="Submit" type="submit" class="btn btn-primary btn-block mt-2">250 
                            </button>
                </form>
            </div>

            <div class=" col-lg-3 col-sm-6">
                <form action="https://esewa.com.np/epay/main" method="POST">
                    <input value="500" name="tAmt" type="hidden">
                    <input value="500" name="amt" type="hidden">
                    <input value="0" name="txAmt" type="hidden">
                    <input value="0" name="psc" type="hidden">
                    <input value="0" name="pdc" type="hidden">
                    <input value={{ env('Merchant_Key') }} name="scd" type="hidden">
                    <input value={{ $esewa_id }} name="pid" type="hidden">
                    <input value={{ url('/loadPayment?q=su') }} type="hidden" name="su">
                    <input value={{ url('/loadPayment?q=fu') }} type="hidden" name="fu">
                    <button value="Submit" type="submit" class="btn btn-primary btn-block mt-2">500 </button>
                </form>
            </div>

            <div class=" col-lg-3 col-sm-6">
                <form action="https://esewa.com.np/epay/main" method="POST">
                    <input value="1000" name="tAmt" type="hidden">
                    <input value="1000" name="amt" type="hidden">
                    <input value="0" name="txAmt" type="hidden">
                    <input value="0" name="psc" type="hidden">
                    <input value="0" name="pdc" type="hidden">
                    <input value={{ env('Merchant_Key') }} name="scd" type="hidden">
                    <input value={{ $esewa_id }} name="pid" type="hidden">
                    <input value={{ url('/loadPayment?q=su') }} type="hidden" name="su">
                    <input value={{ url('/loadPayment?q=fu') }} type="hidden" name="fu">
                    <button value="Submit" type="submit" class="btn btn-primary btn-block mt-2">1000 </button>
                </form>
            </div>
                </div>
            </div>
            </div>
            </div>
        <div class="col-md-9">
            <!-- @if ($user_wallet > 499) -->
                <!-- @if ($after_ct != '0')
                    @if (date('Y-m-d H:i:s') < $after_ct) -->
                        <div class="card pt-3 pb-3">
                            <div class="card-body">
                                <div id="demo"> </div>
                                <i> Please, wait for next Payment Request! </i>
                            </div>
                        </div>
                    <!-- @endif -->
                @else
                    <div class="cd-timeline-block">

                        <div class="cd-timeline-content w-100 p-3">
                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="text-center">
                                        <div class="cd-date mb-4">
                                            {{ $payment_req->created_at ? $payment_req->created_at->diffForHumans() : '' }}
                                        </div>
                                        <div>
                                            <i class="mdi mdi-briefcase-edit-outline h2 text-primary"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-10">
                                    <div>
                                        <!-- <h3>Queue No:# {{ $queueNo }}</h3> -->
                                        <p class="mb-0 text-muted">
                                            @if ($payment_req->requested_amt) Your
                                                requested
                                                amount is <span><b>Rs.
                                                        {{ $payment_req->requested_amt }}</b></span> <br> @endif
                                            <i> Your Request for Payment has been submitted.
                                                The process might take upto 24 working hours from date of submission.
                                                Or sometime it might take more time based on Queue no.</i>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- cd-timeline-content -->
                    </div>
                @endif
            @endif

        </div>



    </div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Payment Details</h4>
                    </div>
                    @if (empty($k_infos) || empty($b_infos))
                        <div class="col-md-4">
                            <div class="float-right">
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle text-uppercase" type="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ti-money mr-1"></i> Add Payment Method
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated">
                                        @if (!isset($k_infos))
                                            <a class="dropdown-item" href="{{ url('/create_khalti') }}">Khalti Detail</a>
                                        @endif
                                        @if (!isset($b_infos))

                                            <a class="dropdown-item" href="{{ url('/create_bank') }}">Bank Account
                                                Details</a>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>
    <div class="row">

        @if (isset($k_infos))

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4>Khalti</h4> <i>(Primary Payment Partner)</i>
                        <h6><span class='text-muted'>Khalti Id : </span>
                            @if ($k_infos->khalti_id)
                                {{ $k_infos->khalti_id }}
                            @else
                                --
                            @endif
                        </h6>
                        <h6><span class='text-muted'>Username : </span>
                            @if ($k_infos->khalti_username)
                                {{ $k_infos->khalti_username }}
                            @else
                                --
                            @endif
                        </h6>

                    </div>
                    <div class="col-md-6">
                        <a href="#" id="editKhalti" style="text-decoration:none;"> Edit khalti Detail </a>
                    </div>
                </div>
            </div>
        @endif
        @if (isset($b_infos))

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4>Bank Detail </h4>
                        <h6><span class='text-muted'>Bank Name : </span>
                            @if ($b_infos->bank_name)
                                {{ $b_infos->bank_name }}
                            @else
                                --
                            @endif
                        </h6>
                        <h6><span class='text-muted'>Branch : </span>
                            @if ($b_infos->branch)
                                {{ $b_infos->branch }}
                            @else
                                --
                            @endif
                        </h6>
                        <h6><span class='text-muted'> A/C Number : </span>
                            @if ($b_infos->ac_no)
                                {{ $b_infos->ac_no }}
                            @else
                                --
                            @endif
                        </h6>
                        <h6><span class='text-muted'> A/C Holder Name:: </span>
                            @if ($b_infos->ac_name)
                                {{ $b_infos->ac_name }}
                            @else
                                --
                            @endif
                        </h6>

                    </div>
                    <div class="col-md-6">
                        <a href="#" id="editBank" style="text-decoration:none;"> Edit Bank Detail </a>
                    </div>
                </div>

            </div>
        @endif
        @if (isset($k_infos))
    </div>
    <div class="row">
        <div class="col-md-6" id="edit_khalti">
            <div class="card">
                <div class="card-body">
                    <form class="form" method="POST" style="padding-left:50px;" action="{{ url('/editKhalti') }}">
                        {{ csrf_field() }}
                        <div class="row form-group">
                            <div class="mb-3">
                                <input type="text" id="khalti_id" name="khalti_id" class="form-control"
                                    value="{{ $k_infos->khalti_id }}" placeholder="Khalti Id">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="mb-3">
                                <input type="text" id="khalti_username" name="khalti_username" class="form-control"
                                    value="{{ $k_infos->khalti_username }}" placeholder="Khalti Username">
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Update</button>
                            <a href="#" id="cancelKhalti" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
        @if (isset($b_infos))
            <div class="col-md-6" id="edit_bank">
                <div class="card">
                    <div class="card-body">
                        <form class="form" method="POST" style="padding-left:50px;" action="{{ url('/editBank') }}">
                            {{ csrf_field() }}
                            <div class="row form-group">
                                <div class="mb-3">
                                    <input type="text" id="bank_name" name="bank_name" class="form-control"
                                        value="{{ $b_infos->bank_name }}" placeholder="Bank Name">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="mb-3">
                                    <input type="text" id="branch" name="branch" class="form-control"
                                        value="{{ $b_infos->branch }}" placeholder="Branch Name">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="mb-3">
                                    <input type="text" id="ac_no" name="ac_no" class="form-control"
                                        value="{{ $b_infos->bank_acno }}" placeholder="Bank A/C Number">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="mb-3">
                                    <input type="text" id="ac_name" name="ac_name" class="form-control"
                                        value="{{ $b_infos->ac_name }}" placeholder="A/C Holder Name">
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Update</button>
                                <a href="#" id="cancelBank" class="btn btn-danger">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- </div> -->

    </div>
    </div>

    @if (Setting::get('CARD') == 1)

        <!-- Add Card Modal -->
        <div id="add-card-modal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">@lang('user.card.add_card')</h4>
                    </div>
                    <form id="payment-form" action="{{ route('card.store') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="row no-margin" id="card-payment">
                                <div class="form-group col-md-12 col-sm-12">
                                    <label>@lang('user.card.fullname')</label>
                                    <input data-stripe="name" autocomplete="off" required type="text" class="form-control"
                                        placeholder="@lang('user.card.fullname')">
                                </div>
                                <div class="form-group col-md-12 col-sm-12">
                                    <label>@lang('user.card.card_no')</label>
                                    <input data-stripe="number" type="text" onkeypress="return isNumberKey(event);" required
                                        autocomplete="off" maxlength="16" class="form-control"
                                        placeholder="@lang('user.card.card_no')">
                                </div>
                                <div class="form-group col-md-4 col-sm-12">
                                    <label>@lang('user.card.month')</label>
                                    <input type="text" onkeypress="return isNumberKey(event);" maxlength="2" required
                                        autocomplete="off" class="form-control" data-stripe="exp-month" placeholder="MM">
                                </div>
                                <div class="form-group col-md-4 col-sm-12">
                                    <label>@lang('user.card.year')</label>
                                    <input type="text" onkeypress="return isNumberKey(event);" maxlength="2" required
                                        autocomplete="off" data-stripe="exp-year" class="form-control" placeholder="YY">
                                </div>
                                <div class="form-group col-md-4 col-sm-12">
                                    <label>@lang('user.card.cvv')</label>
                                    <input type="text" data-stripe="cvc" onkeypress="return isNumberKey(event);" required
                                        autocomplete="off" maxlength="4" class="form-control"
                                        placeholder="@lang('user.card.cvv')">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-default">@lang('user.card.add_card')</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>

    @endif

@endsection

@section('scripts')
<script>
        var config = {
            // replace the publicKey with yours
            "publicKey": "{{ env('public_key_khalti') }}",
            "productIdentity": "<?php echo $esewa_id; ?>",
            "productName": "Dragon",
            "productUrl": "{{url('wallet')}}",
            "paymentPreference": [
                "KHALTI",
                "EBANKING",
                "MOBILE_BANKING",
                "CONNECT_IPS",
                "SCT",
                ],
            "eventHandler": {
                onSuccess (payload) {
                    // hit merchant api for initiating verfication
                    console.log(payload);
                    if(payload.idx){
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "{{route('khalti-verify')}}",
                            type: 'post',
                            data: payload,
                            success:function(response){
                                console.log(response); 

                                alert(response['success']);

                            
                            },
                            error: function (request, error) {
                                console.log(request);
                                alert("Error! Please check");
                            }
                        });
                    }
                },
                onError (error) {
                    console.log(error);
                },
                onClose () {
                    console.log('widget is closing');
                }
            }
        };

        var checkout = new KhaltiCheckout(config);
        var khalti = document.getElementById("khalti-wallet-load");
        var btn = document.getElementById("payment-button");
        khalti.onclick=function (){
                var khaltiamount=$('#tAmtkhalti').val();
                checkout.show({amount:khaltiamount*100 });
            }
        btn.onclick = function () {
            // minimum transaction amount must be 10, i.e 1000 in paisa.
            checkout.show({amount: <?php $amount = abs($user_wallet);
            echo $amount*100;?>});
        }
      
    </script>

    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

    <script type="text/javascript">
        Stripe.setPublishableKey("{{ Setting::get('stripe_publishable_key') }}");

        var stripeResponseHandler = function(status, response) {
            var $form = $('#payment-form');

            console.log(response);

            if (response.error) {
                // Show the errors on the form
                $form.find('.payment-errors').text(response.error.message);
                $form.find('button').prop('disabled', false);
                alert('error');

            } else {
                // token contains id, last4, and card type
                var token = response.id;
                // Insert the token into the form so it gets submitted to the server
                $form.append($('<input type="hidden" id="stripeToken" name="stripe_token" />').val(token));
                jQuery($form.get(0)).submit();
            }
        };

        $('#payment-form').submit(function(e) {

            if ($('#stripeToken').length == 0) {
                console.log('ok');
                var $form = $(this);
                $form.find('button').prop('disabled', true);
                console.log($form);
                Stripe.card.createToken($form, stripeResponseHandler);
                return false;
            }
        });
    </script>
    <script type="text/javascript">
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode;
            if (charCode != 46 && charCode > 31 &&
                (charCode < 48 || charCode > 57))
                return false;

            return true;
        }
    </script>
    <script src="{{ asset('asset/front/js/jquery.min.js') }}"></script>
    <script>
        // function showForm(id)
        // {
        //     console.log('id');
        //     var formid = document.getElementById(id);
        //     if( formid )
        //         formid.style.display = 'block';
        // }

        //Edit Khalti Information.
        $(document).ready(function() {
            $("#editKhalti").click(function() {
                $("#edit_khalti").show();
            });
        });
        $(document).ready(function() {
            $("#cancelKhalti").click(function() {
                $("#edit_khalti").hide();
            });
        });

        //Edit Bank Information.
        $(document).ready(function() {
            $("#editBank").click(function() {
                $("#edit_bank").show();
            });
        });
        $(document).ready(function() {
            $("#cancelBank").click(function() {
                $("#edit_bank").hide();
            });
        });
        //load through esewa
        $(document).ready(function() {
            $("#load").click(function() {
                $("#loadWallet").show();
            });
        });
        $(document).ready(function() {
            $("#cancelload").click(function() {
                $("#loadWallet").hide();
            });
        });
        $(document).ready(function() {
            $("#150").click(function() {
                $("#tAmtkhalti").val("150");
            });
        });
        $(document).ready(function() {
            $("#250").click(function() {
                $("#tAmtkhalti").val("250");
            });
        });
        $(document).ready(function() {
            $("#500").click(function() {
                $("#tAmtkhalti").val("500");
            });
        });
        $(document).ready(function() {
            $("#1000").click(function() {
                $("#tAmtkhalti").val("1000");
            });
        });

        //load through khalti
        $(document).ready(function() {
            $("#load-khalti").click(function() {
                $("#loadkhalti").show();
            });
        });
        $(document).ready(function() {
            $("#cancelloadkhalti").click(function() {
                $("#loadkhalti").hide();
            });
        });
        $(document).ready(function() {
            $("#pay").click(function() {
                $("#payment").show();
            });
        });
    </script>

    <script>
        // Set the date we're counting down to

        // var countDownDate = new Date("Jan 5, 2022 15:37:25").getTime();
        var countDownDate = new Date('{{ $after_ct }}').getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            // var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var days = 0;
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            document.getElementById("demo").innerHTML = hours + "h " +
                minutes + "m " + seconds + "s ";

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("demo").innerHTML = "Please reload the page";
            }
        }, 1000);

        $("#tAmt").focusout(function(e) {
            form = $(this).closest('form');
            var tAmt = form.find("#tAmt").val();
            $('#amt').val(tAmt);
        });
    </script>

@endsection
