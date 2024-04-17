@extends('bm.layout.master')

@section('title', 'Recent Trips ')
 @section('scripts')

    @include('user.layout.partials.datatable')

@endsection



@section('content')
<div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h4 class="page-title m-0">OutGoing Order  History</h4>
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
                                <th>ID</th>
                                <th>Last Update</th>
                                <th>User</th>
                                <th>Pickup Add.</th>
                                <th>Pickup Number</th>
                                <th>DropOff Add.</th>
                                <th>DropOff Name</th>
                                <th>DropOff Number</th>
                                <th>Vendor Remarks</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                       <script> var req_id=[];</script>
                        @foreach($requests as $index => $request)
                            <tr id="dataRow{{$index}}">
                                <td>
                                    @if(@$request->request->created_at)
                                        <span class="text-muted">{{@$request->request->created_at}}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ @$request->request->booking_id }}</td>
                                <td>
                                    @if(@$request->request->updated_at)
                                        <span class="text-muted">{{@$request->request->updated_at}}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->request->user)
                                        {{ @$request->request->user->first_name }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->request->s_address)
                                        {{ @$request->request->s_address }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->request->user->mobile)
                                        {{ @$request->request->user->mobile }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->request->d_address)
                                        {{ @$request->request->d_address }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                 <td>
                                    @if(@$request->request->item->rec_name)
                                        {{ @$request->request->item->rec_name}} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->request->item->rec_mobile)
                                        {{ @$request->request->item->rec_mobile }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->request->special_note)
                                        {{ @$request->request->special_note}} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                @if(@$request->request->status)
                                    {{ @$request->request->status}} 
                                @else
                                N/A
                            @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Date</th>
                                <th>ID</th>
                                <th>Last Update</th>
                                <th>User</th>
                                <th>Pickup Add.</th>
                                <th>Pickup Number</th>
                                <th>DropOff Add.</th>
                                <th>DropOff Name</th>
                                <th>DropOff Number</th>
                                <th>Vendor Remarks</th>
                                <th>Status</th>
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
@if(count($requests) != 0)
        <div class="content-area py-1">
            <div class="container-fluid">
                <div class="box box-block bg-white">
                    <h5 class="mb-1"> <i class="fa fa-recycle"></i> Dispatch Order Comment</h5>
                    <hr/>
                    <form action="{{url('bm/dispatchList/comment/'.$id)}}" method="POST">
                    {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Comment</label>
                            <input type="text" class="form-control"  name="comment" placeholder="Add Your Comment">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        @endif


<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
{{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}


@endsection


 
@section('styles')
    <style type="text/css">
        .bm-nav li span {
            /* // background-color: transparent; */
            color: #000!important;
            padding: 5px 12px;
        }
        .bm-nav li span:hover,
        .bm-nav li span:focus,
        .bm-nav li span:active {
            background-color: #20b9ae;
            color: #fff!important;
            padding: 5px 12px;
        }
        .bm-nav li.active span,
        .bm-nav li span:hover,
        .bm-nav li span:focus,
        .bm-nav li span:active {
            background-color: #20b9ae;
            color: #fff!important;
            padding: 5px 12px;
        }
    </style>
@endsection