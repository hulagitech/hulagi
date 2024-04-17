@extends('admin.layout.base')
@section('title', 'Update Provider ')
@section('content')
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
           <!--  <a href="{{ route('admin.provider.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> Back</a> -->
            <h5 style="margin-bottom: 2em;">&nbsp;Partner Profile</h5><hr>
            <form class="form-horizontal" action="{{route('admin.provider.update', $provider->id )}}" method="POST" enctype="multipart/form-data" role="form">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="PATCH">
                <div class="form-group row">
                    <label for="first_name" class="col-xs-2 col-form-label">Name</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ $provider->first_name }}" name="first_name" required id="first_name" placeholder="Name">
                    </div>
                </div>
                <!--<div class="form-group row">-->
                <!--    <label for="last_name" class="col-xs-2 col-form-label">Last Name</label>-->
                <!--    <div class="col-xs-10">-->
                <!--        <input class="form-control" type="text" value="{{ $provider->last_name }}" name="last_name" required id="last_name" placeholder="Last Name">-->
                <!--    </div>-->
                <!--</div>-->
                <div class="form-group row">
                    <label for="picture" class="col-xs-2 col-form-label">Picture</label>
                    <div class="col-xs-10">
                    @if(isset($provider->avatar))
                        <img style="height: 90px; margin-bottom: 15px; border-radius:2em;" src="{{ asset('/storage/app/public/' . $provider->avatar) }}">
                    @endif
                        <input type="file" accept="image/*" name="avatar" class="dropify form-control-file" id="picture" aria-describedby="fileHelp">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="mobile" class="col-xs-2 col-form-label">Mobile</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ $provider->mobile }}" name="mobile" required id="mobile" placeholder="Mobile">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="mobile" class="col-xs-2 col-form-label">Email</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ $provider->email }}" name="email" required id="email" placeholder="Email">
                    </div>
                </div>
                <div class="form-group row">
					<label for="type" class="col-xs-2 col-form-label">Type</label>
					<div class="col-xs-10">
						<select name="type" id="type" class="form-control" required>
                            <option value="freelance" {{ $provider->type=="freelance"?"selected":null }}> Freelance </option>
                            <option value="pickup" {{ $provider->type=="pickup"?"selected":null }}> Pickup </option>
                            <option value="both" {{ $provider->type=="both"?"selected":null }}> Both </option>
						</select>
					</div>
                </div>
                
                <div class="form-group row">
					<label for="zone" class="col-xs-2 col-form-label"> Zone </label>
					<div class="col-xs-10">
						<select name="zone_id" class="form-control" id="zone"  required>
							@foreach ($zones as $zone)
								<option value="{{$zone->id}}" {{$provider->zone_id==$zone->id?"selected":null}}>{{$zone->zone_name}}</option>
							@endforeach
						</select>
					</div>
                </div>
                
				<div class="form-group row">
					<label for="service_type" class="col-xs-2 col-form-label">Vehicle</label>
					<div class="col-xs-10">
						<select name="service_type" class="form-control" id="service_type"  required>
							@foreach($services as $service) 
								<option value="{{ $service->id }}" <?php echo ( old('service_type', $provider->service->service_type_id) == $service->id ) ? 'selected' : ''; ?>>{{ $service->name }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label for="service_number" class="col-xs-2 col-form-label">Vehicle Number</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ old('service_number',$provider->service->service_number ) }}" name="service_number" required id="service_number" placeholder="Cab Number">
					</div>
				</div>
				<div class="form-group row">
					<label for="service_model" class="col-xs-2 col-form-label">Vehicle Model</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ old('service_model', $provider->service->service_model ) }}" name="service_model" required id="service_model" placeholder="Cab Model">
					</div>
				</div>
                <div class="form-group row">
                    <label for="zipcode" class="col-xs-2 col-form-label"></label>
                    <div class="col-xs-10">
                        <button type="submit" class="btn btn-success btn-secondary">Update Driver</button>
                        <input type="hidden" name="op" id="op" value="outer_rider">
                        <a href="{{route('admin.provider.outerprovider')}}" class="btn btn-default">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="box box-block bg-white">
            <h5 style="margin-bottom: 2em;">Update password</h5>
            <form class="form-horizontal" action="{{url('/admin/changeprovidorpassword')}}" method="POST" enctype="multipart/form-data" role="form">
                  {{csrf_field()}}
                <div class="form-group row">
                    <label for="mobile" class="col-xs-2 col-form-label">Password</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="" name="password" required id="password" placeholder="Password">
                        <input class="form-control" type="hidden" value="{{ $provider->id }}" name="id" required id="id">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="mobile" class="col-xs-2 col-form-label">Confirm Password</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="" name="password_confirmation" required id="password_confirmation" placeholder="Confirm Password">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="zipcode" class="col-xs-2 col-form-label"></label>
                    <div class="col-xs-10">
                        <button type="submit" class="btn btn-success btn-secondary">Update Password</button>
                        <a href="{{route('admin.provider.index')}}" class="btn btn-default">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
