@extends('account.layout.master')

@section('title', 'Provider Settlement')

@section('content')
<style>
    .switch {
        display: inline-block;
        height: 34px;
        position: relative;
        width: 60px;
    }

    .switch input {
        display: none;
    }

    .slider {
        background-color: #ccc;
        bottom: 0;
        cursor: pointer;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        transition: .4s;
    }

    .slider:before {
        background-color: #fff;
        bottom: 4px;
        content: "";
        height: 26px;
        left: 4px;
        position: absolute;
        transition: .4s;
        width: 26px;
    }

    input:checked+.slider {
        background-color: #66bb6a;
    }

    input:checked+.slider:before {
        transform: translateX(26px);
    }

    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0">Log of Rider {{$Providers->first_name}}</h4>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Total Orders</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $total_order }}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-info"></span><span class="ml-2">
                            </span>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-info mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Processing Order</h6>
                        <h4 class="mb-3 mt-0 float-right">{{$processing}}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-danger"></span><span class="ml-2"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-pink mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Scheduled Order</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $Scheduled }}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-primary"></span> <span class="ml-2">
                             </span>
                    </div>
                </div>
               
            </div>
        </div>
        

        <div class="col-xl-3 col-md-6">
            <div class="card bg-success mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Completed Order</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $completed }}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-info"></span> <span class="ml-2"></span>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Return Order</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $returned }}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-primary"></span> <span class="ml-2">
                             </span>
                    </div>
                </div>
               
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-pink mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Return Remaining Order</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $return_remaing }}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-primary"></span> <span class="ml-2">
                             </span>
                    </div>
                </div>
               
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Rejected Order</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $cancelled }}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-primary"></span> <span class="ml-2">
                             </span>
                    </div>
                </div>
               
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Delivering Order</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $Delivering }}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-primary"></span> <span class="ml-2">
                             </span>
                    </div>
                </div>
               
            </div>
        </div>
         <div class="col-xl-3 col-md-6">
            <div class="card bg-success mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">TOTAL PAYABLE</h6>
                        <h4 class="mb-3 mt-0 float-right">{{$totalPayable->payable}}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-info"></span> <span class="ml-2">
                            </span>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-pink mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">NEW PAYABLE</h6>
                        <h4 class="mb-3 mt-0 float-right">{{$Providers->newPayable}}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-primary"></span> <span class="ml-2">
                            </span>
                    </div>
                </div>
                
            </div>
        </div>
</div>
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
                    <form method="POST" action="{{ url('account/statement/rider/settlement/'.$id) }} ">
                    {{csrf_field()}}
                            <div class="form-group">
                                <label for="Amount">Amount</label>
                                <input type="text" class="form-control"  placeholder="Enter settle Amount" name="amount">
                            </div>
                            <div class="form-group">
                                <label for="Remarks">Remarks </label>
                                <input type="text" class="form-control"  placeholder="Enter Remarks Amount" name="remarks">
                            </div>
                            <button type="submit" class="btn btn-primary">Settle</button>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
