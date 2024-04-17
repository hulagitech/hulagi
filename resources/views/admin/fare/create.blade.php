@extends('admin.layout.master')

@section('title', 'Site Settings ')

@section('content')
 

<div class="row" style="padding:20px;">
      <div class="col-md-12">
            <div>
                <h4 class="page-title"><i class="fa fa-angle-right"></i>Fare Setting </h4>
            </div>
            <hr>
            <form class="form"  action="{{ route('admin.fare.store') }}" method="POST" enctype="multipart/form-data" role="form">
            	{{csrf_field()}}
            	
            		<div class="form-group row">
					<label for="zone1" class="col-md-2 col-form-label">Zone1</label>
					<div class="col-md-10">
						<select class="form-control" name="zone1" required id="zone1">
							@foreach ($zones as $zone)
								<option value="{{$zone->id}}"
									@if(isset($fare))
										{{$fare->zone1_id==$zone->id? "selected": ""}}
									@endif
								>{{$zone->zone_name}}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="form-group row">
					<label for="zone2" class="col-md-2 col-form-label">Zone2</label>
					<div class="col-md-10">
						<select class="form-control" name="zone2" required id="zone2">
							@foreach ($zones as $zone)
								<option value="{{$zone->id}}"
									@if(isset($fare))
										{{$fare->zone2_id==$zone->id? "selected": ""}}
									@endif
								>{{$zone->zone_name}}</option>
							@endforeach
						</select>
					</div>
				</div>

			
                <div class="form-group row">
                    <label for="km" class="col-md-2 col-form-label">Upto KM</label>
                    <div class="col-md-10">
						<input class="form-control" type="text" name="km" id="km" placeholder="Enter max km (Leave blank for all others)" onkeypress="javascript:return isValid(this,event)"
						value=@if(isset($fare))
								{{$fare->km}}
							@else
								""
							@endif
						>
                    </div>
                </div>

				<div class="form-group row">
					<label for="fare_half_kg" class="col-md-2 col-form-label">Fare (Upto 500g)</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="fare_half_kg"  id="fare_half_kg" onkeypress="javascript:return isValid(this,event)"
							value=@if(isset($fare))
									{{$fare->fare_half_kg}}
								@else
									""
								@endif
						>
					</div>
				</div>

				<div class="form-group row">
					<label for="fare" class="col-md-2 col-form-label">Fare (Above 500g)</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="fare"  id="fare" onkeypress="javascript:return isValid(this,event)"
							value=@if(isset($fare))
									{{$fare->fare}}
								@else
									""
								@endif
						>
					</div>
				</div>
				<div class="form-group row">
					<label for="fare_half_kg" class="col-md-2 col-form-label">Fare Person</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="person"  id="person" onkeypress="javascript:return isValid(this,event)"
							value=@if(isset($fare))
									{{$fare->Percentage_increase}}
								@endif
						>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="delay_period" class="col-md-2 col-form-label">Delay(Days)</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="delay_period"  id="delay_period" 
						value="@if(isset($fare)){{$fare->delay_period}}@endif">
					</div>
				</div>

				<div class="form-group row">
					<label for="extremely_delay_period" class="col-md-2 col-form-label">Extreme Delay(Days)</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="extremely_delay_period"  id="extremely_delay_period" 
						value="@if(isset($fare)){{$fare->extremely_delay_period}}@endif">
					</div>
				</div>

				<div class="form-group row">
					<label for="cargo" class="col-md-2 col-form-label">Cargo</label>
					<div class="col-md-10">
							{{-- <label for="yes">Yes</label>
							<input type="radio" id="yes" name="cargo" value="1"  >
							<label for="no">No</label>
							<input type="radio" id="no" name="cargo" value="0" @if($fare->cargo=='0')) {{$fare->cargo}} @endif > --}}
							<label for="yes">Yes</label>
							<input type="radio" id="yes" name="cargo" value="1" @if(isset($fare->cargo)) @if(@$fare->cargo=='1') checked @endif @else checked @endif>
							<label for="no">No</label>
							<input type="radio" id="no" name="cargo" value="0" @if(isset($fare->cargo)) @if(@$fare->cargo=='0') checked @endif @endif>

							{{-- <label for="yes">Yes</label>
							<input type="radio" id="yes" name="cargo" value="1" checked>
							<label for="no">No</label>
							<input type="radio" id="no" name="cargo" value="0" > --}}

						{{-- @endif --}}
						{{-- <input class="form-control" type="text" name="cargo"  id="cargo" onkeypress="javascript:return isValid(this,event)"
							value=@if(isset($fare))
									{{$fare->fare}}
								@else
									""
								@endif
						> --}}
					</div>
				</div>

				<div class="form-group row">
                    <div class="col-md-12 col-sm-6 offset-md-2 col-md-3">
                    	<button type="submit" class="btn btn-success shadow-box" id="alertbox">Save</button>
                    	<a href="{{route('admin.fare.index')}}" class="btn btn-danger shadow-box">Cancel</a>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>

@endsection

