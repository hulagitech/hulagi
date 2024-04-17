@extends('pickup.layout.master')

@section('title', 'Order details ')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Pickup Rider Info</h4>
                    </div>
                    <div class="col-md-4 justify-content-end d-flex">
                        <form class="form-inline pull-right" method="GET" action={{ url('pickup/riderSearch') }}>
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input type="text" class="form-control" name="searchField" placeholder="Full Search" style="border-radius: .25rem 0 0 0.25rem;">
                            </div>
                            <div class="form-group">
                                <button name="search" class="btn btn-primary" style="padding: 7px 12px 8px;border-radius: 0 .25rem 0.25rem 0;">Search</button>
                            </div>
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
                    @if (count($providers) != 0)
                        <table id="datatable" class="table table-bordered"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Rider Name</th>
                                    <th>Rider Number</th>
                                    <th>No of Accepetd</th>
                                    <th>No of Pickedup</th>

                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($providers as $key => $provider)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <a href="{{ route('pickup.riderInbound', $provider->id) }}">
                                                {{ $provider->first_name }} </a>
                                        </td>
                                        <td>{{ $provider->mobile }}</td>
                                        <td><a href="{{ route('pickup.rider.remaining', [$provider->id, 'ACCEPTED']) }}">
                                                {{ $provider->provider_Accepted->count() }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('pickup.rider.remaining', [$provider->id, 'PICKEDUP']) }}">
                                                {{ $provider->Pickedup->count() }}</a>

                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <hr>
                        <p style="text-align: center;">No Pickup Rider Info Available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>



@endsection
@section('scripts')

    @include('user.layout.partials.datatable')

@endsection
