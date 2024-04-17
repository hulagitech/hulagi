@extends('user.layout.user-auth')

@section('content')
<div class="card mb-0">
    <div class="card-body">
        <div class="p-2">
            <h4 class="text-muted float-right font-18 mt-4">Branch Manager {{ trans('passengersignin.login') }}
            </h4>
            <div>
                <a href="/" class="logo logo-admin"><img src="{{ asset('asset/user/images/Puryau-logo-black.png') }}"
                        height="28" alt="logo"></a>
            </div>
        </div>

        <div class="p-2">
            <form method="POST" action="{{ url('/bm/login') }}" class="form-horizontal m-t-20">
                {{ csrf_field() }}

                <div class="form-group row {{ $errors->has('email') ? ' has-error' : '' }}">
                    <div class="col-12">
                        <input type="email" name="email" required="true" class="form-control" id="email"
                            placeholder="Email" class="form-control" id="email" name="email" type="email"
                            placeholder="Email" required>
                        @if ($errors->has('email'))
                        <span class="help-block" style="margin-left: 55px;color: red;">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('password') ? ' has-error' : '' }}">
                    <div class="col-12">
                        <input id="password" name="password" class="form-control" type="password" placeholder="Password"
                            required>
                        @if ($errors->has('password'))
                        <span class="help-block" style="margin-left: 55px;color: red;">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : ''}}><span> Remember Me</span>
                </div>

                <div class="form-group text-center row m-t-20">
                    <div class="col-12">
                        <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Log In</button>
                    </div>
                </div>


            </form>
        </div>

    </div>
</div>
@endsection

