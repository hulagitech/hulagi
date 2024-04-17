@extends('user.layout.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('main/vendor/jvectormap/jquery-jvectormap-2.0.3.css') }}">
    <link href="{{ asset('asset/user/plugins/bootstrap-rating/bootstrap-rating.css') }}" rel="stylesheet" type="text/css">

    <style>
        .content__card {
            border: 1px solid #000;
            margin-top: 2rem;
        }

        .content__heading {
            text-transform: uppercase;
        }

        .track {
            position: relative;
            background-color: #ddd;
            height: 7px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            margin-bottom: 75px;
            margin-top: 50px
        }

        .track .step {
            -webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
            width: 25%;
            margin-top: -18px;
            text-align: center;
            position: relative
        }

        .track .step.active:before {
            background: #FF5722
        }

        .track .step::before {
            height: 7px;
            position: absolute;
            content: "";
            width: 100%;
            left: 0;
            top: 18px
        }

        .track .step.active .icon {
            background: #ee5435;
            color: #fff
        }

        .track .icon {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            position: relative;
            border-radius: 100%;
            background: #ddd
        }

        .track .step.active .text {
            font-weight: 400;
            color: #000
        }

        .track .text {
            display: block;
            margin-top: 7px
        }

        .card__comment .comment-date {
            font-size: 0.825rem !important;
        }

        .card__comment .comment__desc {
            text-transform: capitalize;

        }

        .card__comment__header {
            text-transform: uppercase;
            text-align: center;
        }

        .card__comment__form {
            display: flex;
        }

        .card__comment__form input {
            border-radius: 0;
        }

        .card__comment__form .btn {
            border-radius: 0;
            text-transform: uppercase;
            padding: 0.5rem 2rem;
            border: 1px solid white;
            background: #000;
            color: #fff;

            transition: all 0.5s ease-in-out;
        }

        .card__comment__form .btn:hover {
            background: #000;
            color: #fff;
            background: #fff;
            color: #000;
        }


        .cd-timeline-content {
            border: 1px solid lightgrey;
        }

    </style>
@endsection

@section('content')


    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Order Detail</h4>
                    </div>
                     @if ($trip->status == 'COMPLETED')
                        <div class="col-md-4">
                            <div class="float-right">
                                <div class="btn btn-primary" type="button" id="exchangeOrder">
                                    <i class="ti-plus mr-1"></i> Exchange Order
                                </div>

                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class='d-flex justify-content-between'>
                <h6>Booking ID: <span class='lead'> {{ $trip->booking_id }}</span></h6>
                <h6>{{ $trip->created_at->diffForHumans() }}</h6>
            </div>
            <article class="card content__card">

                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-4">
                            <h6 class="content__heading">Receiver Name:</h6>
                            @if ($trip->item->rec_name)
                                <div class="content__desc">{{ $trip->item->rec_name }}
                                </div>
                            @else
                                -
                            @endif
                        </div>
                        <div class="col-md-4">
                            <h6 class="content__heading">Receiver Location:</h6>
                            <div class="content__desc">
                                {{ $trip->d_address }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h6 class="content__heading">Receiver Number:</h6>
                            <div class="content__desc">
                                {{ $trip->item['rec_mobile'] }}
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-4">
                            <h6 class="content__heading">COD Amount</h6>
                            <div class="content__desc">

                                @if ($trip->cod)

                                    {{ currency($trip->cod) }}
                                @else
                                    -
                                @endif
                            </div>


                        </div>
                        <div class="col-md-4">
                            <h6 class="content__heading">Fare</h6>
                            <div class="content__desc">
                                @if ($trip->amount_customer)

                                    {{ currency($trip->amount_customer) }}
                                @else
                                    -
                                @endif
                            </div>


                        </div>
                        <div class="col-md-4">
                            <h6 class="content__heading">Status:</h6>
                            <div class="content_desc">
                                {{ $trip->returned == 1 ? 'RETURNED' : $trip->status }}
                            </div>
                        </div>
                    </div>
                    <hr>

                </div>
                @if (($trip->status == 'ASSIGNED' || $trip->status == 'DELIVERING' || $trip->status == 'SCHEDULED') && $trip->provider)
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <h6 class="content__heading">Rider Name</h6>
                            <div class="content__desc">
                                {{ $trip->provider->first_name ? $trip->provider->first_name : '' }}
                            </div>


                        </div>
                        <div class="col-md-4">
                            <h6 class="content__heading">Rider Number</h6>
                            <div class="content__desc">
                                {{ $trip->provider->mobile ? $trip->provider->mobile : '' }}
                            </div>


                        </div>
                    </div>
                @endif

            </article>

            <div class="track">
                <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span
                        class="text">Order
                        confirmed</span> </div>
                <div class="step" id='second'>
                    <span class="icon"> <i class="fa fa-user"></i> </span> <span class="text">
                        Picked up
                        by hulagi</span>
                </div>
                <div class="step " id='third'>
                    <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text"> On
                        the
                        way
                    </span>
                </div>
                <div class="step" id='fourth'>
                    <span class="icon"> <i class="fa fa-box"></i> </span> <span
                        class="text">Delivery Completed</span>
                </div>
                @if (($trip->status == 'REJECTED' || $trip->status == 'CANCELLED') && $trip->returned_to_hub == 0)
                    <div class="step" id="fifth">
                        <span class="icon"> <i class="fa fa-box"></i> </span> <span
                            class="text">Returned to vendor</span>
                    </div>
                @endif
            </div>
            @if ($trip->status == 'COMPLETED' || $trip->status == 'REJECTED' || $trip->status == 'CANCELLED')
                @if (isset($trip->provider))
                    <article class="card content__card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="content__heading">Rider Name:</h6>
                                    <div class="content__desc">
                                        {{ $trip->provider->first_name }}
                                    </div>
                                </div>
                                @if (!isset($rating_comments))
                                    <div class="col-md-8">
                                        <form
                                            action="{{ route('trips_provider_rating', [$trip->provider->id, $trip->id]) }}"
                                            method='POST' class='row'>
                                            {{ csrf_field() }}
                                            <div class="col-md-6">
                                                <h5 class="font-16">Rate the rider</h5>
                                                <input type="hidden" class="rating "
                                                    data-filled="mdi mdi-star font-32 text-primary"
                                                    data-empty="mdi mdi-star-outline font-32 text-primary" name='rating' />
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name='comment'
                                                    placeholder="Review Rider">
                                                <input type="submit" value="Save"
                                                    class="btn btn-outline-dark mt-2 float-right">
                                            </div>
                                        </form>
                                    </div>
                                @else
                                    <div class="col-md-8 row">

                                        <div class="col-md-6">
                                            <h5 class="font-16">Rating</h5>
                                            <input type="hidden" class="rating "
                                                data-filled="mdi mdi-star font-32 text-primary"
                                                data-empty="mdi mdi-star-outline font-32 text-primary" name='rating'
                                                data-readonly value="{{ $rating_comments->rating }}" />
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="content__heading">Rating review:</h6>

                                            <p>{{ $rating_comments->comment }}</p>
                                        </div>
                                    </div>

                                @endif
                            </div>
                        </div>
                    </article>
                @endif
            @endif
        </div>

        <div class="card card__comment">
            <div class="card-header">
                {{-- <h5 class="card__comment__header">View your comments here</h5> --}}

                {{-- <form method="POST" action="{{ url('comment/' . $trip->id) }}" class='card__comment__form'>
                {{ csrf_field() }}

                <input class="form-control mr-2" type="text" name="user_comment" id="user_comment"
                    placeholder="Add Your Comment ...">
                <button type="submit" class="btn">Post</button>
            </form> --}}

            </div>


            <div class="card-body pt-0 pr-0 pb-0">

                <div class="row">
                    <div class="col-md-6 pl-0 d-none d-sm-block">
                        <?php
                        
                        $smap_icon = asset('asset/front/img/source.png');
                        $dmap_icon = asset('asset/front/img/destination.png');
                        
                        $static_map = 'https://maps.googleapis.com/maps/api/staticmap?autoscale=1&size=600x450&maptype=terrain&format=png&visual_refresh=true&markers=icon:' . $smap_icon . '%7C' . $trip->s_latitude . ',' . $trip->s_longitude . '&markers=icon:' . $dmap_icon . '%7C' . $trip->d_latitude . ',' . $trip->d_longitude . '&path=color:0x191919|weight:8|enc:' . $trip->route_key . '&key=' . env('GOOGLE_MAP_KEY'); ?>

                        <img src="{{ $static_map }}" class='img-fluid'>
                    </div>
                    <div class="col-md-6 ">

                        <div class="comment__container">
                            <h5 class="py-4">Comments</h5>
                            @if ($trip->special_note)
                                <div class="cd-timeline-block m-5">
                                    <div class="cd-timeline-content p-3 w-100">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="text-center">
                                                    <div>
                                                        <i class="mdi mdi-account h2"></i>
                                                    </div>
                                                    <div class="cd-date comment-date mb-4">
                                                        {{ $trip->created_at->diffForHumans() }}</div>

                                                </div>
                                            </div>
                                            <div class="col-lg-9">
                                                <div>
                                                    <h3>

                                                        {{ Auth::user()->first_name }}


                                                    </h3>
                                                    <p class="mb-0 comment__desc text-muted">
                                                        {{ $trip->special_note ? $trip->special_note : '' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
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
                                                            @if (@$comment->dept->dept == 'Dispatcher')
                                                                <div><b> Branch - {{ @$comment->zone }} </b></div>
                                                            @else
                                                                <div><b> {{ @$comment->dept->dept }} </b></div>
                                                            @endif
                                                        @elseif($comment->dept_id==0 && $comment->is_read_user==0)
                                                            <div><b> User </b></div>
                                                        @else
                                                            <div><b> {{ @$comment->authorised_type }} </b></div>
                                                        @endif

                                                        <!-- @if ($comment->dept_id == 0 && $comment->is_read_user == 0)
                                                                        {{ Auth::user()->first_name }}
                                                        @elseif(@$comment->dept_id == 0)
                                                                        @if (@$comment->dept->dept == 'Dispatcher')
                                                                            Branch -
                                                                            {{ @$comment->zone }}

                                                            @else
                                                                            {{ @$comment->dept->dept }}

                                                                        @endif
                                                        @else
                                                                        {{ @$comment->authorised_type }}
                                                                    @endif

                                                                    {{-- @if (@$comment->dept_id == 0)
                                                    @if (@$comment->dept->dept == 'Dispatcher')
                                                        Branch -
                                                        {{ @$comment->zone }}

                                                    @else
                                                        {{ @$comment->dept->dept }}

                                                    @endif
                                                @elseif($comment->dept_id==0 &&
                                                    $comment->is_read_user==0)
                                                    {{ Auth::user()->first_name }}
                                                @else
                                                    {{ @$comment->authorised_type }}

                                                @endif --}} -->

                                                    </h3>
                                                    <p class="mb-0 comment__desc text-muted">{{ $comment->comments }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="m-4">
                                <form method="POST" action="{{ url('comment/' . $trip->id) }}" class='d-flex'>
                                    {{ csrf_field() }}

                                    <input class='form-control' name="user_comment" id="user_comment"
                                        placeholder="Add Your Comment ..." required>

                                    <button type="submit" class="btn btn-outline-dark mx-4 text-uppercase">Post</button>

                                </form>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>






@endsection
@section('scripts')
    <script src="{{ asset('asset/user/plugins/bootstrap-rating/bootstrap-rating.min.js') }}"></script>
    <script>
        $(function() {
            // $('input.check').on('change', function() {
            //     alert('Rating: ' + $(this).val());
            // });
            // $('.rating-tooltip').rating({
            //     extendSymbol: function(rate) {
            //         $(this).tooltip({
            //             container: 'body',
            //             placement: 'bottom',
            //             title: 'Rate ' + rate
            //         });
            //     }
            // });
            // $('.rating-tooltip-manual').rating({
            //     extendSymbol: function() {
            //         var title;
            //         $(this).tooltip({
            //             container: 'body',
            //             placement: 'bottom',
            //             trigger: 'manual',
            //             title: function() {
            //                 return title;
            //             }
            //         });
            //         $(this).on('rating.rateenter', function(e, rate) {
            //                 title = rate;
            //                 $(this).tooltip('show');
            //             })
            //             .on('rating.rateleave', function() {
            //                 $(this).tooltip('hide');
            //             });
            //     }
            // });
            $('.rating').each(function() {
                $('<span class="badge badge-info"></span>')
                    .text($(this).val() || '')
                    .insertAfter(this);
            });
            $('.rating').on('change', function() {
                $(this).next('.badge').text($(this).val());
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            const trip = <?php echo json_encode($trip->status); ?>;
            const returned = <?php echo $trip->returned; ?>;

            if (trip === 'PICKEDUP' || trip === 'SORTCENTER') {
                $('#second').addClass('active');
                // console.log(trip);
            } else if (returned === 1) {
                $('#second').addClass('active');
                $('#third').addClass('active');
                $('#fourth').addClass('active');
                $('#fifth').addClass('active');
            } else if (trip === 'COMPLETED' || trip === 'REJECTED' || trip === 'CANCELLED') {
                $('#second').addClass('active');
                $('#third').addClass('active');
                $('#fourth').addClass('active');
            } else if (trip === 'ASSIGNED' || trip === 'DELIVERING' || trip === 'SCHEDULED' || trip ===
                'DISPATCHED') {
                $('#second').addClass('active');
                $('#third').addClass('active');
            }
        });
    </script>
    <script>
        $("#exchangeOrder").click(function() {
            console.log("exchange clicked");

        });
    </script>

@endsection
