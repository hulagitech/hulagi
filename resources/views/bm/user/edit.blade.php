@extends('bm.layout.master')
@section('title', 'Update User ')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Update User</h4>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('bm.user.update', $user->id) }}" method="POST"
                        enctype="multipart/form-data" role="form">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PATCH">
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="first_name">Name</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{ $user->first_name }}"
                                    name="first_name" required id="first_name" placeholder="Name">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="company_name">Company Name</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{ $user->company_name }}"
                                    name="company_name" required id="company_name" placeholder="Company Name">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="picture">Picture</label>
                            </div>
                            <div class="col-md-10">
                                @if (isset($user->picture))
                                    <img style="height: 90px; margin-bottom: 15px; border-radius:2em;"
                                        src="{{ $user->picture }}">
                                @endif
                                <input type="file" accept="image/*" name="picture" class="dropify form-control-file"
                                    id="picture" aria-describedby="fileHelp">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="mobile">Mobile</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{ $user->mobile }}" name="mobile"
                                    required id="mobile" placeholder="Mobile">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="email">Email</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{ $user->email }}" name="email" required
                                    id="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="Agreement">Aggrement</label>
                            </div>
                            <div class="col-md-10">
                                @if ($user->Agreement == 'NO')
                                    <select class="form-control" id="Agreement" name="Agreement">
                                        <option value="NO">NO</option>
                                        <option value="YES">YES</option>

                                    </select>
                                @else
                                    <select class="form-control" id="Agreement" name="Agreement">
                                        <option value="YES">YES</option>
                                        <option value="NO">NO</option>

                                    </select>
                                @endif
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="Business_Person">User Type</label>
                            </div>
                            <div class="col-md-10">
                                @if ($user->Business_Person == 'Business')
                                    <select class="form-control" id="Business_Person" name="Business_Person">
                                        <option value="Business">Business</option>
                                        <option value="Person">Person</option>

                                    </select>
                                @else
                                    <select class="form-control" id="Business_Person" name="Business_Person">
                                        <option value="Person">Person</option>
                                        <option value="Business">Business</option>

                                    </select>
                                @endif
                            </div>
                        </div>
                        <div class="row form-group align-items-center justify-content-end">
                            <a href="{{ route('bm.user.index') }}" class="btn btn-danger mr-2">Cancel</a>
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
                    <form action="{{ route('bm.changeuserpassword') }}" method="POST" enctype="multipart/form-data"
                        role="form">
                        {{ csrf_field() }}

                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="password">Password</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="" name="password" required id="password"
                                    placeholder="Password">
                                <input class="form-control" type="hidden" value="{{ $user->id }}" name="id" required
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
                            <a href="{{ route('bm.user.index') }}" class="btn btn-danger mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary mr-2">Update Password</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
