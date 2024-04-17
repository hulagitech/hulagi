@extends('bm.layout.master')

@section('title', 'Order History')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Customer Query Order</h4>
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
                    @if (count($request) != 0)
                        <table id="datatable" class="table table-bordered"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Created At</th>
                                    <th>Booking ID</th>
                                    <th>Vendor Name</th>
                                    <th>Receiver Name</th>
                                    <th>Receiver Number</th>
                                    <th>Drop Off Location</th>
                                    <th>Status</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $index = 0; ?>
                                @foreach ($request as $request)
                                    <?php $index += 1; ?>

                                    <tr class="order">
                                        <input type="hidden" value="{{ @$request->id }}" class="form-control"
                                            id="order-{{ @$request->id }}">
                                        <th>{{ $index }}</th>
                                        <th>{{ $request->created_at }}</th>
                                        <th>{{ $request->booking_id }}</th>
                                        <th>{{ @$request->user->first_name }}</th>
                                        <th>{{ $request->item->rec_name }}</th>
                                        <th>{{ $request->item->rec_mobile }}</th>
                                        <th>{{ $request->d_address }}</th>
                                        <th>{{ $request->status }}</th>
                                        <td style="position:relative;">
                                            <a href="{{ route('bm.order_detail', @$request->id) }}"
                                                class="btn btn-success shadow-box"> <i class="ti-comment"></i> </a>

                                            {{-- Count Comment Notification --}}
                                            @if (@$request->noComment != '0')
                                                <span class="tag tag-danger"
                                                    style="position:absolute; top:0px;">{{ @$request->noComment }}</span>
                                            @else
                                                <span> </span>
                                            @endif
                                        </td>
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
