@extends('account.layout.base')

@section('title', 'All Order Comment')

@section('content')
<div class="content-area py-1">
   <div class="container-fluid">
      <div class="box box-block bg-white">
      	<h5 class="mb-1">
            <i class="fa fa-comments"></i>&nbsp; Solved Comments
         </h5>
         <table class="table table-striped table-bordered dataTable" id="table-2"style="width:100%;">
            <thead>
                <tr>
                    {{-- <th>Request ID</th> --}}
                    {{-- <th>Refered Dept.</th> --}}
                    <th>Booking ID</th>
                    <th>User Id</th>
                    <th>User Name</th>
                    <th>Contact No.</th>
                    <th>Pickup Zone</th>
                    <th>Drop Zone</th>
                    <th>Action</th>
                </tr>
                </thead>
            <tbody>
                @foreach($orderComments as $index => $orderComment)
                    <tr>
                        {{-- <td>{{ $index + 1 }}</td> --}}
                        {{-- <td>{{ $orderComment->request_id }}</td> --}}
                        {{-- <td>
                            @if(@$orderComment->ur->dept_id!==0)
                                {{ @$orderComment->dept->dept }}
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

                        <td style="position:relative;">
                            <a href="{{ url('account/oc_detail/'.@$orderComment->request_id) }}" class="btn btn-success btn-secondary"> <i class="ti-comment"></i> </a>
                            
                            {{-- Count Comment Notification --}}
                            @if(@$orderComment->noComment != '0')
                                {{-- <span style="color:red; position:absolute; top:-1px;"> {{$trip->comment_no}} </span> --}}
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

<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
@endsection