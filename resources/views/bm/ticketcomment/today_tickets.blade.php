@extends('bm.layout.base')

@section('title', 'All Order Comment')

@section('content')
<div class="content-area py-1">
   <div class="container-fluid">
      <div class="box box-block bg-white">
      	<h5 class="mb-1">
            <i class="fa fa-ticket"></i>&nbsp;Today's Open Tickets
         </h5>
         <table class="table table-striped table-bordered dataTable" id="table-2"style="width:100%;">
            <thead>
                <tr>
                    <th>S.N</th>
                    <th><i class="ti-ticket"></i>Title</th>
                    <th>User Name</th>
                    <th>Priority</th>
                    <th>Created By</th>
                    <th> </th>
                    <th>Action</th>
                </tr>
                </thead>
            <tbody>
                @foreach($tickets as $index => $ticket)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        
                        <td>{{ $ticket->title }}</td>
                        
                        <td>{{ @$ticket->user->first_name }}</td>
                        
                        <td>
                            @if(@$ticket->priority=="urgent")
                                <div style="color:red;"> Urgent </div>
                            @elseif(@$ticket->priority=="high")
                                <div> High </div>
                            @elseif(@$ticket->priority=="medium")
                                <div> Medium </div>
                            @elseif(@$ticket->priority=="low")
                                <div> Low </div>
                            @else
                                <div style="color:red;"><b> - </b></div>
                            @endif
                        </td>
                        
                        <td>
                            @if(@$ticket->createdby_cs=='1')
                                <div>CS</div>
                            @else
                                <div>User</div>
                            @endif                        
                        </td>

                        <td>{{ @$ticket->created_at->diffForHumans() }}</td>
                        
                        <td style="position:relative;">
                            <a href="{{ url('bm/today_ticket_detail/'.$ticket->id) }}" class="btn btn-success shadow-box"><i class="ti-comment"></i></a>
                            
                            {{-- Count Comment Notification --}}
                            @if($ticket->noComment != '0')
                                <span class="tag tag-danger" style="position:absolute; top:0px;">{{$ticket->noComment}}</span>
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