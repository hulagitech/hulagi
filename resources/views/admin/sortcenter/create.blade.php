
@extends('admin.layout.master')
@section('title', 'Update User ')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Create Sortcenter Manager</h4>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
					<form class="form-horizontal" action="{{route('admin.sortcenter-user.store')}}" method="POST" enctype="multipart/form-data" role="form">
						{{csrf_field()}}
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="first_name">Full Name </label>
                            </div>
                            <div class="col-md-10">
								<input class="form-control" type="text" value="{{ old('name') }}" name="name" required id="name" placeholder="Full Name">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="first_name">Email </label>
                            </div>
                            <div class="col-md-10">
								<input class="form-control" type="email" required name="email" value="{{old('email')}}" id="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
								<label for="first_name">Password</label>
                            </div>
                            <div class="col-md-10">
								<input class="form-control" type="password" name="password" id="password" placeholder="Password">  </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="first_name">Confirm Password </label>
                            </div>
                            <div class="col-md-10">
								<input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="Re-type Password">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="first_name">Mobile </label>
                            </div>
                            <div class="col-md-10">
								<input class="form-control" type="number" value="{{ old('mobile') }}" name="mobile" required id="mobile" placeholder="Mobile">
                            </div>
                        </div>
                     
						
                        <div class="row form-group align-items-center justify-content-end">
                            <a href="{{route('admin.sortcenter-user.index')}}" class="btn btn-danger mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary mr-2">Create User</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
  
@endsection


