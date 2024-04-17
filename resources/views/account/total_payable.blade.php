@extends('account.layout.master')

@section('title', 'Dashboard Payment ')

@section('styles')
<link rel="stylesheet" href="{{asset('main/vendor/jvectormap/jquery-jvectormap-2.0.3.css')}}">
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0"></h4>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="card bg-primary mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Total Amount Requested</h6>
						<br>
                        <h4 class="mb-3 mt-0 ">{{currency($totalAmountRequested)}}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-info"></span><span class="ml-2">
                            </span>
                    </div>
                </div>
				<div class="p-3">
                    <div class="float-right">
                        <a href="{{ route('account.ride.allrequested') }}" class="text-white-50"><i class="mdi mdi-eye-outline h5"></i></a>
                    </div>
                    <p class="font-14 m-0"><a target="_blank" href="{{ route('account.ride.allrequested') }}" class="text-white">
						View more</a></p>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card bg-info mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Total Amount Receivable from Vendor</h6>
						<br>
                        <h4 class="mb-3 mt-0 float-right">{{currency($totalAmountRequested)}}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-danger"></span><span class="ml-2"></span>
                    </div>
                </div>
				<div class="p-3">
                    <div class="float-right">
                        <a href="{{ route('account.ride.allNagative') }}" class="text-white-50"><i class="mdi mdi-eye-outline h5"></i></a>
                    </div>
                    <p class="font-14 m-0"><a target="_blank" href="{{ route('account.ride.allNagative') }}" class="text-white">
						View more</a></p>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card bg-pink mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Total Amount Receivable from Rider</h6>
                        <h4 class="mb-3 mt-0 float-right">{{currency($riderReceivable['amount'])}}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-primary"></span> <span class="ml-2">
                             </span>
                    </div>
					<div class="p-3">
						<div class="float-right">
							<a href="{{url('account/allRider')}}" class="text-white-50"><i class="mdi mdi-eye-outline h5"></i></a>
						</div>
						<p class="font-14 m-0"><a target="_blank" href="{{url('account/allRider')}}" class="text-white">
				View more</a>
						</p>
                	</div>
                </div>
               
            </div>
        </div>
        

</div>

@endsection