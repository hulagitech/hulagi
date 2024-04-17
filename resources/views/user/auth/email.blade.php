@extends('user.layout.user-auth')
@section('content')
    <div class="card mb-0">
        <div class="card-body">
            <div class="text-center">
                <div>
                    <a href="index.html" class="logo logo-admin"><img
                            src="{{ asset('asset/user/images/Puryau-logo-black.png') }}" height="28" alt="logo"></a>
                </div>
                <h4 class="text-muted font-18 mt-4">Reset Password</h4>
            </div>

            <div class="p-2">
                <form class="form-horizontal m-t-20" method="POST" action="{{ url('/password/email') }}">
                    {{ csrf_field() }}
                    @if (session('status'))
                        <div class=" alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ session('status') }}
                        </div>

                    @endif
                    @if ($errors->has('token'))
                        <div class=" alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ $errors->first('token') }}
                        </div>

                    @endif


                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control" type="email" id="email" class="form-control" name="email"
                                placeholder="Email Address" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group text-center row m-t-20">
                        <div class="col-12">
                            <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Send
                                Email</button>
                        </div>
                    </div>

                </form>
                <!-- end form -->
            </div>

        </div>
    </div>
@endsection
