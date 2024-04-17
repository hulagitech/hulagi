@extends('admin.layout.master')

@section('title', 'Add Promocode ')

@section('content')
{{-- CSS and JS for tagsinput and typeahead --}}
<script type="text/javascript" src="{{asset('asset/front/js/typeahead.min.js')}}"></script>
<script type="text/javascript" src="{{asset('asset/front/js/bootstrap-tagsinput.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('asset/front/css/bootstrap-tagsinput.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('asset/front/css/typeaheadjs.css')}}">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="row align-items-center">
				<div class="col-md-8">
					<h4 class="page-title m-0">Add PromoCode</h4>
				</div>

			</div>

		</div>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
					<form action="{{route('admin.promocode.update',$promocode->id)}}" method="POST" enctype="multipart/form-data" role="form">
					{{csrf_field()}}
					<div class="form-group row align-items-center">
						<label for="promo_code" class="col-md-2 text-right">Promocode</label>
						<div class="col-md-10">
							<input class="form-control" autocomplete="off"  type="text" value="{{ $promocode->promo_code }}" name="promo_code" required id="promo_code" placeholder="Promocode" readonly>
						</div>
					</div>
					<div class="form-group row align-items-center">
						<label for="discount_type" class="col-md-2 text-right">Discount_type</label>
						<div class="col-md-10">
							<select name="Discount_type" class="form-control" id="Discount_type" required="" readonly >
								<option value="{{ $promocode->Discount_type }}" >{{ $promocode->Discount_type }}</option>			 
								<option value="Percentage">Percentage</option>
							
								<option value="Amount">Amount</option>
							</select>
						</div>
					</div>
					<div class="form-group row align-items-center">
						<label for="discount" class="col-md-2 text-right">Discount</label>
						<div class="col-md-10">
							<input class="form-control" type="number" value="{{ $promocode->discount }}" name="discount" required id="discount" placeholder="Discount" readonly>
						</div>
					</div>

					<div class="form-group row align-items-center">
						<label for="expiration" class="col-md-2 text-right">Expiration</label>
						<div class="col-md-10">
							{{ $promocode->expiration }}
							<input class="form-control" type="date" value="{{ $promocode->expiration }}" name="expiration" required id="expiration" placeholder="Expiration">
						</div>
					</div>
					<div class="form-group row align-items-center">
						<label for="limit" class="col-md-2 text-right">Set Limit</label>
						<div class="col-md-10">
							<input class="form-control" type="text" value="{{ $promocode->set_limit }}" name="set_limit" required id="set_limit" placeholder="Limit">
						</div>
					</div>
					<div class="form-group row align-items-center">
						<label for="times" class="col-md-2 text-right">Number Of Time</label>
						<div class="col-md-10">
							<input class="form-control" type="text" value="{{ $promocode->number_of_time }}" name="number_of_time" required id="number_of_time" placeholder="Times">
						</div>
					</div>
					<div class="form-group row align-items-center">
						<label for="zone" class="col-md-2 text-right">Zone</label>
						<div class="col-md-10">
							<input class="form-control typeahead" value="@if(@$promocode->promozone)@foreach (@$promocode->promozone as $zone){{ @$zone->Zones->zone_name }},@endforeach @endif" type="text" placeholder="Type in and select zones"
								name="zone" required id="zone">
						</div>
					</div>
					<div class="form-group row align-items-center">
						<label for="zone" class="col-md-2 text-right">Restricted Zone</label>
						<div class="col-md-10">
							<input class="form-control typeahead" type="text" value="@if(@$promocode->promozone)@foreach (@$promocode->promozone as $zone){{ @$zone->RestrictedZones->zone_name }},@endforeach @endif" placeholder="Type in and select zones" name="restricted_zone" required id="restricted_zone">
						</div>
					</div>
					<div class="form-group row align-items-center">
						<label for="expiration" class="col-md-2 text-right">User</label>
							<div class="col-md-10">
								<select name="user_type" class="form-control" id="user_type" required="">
									<option value="{{ $promocode->user_type }}">@if($promocode->user_type==1)
										Business
									@elseif($promocode->user_type==2)
										Person
									@else
										Both
									@endif
									</option>			 
									<option value="1">Business</option>
									<option value="2">Person</option>
									<option value="3">Both</option>
								</select>
							</div>
					</div>
					<div class="row form-group align-items-center justify-content-end">
						<button type="submit" class="btn btn-primary mr-2">Update Promocode</button>
						<a href="{{route('admin.promocode.index')}}" class="btn btn-danger mr-2">Cancel</a>
					</div>
					
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	var zones = new Bloodhound({
		datumTokenizer: Bloodhound.tokenizers.whitespace,
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		// url points to a json file that contains an array of country names, see
		// https://github.com/twitter/typeahead.js/blob/gh-pages/data/countries.json
		prefetch: {
			url: "{{url('/admin/allZones')}}",
			cache: false
		},
	});
	zones.initialize();

	$('.typeahead').tagsinput({
	typeaheadjs: {
		name: 'zones',
		source: zones.ttAdapter()
	}
	});
	var restricted_zone = new Bloodhound({
		datumTokenizer: Bloodhound.tokenizers.whitespace,
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		// url points to a json file that contains an array of country names, see
		// https://github.com/twitter/typeahead.js/blob/gh-pages/data/countries.json
		prefetch: {
			url: "{{url('/admin/allZones')}}",
			cache: false
		},
	});
	restricted_zone.initialize();

	$('.typeahead').tagsinput({
	typeaheadjs: {
		name: 'restricted_zone',
		source: zones.ttAdapter()
	}
	});


	$('#submit').click(function(){
		console.log($('.typeahead').val());
	});
	document.addEventListener('keypress', function (e) {
            if (e.keyCode === 13 || e.which === 13) {
                e.preventDefault();
                return false;
            }
            
        });
</script>
@endsection
