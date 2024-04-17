@extends('admin.layout.master')
@section('title', 'Update admin ')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Update admin</h4>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.admin.update', $admin->id) }}" method="POST" enctype="multipart/form-data"
                        role="form">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PATCH">
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="first_name">Name</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{ $admin->name }}"
                                    name="name" required id="name" placeholder="Name">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="first_name">Email</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{ $admin->email }}"
                                    name="email" required id="email" placeholder="Email" readonly>
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="first_name">Admin For</label>
                            </div>
                            <div class="col-md-10">
                                <select class="user_id  form-control" id="admin_type" name="admin_type">
                                    <option value="hulagi"> Hulagi </option>
                                    @foreach (@$users as $user)
                                        <option value="{{@$user->APP_NAME}}"> {{@$user->APP_NAME}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        

                         <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="password">Password</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="" name="password"  id="password"
                                    placeholder="Password">
                                <input class="form-control" type="hidden" value="{{ $admin->id }}" name="id" 
                                    id="id">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="password">Confirm Password</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="" name="password_confirmation" 
                                    id="password_confirmation" placeholder="Confirm Password">
                            </div>
                        </div>
                        <div class="row form-group align-items-center justify-content-end">
                            <a href="{{ route('admin.admin.index') }}" class="btn btn-danger mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary mr-2">Update admin</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
