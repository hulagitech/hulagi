@extends('sortcenter.layout.master')

@section('title', 'Ride History')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-1">
                        <i class="fa fa-recycle"></i> &nbsp;KTM Delivery Remaining
                    </h5>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body table-responsive">
                 @if (count($remaining_data) != 0)
                <table id="datatable-buttons" class="table table-bordered"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Created Date </th>
                            <th>Booking ID</th>
                            <th>User Name</th>
                            <th>Vendor Number</th>
                            <th>Receiver Name</th>
                            <th>Receiver Location</th>
                            <th>Receiver Number</th>
                            <th>Status</th>
                            <th>COD</th>
                            <th>Rider</th>
                            <th>Remark</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @if ($remaining_data->count())
                            @foreach ($remaining_data as $index => $data)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $data->created_at }}</td>
                                    <td>{{ $data->booking_id }}</td>
                                    <td>{{ $data->user->first_name }}</td>
                                    <td>{{ $data->user->mobile }}</td>
                                    <td>{{ $data->item->rec_name }}</td>
                                    <td>{{ $data->d_address }}</td>
                                    <td>{{ $data->item->rec_mobile }}</td>
                                    <td>{{ $data->status }}</td>
                                    <td>{{ $data->cod }}</td>
                                    <td>
                                        @if($data->provider)
                                            
                                                {{ @$data->provider->first_name}} 
                                        @else
                                           
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $data->special_note }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                        <a href="{{ route('sortcenter.order_details', $data->id) }}" type="button"
                                                class="btn btn-secondary btn-rounded btn-black waves-effect ">
                                        <i class="fa fa-search"></i> More Details
                                    </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
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
