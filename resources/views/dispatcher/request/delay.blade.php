@extends('dispatcher.layout.master')

@section('title', 'Order History')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Track Dispatched Order</h4>
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
                <div class="card-body table-responsive">
                    <form class="form-inline float-right mb-4" method="POST" action={{ url('dispatcher/delaySearch') }}>
                        {{ csrf_field() }}
                        {{-- <div class="form-group">
                    <input type="text" class="form-control" name="searchField" placeholder="Full Search">
                </div> --}}
                        <div class="form-group mr-2">
                            <select class="form-control" name="zone">
                                <option>All</option>
                                @foreach ($zones as $zone)
                                    <option value="{{ $zone->zone->id }}"
                                        {{ request()->zone && request()->zone == $zone->id ? 'selected' : '' }}>
                                        {{ $zone->zone->zone_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mr-2">
                            <select class="form-control" name="status">
                                <option {{ request()->status && request()->status == 'Delayed' ? 'selected' : '' }}>
                                    Delayed
                                </option>
                                <option
                                    {{ request()->status && request()->status == 'Extremely Delayed' ? 'selected' : '' }}>
                                    Extremely Delayed</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button name="search" class="btn btn-success">Search</button>
                        </div>
                    </form>

                    <div class="table-responsive">
                        @if (count($requests) != 0)
                            <table id="datatable-buttons" class="table table-bordered"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Last Update</th>
                                        <th>User</th>
                                        <th>Pickup Add.</th>
                                        <th>Pickup No.</th>
                                        <th>DropOff Add.</th>
                                        <th>DropOff Name</th>
                                        <th>DropOff No.</th>
                                        <th>Km</th>
                                        <th>Rider</th>
                                        <th>Status</th>
                                        <th style="width:4%;">Kg</th>
                                        <th>COD(Rs)</th>
                                        <th>Remarks</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <script>
                                        var req_id = [];
                                    </script>
                                    @foreach ($requests as $index => $request)
                                        <script>
                                            req_id.push(<?php echo $request->id; ?>);
                                        </script>
                                        <tr id="dataRow{{ $index }}">
                                            <td>
                                                @if ($request->created_at)
                                                    <span class="text-muted">{{ $request->created_at }}</span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $request->booking_id }}</td>
                                            <td>
                                                @if ($request->created_at)
                                                    <span
                                                        class="text-muted">{{ $request->created_at->diffForHumans() }}</span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($request->updated_at)
                                                    @if ($request->status == 'PENDING' || $request->status == 'ACCEPTED')
                                                        <span
                                                            class="text-muted">{{ $request->updated_at->diffForHumans() }}</span>
                                                    @else
                                                        <span class="text-muted">{{ $request->updated_at }}</span>
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if (@$request->user)
                                                    {{ @$request->user->first_name }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if ($request->s_address)
                                                    {{ @$request->s_address }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if (@$request->user->mobile)
                                                    {{ @$request->user->mobile }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if ($request->d_address)
                                                    {{ @$request->d_address }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if (@$request->item->rec_name)
                                                    {{ @$request->item->rec_name }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if (@$request->item->rec_mobile)
                                                    {{ @$request->item->rec_mobile }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if (@$request->distance)
                                                    {{ @$request->distance }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if ($request->provider)
                                                    {{ @$request->provider->first_name }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if ($request->status)

                                                    @if ($request->status == 'REJECTED')
                                                        @if ($request->returned)
                                                            RETURNED (Rejected)
                                                        @else
                                                            TOBERETURNED (Rejected)
                                                        @endif
                                                    @elseif($request->status=="CANCELLED")
                                                        @if ($request->returned)
                                                            RETURNED (Cancelled)
                                                        @else
                                                            TOBERETURNED (Cancelled)
                                                        @endif
                                                    @elseif($request->status=="SORTCENTER")
                                                        {{ @$request->status }}
                                                        @if ($request->dispatched)
                                                            ({{ @$request->zone_2->zone_name }})
                                                        @else
                                                            ({{ @$request->zone_1->zone_name }})
                                                        @endif
                                                    @else
                                                        {{ @$request->status }}
                                                    @endif


                                                    {{-- <input type='text' class='txtedit' value="{{@$request->status}}" id='status-{{$index}}'> --}}
                                                @else

                                                    N/A


                                                @endif
                                            </td>
                                            <td style="width:4%;">
                                                @if ($request->weight)

                                                    {{ @$request->weight }}
                                                @else

                                                    0
                                                @endif
                                            </td>
                                            {{-- <td>
                            {{@$request->fare}}
                        </td> --}}

                                            <td>
                                                @if ($request->cod)
                                                    {{ @$request->cod }}
                                                @else
                                                    0
                                                @endif
                                            </td>
                                            <td>
                                                @if ($request->special_note)
                                                    {{ @$request->special_note }}
                                                @else
                                                    N/A
                                                @endif
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
