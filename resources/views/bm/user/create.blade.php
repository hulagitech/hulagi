@extends('bm.layout.master')

@section('title', 'Add User ')

@section('content')

<div class="content-area py-1">
    <div class="container-fluid">
    	<div class="box box-block bg-white">
			<h5 style="margin-bottom: 2em;"><span class="s-icon"><i class="ti-user"></i></span> &nbsp;Add New User</h5>
			<hr/>
            <form class="form-horizontal" action="{{route('bm.user.store')}}" method="POST" enctype="multipart/form-data" role="form">
            	{{csrf_field()}}
				<div class="form-group row">
					<label for="first_name" class="col-xs-12 col-form-label">Name</label>
					<div class="col-xs-12">
						<input class="form-control" type="text" value="{{ old('first_name') }}" name="first_name" required id="first_name" placeholder="Name">
					</div>
				</div>
				<div class="form-group row">
					<label for="company_name" class="col-xs-12 col-form-label">Company Name</label>
					<div class="col-xs-12">
						<input class="form-control" type="text" value="{{ old('company_name') }}" name="company_name" required id="company_name" placeholder="Company Name">
					</div>
				</div>

				<div class="form-group row">
					<label for="email" class="col-xs-12 col-form-label">Email</label>
					<div class="col-xs-12">
						<input class="form-control" type="email" required name="email" value="{{old('email')}}" id="email" placeholder="Email">
					</div>
				</div>

				<div class="form-group row">
					<label for="password" class="col-xs-12 col-form-label">Password</label>
					<div class="col-xs-12">
						<input class="form-control" type="password" name="password" id="password" placeholder="Password">
					</div>
				</div>

				<div class="form-group row">
					<label for="password_confirmation" class="col-xs-12 col-form-label">Password Confirmation</label>
					<div class="col-xs-12">
						<input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="Re-type Password">
					</div>
				</div>

				<div class="form-group row">
					<label for="picture" class="col-xs-12 col-form-label">Picture</label>
					<div class="col-xs-12">
						<input type="file" accept="image/*" name="picture" class="dropify form-control-file" id="picture" aria-describedby="fileHelp">
					</div>
				</div>

				<div class="form-group row">
					<label for="mobile" class="col-xs-12 col-form-label">Mobile</label>
					<div class="col-xs-12">
						<input class="form-control" type="number" value="{{ old('mobile') }}" name="mobile" required id="mobile" placeholder="Mobile">
					</div>
				</div>

				<div class="form-group row">
					<div class="col-xs-12">
						<button type="submit" class="btn btn-success shadow-box">Add New User</button>
						<a href="{{route('bm.user.index')}}" class="btn btn-default">Cancel</a>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>

@endsection
