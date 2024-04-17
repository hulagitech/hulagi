@extends('dispatcher.layout.master')

@section('title', 'Recent Trips ')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-4">
                   <h5 class="mb-1"> <i class="fa fa-truck"></i> InComplete Received </h5>
                </div>
                <div class="col-md-8 d-flex justify-content-end">
                   
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="container-fluid">
        <div class="card m-b-30">
            <div class="card-body table-responsive">
         
                    @if(count($requests) != 0)
                    <table id="datatable" class="table table-bordered"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>ID</th>
                                <th>Last Update</th>
                                <th>From (Zone)</th>
                                <th>Remarks</th>
                                {{-- <th>Bill Image</th>
                                <th>Dispatch</th> --}}
                                <th>No of orders</th>
                                <th>Received No.</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <script> var req_id=[];</script>
                        @foreach($requests as $index => $request)
                            <tr id="dataRow{{$index}}">
                                <td>
                                    @if(@$request->created_at)
                                        <span class="text-muted">{{@$request->created_at}}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{@$request->zone2->name}}#{{@$request->id}}</td>
                                <td>
                                    @if(@$request->updated_at)
                                        <span class="text-muted">{{@$request->updated_at}}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->zone1->name)
                                        <span>{{@$request->zone1->name}}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->remarks)
                                        <span>{{@$request->remarks}}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->lists_count)
                                        <span>{{@$request->lists_count}}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->received_count)
                                        <span>{{@$request->received_count}}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    {{-- <a href="{{ route('dispatcher.dispatchList.showNewDispatch', @$request->id) }}" class="btn btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </a> --}}
                                    <a href="{{ route('dispatcher.dispatchList.eachCompleteReceived', @$request->id) }}" class="btn btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Date</th>
                                <th>ID</th>
                                <th>Last Update</th>
                                <th>From (Zone)</th>
                                <th>Remarks</th>
                                {{-- <th>Bill Image</th>
                                <th>Dispatch</th> --}}
                                <th>No of orders</th>
                                <th>Received No.</th>
                                <th>Action</th>
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



@section('styles')
    <style type="text/css">
        .dispatcher-nav li span {
            /* // background-color: transparent; */
            color: #000!important;
            padding: 5px 12px;
        }
        .dispatcher-nav li span:hover,
        .dispatcher-nav li span:focus,
        .dispatcher-nav li span:active {
            background-color: #20b9ae;
            color: #fff!important;
            padding: 5px 12px;
        }
        .dispatcher-nav li.active span,
        .dispatcher-nav li span:hover,
        .dispatcher-nav li span:focus,
        .dispatcher-nav li span:active {
            background-color: #20b9ae;
            color: #fff!important;
            padding: 5px 12px;
        }
    </style>
@endsection
@section('scripts')

@include('user.layout.partials.datatable')

@endsection
