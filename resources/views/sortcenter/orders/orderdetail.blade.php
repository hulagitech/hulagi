
@extends('sortcenter.layout.master')

@section('title', 'Rider details ')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h4 class="page-title m-0">{{$status}} Orders</h4>
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
                @if(count($order) > 0)
                <table id="datatable-buttons" class="table table-bordered"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Vendor Number</th>
                            <th>Bookin ID</th>
                            <th>Receiver Name</th>
                            <th>Receiver Number</th>
                            <th>Reciver Location</th>
                            <th>COD</th>
                        </tr>
                    </thead>
        
                    <tbody>
                        @foreach($order as $index => $rider)
                        <tr id="dataRow{{$index}}">
                            <td>
                                {{$index+1}}
                            </td>
                            <td>
                               {{$rider->user->mobile ?? ''}}
                            </td>
                            <td>
                               {{$rider->booking_id}}
                            </td>
                            <td>{{$rider->item->rec_name}}</td>
                            <td>
                                {{$rider->item->rec_mobile}}
                            </td>
                            <td>
                            {{$rider->d_address}}
                            </td>
                            <td>{{$rider->cod}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>SN</th>
                            <th>Bookin ID</th>
                            <th>Receiver Name</th>
                            <th>Receiver Number</th>
                            <th>Reciver Location</th>
                            <th>COD</th>
                        </tr>
                    </tfoot>
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