@extends('bm.layout.master')

@section('title', 'Recent Trips ')

@section('content')


<style>
    .txtedit {
        display: none;
        width: 99%;
        height: 30px;
    }

</style>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h4 class="page-title m-0">retrun Remaining</h4>
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
                        <th>User</th>
                        <th>DropOff Add.</th>
                        <th>DropOff Name</th>
                        <th>DropOff No.</th>
                        <th>Rider</th>
                        <th>COD</th>
                        <th>Vendor Remarks</th>
                        <th> Action </th>
                        {{-- <th>Receive</th> --}}
                    </tr>
                </thead>
                <tbody>
                    <script>
                        var req_id = [];

                    </script>
                    @foreach($requests as $index => $request)
                    <tr id="dataRow{{$index}}">
                        <td>
                            @if(@$request->created_at)
                            <span class="text-muted">{{@$request->created_at}}</span>
                            @else
                            -
                            @endif
                        </td>
                        <td>{{ @$request->booking_id }}</td>

                        <td>
                            @if(@$request->user)
                            {{ @$request->user->first_name }}
                            @else
                            N/A
                            @endif
                        </td>

                        <td>
                            @if(@$request->d_address)
                            {{ @$request->d_address }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td>
                            @if(@$request->item->rec_name)
                            {{ @$request->item->rec_name}}
                            @else
                            N/A
                            @endif
                        </td>
                        <td>
                            @if(@$request->item->rec_mobile)
                            {{ @$request->item->rec_mobile }}
                            @else
                            N/A
                            @endif
                        </td>

                        <td>
                            @if(@$request->provider)
                            {{ @$request->provider->first_name}}
                            @else
                            N/A
                            @endif
                        </td>

                        <td>
                            @if(@$request->cod)
                            {{ @$request->cod}}
                            @else
                            N/A
                            @endif
                        </td>

                        <td>
                            @if(@$request->special_note)
                            {{ @$request->special_note}}
                            @else
                            N/A
                            @endif
                        </td>

                        <td style="position:relative;" width="5%">
                            <a href="{{ route('bm.order_detail', @$request->id) }}" class="btn btn-success shadow-box"> <i class="ti-comment"></i> </a>

                            {{-- Count Comment Notification --}}
                            @if($request->noComment != '0')
                            <span class="tag tag-danger" style="position:absolute; top:0px;"> {{$request->noComment}}</span>
                            @else
                            <span> </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Date</th>
                        <th>ID</th>
                        <th>User</th>
                        <th>DropOff Add.</th>
                        <th>DropOff Name</th>
                        <th>DropOff No.</th>
                        <th>Rider</th>
                        <th>COD</th>
                        <th>Vendor Remarks</th>
                        <th> Action </th>

                        {{-- <th>Receive</th> --}}
                    </tr>
                </tfoot>
            </table>
                {{$requests->links('vendor.pagination.bootstrap-4')}}
                @else
                <h6 class="no-result">No results found</h6>
                @endif 
            </div>
        </div>
    </div>
</div>

@section('scripts')

@include('user.layout.partials.datatable')

@endsection
@endsection
