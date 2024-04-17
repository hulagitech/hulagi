@extends('pickup.layout.master')

@section('title', 'Order details ')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">{{$rider->first_name}}-({{$status}})</h4>
                    </div>
                    <div class="col-md-4 justify-content-end d-flex">
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
                                    <th>Booking ID</th>
                                    <th>Vendor Name </th>
                                    <th>Reciver Name</th>
                                    <th>Reciver Number</th>
                                    <th>COD</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($request as $key => $req)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $req->booking_id }}</td>
                                        <td>{{ @$req->user->first_name }}</td>
                                        <td>{{$req->item->rec_name}}</td>
                                        <td>{{$req->item->rec_mobile}}</td>
                                        <td>{{$req->cod}}</td>
                                       
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                <th>SN</th>
                                    <th>Booking ID</th>
                                    <th>Vendor Name </th>
                                    <th>Reciver Name</th>
                                    <th>Reciver Number</th>
                                    <th>COD</th>
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



@endsection
@section('scripts')

    @include('user.layout.partials.datatable')

@endsection
<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">







