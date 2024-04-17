@extends('return.layout.master')

@section('title', 'Remaining')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
                    @if (count($log) > 0)
                        <table id="datatable-buttons" class="table table-bordered"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Date </th>
                                <th>User Name</th>
                                <!-- <th>No of Order</th> -->
                                <th>Booking ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($log as $key => $req)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $req->created_at}}</td>
                                    <td>{{$req->user->first_name}}</td>
                                    <!-- <th></th> -->
                                    <td>{{ $req->booking_id }}</td>
                                    
                                   
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>SN</th>
                                <th>Date </th>
                                <th>User Name</th>
                                <th>Booking ID</th>
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
