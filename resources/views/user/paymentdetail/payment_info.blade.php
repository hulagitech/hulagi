@extends('user.layout.base')

@section('title', 'Payment Detail')

@section('content')

    <div class="row" style="padding:20px;">
        <div class="col-lg-12">
            <div class="">
                <h4 class="page-title"><i class="fa fa-angle-right"></i> Add Payment Information </h4>
                <br>
                <hr>
                <h5><b>Khalti Detail Info.</b></h5>
                <p> Our primary payment partner </p>
                <form class="form" id="payment_info" method="POST" action="{{ url('/payment_info') }}">
                    {{ csrf_field() }}
                    <!-- {{ method_field('POST') }} -->

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

                    <br>
                    <hr>
                    <h5><b>Bank Detail Info.</b></h5>
                    <div class="row form-group">
                        <!-- <label for="bank_name" style="font-size:12px; padding-top:7px;" class="control-label col-lg-2"> Bank Name:</label> -->
                        <div class="col-lg-3">
                            <input type="text" id="bank_name" name="bank_name" class="form-control" placeholder="Bank Name">
                        </div>
                    </div>

                    <div class="row form-group">
                        <!-- <label for="branch" style="font-size:12px; padding-top:7px;" class="control-label col-lg-2"> Branch:</label> -->
                        <div class="col-lg-3">
                            <input type="text" id="branch" name="branch" class="form-control" placeholder="Branch Name">
                        </div>
                    </div>

                    <div class="row form-group">
                        <!-- <label for="ac_no" style="font-size:12px; padding-top:7px;" class="control-label col-lg-2"> Bank Account:</label> -->
                        <div class="col-lg-3">
                            <input type="text" id="ac_no" name="ac_no" class="form-control" placeholder="Bank A/C Number">
                        </div>
                    </div>

                    <div class="row form-group">
                        <!-- <label for="ac_name" style="font-size:12px; padding-top:7px;" class="control-label col-lg-2"> A/C Name:</label> -->
                        <div class="col-lg-3">
                            <input type="text" id="ac_name" name="ac_name" class="form-control" placeholder="A/C Holder Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection