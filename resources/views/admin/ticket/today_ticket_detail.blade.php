@extends('admin.layout.master')

@section('title', 'Todays Ticket Detail')

@section('styles')
    <link rel="stylesheet" href="{{ asset('main/vendor/jvectormap/jquery-jvectormap-2.0.3.css') }}">
    <style>
        .card-ticket-detail {
            border: 1px solid #0000;
        }

        .ticket-header {
            background: #000;
            color: #fff;
            padding: 3rem;
        }

        .ticket-header h2 {
            text-align: center;
            font-size: 2.5rem;
        }

        .table tr {
            padding-left: 10px;
        }

        .txtedit {
            display: none;
            width: 99%;
            height: 30px;
        }

        .ticket-info {
            background-color: #ffffff;
            min-height: 80px;
            border-radius: 3px;
            margin-bottom: 2px;
            padding: 15px 10px;

        }

        .grey-color {
            background-color: #f6f7f8
        }

        .heading {
            font-size: 18px;
            font-weight: 500;
            color: grey
        }

        .sub-heading {
            font-size: 14px;
            font-weight: 700;
        }

        .description {
            background-color: #ffffff;
            padding: 10px;
            margin-bottom: 10px
        }

    </style>

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
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0">Ticket Detail</h4>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-2">
                    @if ($ticket->status == 'open')
                        <form method="POST" action="{{ url('admin/today_close_ticket/' . $ticket->id) }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="status" id="status" value="close">
                            <button type="submit" onclick="return confirm('Are you sure, you want to close?');"
                                class=" btn btn-primary form-control">Close <i class="fa fa-ticket"></i></button>
                        </form>
                    @endif
                </div>

            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="card">
            <div class="card-header ticket-header">
                <h2>Ticket #
                    {{ $ticket->id }} - {{ $ticket->title }}</h2>
            </div>
            <div class="card-body row">
                <div class="col-md-4">
                    <div class="card card-ticket-detail">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-10 offset-md-0.5" s>
                                    <h4>Ticket Details</h4>
                                    <div>
                                        <div class="ticket-info">
                                            <span class="heading">Requestor</span><br>
                                            <span class="sub-heading"
                                                style="text-transform:capitalize;">{{ $ticket->user->first_name }}<br>{{ $ticket->user->mobile }}</span>
                                        </div>
                                        <div class="ticket-info">
                                            <span class="heading">Department</span><br>
                                            <span class="sub-heading">{{ $ticket->dept->dept }}</span>
                                        </div>
                                        <div class="ticket-info">
                                            <span class="heading">Submitted</span><br>
                                            <span class="sub-heading">{{ $ticket->created_at }}</span>
                                        </div>
                                        <div class="ticket-info">
                                            <span class="heading">Status/Priority</span><br>
                                            <span class="sub-heading">{{ $ticket->status }} /
                                                {{ $ticket->priority }}</span>
                                        </div>
                                        <div class="ticket-info">
                                            <span class="heading">Created From</span><br>
                                            <span class="sub-heading">

                                                @if (@$ticket->createdby_cs == '1' && isset($ticket->from_Dep->dept))
                                                    {{ $from_Dep->dept }}
                                                @else
                                                    User
                                                @endif

                                            </span>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">

                    <div class="comments__container">
                        <div class="cd-timeline-block m-5">
                            <div class="cd-timeline-content p-3 w-100">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="text-center">
                                            <div>
                                                <i class="mdi mdi-account h2"></i>
                                            </div>
                                            <div class="cd-date comment-date mb-4">
                                                {{ $ticket->created_at->diffForHumans() }}</div>

                                        </div>
                                    </div>
                                    <div class="col-lg-9">
                                        <h3>

                                            @if (@$ticket->createdby_cs == 1)
                                                Hulagi Logistics<span class="text-danger">(Staff)</span>
                                            @else
                                                {{ @$ticket->user->first_name }}
                                                {{ $ticket->user->last_name }} ({{ $ticket->user->email }})
                                            @endif

                                        </h3>
                                        <p class="mb-0 comment__desc text-muted">{{ $ticket->description }}</p>
                                        @if (@$ticket->createdby_cs == 1)

                                            <div class="float-right mt-4">
                                                Kind regards,<br>
                                                Hulagi Logistics<br>
                                             Dillibazar,kathmandu
                                            </div>

                                        @else
                                            <span></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach ($comments as $comment)

                            <div class="cd-timeline-block m-5">
                                <div class="cd-timeline-content p-3 w-100">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="text-center">
                                                <div>
                                                    <i class="mdi mdi-account h2"></i>
                                                </div>
                                                <div class="cd-date comment-date mb-4">
                                                    {{ $comment->created_at->diffForHumans() }}</div>

                                            </div>
                                        </div>
                                        <div class="col-lg-9">
                                            <h3>

                                                @if (@$comment->createdby_cs == 0)
                                                Hulagi Logistics <span class="text-danger">(Staff)</span>
                                                @else
                                                    {{ @$ticket->user->first_name }}
                                                @endif

                                            </h3>
                                            <p class="mb-0 comment__desc text-muted">{{ $comment->comment }}</p>
                                            @if (@$comment->createdby_cs == 0)

                                                <div class="float-right mt-4">
                                                    Kind regards,<br>
                                                    Hulagi Logistics<br>
                                                    Maitidevi,Kathmandu
                                                </div>

                                            @else
                                                <span></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <form class='d-flex' method="POST" action="{{ url('admin/ticket_reply/' . $ticket->id) }}">
                            {{ csrf_field() }}
                            <input type="text" name="comment" id="comment" class="form-control mr-2"
                                placeholder="Add Your Comment ..." required>
                            <button type="submit" class="btn btn-lg btn-outline-dark text-uppercase">Post</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>



@endsection