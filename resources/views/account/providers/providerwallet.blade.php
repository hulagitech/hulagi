@extends('account.layout.master')

@section('title', 'Provider')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-print-none">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0"> Provider wallet</h4>
                </div>
                
            </div>
            
        </div>
    </div>
</div>
<div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
                               <table id="datatable-buttons" class="table table-bordered"
                        								style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Provider Name</th>
                            <th>Provider Wallet</th>
                            <th>New Payable</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($Providers as $index => $provider)
                            <tr>
                                <th>{{ $index + 1 }}</th>
                                <th>{{ $provider->first_name }}</th>
                                <th>{{ $provider->payable }}</th>
                                <th>
                                    @if (isset($provider->newPayable))
                                        {{ $provider->newPayable }}
                                    @else
                                        -
                                    @endif
                                </th>
                            </tr>
                        @endforeach

                    </tbody>

            </table>
                {{ $Providers->links('vendor.pagination.bootstrap-4') }}
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')

    @include('user.layout.partials.datatable')

@endsection
