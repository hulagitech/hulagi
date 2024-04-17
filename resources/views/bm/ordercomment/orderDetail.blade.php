@extends('bm.layout.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('main/vendor/jvectormap/jquery-jvectormap-2.0.3.css') }}">
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

                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class='d-flex justify-content-between'>
                <h6>Booking ID: <span class='lead'> {{ $user_req->booking_id }}</span></h6>
                <h6>{{ $user_req->created_at->diffForHumans() }}</h6>
            </div>
            <article class="card content__card">

                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-4">
                            <h6 class="content__heading">Receiver Name:</h6>
                            @if ($user_req->item->rec_name)
                                <div class="content__desc">{{ $user_req->item->rec_name }}
                                </div>
                            @else
                                -
                            @endif
                        </div>
                        <div class="col-md-4">
                            <h6 class="content__heading">Receiver Location:</h6>
                            <div class="content__desc">
                                {{ $user_req->d_address }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h6 class="content__heading">Receiver Number:</h6>
                            <div class="content__desc">
                                {{ $user_req->item['rec_mobile'] }}
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-4">
                            <h6 class="content__heading">COD Amount</h6>
                            <div class="content__desc">

                                @if ($user_req->cod)

                                    {{ currency($user_req->cod) }}
                                @else
                                    -
                                @endif
                            </div>


                        </div>
                        <div class="col-md-4">
                            <h6 class="content__heading">Fare</h6>
                            <div class="content__desc">
                                @if ($user_req->amount_customer)

                                    {{ currency($user_req->amount_customer) }}
                                @else
                                    -
                                @endif
                            </div>


                        </div>
                        <div class="col-md-4">
                            <h6 class="content__heading">Status:</h6>
                            <div class="content_desc">
                                {{ $user_req->returned == 1 ? 'RETURNED' : $user_req->status }}
                            </div>
                        </div>
                    </div>
                    <hr>

                </div>
                @if (($user_req->status == 'ASSIGNED' || $user_req->status == 'DELIVERING' || $user_req->status == 'SCHEDULED') && $user_req->provider)
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <h6 class="content__heading">Rider Name</h6>
                            <div class="content__desc">
                                {{ $user_req->provider->first_name ? $user_req->provider->first_name : '' }}
                            </div>


                        </div>
                        <div class="col-md-4">
                            <h6 class="content__heading">Rider Number</h6>
                            <div class="content__desc">
                                {{ $user_req->provider->mobile ? $user_req->provider->mobile : '' }}
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
                        by Hulagi</span>
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
                @if (($user_req->status == 'REJECTED' || $user_req->status == 'CANCELLED') && $user_req->returned_to_hub == 0)
                    <div class="step" id="fifth">
                        <span class="icon"> <i class="fa fa-box"></i> </span> <span
                            class="text">Returned to vendor</span>
                    </div>
                @endif
            </div>

        </div>




        <div class="card card__comment">
            <div class="card-header">
                {{-- <h5 class="card__comment__header">View your comments here</h5> --}}

                {{-- <form method="POST" action="{{ url('comment/' . $user_req->id) }}" class='card__comment__form'>
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
                        
                        $static_map = 'https://maps.googleapis.com/maps/api/staticmap?autoscale=1&size=600x450&maptype=terrain&format=png&visual_refresh=true&markers=icon:' . $smap_icon . '%7C' . $user_req->s_latitude . ',' . $user_req->s_longitude . '&markers=icon:' . $dmap_icon . '%7C' . $user_req->d_latitude . ',' . $user_req->d_longitude . '&path=color:0x191919|weight:8|enc:' . $user_req->route_key . '&key=' . env('GOOGLE_MAP_KEY'); ?>

                        <img src="{{ $static_map }}" class='img-fluid'>
                    </div>
                    <div class="col-md-6 ">

                        <div class="comment__container">
                            <h5 class="py-4">Comments</h5>
                            @if ($user_req->special_note)
                                <div class="cd-timeline-block m-5">
                                    <div class="cd-timeline-content p-3 w-100">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="text-center">
                                                    <div>
                                                        <i class="mdi mdi-account h2"></i>
                                                    </div>
                                                    <div class="cd-date comment-date mb-4">
                                                        {{ $user_req->created_at }}</div>

                                                </div>
                                            </div>
                                            <div class="col-lg-9">
                                                <div>
                                                    <h3>

                                                        {{ Auth::user()->first_name }}


                                                    </h3>
                                                    <p class="mb-0 comment__desc text-muted">
                                                        {{ $user_req->special_note ? $user_req->special_note : '' }}</p>
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
                                                        {{ $comment->created_at }}</div>

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
                                <form method="POST" action="{{ url('bm/order_reply/' . $user_req->id) }}"
                                    class='d-flex'>
                                    {{ csrf_field() }}

                                    <input class='form-control' name="comment" id="comment"
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




    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <script>
    $(document).ready(function(){
 
        // Show Input element
        $('.edit').click(function(){
            $('.txtedit').hide();
            $(this).next('.txtedit').show().focus();
            $(this).hide();
        });

        // Save data
        $(".txtedit").focusout(function(){
        
            // Get edit id, field name and value
            var id = this.id;
            var split_id = id.split("-");
            var field_name = split_id[0];
            var edit_id = split_id[1];
            var value = $(this).val();

            //alert(edit_id+" ---> "+field_name+"="+value);
            
            if(field_name=="department" && !confirm("Are you sure, you want to change \""+$("option:selected", this).text()+"\" department?")){
                $(this).hide();
                $(this).prev('.edit').show();
                return;
            }
            // Hide Input element
            $(this).hide();

            // Hide and Change Text of the container with input elmeent
            $(this).prev('.edit').show();
            if($(this).is('select')){
                var val=$(this).find("option:selected").text();
                $(this).prev('.edit').text(val);    
            }
            else{
                $(this).prev('.edit').text(value);
            }

            // Sending AJAX request
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{url('return/edit_dept_order/')}}"+"/"+edit_id,
                type: 'post',
                data: field_name+"="+value,
                success:function(response){
                    console.log(response); 
                    if(response.showError){
                        alert(response.error);
                    }
                },
                error: function (request, error) {
                    console.log(request);
                    alert("Error! Please refresh page");
                }
            });
            
        });

    });
</script> --}}

@endsection
{{-- <div class="content-area py-1">
    <div class="container-fluid">
        <div class="accordian-body">
            <div class="col-md-12">
                <div style="background-color:#f5f5f5; padding:30px 20px 30px 20px;">
                    <div class="from-to row no-margin">
                        <table style="width:100%;">
                            <tr>
                                <th width="13%">
                                    <h4>Booking ID:</h4>
                                </th>
                                @if (@$user_req->booking_id)
                                    <td width="57%">
                                        <h4>{{ @$user_req->booking_id }}</h4>
                                    </td>
                                @else
                                    <td> -- </td>
                                @endif

                                <th width="13%"></th>
                                <td>
                                    <h4 style="background: #00FA9A; text-align:center; padding:5px;">
                                        {{ @$user_req->status }}</h4>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <h6>User Name:</h6>
                                </th>
                                @if (@$user_req->user->first_name)
                                    <td>
                                        <h6>{{ @$user_req->user->first_name }}</h6>
                                    </td>
                                @else
                                    <td> -- </td>
                                @endif

                                <th>
                                    <h6>COD:</h6>
                                </th>
                                @if (@$user_req->cod)
                                    <td>
                                        <h6>{{ @$user_req->cod }}</h6>
                                    </td>
                                @else
                                    <td> -- </td>
                                @endif
                            </tr>
                            <tr>
                                <th>
                                    <h6>Pick-Up Location:</h6>
                                </th>
                                @if (@$user_req->s_address)
                                    <td>
                                        <h6>{{ @$user_req->s_address }}</h6>
                                    </td>
                                @else
                                    <td> -- </td>
                                @endif

                                <th>
                                    <h6>Rider:</h6>
                                </th>
                                @if (@$user_req->provider->first_name)
                                    <td>
                                        <h6>{{ @$user_req->provider->first_name }}</h6>
                                    </td>
                                @else
                                    <td> -- </td>
                                @endif
                            </tr>
                            <tr>
                                <th>
                                    <h6>Drop-Up Location:</h6>
                                </th>
                                @if (@$user_req->s_address)
                                    <td>
                                        <h6>{{ @$user_req->s_address }}</h6>
                                    </td>
                                @else
                                    <td> -- </td>
                                @endif

                                <th>
                                    <h6>Rider Number:</h6>
                                </th>
                                @if (@$user_req->provider->mobile)
                                    <td>
                                        <h6>{{ @$user_req->provider->mobile }}</h6>
                                    </td>
                                @else
                                    <td> -- </td>
                                @endif
                            </tr>
                            <tr>
                                <th>
                                    <h6>Receiver Name:</h6>
                                </th>
                                @if (@$user_req->item->rec_name)
                                    <td>
                                        <h6>{{ @$user_req->item->rec_name }}</h6>
                                    </td>
                                @else
                                    <td> -- </td>
                                @endif

                                <th>
                                    <h6></h6>
                                </th>
                                <td>
                                    <h6></h6>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <h6>Receiver Number:</h6>
                                </th>
                                @if (@$user_req->item->rec_mobile)
                                    <td>
                                        <h6>{{ @$user_req->item->rec_mobile }}</h6>
                                    </td>
                                @else
                                    <td> -- </td>
                                @endif

                                <th>
                                    <h6></h6>
                                </th>
                                <td>
                                    @if ($user_req->comment_status == '0')
                                        <form method="POST" action="{{ url('bm/solved/' . $user_req->id) }}">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="status" id="status" value="1">
                                            <input type="hidden" name="filter" id="filter" value="1">
                                            <button type="submit"
                                                onclick="return confirm('Are you sure, Is it solve?');"
                                                class="btn btn-primary form-control">Solved</button>
                                        </form>
                                    @else
                                        <form method="POST"
                                            action="{{ url('bm/unsolve/' . $user_req->id) }}">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="status" id="status" value="0">
                                            <input type="hidden" name="filter" id="filter" value="1">
                                            <button type="submit"
                                                onclick="return confirm('Are you sure, you want to make unsolve?');"
                                                class="btn btn-primary form-control">Unsolve</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <h6> Department: </h6>
                                </th>
                                <td colspan="3">
                                    @if (@$user_req->dept_id !== 0)
                                        <div style="color: maroon;"><b> {{ @$user_req->dept->dept }} </b></div>
                                    @else
                                        <div style="color: maroon;"><b> Customer Service </b></div>
                                    @endif
                                <td>

                                    {{-- <td colspan="3">
                                    <div class="edit">
                                        @if (@$user_req->dept_id !== 0)
                                            <div style="color: maroon;"><b> {{@$user_req->dept->dept}} </b></div>
                                        @else
                                            <div style="color: maroon;"><b> Customer Service </b></div>
                                        @endif
                                    </div>

                                    <select class="txtedit col-md-3" id='department-{{$user_req->id}}'>
                                        @foreach ($depts as $dept)
                                            <option value="{{$dept->id}}" {{$user_req->dept_id==$dept->id?"selected":null}}> {{$dept->dept}} </option>
                                        @endforeach
                                    </select>
                                </td> --}}
{{-- </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="row">
                    <div class="col-lg-12" style="overflow-y:auto; margin-top:20px;"> <i
                            class="fa fa-comments"></i>
                        <b><i style="font-weight:bold; font-size:14px;">Comments:</i></b>
                    </div>

                    @if ($comments->count() > 0)
                        @foreach ($comments as $comment)
                            <div class="col-lg-12" style="margin:5px 0px;">
                                <div class="col-lg-12"
                                    style="background-color: #F5F5F5; padding:15px 15px 15px 17px;">
                                    <div style="display:flex; flex:1; justify-content:space-between;">

                                        @if (@$comment->dept_id !== 0)
                                            @if (@$comment->dept->dept == 'Dispatcher')
                                                <div><b> {{ @$comment->dept->dept }} - {{ @$comment->zone }} </b>
                                                </div>
                                            @else
                                                <div><b> {{ @$comment->dept->dept }} </b></div>
                                            @endif
                                        @elseif($comment->dept_id==0 && $comment->is_read_user==0)
                                            <div><b> User </b></div>
                                        @else
                                            <div><b> {{ @$comment->authorised_type }} </b></div>
                                        @endif
                                        @if ($comment->authorised_type == 'Sortcenter')
                                            <p>({{ $comment->sortcenter->name }})</p>
                                        @elseif($comment->authorised_type == 'Rider')
                                            <p>({{ $comment->rider->first_name }})</p>
                                        @elseif($comment->authorised_type == 'Return')
                                            <p>({{ $comment->return->name }})</p>
                                        @elseif($comment->authorised_type == 'admin')
                                            <p>({{ $comment->admin->name }})</p>
                                        @elseif($comment->authorised_type == 'Pickup')
                                            <p>({{ $comment->pickup->name }})</p>
                                        @elseif($comment->authorised_type == 'Support' || $comment->authorised_type
                                            == 'Customer Support' || $comment->authorised_type == 'cs' )
                                            <p>({{ @$comment->support->name }})</p>
                                        @elseif($comment->authorised_type == 'Dispatcher')
                                            <p>({{ $comment->bm->name }})</p>
                                        @elseif($comment->authorised_type == 'Branch Manager')
                                            <p>({{ $comment->branch->name }})</p>
                                        @endif --}}

{{-- @if (@$comment->authorised_type == 'cs')
                                            <div> <b>CS</b> </div>
                                        @elseif(@$comment->authorised_type=='user')
                                            <div> <b>User</b> </div>
                                        @elseif(@$comment->authorised_type=='admin')
                                            <div> <b>Admin</b> </div>
                                        @elseif(@$comment->authorised_type=='rider')
                                            <div> <b>Rider</b> </div>
                                        @endif --}}

{{-- <div> {{ @$comment->created_at->diffForHumans() }} </div>
                                    </div>
                                    <div style="padding-top:7px;">
                                        - {{ @$comment->comments }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else --}}
{{-- <hr> --}}
{{-- <p style="padding-left:20px; color: maroon;">No Comment Available</p>
                    @endif --}}

<!-- <div class="col-lg-12"> -->
{{-- <form method="POST" action="{{ url('bm/order_reply/' . $user_req->id) }}">
                        {{ csrf_field() }}
                        <div class="col-lg-10">
                            <input type="text" name="comment" id="comment" class="form-control"
                                placeholder="Add Your Comment ...">
                        </div>
                        <div class="col-lg-2">
                            <button type="submit" class="btn btn-primary form-control"
                                style="font-size:14px;">Post</button>
                        </div>
                    </form>

                </div>
            </div>


        </div>
    </div>
</div> --}}
