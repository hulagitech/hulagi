@extends('user.layout.master')

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

        /* 
                        .comments__container {
                            max-height: 480px;
                            overflow-y: scroll;
                            overflow-x: hidden
                        } */

        #topnav .topbar-main .logo {
            margin-top: 1rem;
        }

    </style>
@endsection


<style>
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


@section('content')

    {{-- <div class="row" style="background-color:#083caa; padding:30px 0px 30px 150px;">
        <div class="col-md-10">
            <h2 style="color:#F5F5F5 ;font-size:40px; font-weight: 300;">Ticket #
                {{ $ticket->id }} - {{ $ticket->title }}</h2>
        </div>

    </div> --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Ticket Detail</h4>
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
                                                <span
                                                    class="sub-heading">{{ $ticket->user->first_name }}<br>{{ $ticket->user->mobile }}</span>
                                            </div>
                                            <div class="ticket-info">
                                                <span class="heading">Department</span><br>
                                                <span class="sub-heading">{{ $ticket->department }}</span>
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

                                                    User

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
                                                   Hulagi Delivery <span class="text-danger">(Staff)</span>
                                                @else
                                                    {{ @$ticket->user->first_name }} 
                                                    {{ $ticket->user->last_name }} ({{ $ticket->user->email }})
                                                @endif

                                            </h3>
                                            <p class="mb-0 comment__desc text-muted">{{ $ticket->description }}</p>

                                            @if (@$ticket->createdby_cs == 1)

                                                <div class="float-right mt-4">
                                                    Kind regards,<br>
                                                    HUlagi Delivery<br>
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
                                            <div class="col-lg-9" style="border: 1px solid red;">
                                                <h3>

                                                    @if (@$comment->createdby_cs == 1)
                                                        Hulagi Delivery <span class="text-danger">(Staff)</span>
                                                    @elseif($comment->dept_id > 0)
                                                         {{ $comment->dept->dept }} Department 
                                                    @else
                                                        {{ @$ticket->user->first_name }}
                                                    @endif

                                                </h3>
                                                <p class="mb-0 comment__desc text-muted">

                                                @if($comment->dept_id > 0)
                                                   <b> {{ $comment->dept->dept }} replied: </b>
                                                @endif    

                                                    {{ $comment->comment }} 
                                                </p>
                                                @if (@$comment->createdby_cs == 1)

                                                    <div class="float-right mt-4">
                                                        Kind regards,<br>
                                                        Hulagi Delivery<br>
                                                        Dillibazar,Kathmandu
                                                    </div>

                                                @else
                                                    <span></span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach



                            <form class='d-flex' method="POST" action="{{ url('comment/ticket/' . $ticket->id) }}">
                                {{ csrf_field() }}
                                <input type="text" name="user_comment" id="user_comment" class="form-control mr-2"
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


<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    $(document).ready(function() {

        // Show Input element
        $('.edit').click(function() {
            $('.txtedit').hide();
            $(this).next('.txtedit').show().focus();
            $(this).hide();
        });

        // Save data
        $(".txtedit").focusout(function() {

            // Get edit id, field name and value
            var id = this.id;
            var split_id = id.split("-");
            var field_name = split_id[0];
            var edit_id = split_id[1];
            var value = $(this).val();

            if (field_name == "department" && !confirm("Are you sure, you want to change \"" + $(
                    "option:selected", this).text() + "\" department?")) {
                $(this).hide();
                $(this).prev('.edit').show();
                return;
            }
            // Hide Input element
            $(this).hide();

            // Hide and Change Text of the container with input elmeent
            $(this).prev('.edit').show();
            if ($(this).is('select')) {
                var val = $(this).find("option:selected").text();
                $(this).prev('.edit').text(val);
            } else {
                $(this).prev('.edit').text(value);
            }

            // Sending AJAX request
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/support/edit_department/') }}" + "/" + edit_id,
                type: 'post',
                data: field_name + "=" + value,
                success: function(response) {
                    console.log(response);
                    if (response.showError) {
                        alert(response.error);
                    }
                },
                error: function(request, error) {
                    console.log(request);
                    alert("Error! Please refresh page");
                }
            });
            //console.log($(this).html());

        });

    });
</script>
