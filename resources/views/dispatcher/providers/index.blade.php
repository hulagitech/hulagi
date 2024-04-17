@extends('dispatcher.layout.master')


@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Riders Info</h4>
                    </div>
                    <div class="col-md-4">
                        <div class="float-right">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="d-flex justify-content-end">
                        <form method="get" class="d-flex" action={{ url('dispatcher/zoneProvider') }}>
                            {{ csrf_field() }}
                            <select name='zones' class="form-control mr-4">
                                <option value="selectzone">Select Zone</option>
                                @foreach ($Zone as $rider)
                                    <option value={{ $rider['zone_name'] }} <?php if ($rider['zone_name']) {
    echo 'selected';
} ?>>
                                        {{ $rider['zone_name'] }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-group">
                                <button name="search" class="btn btn-success">Search</button>
                            </div>
                        </form>
                    </div>
                    <hr>

                    <div class="table-responsive">
                        @if (count($Providers) != 0)
                            <table id="datatable" class="table table-bordered"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <!--<th>Total Ride</th>
                                                                                                                                        <th>Accepted Ride</th>
                                                                                                                                        <th>Cancelled Ride</th>-->
                                        <th>Documents</th>
                                        <!-- <th>Total Receivables</th> -->
                                        <th>New Payable</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Providers as $index => $provider)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td><a
                                                    href="provider/{{ $provider->id }}/request">{{ $provider->first_name }}</a>
                                            </td>
                                            <td>{{ $provider->email }}</td>
                                            <td>{{ $provider->mobile }}</td>
                                            <!--<td>{{ $provider->total_requests }}</td>
                                                                                                                                        <td>{{ $provider->accepted_requests }}</td>
                                                                                                                                        <td>{{ $provider->total_requests - $provider->accepted_requests }}</td>-->
                                            <td>
                                                @if ($provider->pending_documents() > 0 || $provider->service == null)
                                                <span class="btn btn-secondary btn-danger">{{ $provider->pending_documents() }}
                                                            Doc! </span>
                                                    <!-- <a class="btn btn-secondary btn-danger"
                                                        href="{{ route('dispatcher.provider.document.index', $provider->id) }}"><span>{{ $provider->pending_documents() }}
                                                            Doc! </span></a> -->
                                                @else
                                                <span class="btn btn-secondary btn-success">All Set </span>
                                                    <!-- <a class="btn btn-secondary btn-success"
                                                        href="{{ route('dispatcher.provider.document.index', $provider->id) }}">All
                                                        Set!</a> -->
                                                @endif
                                            </td>
                                            <!-- <td>
                                                                                                                                        {{ $provider->payable }}
                                                                                                                                        </td> -->
                                            <td>
                                                @if (isset($provider->newPayable))
                                                    {{ $provider->newPayable }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <div class="input-group-btn">
                                                    {{--@if ($provider->status == 'approved')
                                                        <a class="btn btn-secondary btn-success btn-block"
                                                            href="{{ route('dispatcher.provider.disapprove', $provider->id) }}"><i
                                                                class="fa fa-check"></i>{{ $provider->status }} </a>
                                                    @else
                                                        <a class="btn btn-secondary btn-danger btn-block"
                                                            href="{{ route('dispatcher.provider.approve', $provider->id) }}"><i
                                                                class="fa fa-ban"></i>{{ $provider->status }}</a>
                                                    @endif--}}
                                                    <a href="{{ route('dispatcher.provider.today', $provider->id) }}"
                                                        class="btn btn-secondary btn-primary btn-block">Today Ride Details</a>
                                                    <a href="{{ route('dispatcher.provider.payment', $provider->id) }}"
                                                        class="btn btn-secondary btn-success btn-block">Payment Details</a>

                                                    <!-- <button type="button" 
                                                                                                                                                    class="btn btn-secondary btn-primary btn-block dropdown-toggle"
                                                                                                                                                    data-toggle="dropdown">Action
                                                                                                                                                    <span class="caret"></span>
                                                                                                                                                </button>  -->
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a href="{{ route('dispatcher.provider.inbound', $provider->id) }}"
                                                                class="btn btn-default"><i class="fa fa-sticky-note-o"></i>
                                                                Inbound
                                                                Orders</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('dispatcher.provider.request', $provider->id) }}"
                                                                class="btn btn-default"><i class="fa fa-search"></i>
                                                                Details</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('dispatcher.provider.today', $provider->id) }}"
                                                                class="btn btn-default"><i class="fa fa-search"></i>
                                                                today</a>
                                                        </li>

                                                        {{-- <li>
                                        <a href="{{ route('dispatcher.provider.edit', $provider->id) }}" class="btn btn-default"><i class="fa fa-pencil"></i> Edit Profile</a>
                                    </li>
                                    <li>
                                        <form action="{{ route('dispatcher.provider.destroy', $provider->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button class="btn btn-default look-a-like" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i> Delete</button>
                                        </form>
                                    </li> --}}
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <h6 class="no-result">No results found</h6>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    @include('user.layout.partials.datatable')

@endsection
