@extends('bm.layout.master')

@section('title', 'Dashboard ')


@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Today's Order</h4>
                    </div>
                    <div class="col-md-4">

                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
                
        </div>
        
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-primary mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Total Incoming Orders Today</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $incoming_order }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-success mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Total Outgoing Order Today</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $outgoing_order }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-info mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Total Received Order</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $Received_order }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-primary mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Total Outgoing Received</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $outgoing_receive }}</h4>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <h4 class="page-title m-0">All Orders</h4>
                    </div>
                    <div class="col-md-4">

                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-primary mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Total Incoming Order</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $total_incoming_order }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-success mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Total Outgoing Order</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $total_outgoing_order }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-info mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Total Recived Orders</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $total_Received_order }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-primary mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Total Outgoing Receive Order</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $total_outgoing_receive }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
   
@endsection
