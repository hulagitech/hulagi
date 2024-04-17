@extends('admin.layout.master')

@section('title', 'Order History')

@section('content')
<div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h4 class="page-title m-0">Order Logs </h4>
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
               @if(count($logs) != 0)
                    <table id="datatable" class="table table-bordered"
                                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($logs as $index => $log)
                            <tr id="dataRow{{$index}}">
                                <td>
                                    @if($log->created_at)
                                        <span class="text-muted">{{$log->created_at}}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ @$log->type }}</td>
                                <td>{{ @$log->description }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Description</th>
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