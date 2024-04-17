@extends('bm.layout.base')

@section('styles')
    <link rel="stylesheet" href="{{ asset('main/vendor/jvectormap/jquery-jvectormap-2.0.3.css') }}">
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

    <div class="row" style="background-color:#083caa; padding:30px 0px 30px 150px;">
        <div class="col-md-10">
            <h2 style="color:#F5F5F5 ;font-size:40px; font-weight: 300;">Ticket #
                {{ $ticket->id }} - {{ $ticket->title }}</h2>
        </div>
        <div class="col-md-2">
            @if ($ticket->status == 'open')
                <form method="POST" action="{{ url('bm/close_ticket/' . $ticket->id) }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="status" id="status" value="close">
                    <button type="submit" onclick="return confirm('Are you sure, you want to close?');"
                        class=" btn btn-primary form-control">Close <i class="fa fa-ticket"></i></button>
                </form>
            @else
                <form method="POST" action="{{ url('support/open_ticket/' . $ticket->id) }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="status" id="status" value="open">
                    <button type="submit" onclick="return confirm('Are you sure, you want to open?');"
                        class=" btn btn-primary form-control">Open <i class="fa fa-ticket"></i></button>
                </form>
            @endif
        </div>
    </div>

    <div class="content-area py-1 grey-color">

        <div class="container-fluid">
            <div class="dash-content">
                <div class="row no-margin ride-detail">

                    <div class="col-md-2 grey-color"></div>
                    <div class="col-md-8 grey-color" style="padding-top:50px">
                        <div class="accordian-body">
                            <div class="col-md-4">
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
                            <div class="col-md-8">
                                <div style="margin:20px 0px">
                                    <form method="POST" action="{{ url('bm/ticket_reply/' . $ticket->id) }}">
                                        {{ csrf_field() }}
                                        <div class="col-lg-10">
                                            <input type="text" name="cs_comment" id="cs_comment" class="form-control"
                                                placeholder="Add Your Comment ...">
                                        </div>
                                        <div class="col-lg-2">
                                            <button type="submit" class="btn btn-primary form-control"
                                                style="font-size:14px;">Post</button>
                                        </div>
                                    </form>
                                </div><br><br><br>
                                @foreach ($comments as $comment)
                                    <div class="description" style="">
                                        <div>
                                            <i class="fa fa-user"></i>
                                            @if (@$comment->createdby_cs == 0)

                                                <span class="sub-heading">  Hulagi Logistics</span>
                                                
                                                @endif
                                                <span class="sub-heading"
                                                    style="float: right">{{ $comment->created_at->diffForHumans() }}
                                                </span>
                                                <br>

                                                @if (@$comment->createdby_cs == 0)
                                                    <span class="heading">Staff</span><br>
                                                @else
                                                    <span class="heading">{{ $ticket->user->first_name }}</span><br>
                                                @endif
                                        </div>
                                        <div style="height:0.5px;background-color:rgb(192, 189, 189);margin:5px 0px"></div>
                                        <div style="min-height: 80px">
                                            {{ $comment->comment }}
                                        </div>

                                        @if (@$comment->createdby_cs == 0)
                                            <div style="height:0.5px;background-color:rgb(192, 189, 189);margin:5px 0px">
                                            </div>
                                            Kind regards,<br>
                                            Hulagi Logistics<br>
                                           Maitidevi,kathmandu

                                        @else
                                            <span></span>
                                        @endif
                                    </div>
                                @endforeach
                                <div class="description">
                                    <div>
                                        <i class="fa fa-user"></i>
                                        @if (@$comment->createdby_cs == 0)

                                            <span class="sub-heading">Hulagi Services</span>
                                            
                                            @endif
                                       <span class="sub-heading"
                                            style="float:right ">{{ $ticket->created_at->diffForHumans() }} </span>
                                        <br>

                                        @if (@$ticket->createdby_cs == 0)
                                            <span class="heading">Staff</span><br>
                                        @else
                                            <span class="heading">{{ $ticket->user->first_name }}</span><br>
                                        @endif
                                    </div>
                                    <div style="height:0.5px;background-color:rgb(192, 189, 189);margin:5px 0px"></div>
                                    <div style="min-height: 80px">
                                        {{ $ticket->description }}
                                    </div>

                                    @if (@$ticket->createdby_cs == 0)
                                        <div style="height:0.5px;background-color:rgb(192, 189, 189);margin:5px 0px"></div>
                                        Kind regards,<br>
                                        Hulagi Logistics<br>
                                        Maitidevi,kathmandu
                                    @else
                                        <span></span>
                                    @endif
                                </div>



                            </div>
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
