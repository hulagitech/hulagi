@extends('website.app')

@section('content')
<?php  $login_user = asset('asset/img/login-user-bg.jpg'); ?>
<div class="container-fluid provider_reset_margin_50">
    <div class="col-md-6 log-left">
        <!-- <span class="login-logo"><img src="{{asset('asset/img/logo.png')}}"></span> -->
        <h2>Create your account and get moving in minutes</h2>
        <p>Welcome to {{ Setting::get('site_title', 'Ilyft')  }}, the easiest way to get around at the tap of a button.</p>
    </div>
    <div class="col-md-12">
        
        <h3>Reset Password</h3>
    </div>
        @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
       @endif
    <form role="form" method="POST" action="{{ url('provider/password/update') }}">
        {{ csrf_field() }}
            <div class="col-md-12 provider_reset_margin_10">
            <input type="email" class="form-control provider_reset_width_312" name="email" placeholder="Email Address" value="{{ old('email') }}">
            <br/>
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif                        
            </div>
            <div class="col-md-12 provider_reset_margin_10">
            <input type="password" class="form-control provider_reset_width_312" name="password" placeholder="Password">

                @if ($errors->has('password'))
                 <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
            <div class="col-md-12 provider_reset_margin_10">
            <input type="password" placeholder="Re-type Password" class="provider_reset_width_312 form-control" name="password_confirmation">

                @if ($errors->has('password_confirmation'))
                 <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                 </span>
                @endif
            </div>   
            <div class="col-md-12 provider_reset_margin_10">   
            <div class="facebook_btn">
                <button value="submit" class="btn btn-success btn-arrow-left">RESET PASSWORD</button>
            </div>  
             <h5>Already have account?<a class="log-blk-btn" href="{{url('provider/login')}}">Click Here</a></h5>
        </div>  
    
    </form>     
 </div>




@endsection
