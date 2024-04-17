@extends('admin.layout.master')

@section('title', 'Active Drivers')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-1">
                        <i class="mdi mdi-bike"></i> Active Patner Info
                    </h5>
                </div>
                <div class="col-md-4 d-flex justify-content-end">
                    
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body table-responsive">
                @if (count($todayTotal) > 0)
                <table id="datatable" class="table table-bordered"
                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                            <th>Total Earned</th>
                            <th>Total Payable</th>
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
                            <th>Total Earned</th>
                            <th>Total Payable</th>
                        </tr>
                    </tfoot>
                </table>
                @else
                <h6 class="no-result">No results found</h6>
                @endif
            </div>
        </div>
    </div>
</div>

@section('scripts')

@include('user.layout.partials.datatable')

@endsection
@endsection
