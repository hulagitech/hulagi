@extends('admin.layout.master')

@section('title', 'Payment Settings ')

@section('content')
<style>
    .txtedit{
        display: none;
        width: 99%;
        height: 30px;
    }

    #weight{
        display: none;
    }
    .switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 34px;
    }
    
    .switch input { 
      opacity: 0;
      width: 0;
      height: 0;
    }
    
    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }
    
    .slider:before {
      position: absolute;
      content: "";
      height: 26px;
      width: 26px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }
    
    input:checked + .slider {
      background-color: #2196F3;
    }
    
    input:focus + .slider {
      box-shadow: 0 0 1px #2196F3;
    }
    
    input:checked + .slider:before {
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(26px);
    }
    
    /* Rounded sliders */
    .slider.round {
      border-radius: 34px;
    }
    
    .slider.round:before {
      border-radius: 50%;
    }
</style>

<div class="content-area py-1">
    <div class="container-fluid card">
        <div class="box box-block bg-white card-body">
            <form class="form" action="{{route('admin.settings.payment.store')}}" method="POST">
                {{csrf_field()}}
                <h5><i class="ti-files"></i>&nbsp;Payment Gateway</h5>
                <div class="card card-block">
                    <blockquote class="card-blockquote">
                        <i class="fa fa-3x fa-cc-stripe pull-right"></i>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="stripe_secret_key" class="col-form-label">
                                    Stripe (Card Payments)
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="switch">
                                    <input @if(Setting::get('CARD') == 1) checked  @endif  name="CARD" id="stripe_check" onchange="cardselect()" type="checkbox" class="js-switch" data-color="#43b968">
                                    <span class="slider round"></span>
                                </label>
                               
                            </div>
                        </div>
                        <div id="card_field" @if(Setting::get('CARD') == 0) style="display: none;" @endif>
                            <div class="form-group row">
                                <label for="stripe_secret_key" class="col-md-4 col-form-label">Stripe Secret key</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" value="{{Setting::get('stripe_secret_key', '') }}" name="stripe_secret_key" id="stripe_secret_key"  placeholder="Stripe Secret key">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="stripe_publishable_key" class="col-md-4 col-form-label">Stripe Publishable key</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" value="{{Setting::get('stripe_publishable_key', '') }}" name="stripe_publishable_key" id="stripe_publishable_key"  placeholder="Stripe Publishable key">
                                </div>
                            </div>
                        </div>
                    </blockquote>
                </div>
                <div class="card card-block">
					<blockquote class="card-blockquote">
                        <i class="fa fa-3x fa fa-cc-paypal pull-right"></i>
						<div class="form-group row">
								<div class="col-md-4">
									<label for="stripe_secret_key" class="col-form-label">
										Paypal Setting
									</label>
								</div>
								<div class="col-md-6">
                                    <label class="switch">
                                    <input @if(Setting::get('PAYPAL') == 1) checked  @endif  name="PAYPAL" id="paypal_check" onchange="paypalselect()" type="checkbox" class="js-switch" data-color="#43b968">
                                    <span class="slider round"></span>
                                    </label>
									
								</div>
							</div>
							<div id="paypal_field" @if(Setting::get('PAYPAL') == 0) style="display: none;" @endif>
							<div class="form-group row">
								<label for="PAYPAL_CLIENT_ID" class="col-md-4 col-form-label">Paypal Client Id</label>
								<div class="col-md-8">
									<input class="form-control" type="text" value="{{ Setting::get('PAYPAL_CLIENT_ID', '')  }}" name="PAYPAL_CLIENT_ID" required id="PAYPAL_CLIENT_ID" placeholder=">Paypal Client Id">
								</div>
							</div>
							<div class="form-group row">
								<label for="PAYPAL_SECRET" class="col-md-4 col-form-label">Pay Secret Key</label>
								<div class="col-md-8">
									<input class="form-control" type="text" value="{{ Setting::get('PAYPAL_SECRET', '')  }}" name="PAYPAL_SECRET" required id="PAYPAL_SECRET" placeholder="Contact Email">
								</div>
							</div>
							<div class="form-group row">
								<label for="PAYPAL_MODE" class="col-md-4 col-form-label">PAYPAL MODE</label>
								<div class="col-md-8">
									<select class="form-control" id="PAYPAL_MODE" name="PAYPAL_MODE">
										<option value="sandbox" @if(Setting::get('PAYPAL_MODE', 0) == 'sandbox') selected @endif>Sandbox</option>
										<option value="live" @if(Setting::get('PAYPAL_MODE', 0) == 'live') selected @endif>Live</option>
									</select>
								</div>
							</div>
							</div>
					</blockquote>
				</div>
				<div class="card card-block">
					<blockquote class="card-blockquote">
						 <div class="form-group row">
								<div class="col-md-4">
									<label for="stripe_secret_key" class="col-form-label">
										Razorpay Setting
									</label>
								</div>
								<div class="col-md-6">
                                    <label class="switch">
                                    <input @if(Setting::get('RAZORPAY') == 1) checked  @endif  name="RAZORPAY" id="razorpay_check" onchange="razorpayselect()" type="checkbox" class="js-switch" data-color="#43b968">
                                    <span class="slider round"></span>
                                    </label>
								</div>
							</div>
								 <div id="razorpay_field" @if(Setting::get('RAZORPAY') == 0) style="display: none;" @endif>
							<div class="form-group row">
								<label for="RAZORPAY_CLIENT_ID" class="col-md-4 col-form-label">Razorpay Client Id</label>
								<div class="col-md-8">
									<input class="form-control" type="text" value="{{ Setting::get('RAZORPAY_CLIENT_ID', '')  }}" name="RAZORPAY_CLIENT_ID" required id="RAZORPAY_CLIENT_ID" placeholder="Razorpay Client Id">
								</div>
							</div>
							
							<div class="form-group row">
								<label for="RAZORPAY_SECRET" class="col-md-4 col-form-label">Razorpay Secret Key</label>
								<div class="col-md-8">
									<input class="form-control" type="text" value="{{ Setting::get('RAZORPAY_SECRET', '')  }}" name="RAZORPAY_SECRET" required id="RAZORPAY_SECRET" placeholder="RAZORPAY SECRET">
								</div>
							</div>
							
							<div class="form-group row">
								<label for="RAZORPAY_MODE" class="col-md-4 col-form-label">Razorpay MODE</label>
								<div class="col-md-8">
									<select class="form-control" id="RAZORPAY_MODE" name="RAZORPAY_MODE">
										<option value="sandbox" @if(Setting::get('RAZORPAY_MODE', 0) == 'sandbox') selected @endif>Sandbox</option>
										<option value="live" @if(Setting::get('RAZORPAY_MODE', 0) == 'live') selected @endif>Live</option>
									</select>
								</div>
							</div>
						</div>
					</blockquote>
				</div>
                <div class="card card-block">
                    <blockquote class="card-blockquote">
                        <i class="fa fa-3x fa-money pull-right"></i>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="cash-payments" class="col-form-label">
                                    Cash Payments
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="switch">
                                   <input @if(Setting::get('CASH') == 1) checked  @endif name="CASH" id="cash-payments" onchange="cardselect()" type="checkbox" class="js-switch" data-color="#43b968">
                                    <span class="slider round"></span>
                                </label>
                                
                            </div>
                        </div>
                    </blockquote>
                </div>
                <h5>Payment Settings</h5>
                <div class="card card-block">
                    <blockquote class="card-blockquote">
                        <!-- <div class="form-group row">
                            <label for="daily_target" class="col-md-4 col-form-label">Daily Target</label>
                            <div class="col-md-8">
                                <input class="form-control" 
                                    type="number"
                                    value="{{ Setting::get('daily_target', '0')  }}"
                                    id="daily_target"
                                    name="daily_target"
                                    min="0"
                                    required
                                    placeholder="Daily Target">
                            </div>
                        </div> -->

                        <div class="form-group row">
                            <label for="tax_percentage" class="col-md-4 col-form-label">Tax percentage(%)</label>
                            <div class="col-md-8">
                                <input class="form-control"
                                    type=""
                                    value="{{ Setting::get('tax_percentage', '0')  }}"
                                    id="tax_percentage"
                                    name="tax_percentage"
                                    
                                    placeholder="Tax Percentage">
                            </div>
                        </div>

                        <!-- <div class="form-group row">
                            <label for="surge_trigger" class="col-md-4 col-form-label">Surge Trigger Point</label>
                            <div class="col-md-8">
                                <input class="form-control"
                                    type="number"
                                    value="{{ Setting::get('surge_trigger', '')  }}"
                                    id="surge_trigger"
                                    name="surge_trigger"
                                    min="0"
                                    required
                                    placeholder="Surge Trigger Point">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="surge_percentage" class="col-md-4 col-form-label">Surge percentage(%)</label>
                            <div class="col-md-8">
                                <input class="form-control"
                                    type="number"
                                    value="{{ Setting::get('surge_percentage', '0')  }}"
                                    id="surge_percentage"
                                    name="surge_percentage"
                                    min="0"
                                    max="100"
                                    placeholder="Surge percentage">
                            </div>
                        </div> -->

                        <div class="form-group row">
                            <label for="commission_percentage" class="col-md-4 col-form-label">Commission percentage(%)</label>
                            <div class="col-md-8">
                                <input class="form-control"
                                    type=""
                                    value="{{ Setting::get('commission_percentage', '0') }}"
                                    id="commission_percentage"
                                    name="commission_percentage"
                                
                                    placeholder="Commission percentage">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="commission_percentage" class="col-md-4 col-form-label">Cargo Charge</label>
                            <div class="col-md-8">
                                <input class="form-control"
                                    type=""
                                    value="{{ Setting::get('cargo_amount', '0') }}"
                                    id="cargo_amount"
                                    name="cargo_amount"
                                
                                    placeholder="Cargo Amount">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="commission_percentage" class="col-md-4 col-form-label">Hold Amount Charge</label>
                            <div class="col-md-8">
                                <input class="form-control"
                                    type=""
                                    value="{{ Setting::get('hold_amount', '0') }}"
                                    id="hold_amount"
                                    name="hold_amount"
                                
                                    placeholder="Hold Amount Charge">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="booking_prefix" class="col-md-4 col-form-label">Booking ID Prefix</label>
                            <div class="col-md-8">
                                <input class="form-control"
                                    type="text"
                                    value="{{ Setting::get('booking_prefix', '0') }}"
                                    id="booking_prefix"
                                    name="booking_prefix"
                                    min="0"
                                    max="4"
                                    placeholder="Booking ID Prefix">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="base_price" class="col-md-4 col-form-label">
                                Currency ( <strong>{{ Setting::get('currency', '$')  }} </strong>)
                            </label>
                            <div class="col-md-8">
                                <select name="currency" class="form-control" required>
                                    <option @if(Setting::get('currency') == "TZS") selected @endif value="TZS">Tanzania (TZS)</option>
                                    <option @if(Setting::get('currency') == "$") selected @endif value="$">US Dollar (USD)</option>
                                    <option @if(Setting::get('currency') == "₹") selected @endif value="₹"> Indian Rupee (INR)</option>

                                    <option @if(Setting::get('currency') == "KES") selected @endif value="KES"> Kenya (KES)</option>

                                    <option @if(Setting::get('currency') == "د.ك") selected @endif value="د.ك">Kuwaiti Dinar (KWD)</option>
                                    <option @if(Setting::get('currency') == "د.ب") selected @endif value="د.ب">Bahraini Dinar (BHD)</option>
                                    <option @if(Setting::get('currency') == "﷼") selected @endif value="﷼">Omani Rial (OMR)</option>
                                    <option @if(Setting::get('currency') == "£") selected @endif value="£">British Pound (GBP)</option>
                                    <option @if(Setting::get('currency') == "€") selected @endif value="€">Euro (EUR)</option>
                                    <option @if(Setting::get('currency') == "CHF") selected @endif value="CHF">Swiss Franc (CHF)</option>
                                    <option @if(Setting::get('currency') == "ل.د") selected @endif value="ل.د">Libyan Dinar (LYD)</option>
                                    <option @if(Setting::get('currency') == "B$") selected @endif value="B$">Bruneian Dollar (BND)</option>
                                    <option @if(Setting::get('currency') == "S$") selected @endif value="S$">Singapore Dollar (SGD)</option>
                                    <option @if(Setting::get('currency') == "AU$") selected @endif value="AU$"> Australian Dollar (AUD)</option>
                                    <option @if(Setting::get('currency') == "؋") selected @endif value="؋"> Afghanis (AFN)</option>
                                    <option @if(Setting::get('currency') == "$") selected @endif value="$"> Pesos (ARS)</option>
                                    <option @if(Setting::get('currency') == "ƒ") selected @endif value="ƒ"> Guilders (AWG)</option>
                                    <option @if(Setting::get('currency') == "ман") selected @endif value="ман">New Manats (AZN)</option>
                                    <option @if(Setting::get('currency') == "$") selected @endif value="$"> Dollars (BSD)</option>
                                    <option @if(Setting::get('currency') == "$") selected @endif value="$">Dollars (BBD)</option>
                                    <option @if(Setting::get('currency') == "p.") selected @endif value="p."> Rubles (BYR)</option>
                                    <option @if(Setting::get('currency') == "BZ$") selected @endif value="BZ$"> Dollars (BZD)</option>
                                    <option @if(Setting::get('currency') == "£") selected @endif value="£"> Pounds (EGP)</option>
                                    <option @if(Setting::get('currency') == "¢") selected @endif value="¢">Cedis (GHC)</option>
                                    <option @if(Setting::get('currency') == "kr") selected @endif value="kr"> Kronur (ISK)</option>
                                    <option @if(Setting::get('currency') == "Rp") selected @endif value="Rp"> Rupiahs (IDR)</option>
                                    <option @if(Setting::get('currency') == "﷼") selected @endif value="﷼"> Rials (IRR)</option>
                                    <option @if(Setting::get('currency') == "₨") selected @endif value="₨"> Rupees (MUR)</option>
                                    <option @if(Setting::get('currency') == "฿") selected @endif value="฿"> Baht (THB)</option>
                                    <option @if(Setting::get('currency') == "₨") selected @endif value="₨"> Rupees (MUR)</option>
                                    <option @if(Setting::get('currency') == "kr") selected @endif value="kr"> Kronor (SEK)</option>
                                    <option @if(Setting::get('currency') == "лв") selected @endif value="лв"> Sums (UZS)</option>
                                    <option @if(Setting::get('currency') == "₴") selected @endif value="₴"> Hryvnia (UAH)</option>
                                    <option @if(Setting::get('currency') == "руб") selected @endif value="руб"> Rubles (RUB)</option>
                                    <option @if(Setting::get('currency') == "﷼") selected @endif value="﷼"> Riyals (SAR)</option>
                                    <option @if(Setting::get('currency') == "S") selected @endif value="S"> Shillings (SOS)</option>
                                    <option @if(Setting::get('currency') == "R") selected @endif value="R"> Rand (ZAR)</option>
                                    <option @if(Setting::get('currency') == "NT$") selected @endif value="NT$"> New Dollars (TWD)</option>
                                    <option @if(Setting::get('currency') == "TL") selected @endif value="TL"> Lira (TRY)</option>
                                    <option @if(Setting::get('currency') == "$") selected @endif value="$"> Dollars (TVD)</option>
                                </select>
                            </div>
                        </div>
                    </blockquote>
                </div>
                <div class="form-group row">
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-success shadow-box btn-block">Update</button>
                        
                    </div>
                    <div class="offset-md-4 col-md-4">
                       <a href="{{ route('admin.dashboard') }}" class="btn btn-danger shadow-box btn-block">Cancel</a> 
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
function cardselect()
{
    if($('#stripe_check').is(":checked")) {
        $("#card_field").fadeIn(700);
    } else {
        $("#card_field").fadeOut(700);
    }
}
function paypalselect()
{
    if($('#paypal_check').is(":checked")) {
        $("#paypal_field").fadeIn(700);
    } else {
        $("#paypal_field").fadeOut(700);
    }
}
function razorpayselect()
{
    if($('#razorpay_check').is(":checked")) {
        $("#razorpay_field").fadeIn(700);
    } else {
        $("#razorpay_field").fadeOut(700);
    }
}
</script>
@endsection