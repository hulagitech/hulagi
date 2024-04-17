@extends('return.layout.master')

@section('title', 'Remaining')

@section('content')
<div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h4 class="page-title m-0"> <h1>{{$rider->first_name}}</h1><h2>({{$status}})</h2></h4>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end">
                       
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
                   <table id="datatable-buttons" class="table table-bordered"
                        								style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Booking ID</th>
                                <th>Vendor Name </th>
                                <th>Vendor Number </th>
                                <th>Reciver Name</th>
                                <th>Reciver Number</th>
                                <th>Reciver Address</th>
                                <th>COD</th>
                                <th>Remarks</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($request as $key => $req)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $req->booking_id }}</td>
                                    <td>{{ $req->user->first_name }}</td>
                                    <td>{{$req->user->mobile}}</td>
                                    <td>{{$req->item->rec_name}}</td>
                                    <td>{{$req->item->rec_mobile}}</td>
                                    <td>{{$req->item->rec_address}}</td>
                                    <td>{{$req->cod}}</td>
                                    <td>{{$req->special_note}}</td>
                                    <td><a href="{{ route('return.order_details', $req->id) }}" arget="_blank" class="btn btn-primary">
                                         More Details
                                    </a></td>
                                   
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>SN</th>
                                <th>Booking ID</th>
                                <th>Vendor Name </th>
                                <th>Vendor Number </th>
                                <th>Reciver Name</th>
                                <th>Reciver Number</th>
                                <th>Reciver Address</th>
                                <th>COD</th>
                                <th>Remarks</th>
                                <th>Details</th>
                            </tr>
                        </tfoot>
                    </table>
                    {{-- {{ $requests->links('vendor.pagination.bootstrap-4') }} --}}
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

