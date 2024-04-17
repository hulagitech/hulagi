@extends('sortcenter.layout.master')

@section('title', 'All Tickets')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-1">
                        <i class="fa fa-plus fa-ticket"></i>&nbsp;All Tickets
                     </h5>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body table-responsive">
                 <table id="datatable" class="table table-bordered"style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    @if (count($tickets) != 0)
                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Created Date</th>
                            <th>User Name</th>
                            <th><i class="ti-ticket"></i> Title</th>
                            <th><i class="ti-ticket"></i> Description</th>
                            <th>Refered Dept.</th>
                            <th>Priority</th>
                            <th>Created From</th>
                            <th>Action</th>
                            <th>Solve</th>
                        </tr>
                        </thead>
                    <tbody>
                        @foreach($tickets as $index => $ticket)
                            <tr>
                                <td>{{ $index+1 }}</td>
                                <td>{{ $ticket->created_at->diffForHumans() }}</td>
                                <td>{{ $ticket->user->first_name }}</td>
                                <td>{{ $ticket->title }}</td>
                                <td>{{ $ticket->description }}</td>
                                
                                <td>
                                    @if(@$ticket->dept_id!==0)
                                        <div> {{$ticket->dept->dept}} </div>
                                    @else
                                        <div> {{$ticket->department}} </div>
                                    @endif
                                </td>
        
                                
                                
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
                                        <div> - </div>
                                    @endif
                                </td>
        
                                <td>
                                    @if(@$ticket->createdby_cs=='1'&&isset($ticket->from_Dep->dept))
                                    <div>{{$ticket->from_Dep->dept}} </div>
                                    @else
                                        <div>User</div>
                                    @endif
                                </td>
                                <td style="position:relative;">
                                    <a href="{{ url('sortcenter/ticket_comment/'.$ticket->id) }}" class="btn btn-success btn-secondary"><i class="ti-comment"></i></a>
                                    
                                    {{-- Count Comment Notification --}}
                                    @if($ticket->noComment != '0')
                                        <span class="tag tag-danger" style="position:absolute; top:0px;">{{$ticket->noComment}}</span>
                                    @else
                                        <span>  </span>
                                    @endif
                                </td>
                                <td>
                                    <form method="POST" action="{{ url('sortcenter/close_ticket/' . $ticket->id) }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="status" id="status" value="close">
                                        <button type="submit" onclick="return confirm('Are you sure, you want to close?');"
                                            class=" btn btn-primary form-control">Close <i class="fa fa-ticket"></i></button>
                                    </form>
                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    @else
                    <h6 class="no-result">No results found</h6>
                    @endif
                 </table>
            </div>

        </div>
    </div>
</div>

@endsection
@section('scripts')

    @include('user.layout.partials.datatable')

@endsection