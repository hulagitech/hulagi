<?php 
	
	if( isset( $zone ) ) {
		$zone_name 	=	$zone->name;
		$zone_id	=	$zone->id;		
		
	} else {
		$zone_name = '';
		$zone_id = 0;
	
	}

?>

{{-- <div class="modal" tabindex="-1" id="zoneModel" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title pull-left">Add Location</h4>
					<span class="btn close  zone_close pull-right" id="zone_close" onClick="window.location.reload()"><i
							class="fa fa-times"></i></span>
        
        </button>
      </div>
      <div class="modal-body">
					<div class="form-group">
						<input type="hidden" name="country_id" id="country_id" />
						<select class='form-control' v-model='country' @change='getStates()' name="country_name"
							id="country_name">
							<option value='0'>Select Country</option>
							<option v-for='data in countries' :value='data.id'>@{{ data.name }}</option>
						</select>
					</div>
					<div class="form-group">
						<input type="hidden" name="state_id" id="state_id" />
						<select class='form-control' v-model='state' @change='getCities()' name="state_name"
							id="state_name">
							<option value='0'>Select State</option>
							<option v-for='data in states' :value='data.id'>@{{ data.name }}</option>
						</select>
					</div>
					<div class="form-group">
						<input type="hidden" name="city_id" id="city_id" />
						<select class='form-control' v-model='city' name="city_name" id="city_name">
							<option value='0'>Select City</option>
							<option v-for='data in cities' :value='data.id'>@{{ data.name }}</option>
						</select>
					</div>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Zone Name" name="zone_name"
							value="{{ $zone_name }}" />
						<input type="hidden" name="zone_id" id="zone_id" value="{{ $zone_id }}" />
					</div>
					<div class="form-group">
						<!--<input type="text" class="form-control" placeholder="Currency Name" name="currency_name"/>-->
						<select name="currency_name" id="currency_name" class="form-control" required>
							<option @if(Setting::get('currency')=="TZS" ) selected @endif value="TZS">Tanzania (TZS)
							</option>
							<option @if(Setting::get('currency')=="$" ) selected @endif value="$">US Dollar (USD)
							</option>
							<option @if(Setting::get('currency')=="₹" ) selected @endif value="₹"> Indian Rupee (INR)
							</option>
							<option @if(Setting::get('currency')=="KES" ) selected @endif value="KES"> Kenya (KES)
							</option>
							<option @if(Setting::get('currency')=="د.ك" ) selected @endif value="د.ك">Kuwaiti Dinar
								(KWD)</option>
							<option @if(Setting::get('currency')=="د.ب" ) selected @endif value="د.ب">Bahraini Dinar
								(BHD)</option>
							<option @if(Setting::get('currency')=="﷼" ) selected @endif value="﷼">Omani Rial (OMR)
							</option>
							<option @if(Setting::get('currency')=="£" ) selected @endif value="£">British Pound (GBP)
							</option>
							<option @if(Setting::get('currency')=="€" ) selected @endif value="€">Euro (EUR)</option>
							<option @if(Setting::get('currency')=="CHF" ) selected @endif value="CHF">Swiss Franc (CHF)
							</option>
							<option @if(Setting::get('currency')=="ل.د" ) selected @endif value="ل.د">Libyan Dinar (LYD)
							</option>
							<option @if(Setting::get('currency')=="B$" ) selected @endif value="B$">Bruneian Dollar
								(BND)</option>
							<option @if(Setting::get('currency')=="S$" ) selected @endif value="S$">Singapore Dollar
								(SGD)</option>
							<option @if(Setting::get('currency')=="AU$" ) selected @endif value="AU$"> Australian Dollar
								(AUD)</option>
							<option @if(Setting::get('currency')=="؋" ) selected @endif value="؋"> Afghanis (AFN)
							</option>
							<option @if(Setting::get('currency')=="$" ) selected @endif value="$"> Pesos (ARS)</option>
							<option @if(Setting::get('currency')=="ƒ" ) selected @endif value="ƒ"> Guilders (AWG)
							</option>
							<option @if(Setting::get('currency')=="ман" ) selected @endif value="ман">New Manats (AZN)
							</option>
							<option @if(Setting::get('currency')=="$" ) selected @endif value="$"> Dollars (BSD)
							</option>
							<option @if(Setting::get('currency')=="$" ) selected @endif value="$">Dollars (BBD)</option>
							<option @if(Setting::get('currency')=="p." ) selected @endif value="p."> Rubles (BYR)
							</option>
							<option @if(Setting::get('currency')=="BZ$" ) selected @endif value="BZ$"> Dollars (BZD)
							</option>
							<option @if(Setting::get('currency')=="£" ) selected @endif value="£"> Pounds (EGP)</option>
							<option @if(Setting::get('currency')=="¢" ) selected @endif value="¢">Cedis (GHC)</option>
							<option @if(Setting::get('currency')=="kr" ) selected @endif value="kr"> Kronur (ISK)
							</option>
							<option @if(Setting::get('currency')=="Rp" ) selected @endif value="Rp"> Rupiahs (IDR)
							</option>
							<option @if(Setting::get('currency')=="﷼" ) selected @endif value="﷼"> Rials (IRR)</option>
							<option @if(Setting::get('currency')=="₨" ) selected @endif value="₨"> Rupees (MUR)</option>
							<option @if(Setting::get('currency')=="฿" ) selected @endif value="฿"> Baht (THB)</option>
							<option @if(Setting::get('currency')=="₨" ) selected @endif value="₨"> Rupees (MUR)</option>
							<option @if(Setting::get('currency')=="kr" ) selected @endif value="kr"> Kronor (SEK)
							</option>
							<option @if(Setting::get('currency')=="лв" ) selected @endif value="лв"> Sums (UZS)</option>
							<option @if(Setting::get('currency')=="₴" ) selected @endif value="₴"> Hryvnia (UAH)
							</option>
							<option @if(Setting::get('currency')=="руб" ) selected @endif value="руб"> Rubles (RUB)
							</option>
							<option @if(Setting::get('currency')=="﷼" ) selected @endif value="﷼"> Riyals (SAR)</option>
							<option @if(Setting::get('currency')=="S" ) selected @endif value="S"> Shillings (SOS)
							</option>
							<option @if(Setting::get('currency')=="R" ) selected @endif value="R"> Rand (ZAR)</option>
							<option @if(Setting::get('currency')=="NT$" ) selected @endif value="NT$"> New Dollars (TWD)
							</option>
							<option @if(Setting::get('currency')=="TL" ) selected @endif value="TL"> Lira (TRY)</option>
							<option @if(Setting::get('currency')=="$" ) selected @endif value="$"> Dollars (TVD)
							</option>
						</select>
					</div>
					<h5 class="modal-title pull-left">Status</h5><br><br>
					<div class="form-group">
						<input type="radio" value="active" name="status_name" class="pull-left">Active
						<input type="radio" value="inactive" name="status_name" class="align-center">Inactive
						<input type="radio" value="banned" name="status_name">Banned
					</div>
				</div>
				<div class="modal-footer">
					<a class="btn btn-block" id="submit_zone_btn"><i class="fa fa-save"></i> SUBMIT</a>
				</div>
    </div>
  </div>
</div> --}}

<div class="modal fade" tabindex="-1" id="zoneModel"  role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="zoneForm">
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title pull-left">Add Location</h4>
					<span class="btn close  zone_close pull-right" id="zone_close" onClick="window.location.reload()"><i
							class="fa fa-times"></i></span>
				</div>
				<!-- Modal body -->
				<div class="modal-body">
					<div class="form-group">
						<input type="hidden" name="country_id" id="country_id" />
						<select class='form-control' v-model='country' @change='getStates()' name="country_name"
							id="country_name">
							<option value='0'>Select Country</option>
							<option v-for='data in countries' :value='data.id'>@{{ data.name }}</option>
						</select>
					</div>
					<div class="form-group">
						<input type="hidden" name="state_id" id="state_id" />
						<select class='form-control' v-model='state' @change='getCities()' name="state_name"
							id="state_name">
							<option value='0'>Select State</option>
							<option v-for='data in states' :value='data.id'>@{{ data.name }}</option>
						</select>
					</div>
					<div class="form-group">
						<input type="hidden" name="city_id" id="city_id" />
						<select class='form-control' v-model='city' name="city_name" id="city_name">
							<option value='0'>Select City</option>
							<option v-for='data in cities' :value='data.id'>@{{ data.name }}</option>
						</select>
					</div>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Zone Name" name="zone_name"
							value="{{ $zone_name }}" />
						<input type="hidden" name="zone_id" id="zone_id" value="{{ $zone_id }}" />
					</div>
					<div class="form-group">
						<!--<input type="text" class="form-control" placeholder="Currency Name" name="currency_name"/>-->
						<select name="currency_name" id="currency_name" class="form-control" required>
							<option @if(Setting::get('currency')=="TZS" ) selected @endif value="TZS">Tanzania (TZS)
							</option>
							<option @if(Setting::get('currency')=="$" ) selected @endif value="$">US Dollar (USD)
							</option>
							<option @if(Setting::get('currency')=="₹" ) selected @endif value="₹"> Indian Rupee (INR)
							</option>
							<option @if(Setting::get('currency')=="KES" ) selected @endif value="KES"> Kenya (KES)
							</option>
							<option @if(Setting::get('currency')=="د.ك" ) selected @endif value="د.ك">Kuwaiti Dinar
								(KWD)</option>
							<option @if(Setting::get('currency')=="د.ب" ) selected @endif value="د.ب">Bahraini Dinar
								(BHD)</option>
							<option @if(Setting::get('currency')=="﷼" ) selected @endif value="﷼">Omani Rial (OMR)
							</option>
							<option @if(Setting::get('currency')=="£" ) selected @endif value="£">British Pound (GBP)
							</option>
							<option @if(Setting::get('currency')=="€" ) selected @endif value="€">Euro (EUR)</option>
							<option @if(Setting::get('currency')=="CHF" ) selected @endif value="CHF">Swiss Franc (CHF)
							</option>
							<option @if(Setting::get('currency')=="ل.د" ) selected @endif value="ل.د">Libyan Dinar (LYD)
							</option>
							<option @if(Setting::get('currency')=="B$" ) selected @endif value="B$">Bruneian Dollar
								(BND)</option>
							<option @if(Setting::get('currency')=="S$" ) selected @endif value="S$">Singapore Dollar
								(SGD)</option>
							<option @if(Setting::get('currency')=="AU$" ) selected @endif value="AU$"> Australian Dollar
								(AUD)</option>
							<option @if(Setting::get('currency')=="؋" ) selected @endif value="؋"> Afghanis (AFN)
							</option>
							<option @if(Setting::get('currency')=="$" ) selected @endif value="$"> Pesos (ARS)</option>
							<option @if(Setting::get('currency')=="ƒ" ) selected @endif value="ƒ"> Guilders (AWG)
							</option>
							<option @if(Setting::get('currency')=="ман" ) selected @endif value="ман">New Manats (AZN)
							</option>
							<option @if(Setting::get('currency')=="$" ) selected @endif value="$"> Dollars (BSD)
							</option>
							<option @if(Setting::get('currency')=="$" ) selected @endif value="$">Dollars (BBD)</option>
							<option @if(Setting::get('currency')=="p." ) selected @endif value="p."> Rubles (BYR)
							</option>
							<option @if(Setting::get('currency')=="BZ$" ) selected @endif value="BZ$"> Dollars (BZD)
							</option>
							<option @if(Setting::get('currency')=="£" ) selected @endif value="£"> Pounds (EGP)</option>
							<option @if(Setting::get('currency')=="¢" ) selected @endif value="¢">Cedis (GHC)</option>
							<option @if(Setting::get('currency')=="kr" ) selected @endif value="kr"> Kronur (ISK)
							</option>
							<option @if(Setting::get('currency')=="Rp" ) selected @endif value="Rp"> Rupiahs (IDR)
							</option>
							<option @if(Setting::get('currency')=="﷼" ) selected @endif value="﷼"> Rials (IRR)</option>
							<option @if(Setting::get('currency')=="₨" ) selected @endif value="₨"> Rupees (MUR)</option>
							<option @if(Setting::get('currency')=="฿" ) selected @endif value="฿"> Baht (THB)</option>
							<option @if(Setting::get('currency')=="₨" ) selected @endif value="₨"> Rupees (MUR)</option>
							<option @if(Setting::get('currency')=="kr" ) selected @endif value="kr"> Kronor (SEK)
							</option>
							<option @if(Setting::get('currency')=="лв" ) selected @endif value="лв"> Sums (UZS)</option>
							<option @if(Setting::get('currency')=="₴" ) selected @endif value="₴"> Hryvnia (UAH)
							</option>
							<option @if(Setting::get('currency')=="руб" ) selected @endif value="руб"> Rubles (RUB)
							</option>
							<option @if(Setting::get('currency')=="﷼" ) selected @endif value="﷼"> Riyals (SAR)</option>
							<option @if(Setting::get('currency')=="S" ) selected @endif value="S"> Shillings (SOS)
							</option>
							<option @if(Setting::get('currency')=="R" ) selected @endif value="R"> Rand (ZAR)</option>
							<option @if(Setting::get('currency')=="NT$" ) selected @endif value="NT$"> New Dollars (TWD)
							</option>
							<option @if(Setting::get('currency')=="TL" ) selected @endif value="TL"> Lira (TRY)</option>
							<option @if(Setting::get('currency')=="$" ) selected @endif value="$"> Dollars (TVD)
							</option>
						</select>
					</div>
					<h5 class="modal-title pull-left">Status</h5><br><br>
					<div class="form-group">
						<input type="radio" value="active" name="status_name" class="pull-left">Active
						<input type="radio" value="inactive" name="status_name" class="align-center">Inactive
						<input type="radio" value="banned" name="status_name">Banned
					</div>
				</div>
				<div class="modal-footer">
					<a class="btn btn-block" id="submit_zone_btn"><i class="fa fa-save"></i> SUBMIT</a>
				</div>
			</form>
		</div>
	</div>
</div>