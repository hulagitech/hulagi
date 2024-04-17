@extends('admin.layout.base')

@section('title', 'Ticket Detail')

@section('styles')
    <link rel="stylesheet" href="{{asset('main/vendor/jvectormap/jquery-jvectormap-2.0.3.css')}}">
@endsection


<style>
    .table tr{
        padding-left:10px;
    }

    .txtedit{
        display: none;
        width: 99%;
        height: 30px;
    }
</style>


@section('content')

<div class="content-area py-1">

<div class="container-fluid">
    <div class="dash-content">
        <div class="row no-margin ride-detail">
            
            <div class="col-md-12">

                @if($ticket->count() > 0)
                    <div class="accordian-body">
                        <div class="col-md-12" style="background-color:#f5f5f5; padding:30px 20px 20px 20px;">
                            <div class="from-to row no-margin">
                                <div style="display:flex; font-size:12px; padding-left:5px;">
                                    <h4> <i class="ti-ticket"></i> {{ $ticket->title }} </h4>
                                </div>
                                <div style="display:flex; font-size:12px; padding-left:10px;">
                                    By:&nbsp;<b> {{$ticket->user->first_name}} </b> &nbsp; - &nbsp; {{$ticket->created_at->diffForHumans()}} &nbsp; - &nbsp; Priority:&nbsp;
                                    @if(@$ticket->priority=="urgent")
                                        <div style="color:red;"><b> Urgent </b></div>
                                    @elseif(@$ticket->priority=="high")
                                        <div><b> High </b></div>
                                    @elseif(@$ticket->priority=="medium")
                                        <div><b> Medium </b></div>
                                    @elseif(@$ticket->priority=="low")
                                        <div><b> Low </b></div>
                                    @endif
                                </div>
                            </div><br>

                            <div style="padding-left:10px;"> 
                                <div class="col-md-12"><h6> {{ $ticket->description }} </h6></div>

                                <div class="col-md-12">
                                    <div class="col-md-2" style="float:right;">
                                        @if($ticket->status=="open")
                                            <form method="POST" action="{{url('admin/close_ticket/'.$ticket->id)}}">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="status" id="status" value="close">
                                                <button type="submit" onclick="return confirm('Are you sure, you want to close?');" class=" btn btn-primary form-control">Close <i class="fa fa-ticket"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- User Comment Section -->
                        <div class="col-md-8">
                            <div class="col-lg-12" style="overflow-y:auto; margin-top:20px;"> <i class="fa fa-comments"></i> <b><i style="font-weight:bold; font-size:14px;">Comments:</i></b> </div>
                        
                            @if($comments != '0')
                                @foreach($comments as $comment)
                                <div class="col-lg-12" style="margin:5px 0px;">
                                    <div class="col-lg-12" style="background-color: #F5F5F5; padding:15px 15px 15px 17px;">
                                        <div style="display:flex; flex:1; justify-content:space-between;">
                                            @if(@$comment->dept_id!==0)
                                                <div><b> {{@$comment->dept->dept}} </b></div>
                                            @elseif($comment->dept_id==0 && $comment->is_read_user==0)
                                                <div><b> User </b></div>
                                            @else
                                                <div><b> {{@$comment->authorised_type}} </b></div>
                                            @endif
                                            
                                            <div> {{ @$comment->created_at->diffForHumans() }} </div>
                                        </div>
                                        <div style="padding-top:7px;">
                                            - {{ @$comment->comment }}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @endif 
                                
                            <!-- <div class="col-lg-12"> -->
                            <form method="POST" action="{{ url('admin/ticket_reply/'.$ticket->id) }}">
                                {{ csrf_field() }}
                                <div class="col-lg-10">
                                    <input type="text" name="comment" id="comment" class="form-control" placeholder="Add Your Comment ...">
                                </div>
                                <div class="col-lg-2">
                                    <button type="submit" class="btn btn-primary form-control" style="font-size:14px;">Post</button>
                                </div>
                            </form>
                        </div>
                    </div>         


                @else
                    <hr>
                    <p style="text-align: center;">No Ticket Available</p>
                @endif

            </div>
        </div>
    </div>
</div>

</div>

@endsection