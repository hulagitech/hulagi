@extends('admin.layout.base')

@section('title', 'Active Drivers')
<style>
div.dataTables_wrapper div.dataTables_filter input[type="search"]{
    height: 18px;
    margin-right: 10px;
}
</style>
@section('content')
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="row row-md">
        <div class="col-lg-6 col-md-6 col-xs-12">
            <div class="box box-block bg-success mb-2 btn-secondary">
                <div class="t-content">
                    <h5 class="text-uppercase mb-1">Total Partner</h5>
                    <h5 class="mb-1">{{$providers->count()}}</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-xs-12">
            <div class="box box-block bg-warning mb-2 btn-secondary">
                <div class="t-content">
                    <h5 class="text-uppercase mb-1">Active Drivers</h5>
                    <h5 class="mb-1">{{$activeDrivers->count()}}</h5>
                </div>
            </div>
        </div> 
    </div>
        <div class="box box-block bg-white">
            <h5 class="mb-1"><span class="s-icon"><i class="ti-infinite"></i></span>&nbsp; Active Drivers</h5>
            <table class="table table-striped table-bordered dataTable" id="table-2" style="width:100%;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Accepted Order</th>
                        <th>Picked Order</th>
                        <th>Payable(Today)</th>
                        <th>Earned(Today)</th>
                        <th>Total Payable</th>
                        <th>Total Earned</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($todayTotal as $index => $provider)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $provider->full_name }}</td>
                        <td>{{ $provider->mobile }}</td>
                        <td>{{ $provider->totalAccepted }}</td>
                        <td>{{ $provider->totalPicked }}</td>
                        <td>{{ $provider->todayCod }}</td>
                        <td>{{ $provider->todayFare }}</td>
                        <td>{{ $provider->totalCod }}</td>
                        <td>{{ $provider->totalFare }}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Accepted Order</th>
                        <th>Picked Order</th>
                        <th>Payable(Today)</th>
                        <th>Earned(Today)</th>
                        <th>Total Payable</th>
                        <th>Total Earned</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection