@extends('user.layout.master')
@section('styles')
    <link rel="stylesheet" href="{{ asset('main/vendor/jvectormap/jquery-jvectormap-2.0.3.css') }}">
@endsection
@section('content')
    <style>
        .txtedit {
            display: none;
            width: 99%;
            height: 30px;
        }

    </style>
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Tickets</h4>
                    </div>
                    <div class="col-md-4">
                        <div class="float-right">
                            <a href="{{ url('/ticket/create') }}" class="btn btn-primary" type="button">
                                <i class="ti-plus mr-1"></i> Add New Ticket
                            </a>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
                    @if ($tickets->count() > 0)
                        <table id="datatable" class="table table-bordered"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>Creation Date</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Details</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($tickets as $ticket)
                                    <?php $i = 0; ?>
                                    <tr data-toggle="collapse" data-target="#ticket_{{ $ticket->id }}"
                                        class="accordion-toggle collapsed">
                                        <!--td><span class="arrow-icon fa fa-chevron-right"></span></td-->
                                        <td> {{ $loop->iteration }} </td>
                                        <td> {{ $ticket->created_at->diffForHumans() }} </td>

                                        @if ($ticket->title)
                                            <td>{{ $ticket->title }}</td>
                                        @else
                                            <td>-</td>
                                        @endif

                                        @if ($ticket->description)
                                                        <td>{{$ticket->description}}</td>
                                                    @else
                                                        <td>-</td>
                                                    @endif

                                        @if ($ticket->status == 'open')
                                            <td style="color:green;"> Open </td>
                                        @else
                                            <td style="color:red;"> Close </td>
                                        @endif


                                        <td style="position:relative;">
                                            <a href="{{ url('ticket/comment/' . $ticket->id) }}"
                                                style="text-decoration:none;"><i class="ti-comment"></i></a>

                                            {{-- Count Comment Notification --}}
                                            @if ($ticket->noComment != '0')
                                                {{-- <span style="color:red; position:absolute; top:-1px;"> {{$trip->comment_no}} </span> --}}
                                                <span class="tag tag-danger"
                                                    style="position:absolute; top:-1px;">{{ $ticket->noComment }}</span>
                                            @else
                                                <span> </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <hr>
                        <p style="text-align: center;">No Ticket Available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

   

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
                    url: "{{ url('mytrips/') }}/" + edit_id,
                    type: 'post',
                    data: field_name + "=" + value,
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(request, error) {
                        console.log(request);
                        alert(" Can't do!! Error" + error);
                    }
                });
                // console.log($(this).html());

            });
        });
    </script>

@endsection
@section('scripts')

    @include('user.layout.partials.datatable')

@endsection
