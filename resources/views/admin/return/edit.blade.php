@extends('admin.layout.master')
@section('title', 'Update User ')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Update Return Manager - {{$return->name}}</h4>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.return-manager.update', $return->id )}}" method="POST" enctype="multipart/form-data"
                        role="form">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PATCH">
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="first_name">Full Name </label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{ $return->name }}" name="name" required id="name" placeholder="Full Name">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="first_name">E-mail </label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{ $return->email }}" readonly="true" name="email" required id="email" placeholder="E-mail">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="first_name">Mobile </label>
                            </div>
                            <div class="col-md-10">
								<input class="form-control" type="number" value="{{ $return->mobile }}" name="mobile" required id="mobile" placeholder="Mobile">
                            </div>
                        </div>
						
                        <div class="row form-group align-items-center justify-content-end">
                            <a href="{{route('admin.return-manager.index')}}" class="btn btn-danger mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary mr-2">Update User</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col-sm-8">
                        <h4 class="page-title m-0">Update User Password</h4>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
					<form  action="{{route('admin.changeReturnPassword')}}" method="POST" enctype="multipart/form-data" role="form">
                        {{ csrf_field() }}

                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="password">Password</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="" name="password" required id="password"
                                    placeholder="Password">
                                <input class="form-control" type="hidden" value="{{ $return->id }}" name="id" required
                                    id="id">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="password">Confirm Password</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="" name="password_confirmation" required
                                    id="password_confirmation" placeholder="Confirm Password">
                            </div>
                        </div>
                        <div class="row form-group align-items-center justify-content-end">
                            <a href="{{route('admin.return-manager.index')}}" class="btn btn-danger mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary mr-2">Update Password</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection



