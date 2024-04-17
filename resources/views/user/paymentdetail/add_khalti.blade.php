@extends('user.layout.master')

@section('title', 'Payment Detail')

@section('content')

<div class="row" style="padding:20px;">
    <div class="col-lg-12">
        <div class="">
            <h4 class="page-title"><i class="fa fa-angle-right"></i> <b> Add Khalti Detail Info.</b></h4>
            <hr>
            <p> Our primary payment partner </p>
            <form class="form" id="payment_info" method="POST" action="{{ url('/payment_khalti') }}">
                {{ csrf_field() }}

                <div class="row form-group">
                    <!-- <label for="khalti_id" style="font-size:12px; padding-top:7px;" class="control-label col-lg-2"> Kalti Id:</label> -->
                    <div class="col-lg-3">
                        <input type="text" id="khalti_id" name="khalti_id" class="form-control" placeholder="Khalti Id">
                    </div>
                </div>

                <div class="row form-group">
                    <!-- <label for="khalti_username" style="font-size:12px; padding-top:7px;" class="control-label col-lg-2"> Khalti Username:</label> -->
                    <div class="col-lg-3">
                        <input type="text" id="khalti_username" name="khalti_username" class="form-control" placeholder="Khalti Username">
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-success">Submit</button>
                    <a href="{{ url('/wallet') }}" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection