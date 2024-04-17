@extends('admin.layout.master')

@section('title', 'Add Admin admin ')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="row align-items-center">
				<div class="col-md-8">
					<h5 class="mb-1">
						<i class="fa fa-recycle"></i> &nbsp;Add Admin
					</h5>
				</div>
				<div class="col-md-4">
					<div class="float-right d-none d-md-block">
						<div class="dropdown">
							<button class="btn btn-primary dropdown-toggle arrow-none waves-effect waves-light"
								type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="mdi mdi-settings mr-2"></i> Settings
							</button>
							<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item" href="#">Action</a>
								<a class="dropdown-item" href="#">Another action</a>
								<a class="dropdown-item" href="#">Something else here</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="#">Separated link</a>
							</div>
						</div>
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
				<h4 class="mt-0 header-title">Add Admin</h4>
				<p class="text-muted mb-4 font-13">
					Please fill the form below to add new admin.
				</p>
				<form action="{{ route('admin.admin.store') }}" method="POST">
					{{ csrf_field() }}
					<div class="form-group row">
						<label for="name" class="col-sm-2 col-form-label">Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="name" name="name"
								placeholder="Enter admin name" required>
						</div>
					</div>
					<div class="form-group row">
						<label for="email" class="col-sm-2 col-form-label">Email</label>
						<div class="col-sm-10">
							<input type="email" class="form-control" id="email" name="email"
								placeholder="Enter admin email" required>
						</div>
					</div>
					 <div class="row form-group">
                            <div class="col-sm-2 col-form-label">
                                <label for="first_name">Admin For</label>
                            </div>
                            <div class="col-md-10">
                                <select class="user_id  form-control" id="admin_type" name="admin_type">
                                    <option value="hulagi"> Hulagi </option>
                                    @foreach (@$users as $user)
                                        <option value="{{@$user->APP_NAME}}"> {{@$users->APP_NAME}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
					<div class="form-group row">
						<label for="password" class="col-sm-2 col-form-label">Password</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" id="password" name="password"
								placeholder="Enter admin password" required>
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
							<a href="{{route('admin.admin.index')}}" class="btn btn-danger">Cancel</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


@endsection
