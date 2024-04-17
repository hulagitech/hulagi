@extends('support.layout.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('main/vendor/jvectormap/jquery-jvectormap-2.0.3.css') }}">
    <style>
    .table tr {
        padding-left: 10px;
    }
    .txtedit {
        display: none;
        width: 99%;
        height: 30px;
    }
</style>
@endsection





@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Ticket Detail</h4>
                    </div>
                    {{-- @if ($request->status == 'COMPLETED')
                        <div class="col-md-4">
                            <div class="float-right">
                                <div class="btn btn-primary" type="button" id="exchangeOrder">
                                    <i class="ti-plus mr-1"></i> Exchange Order
                                </div>
                            </div>
                        </div>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
    @if ($ticket->count() > 0)
        <div class="card">
            <div class="card-body">
                <div class='d-flex justify-content-between'>
                    <h6>Title: <span class='lead'> {{ $ticket->title }}</span></h6>
                    <h6>{{ $ticket->created_at->diffForHumans() }}</h6>
                </div>
                <article class="card content__card">

                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-4">
                                <h6 class="content__heading">User:</h6>
                                <div class="content__desc text-capitalize">

                                    {{ $ticket->user->first_name }}</div>
                            </div>
                            <div class="col-md-4">
                                <h6 class="content__heading">Priority:</h6>
                                <div class="content__desc">
                                    @if (@$ticket->priority == 'urgent')
                                        <div style="color:red;"><b> Urgent </b></div>
                                    @elseif(@$ticket->priority=="high")
                                        <div><b> High </b></div>
                                    @elseif(@$ticket->priority=="medium")
                                        <div><b> Medium </b></div>
                                    @elseif(@$ticket->priority=="low")
                                        <div><b> Low </b></div>
                                    @else
                                        <div style="color:red;"><b> - </b></div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h6 class="content__heading">Department:</h6>
                                <div class="content__desc">
                                    <div class="edit">
                                        @if (@$ticket->dept_id !== 0)
                                            <div style="color: maroon;"><b> {{ $ticket->dept->dept }} </b></div>
                                        @else
                                            <div style="color: maroon;"><b> {{ $ticket->department }} </b></div>
                                        @endif
                                    </div>

                                    <select class="txtedit col-md-3" id='department-{{ $ticket->id }}'>
                                        @foreach ($depts as $dept)
                                            <option value="{{ $dept->id }}"
                                                {{ $ticket->dept_id == $dept->id ? 'selected' : null }}>
                                                {{ $dept->dept }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-12">
                            <h6> {{ $ticket->description }} </h6>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    @if ($ticket->status == 'open')
                        <form method="POST" action="{{ url('support/close_ticket/' . $ticket->id) }}">
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
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="page-title m-0">Comments</h4>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="comment__container">
                    @if ($comments != '0')

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
                                            <div>
                                                <h3>
                                                    @if (@$comment->dept_id !== 0)
                                                        <div><b> {{ @$comment->dept->dept }} </b></div>
                                                    @elseif($comment->dept_id==0 && $comment->is_read_user==0)
                                                        <div><b> User </b></div>
                                                    @else
                                                        <div><b> {{ @$comment->authorised_type }} </b></div>
                                                    @endif

                                                </h3>
                                                <p class="mb-0 comment__desc text-muted">{{ $comment->comment }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <div class="m-4">
                        <form method="POST" action="{{ url('support/ticket_reply/' . $ticket->id) }}"
                            class="row">
                            {{ csrf_field() }}
                            <div class="col-md-10">

                                <input type="text" name="cs_comment" id="cs_comment" class="form-control"
                                    placeholder="Add Your Comment ..." required>

                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary form-control"
                                    style="font-size:14px;">Post</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @else
        <hr>
        <p style="text-align: center;">No Ticket Available</p>
    @endif

@endsection

@section('scripts')

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

@endsection