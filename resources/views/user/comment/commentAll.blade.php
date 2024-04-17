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
                    
                        <h4 class="page-title m-0">All Comments</h4>


                </div>

            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
                    @if ($comments->count() > 0)
                        <table id="datatable" class="table table-bordered"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <th>S.N</th>
                                <th>Date</th>
                                <th>Booking ID</th>
                                <th>Reciver Name</th>
                                <th>Reciver Phone</th>
                                <th>Reciver Address</th>
                                <th>Status</th>
                                <th>COD</th>
                                <th>comment status</th>

                                <th>Details</th>
                            </thead>
                            <tbody>
                                @foreach ($comments as $ticket)
                                    <?php $i = 0; ?>
                                    <tr data-toggle="collapse" data-target="#ticket_{{ $ticket->id }}"
                                        class="accordion-toggle collapsed">

                                        <td> {{ $loop->iteration }} </td>
                                        <td> {{ $ticket->updated_at->format('Y-m-d') }} </td>

                                        <td>{{ $ticket->booking_id }}</td>
                                        <td>{{ $ticket->item->rec_name }}</td>
                                        <td>{{ $ticket->item->rec_mobile }}</td>
                                        <td>{{ $ticket->d_address }}</td>
                                        <td>{{ $ticket->status }}</td>
                                        <td>{{ $ticket->cod }}</td>



                                        @if ($ticket->comment_status == 1)
                                            <td style="color:green;"> Open </td>
                                        @else
                                            <td style="color:red;"> Close </td>
                                        @endif
                                        <td>
                                            <form action="{{ url('/mytrips/detail') }}">

                                                <input type="hidden" value="{{ $ticket->id }}" name="request_id">

                                                <button type="submit" style="margin-top: 0px;"
                                                    class="btn btn-dark">Detail</button>
                                            </form>

                                        </td>

                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <hr>
                        <p style="text-align: center;">No Comment Available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center">
    {{$comments->links()}}

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
