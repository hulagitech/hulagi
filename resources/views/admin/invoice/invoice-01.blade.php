{{-- @extends('admin.layout.base')

@section('title', 'Invoice') --}}

{{-- @section('styles')
    <link rel="stylesheet" href="{{asset('main/vendor/jvectormap/jquery-jvectormap-2.0.3.css')}}">
@endsection --}}


<style>
    /* .table tr{
        padding-left:10px;
    } */
</style>


@section('content')

<div class="content-area py-1">

<div class="container-fluid">
    <div class="dash-content">
        <div class="row no-margin ride-detail">
            <div class="accordian-body">
                <div class="col-lg-12">
                    <h4 class="page-title"><i class="fa fa-ticket"></i> Invoice </h4>
                    <hr>
                    <br>
                    <div class="row form-group">
                        <div class="col-lg-1"> Booking ID : </div>
                        <div class="col-lg-5">
                            <h5> {{ $order->s_address }} </h5>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-1"> S Address : </div>
                        <div class="col-lg-5">
                            <h5> {{ $order->s_address }} </h5>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-1"> D Address : </div>
                        <div class="col-lg-5">
                            <h5> {{ $order->d_address }} </h5>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-1"> QR Code : </div>
                        <div class="col-lg-5">
                            <h5> {{ $order->b_id }} </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>



@endsection