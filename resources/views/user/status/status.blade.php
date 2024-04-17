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

        #weight {
            display: none;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

    </style>

    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">{{$status}} Order History</h4>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
                    @if ($trips->count() > 0)
                        <table id="datatable" class="table table-bordered"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>S.N</th>

                                    <th>@lang('user.date')</th>
                                    <th>@lang('user.booking_id')</th>
                                    <th>Location</th>
                                    <th>@lang('user.profile.name')</th>
                                    <th>Phone</th>
                                    <th>COD</th>
                                    <th>Fare</th>
                                    <th>Remarks</th>

                                    {{-- <th>Delivery Type</th> --}}

                                    {{-- <th>@lang('user.payment')</th> --}}

                                    <th>Status</th>

                                    <th>Rider Name</th>
                                    <th>Rider Phone</th>
                                    {{-- <th>Rider Remarks</th> --}}
                                    <th>Details</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trips as $index=>$trip)

                                    <tr data-toggle="collapse" data-target="#trip_{{ $trip->id }}"
                                        class="accordion-toggle collapsed">

                                        <!--td><span class="arrow-icon fa fa-chevron-right"></span></td-->

                                        <td>{{ $loop->iteration }}</td>
                                        @if ($trip->item)
                                            <td>{{ date('d-m-Y', strtotime($trip->item['created_at'])) }}</td>
                                        @else
                                            <td></td>
                                        @endif
                                        <td>{{ $trip->booking_id }}</td>

                                        @if ($trip->d_address)

                                            <td>{{ $trip->d_address }}</td>

                                        @else

                                            <td>-</td>

                                        @endif

                                        @if ($trip->status == 'PENDING' || $trip->status == 'ACCEPTED')
                                            @if ($trip->item)

                                                <td>
                                                    <div class='edit'>
                                                        {{ $trip->item->rec_name }}
                                                    </div>
                                                    <input type='text' class='txtedit'
                                                        value="{{ $trip->item['rec_name'] }}"
                                                        id='rec_name-{{ $trip->id }}'>
                                                </td>
                                            @else

                                                <td>
                                                    <div class='edit'>
                                                        -
                                                    </div>
                                                    <input type='text' class='txtedit' value=""
                                                        id='rec_name-{{ $trip->id }}'>
                                                </td>

                                            @endif

                                            @if ($trip->item)

                                                <td>
                                                    <div class='edit'>
                                                        {{ $trip->item['rec_mobile'] }}
                                                    </div>
                                                    <input type='text' class='txtedit'
                                                        value="{{ $trip->item['rec_mobile'] }}"
                                                        id='rec_mobile-{{ $trip->id }}'>
                                                </td>

                                            @else

                                                <td>
                                                    <div class='edit'>
                                                        -
                                                    </div>
                                                    <input type='text' class='txtedit' value=""
                                                        id='rec_mobile-{{ $trip->id }}'>
                                                </td>

                                            @endif

                                            @if ($trip->cod)

                                                <td>
                                                    <div class='edit'>
                                                        {{ $trip->cod }}
                                                    </div>
                                                    <input type='text' class='txtedit' value="{{ $trip->cod }}"
                                                        id='cod-{{ $trip->id }}'>
                                                </td>

                                            @else

                                                <td>
                                                    <div class='edit'>
                                                        -
                                                    </div>
                                                    <input type='text' class='txtedit' value=""
                                                        id='cod-{{ $trip->id }}'>
                                                </td>

                                            @endif
                                            @if ($trip->amount_customer)

                                                <td>{{ $trip->amount_customer }}</td>

                                            @else

                                                <td>-</td>

                                            @endif

                                            @if ($trip->special_note)

                                                <td>
                                                    <div class='edit'>
                                                        {{ $trip->special_note }}
                                                    </div>
                                                    <input type='text' class='txtedit' value="{{ $trip->special_note }}"
                                                        id='special_note-{{ $trip->id }}'>
                                                </td>

                                            @else

                                                <td>
                                                    <div class='edit'>
                                                        -
                                                    </div>
                                                    <input type='text' class='txtedit' value=""
                                                        id='special_note-{{ $trip->id }}'>
                                                </td>

                                            @endif
                                        @else
                                            @if ($trip->item)
                                                <td>{{ $trip->item['rec_name'] }}</td>
                                            @else

                                                <td>-</td>

                                            @endif

                                            @if ($trip->item)

                                                <td>{{ $trip->item['rec_mobile'] }}</td>

                                            @else

                                                <td>-</td>

                                            @endif
                                            @if ($trip->cod)

                                                <td>{{ currency($trip->cod) }}</td>

                                            @else

                                                <td>-</td>

                                            @endif

                                            @if ($trip->amount_customer)

                                                <td>{{ $trip->amount_customer }}</td>

                                            @else

                                                <td>-</td>

                                            @endif

                                            @if ($trip->special_note)

                                                <td>{{ $trip->special_note }}</td>

                                            @else

                                                <td>-</td>

                                            @endif
                                        @endif




                                        {{-- <td>@lang('user.paid_via') {{$trip->payment_mode}}</td> --}}
                                        <td>
                                            {{ $trip->status }}
                                            @if ($trip->status == 'REJECTED' || $trip->status == 'CANCELLED')
                                                @if ($trip->returned)
                                                    (R)
                                                @elseif($trip->returned_to_hub==1)
                                                    (Returned to head office)
                                                @else
                                                    (NR)
                                                @endif
                                            @endif
                                            @if($trip->dispatchList)
                                                @if($trip->status == 'SORTCENTER' && $trip->dispatchList->received==1 )
                                                   ( {{$trip->zone_2->zone_name}})
                                                @endif
                                                @if($trip->status == 'SORTCENTER' && $trip->dispatchList->received==0 )
                                                    ({{$trip->zone_1->zone_name}})
                                                @endif
                                            @endif
                                        </td>

                                        {{-- Rider Name and Rider Phone --}}
                                        @if ($trip->status != 'PENDING' && $trip->status != 'COMPLETED' && $trip->status != 'REJECTED' && $trip->status != 'CANCELLED' && $trip->provider)
                                            <td>{{ $trip->provider->first_name }}</td>
                                            <td>{{ $trip->provider->mobile }}</td>
                                        @else
                                            <td>N/A</td>
                                            <td>N/A</td>
                                        @endif

                                        {{-- Rider Remarks --}}
                                        {{-- @if (@$trip->log->complete_remarks)
                                            <td>{{ @$trip->log->complete_remarks }}</td>
                                        @else
                                            <td>{{ @$trip->log->pickup_remarks }}</td>
                                        @endif --}}
                                        {{-- <td>Remarks</td> --}}


                                        <td style="position:relative">
                                        <form class="inboundAndPrint form-inline" target="_blank" method="POST"
                                                action="{{url('printInvoice/'.$trip->id)}}">
                                                
                                                <button type="submit" class="btn btn-primary">Print</button>
                                                {{csrf_field()}}
                                            </form>
                                                            <form action="{{ url('/mytrips/detail') }}">

                                                <input type="hidden" value="{{ $trip->id }}" name="request_id">

                                                <button type="submit" style="margin-top: 0px;"
                                                    class="btn btn-dark">Detail</button>

                                                {{-- Count Comment Notification --}}
                                                @if ($trip->comment_no != '0')
                                                    {{-- <span style="color:red; position:absolute; top:-1px;"> {{$trip->comment_no}} </span> --}}
                                                    <span class="tag tag-danger"
                                                        style="position:absolute; top:-1px;">{{ $trip->comment_no }}</span>
                                                @else
                                                    <span> </span>
                                                @endif
                                            </form>
                                        </td>
                                    </tr>

                                @endforeach

                            </tbody>
                  
                        </table>
                        <div style="display: flex;justify-content: center;"> 
                {{$trips->links('vendor.pagination.bootstrap-4') }}
            </div>

                    @else
                        <hr>

                        <p style="text-align: center;">No Orders Available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

@endsection

@section('scripts')
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


    @include('user.layout.partials.datatable')
@endsection
