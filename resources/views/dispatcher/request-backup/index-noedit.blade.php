@extends('dispatcher.layout.master')

@section('title', 'Order History')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0"> STATUS DETAILS OF {{ $provider[0]->first_name }}</h4>
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
                    <table class="table table-bordered"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>ASSIGNED</th>
                                <th>DELIVERING</th>
                                <th>SCHEDULED</th>
                                <th>RETURNED</th>
                                <th>RETURN REMAINING</th>
                            </tr>
                        </thead>
                        <tbody>
                            <th>{{ count($provider[0]->assigned) }}</th>
                            <th>{{ count($provider[0]->delivering) }}</th>
                            <th>{{ count($provider[0]->schedule) }}</th>
                            <th>{{ count($provider[0]->rejectedreturned) }}</th>
                            <th>{{ count($provider[0]->rejectedRemaining) }}</th>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0"> Rider log OF {{ $provider[0]->first_name }}</h4>
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
                    @if (isset($type))
                        @if ($type == 'user')
                            <form class="form-inline float-right" method="POST"
                                action={{ url('dispatcher/userdetailSearch/' . $id) }}>
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="from_date" style="padding-top:5px;"> From: <label>
                                            <input type="date" class="form-control" name="from_date">
                                </div>
                                <div class="form-group">
                                    <label for="to_date" style="padding-top:5px;"> To: <label>
                                            <input type="date" class="form-control" name="to_date">
                                </div>
                                <div class="form-group">
                                    <button name="search" class="btn btn-success ml-4">Search</button>
                                </div>
                            </form>
                        @elseif($type == "rider")
                            <form class="form-inline float-right" method="POST"
                                action={{ url('dispatcher/riderdetailSearch/' . $id) }}>
                                {{ csrf_field() }}
                                <!-- <div class="form-group">
                                                                                                                                <label for="from_date" style="padding-top:5px;"> From: <label>
                                                                                                                                <input type="date" class="form-control" name="from_date">
                                                                                                                            </div>
                                                                                                                            <div class="form-group">
                                                                                                                                <label for="to_date" style="padding-top:5px;"> To: <label>
                                                                                                                                <input type="date" class="form-control" name="to_date">
                                                                                                                            </div> -->
                                <div class="form-group">
                                    <select class="form-control" name="status">
                                        <option {{ isset($current) && $current['status'] == 'All' ? 'selected' : '' }}>
                                            All</option>
                                        <!-- <option {{ isset($current) && $current['status'] == 'PENDING' ? 'selected' : '' }}>PENDING</option> -->
                                        <option
                                            {{ isset($current) && $current['status'] == 'SCHEDULED' ? 'selected' : '' }}>
                                            SCHEDULED</option>
                                        <option
                                            {{ isset($current) && $current['status'] == 'COMPLETED' ? 'selected' : '' }}>
                                            COMPLETED</option>
                                        <option
                                            {{ isset($current) && $current['status'] == 'REJECTED' ? 'selected' : '' }}>
                                            REJECTED</option>
                                        <option
                                            {{ isset($current) && $current['status'] == 'ASSIGNED' ? 'selected' : '' }}>
                                            ASSIGNED</option>
                                        <option
                                            {{ isset($current) && $current['status'] == 'DELIVERING' ? 'selected' : '' }}>
                                            DELIVERING</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button name="search" class="btn btn-success ml-4">Search</button>
                                </div>
                            </form>
                        @endif
                        <br>
                        <br>
                        <hr />
                    @endif
                    @if (count($requests) != 0)
                        <table id="datatable" class="table table-bordered"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>ID</th>
                                    <!-- <th>Last Update</th> -->
                                    <th>User</th>
                                    <!-- <th>Pickup Add.</th> -->
                                    <th>Pickup Number</th>
                                    <th>DropOff Add.</th>
                                    <th>DropOff Name</th>
                                    <th>DropOff Number</th>
                                    <!-- <th>Km</th> -->
                                    <!-- <th>Rider</th> -->
                                    <th>Status</th>
                                    <!-- <th>Fare</th> -->
                                    <th>COD(Rs)</th>
                                    <!-- <th>Remarks</th> -->
                                    <!-- <th>Rider Remarks</th> -->
                                    <th>Payment Received</th>
                                    <th>Action</th>
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
                                        <!-- <td>
                                                                                                                                @if ($request->updated_at)
                                                                                                                                    <span class="text-muted">{{ $request->updated_at }}</span>
                            @else
                                                                                                                                    -
                                                                                                                                @endif
                                                                                                                            </td> -->
                                        <td>
                                            @if (@$request->user)
                                                {{ @$request->user->first_name }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <!-- <td>
                                                                                                                                @if ($request->s_address)
                                                                                                                                    {{ @$request->s_address }} 
                            @else
                                                                                                                                    N/A
                                                                                                                                @endif
                                                                                                                            </td> -->
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
                                        <!-- <td>
                                                                                                                                @if (@$request->distance)
                                                                                                                                    {{ @$request->distance }} 
                            @else
                                                                                                                                    N/A
                                                                                                                                @endif
                                                                                                                            </td> -->
                                        <!-- <td>
                                                                                                                                @if ($request->provider)
                                                                                                                                    {{ @$request->provider->first_name }} 
                            @else
                                                                                                                                    N/A
                                                                                                                                @endif
                                                                                                                            </td> -->
                                        <td>
                                            @if ($request->status)
                                                @if ($request->status == 'REJECTED' && $request->returned_to_hub == '1')
                                                    RETURNED
                                                    <BR> (R)
                                                @elseif($request->status=="REJECTED" &&
                                                    $request->returned_to_hub=='0')
                                                    RETURN REMAINING
                                                @else
                                                    {{ $request->status }}
                                                @endif

                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <!-- <td>
                                                                                                                                {{-- @if ($request->payment != '')
                            {{ currency($request->payment->total) }} --}}
                                                                                                                                @if ($request->amount_customer)
                                                                                                                                    {{ @$request->amount_customer }} 
                            @else
                                                                                                                                    0
                                                                                                                                @endif
                                                                                                                            </td> -->
                                        <td>
                                            @if ($request->cod)
                                                {{ @$request->cod }}
                                            @else
                                                0
                                            @endif{{-- @if ($request->cod != '')
                            {{ currency($request->cod) }}
                            @else
                                N/A
                            @endif --}}
                                        </td>{{-- <!-- <td>{{ $request->payment_mode }}</td> -->
                        <td>
                            @if ($request->paid)
                                Paid
                            @else
                                Not Paid
                            @endif
                        </td> --}}
                                        <!-- <td>
                                                                                                                                @if ($request->special_note)
                                                                                                                                    {{ @$request->special_note }} 
                            @else
                                                                                                                                    N/A
                                                                                                                                @endif
                                                                                                                            </td> -->
                                        <!-- @if (@$request->log->complete_remarks)
                                                                                                                                <td>{{ @$request->log->complete_remarks }}</td>    
                        @else
                                                                                                                                <td>{{ @$request->log->pickup_remarks }}</td>
                                                                                                                            @endif -->
                                        @if (@$request->log->payment_received)
                                            <td>{{ @$request->log->payment_received ? 'Yes' : 'No' }}</td>
                                        @else
                                            <td>No</td>
                                        @endif
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button"
                                                    class="btn btn-secondary btn-rounded btn-black waves-effect dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a href="{{ route('dispatcher.requests.show', $request->id) }}"
                                                        class="dropdown-item">
                                                        <i class="fa fa-search"></i> More Details
                                                    </a>
                                                    {{-- <a href="{{ route('dispatcher.requests.edit', $request->id) }}" class="dropdown-item">
                                    <i class="fa fa-pencil"></i>  Edit
                                    </a> --}}
                                                    {{-- <form action="{{ route('dispatcher.requests.destroy', $request->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="dropdown-item">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </form> --}}
                                                </div>
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


@endsection
@section('scripts')
    @include('user.layout.partials.datatable')

@endsection
