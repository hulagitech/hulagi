@extends('user.layout.master')

@section('title', 'Payment Detail')

@section('content')

    <div class="row" style="padding:20px;">
        <div class="col-lg-12">
            <div class="">
                <h4 class="page-title"><i class="fa fa-angle-right"></i> <b>Add Bank Detail Info.</b> </h4>
                <hr>

                <form class="form" id="payment_info" method="POST" action="{{ url('/payment_bank') }}">
                    {{ csrf_field() }}
                    
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
                        <a href="{{ url('/wallet') }}" class="btn btn-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection