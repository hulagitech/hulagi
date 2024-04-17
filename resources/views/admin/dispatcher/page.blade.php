@extends('admin.layout.master')

@section('title', 'Dispatcher ')

@section('content')
<div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h4 class="page-title m-0">Dispatch Pending Receive </h4>
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
              
             @if(count($requests) != 0)
                    <table id="datatable" class="table table-bordered"
                        								style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Dispatch ID</th>
                                <th>No of Orders</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <script> var req_id=[];</script>
                        @foreach($requests as $index => $request)
                            <tr id="dataRow{{$index}}">
                                <td>
                                    @if(@$request->created_at)
                                        <span class="text-muted">{{@$request->created_at->format('Y-m-d')}}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td> {{@$request->zone2->name}}#{{@$request->id}} </td>
                                <td>
                                    {{$request->lists_count}}
                                </td>
                                <td>
                                    <a href="" class="btn btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    {{-- <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-secondary btn-rounded btn-black waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            Action
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="{{ route('dispatcher.dispatchList.showNewDispatch', $request->id) }}" class="dropdown-item">
                                                <i class="fa fa-search"></i> More Details
                                            </a>
                                        </div>
                                    </div> --}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Date</th>
                                <th>Dispatch ID</th>
                                <th>No of Orders</th>
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
</div>

@endsection
@section('scripts')

    @include('user.layout.partials.datatable')

@endsection