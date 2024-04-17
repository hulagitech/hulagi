@extends('pickup.layout.master')

@section('title', 'Add User')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="row align-items-center">
				<div class="col-md-8">
					<h5 class="mb-1">
						<i class="fa fa-recycle"></i> &nbsp;Add User
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
				<h4 class="mt-0 header-title">Add User</h4>
				<p class="text-muted mb-4 font-13">
					Please fill the form below to add new User.
				</p>
				<form action="{{ route('pickup.user.store') }}" method="POST">
					{{ csrf_field() }}
					<div class="form-group row">
						<label for="name" class="col-sm-2 col-form-label">Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="name" name="first_name"
								placeholder="Enter Name name" required>
						</div>
					</div>
					<div class="form-group row">
						<label for="name" class="col-sm-2 col-form-label">Company Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="name" name="company_name"
								placeholder="Enter Company name" required>
						</div>
					</div>
					<div class="form-group row">
						<label for="email" class="col-sm-2 col-form-label">Email</label>
						<div class="col-sm-10">
							<input type="email" class="form-control" id="email" name="email"
								placeholder="Enter  email" required>
						</div>
					</div>
					<div class="form-group row">
						<label for="email" class="col-sm-2 col-form-label">Phone no</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="email" name="mobile"
								placeholder="Enter phone no" required>
						</div>
					</div>
					<div class="form-group row">
						<label for="password" class="col-sm-2 col-form-label">Password</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" id="password" name="password"
								placeholder="Enter user password" required>
						</div>
					</div>
					<div class="form-group row">
                            <label for="password_confirmation"class="col-sm-2 col-form-label">Password
                                Confirmation</label>
                            <div class="col-md-10">
                                <input class="form-control" type="password" name="password_confirmation"
                                    id="password_confirmation" placeholder="Re-type Password">
                            </div>
                        </div>
					<div class="form-group row">
						<div class="col-sm-4">
							<button type='submit' class='btn btn-primary'>Submit</button>
							<a href="{{route('pickup.user.index')}}" class="btn btn-danger">Cancel</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


@endsection
