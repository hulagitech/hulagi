@extends('user.layout.user-auth')
@section('content')
    <div class="card mb-0">
        <div class="card-body">
            <div class="p-2">
                <h4 class="text-muted float-right font-18 mt-4">{{ trans('passengersignin.login') }}
                </h4>
                <div>
                    <a href="/" class="logo logo-admin"><img src="{{ asset('asset/user/images/Puryau-logo-black.png') }}"
                            height="28" alt="logo"></a>
                </div>
            </div>

            <div class="p-2">
                <form method="POST" action="{{ url('/login') }}" class="form-horizontal m-t-20">
                    {{ csrf_field() }}

                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control" id="email" name="email" type="email"
                                placeholder="{{ trans('passengersignin.email') }}" value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12">
                            <input id="password" name="password" class="form-control" type="password"
                                placeholder="{{ trans('passengersignin.password') }}" required>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>


                    <div class="form-group text-center row m-t-20">
                        <div class="col-12">
                            <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>

                    <div class="form-group m-t-10 mb-0 row">
                        <div class="col-sm-7 m-t-20">
                            <a href="{{ url('/password/reset') }}" class="text-muted"><i class="mdi mdi-lock"></i>
                                Forgot your password?</a>
                        </div>
                        <div class="col-sm-5 m-t-20">
                            <a href="{{ url('/register') }}" class="text-muted"><i
                                    class="mdi mdi-account-circle"></i> Create an account</a>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

@endsection


<!--  @if (Setting::get('social_login', 0) == 1) <div class="">
                                                            <a href="{{ url('/auth/facebook') }}"><button type="submit" class="btn btn-default" style="background-color:#3b61ad;">LOGIN WITH FACEBOOK</button></a>
                                                           </div>  
                                                           <div class="">
                                                            <a href="{{ url('/auth/google') }}"><button type="submit" class="btn btn-default" style="background-color:#f37151">LOGIN WITH GOOGLE+</button></a>
                                                           </div> @endif -->
