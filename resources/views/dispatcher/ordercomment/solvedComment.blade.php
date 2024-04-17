@extends('dispatcher.layout.master')

@section('title', 'All Order Comment')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h4 class="page-title m-0">Solve Comment</h4>
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
                 <table id="datatable-buttons" class="table table-bordered"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
                <tr>
                    {{-- <th>Refered Dept.</th> --}}
                    <th>Booking ID</th>
                    <th>User Id</th>
                    <th>User Name</th>
                    <th>Contact No.</th>
                    <th>Pickup Zone</th>
                    <th>Drop Zone</th>
                    {{-- <th>Pickup Location</th> --}}
                    <th> <i class="fa fa-comments"></i> </th>
                </tr>
                </thead>
            <tbody>
                @foreach($orderComments as $index => $orderComment)
                    <tr>
                        {{-- <td>
                            @if(@$orderComment->ur->dept_id!==0)
                                {{ @$orderComment->ur->dept_id }}
                            @else
                                Customer Service
                            @endif
                        </td> --}}
                        <td>{{ @$orderComment->ur->booking_id }}</td>
                        <td>{{ @$orderComment->ur->user_id }}</td>
                        <td>{{ @$orderComment->user->first_name }}</td>
                        <td>{{ @$orderComment->user->mobile }}</td>
                        <td>{{ @$orderComment->ur->zone_1->zone_name }}</td>
                        <td>{{ @$orderComment->ur->zone_2->zone_name }}</td>
                        {{-- <td>{{ @$orderComment->ur->s_address }}</td> --}}

                        
                        <td style="position:relative;">
                            <a href="{{ url('dispatcher/oc_detail/'.$orderComment->request_id) }}" class="btn btn-success btn-secondary"> <i class="ti-comment"></i> </a>
                            
                            {{-- Count Comment Notification --}}
                            @if(@$orderComment->noComment != '0')
                                <span class="tag tag-danger" style="position:absolute; top:0px;">{{@$orderComment->noComment}}</span>
                            @else
                                <span>  </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
@endsection
@section('scripts')

@include('user.layout.partials.datatable')

@endsection