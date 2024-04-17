@extends('dispatcher.layout.master')

@section('title', 'Dashboard ')

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/admin/vendor/jvectormap/jquery-jvectormap-2.0.3.css') }}">
@endsection



@section('content')


    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Dashboard</h4>
                    </div>
                    <div class="col-md-4">
                        <div class="float-right">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Pending Receive</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $pending->count() }}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-info"></span><span class="ml-2">
                        </span>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Complete Received :</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $complete_received->count() }}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-info"></span><span class="ml-2">
                        </span>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-pink mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Incomplete Received :</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $incomplete_received->count() }}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-info"></span><span class="ml-2">
                        </span>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Dispatched :</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $dispatch->count() }}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-info"></span><span class="ml-2">
                        </span>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Complete Reached : </h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $complete_reached->count() }}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-info"></span><span class="ml-2">
                        </span>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Incomplete Reached :</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $incomplete_reached->count() }}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-info"></span><span class="ml-2">
                        </span>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Total Rider :</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $rider }}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-info"></span><span class="ml-2">
                        </span>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-pink mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Total Draft :</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $draft->count() }}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-info"></span><span class="ml-2">
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
                    <h6>Pending Receive</h6>
                    <hr>
                    @if (count($pending) != 0)
                        <table id="datatable" class="table table-bordered"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>ID</th>
                                    <th>Dispatch On</th>
                                    <th>From (Zone)</th>
                                    <th>Remarks</th>
                                    <th>Bill Image</th>
                                    <th>Bulk Receive</th>
                                    <th>No of Orders</th>

                                </tr>
                            </thead>
                            <tbody>
                                <script>
                                    var req_id = [];
                                </script>
                                @foreach ($pending as $index => $row)
                                    <tr id="dataRow{{ $index }}">
                                        <td>
                                            @if (@$row->created_at)
                                                <span
                                                    class="text-muted">{{ @$row->created_at->format('Y-m-d') }}</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ @$row->id }}</td>
                                        <td>
                                            @if (@$row->updated_at)
                                                <span
                                                    class="text-muted">{{ @$row->updated_at->diffForHumans() }}</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if (@$row->zone1->name)
                                                <span>{{ @$row->zone1->name }}</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if (@$row->remarks)
                                                <span>{{ @$row->remarks }}</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if (@$row->file_path)
                                                <img src="{{ asset('storage/app/public/dispatch/' . @$row->file_path) }}"
                                                    width="80px" height="80px" id="image-{{ @$row->id }}">
                                                <div id="myModal-{{ @$row->id }}" class="modal">

                                                    <!-- The Close Button -->
                                                    <span class="close-{{ @$row->id }}">&times;</span>

                                                    <!-- Modal Content (The Image) -->
                                                    <img class="modal-content" id="img-{{ @$row->id }}">

                                                </div>
                                                <style>
                                                    /* Style the Image Used to Trigger the Modal */
                                                    #image-{{ $row->id }} {
                                                        border-radius: 5px;
                                                        cursor: pointer;
                                                        transition: 0.3s;
                                                    }

                                                    #image-{{ $row->id }}:hover {
                                                        opacity: 0.7;
                                                    }

                                                    /* The Modal (background) */
                                                    .modal {
                                                        display: none;
                                                        /* Hidden by default */
                                                        position: fixed;
                                                        /* Stay in place */
                                                        z-index: 10000;
                                                        /* Sit on top */
                                                        padding-top: 100px;
                                                        /* Location of the box */
                                                        left: 0;
                                                        top: 0;
                                                        width: 100%;
                                                        /* Full width */
                                                        height: 100%;
                                                        /* Full height */
                                                        overflow: auto;
                                                        /* Enable scroll if needed */
                                                        background-color: rgb(0, 0, 0);
                                                        /* Fallback color */
                                                        background-color: rgba(0, 0, 0, 0.9);
                                                        /* Black w/ opacity */
                                                    }

                                                    /* Modal Content (Image) */
                                                    .modal-content {
                                                        margin: auto;
                                                        display: block;
                                                        width: 80%;
                                                        max-width: 700px;
                                                    }

                                                    /* Caption of Modal Image (Image Text) - Same Width as the Image */
                                                    #caption {
                                                        margin: auto;
                                                        display: block;
                                                        width: 80%;
                                                        max-width: 700px;
                                                        text-align: center;
                                                        color: #ccc;
                                                        padding: 10px 0;
                                                        height: 150px;
                                                    }

                                                    /* Add Animation - Zoom in the Modal */
                                                    .modal-content,
                                                    #caption {
                                                        animation-name: zoom;
                                                        animation-duration: 0.6s;
                                                    }

                                                    @keyframes zoom {
                                                        from {
                                                            transform: scale(0)
                                                        }

                                                        to {
                                                            transform: scale(1)
                                                        }
                                                    }

                                                    /* The Close Button */
                                                    .close-{{ $row->id }} {
                                                        position: absolute;
                                                        top: 15px;
                                                        right: 35px;
                                                        color: #f1f1f1;
                                                        font-size: 40px;
                                                        font-weight: bold;
                                                        transition: 0.3s;
                                                    }

                                                    .close-{{ $row->id }}:hover,
                                                    .close-{{ $row->id }}:focus {
                                                        color: #bbb;
                                                        text-decoration: none;
                                                        cursor: pointer;
                                                    }

                                                    /* 100% Image Width on Smaller Screens */
                                                    @media only screen and (max-width: 700px) {
                                                        .modal-content {
                                                            width: 100%;
                                                        }
                                                    }

                                                </style>
                                                <script>
                                                    // Get the modal
                                                    var modal = document.getElementById("myModal-{{ $row->id }}");

                                                    // Get the image and insert it inside the modal - use its "alt" text as a caption
                                                    var img = document.getElementById("image-{{ $row->id }}");
                                                    var modalImg = document.getElementById("img-{{ $row->id }}");
                                                    img.onclick = function() {
                                                        modal.style.display = "block";
                                                        modalImg.src = this.src;
                                                    }

                                                    // Get the <span> element that closes the modal
                                                    var span = document.getElementsByClassName("close-{{ $row->id }}")[0];

                                                    // When the user clicks on <span> (x), close the modal
                                                    span.onclick = function() {
                                                        modal.style.display = "none";
                                                    }
                                                </script>
                                            @else
                                                -
                                            @endif

                                        </td>
                                        <td>
                                            {{-- <input type="checkbox" class="received" id="received-{{@$row->id}}"> --}}
                                            <a class="received btn btn-info" style="color: #fff;"
                                                name="received-{{ $row->id }}"> <i class="fa fa-arrow-down"></i>
                                                Receive</a>
                                            <span style="color: orange; display:none;" class="checkreceived"><i
                                                    class="fa fa-check"></i></span>
                                        </td>
                                        <td>
                                            @if (@$row->lists_count)
                                                <span>{{ @$row->lists_count }}</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <h6 class="no-result">No results found</h6>
                    @endif
                </div>
            </div>
        </div>
    </div>






@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        $(document).ready(function() {
            $(".received").change(function() {
                var id = this.id;
                var split_id = id.split("-");
                var field_name = split_id[0];
                var edit_id = split_id[1];
                var value = false;
                if (this.checked) {
                    value = true;
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('dispatcher/dispatchList/pendingReceive') }}/" + edit_id,
                    type: 'post',
                    data: field_name + "=" + value,
                    success: function(response) {
                        if (response.showError) {

                        }
                        console.log(response);
                    },
                    error: function(request, error) {
                        console.log(request);
                        alert(" Can't do!! Error" + error);
                    }
                });
            });
        });
    </script>
    @include('user.layout.partials.datatable')
@endsection

@section('styles')
    <style type="text/css">
        .dispatcher-nav li span {
            /* // background-color: transparent; */
            color: #000 !important;
            padding: 5px 12px;
        }

        .dispatcher-nav li span:hover,
        .dispatcher-nav li span:focus,
        .dispatcher-nav li span:active {
            background-color: #20b9ae;
            color: #fff !important;
            padding: 5px 12px;
        }

        .dispatcher-nav li.active span,
        .dispatcher-nav li span:hover,
        .dispatcher-nav li span:focus,
        .dispatcher-nav li span:active {
            background-color: #20b9ae;
            color: #fff !important;
            padding: 5px 12px;
        }

    </style>
@endsection
