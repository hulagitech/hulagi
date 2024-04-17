@extends('admin.layout.master')

@section('title', 'Add User ')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="row align-items-center">
				<div class="col-md-8">
					<h4 class="page-title m-0">Add  New User</h4>
				</div>

			</div>

		</div>
	</div>
</div>
<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal" action="{{route('admin.user.store')}}" method="POST" enctype="multipart/form-data" role="form">
                        {{ csrf_field() }}
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="first_name">Name</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{ old('first_name') }}" name="first_name" required id="first_name" placeholder="Name">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="company_name">Company Name</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="company_name" required id="company_name" placeholder="Company Name">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="picture">Picture</label>
                            </div>
                            <div class="col-md-10">
                                <input type="file" accept="image/*" name="picture" class="dropify form-control-file" id="picture" aria-describedby="fileHelp">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="mobile">Mobile</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="number" value="{{ old('mobile') }}" name="mobile" required id="mobile" placeholder="Mobile">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="email">Email</label>
                            </div>
                            <div class="col-md-10">
                               <input class="form-control" type="email" required name="email" value="{{old('email')}}" id="email" placeholder="Email">
                            </div>
                        </div>
						<div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="email">Password</label>
                            </div>
                            <div class="col-md-10">
                               <input class="form-control" type="password" name="password" id="password" placeholder="Password">
                            </div>
                        </div>
						<div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="email">Confirm Password</label>
                            </div>
                            <div class="col-md-10">
                              <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="Re-type Password">
                            </div>
                        </div>
                        <div class="row form-group align-items-center justify-content-end">
                            <a href="{{ route('admin.user.index') }}" class="btn btn-danger mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary mr-2">Add New User</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
