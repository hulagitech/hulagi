@extends('website.app')

@section('content')

<?php $login_user = asset('asset/img/login-user-bg.jpg'); ?>
<div class="container-fluid user_resetpass_container">
<!--     <div class="col-md-8" > -->

       
    <!-- </div> -->
    
    <div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            
              <div class="panel-body">
                <div class="text-center">
                  
                  <h3 class="text-center">Forgot Password?</h3>
                  <p>You can reset your password here.</p>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                  <div class="panel-body">
                    <form id="register-form" role="form" autocomplete="off" class="form" method="POST" action="{{ url('/provider/password/email') }}">
                    {{ csrf_field() }}
                    
    
                      <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                            <input type="email" id="email" class="form-control" name="email" placeholder="Email Address" value="{{ old('email') }}">
                            
                        </div>
                      </div>
                      @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif 
                      <div class="form-group">
                        <input name="recover-submit" class="btn btn-lg btn-success btn-block" value="Reset Password" type="submit">
                      </div>
                      <h5>Already have account?<a class="log-blk-btn" href="{{url('/provider/login')}}">Click Here</a></h5>
                      <!-- <input type="hidden" class="hide" name="token" id="token" value="">  -->
                    </form>
    
                  </div>
                </div>
              </div>
           
          </div>
    </div>
</div>
    

        
    
    
 </div>




@endsection
