@extends('admin.layout.master')

@section('title', 'Add Provider ')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="row align-items-center">
				<div class="col-md-8">
					<h5 class="mb-1">
						<i class="fa fa-recycle"></i> &nbsp;Add Provider
					</h5>
				</div>
				<div class="col-md-4">
					<div class="float-right d-none d-md-block">
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card m-b-30">
			<div class="card-body">
				<h4 class="mt-0 header-title">Add Provider</h4>
				<p class="text-muted mb-4 font-13">
					Please fill the form below to add new provider.
				</p>
				<form action="{{ route('admin.provider.store') }}" method="POST">
					{{ csrf_field() }}
					<div class="form-group row">
						<label for="name" class="col-sm-2 col-form-label">Name</label>
						<div class="col-sm-10">
							<input class="form-control" type="text" value="{{ old('first_name') }}" name="first_name" required id="first_name" placeholder="Name">
						</div>
					</div>
					<div class="form-group row">
						<label for="email" class="col-sm-2 col-form-label">Email</label>
						<div class="col-sm-10">
							<input class="form-control" type="email" required name="email" value="{{old('email')}}" id="email" placeholder="Email">
						</div>
					</div>
					<div class="form-group row">
						<label for="phone" class="col-sm-2 col-form-label">Phone</label>
						<div class="col-sm-10">
							<input class="form-control" type="number" value="" name="mobile" required id="mobile" placeholder="Mobile">
						</div>
					</div>
					<div class="form-group row">
					<label for="type" class="col-sm-2 col-form-label"> Type </label>
					<div class="col-sm-10">
						<select name="type" class="form-control" id="type"  required>
							<option value=""> > Select Type </option>
							<option value="freelance"> Freelance </option>
							<option value="pickup"> Pickup </option>
							<option value="both"> Both </option>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label for="zone" class="col-sm-2 col-form-label"> Zone </label>
					<div class="col-sm-10">
						<select name="zone_id" class="form-control" id="zone"  required>
							@foreach ($zones as $zone)
								<option value="{{$zone->id}}">{{$zone->zone_name}}</option>
							@endforeach
						</select>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="service_type" class="col-sm-2 col-form-label">Vehicle</label>
					<div class="col-sm-10">
						<select name="service_type" class="form-control" id="service_type"  required>
							@foreach($services as $service) 
								<option value="{{ $service->id }}" <?php echo ( old('service_type') == $service->id ) ? 'selected' : ''; ?> >{{ $service->name }}</option>
							@endforeach
						</select>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="service_number" class="col-sm-2 col-form-label">Vehicle Number</label>
					<div class="col-sm-10">
						<input class="form-control" type="text" value="{{ old('service_number') }}" name="service_number" required id="service_number" placeholder="Cab Number">
					</div>
				</div>
				
				<div class="form-group row">
					<label for="service_model" class="col-sm-2 col-form-label">Vehicle Model</label>
					<div class="col-sm-10">
						<input class="form-control" type="text" value="{{ old('service_model') }}" name="service_model" required id="service_model" placeholder="Cab Model">
					</div>
				</div>
					<div class="form-group row">
						<label for="address" class="col-sm-2 col-form-label">Password</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="address" name="password"
								placeholder="Enter Password" required>
						</div>
					</div>
					<div class="form-group row">
						<label for="address" class="col-sm-2 col-form-label">Password Confirmation</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="password_confirmation" name="password_confirmation"
								placeholder="Retype Password" required>
						</div>
					</div>
					<div class="row form-group align-items-center justify-content-end">
				
						<button type="submit" class="btn btn-success btn-secondary mr-2">Add Driver</button>
						<a href="{{route('admin.provider.index')}}" class="btn btn-danger mr-2">Cancel</a>
					
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
