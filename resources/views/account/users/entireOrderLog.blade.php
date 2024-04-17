@extends('account.layout.master')

@section('title', $page)

@section('content')
<div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h4 class="page-title m-0">{{ $page }}</h4>
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
            @if (count($orderLog) != 0)
                                    <table id="datatable-buttons" class="table table-bordered"
                        								style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <td>Date</td>
                                                <td>Order Id</td>
                                                <td>Type</td>
                                                <td>Description</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orderLog as $log)
                                                <tr>
                                                    <td>{{$log->created_at}}</td>
                                                    <td>{{$log->request->booking_id}}</td>
                                                    <td>{{$log->type}}</td>
                                                    <td>{{$log->description}}</td>
                                                </tr>                                              
                                            @endforeach
                                        <tfoot>
                                            <tr>
                                                <td>Date</td>
                                                <td>Order Id</td>
                                                <td>Type</td>
                                                <td>Description</td>
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
</div>

@endsection
@section('scripts')

    @include('user.layout.partials.datatable')

@endsection
