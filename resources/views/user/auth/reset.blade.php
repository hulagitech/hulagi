@extends('user.layout.user-auth')
@section('content')
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<div class="card mb-0">
        <div class="card-body">
            <div class="p-2">
                <h4 class="text-muted float-right font-18 mt-4">Reset Password</h4>
                <div>
                    <a href="/" class="logo logo-admin"><img src="{{ asset('asset/user/images/Puryau-logo-black.png') }}"
                            height="28" alt="logo"></a>
                </div>
            </div>

            <div class="p-2">
                <form class="form-horizontal m-t-20" role="form" method="POST" action="{{ url('/password/update') }}">
                    {{ csrf_field() }}
                    <input type="hidden" value="{{$token}}" name="token">
                    <div class="form-group row">
                        <div class="col-12">
                        <input type="password" class="form-control" name="password" placeholder="Password" style="width: 312px;">

                            @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                        <input type="password" placeholder="Re-type Password" class="form-control" name="password_confirmation" style="width: 312px;">

                            @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group text-center row m-t-20">
                        <div class="col-12">
                            <button class="btn btn-primary btn-block waves-effect waves-light"
                                type="submit">Reset Password</button>
                        </div>
                    </div>

                    <div class="form-group m-t-10 mb-0 row">
                        <div class="col-12 m-t-20 text-center">
                            <a href="{{ url('/UserSignin') }}" class="text-muted">Already have
                                account?</a>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>



@endsection



