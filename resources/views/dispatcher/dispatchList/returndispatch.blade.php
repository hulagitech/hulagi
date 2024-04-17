@extends('dispatcher.layout.master')



@section('title', 'Recent Trips ')



@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h5 class="mb-1"> <i class="fa fa-truck"></i> Return Dispatched </h5>
                </div>
                <div class="col-md-8 d-flex justify-content-end">
                   
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="container-fluid">
        <div class="card m-b-30">
            <div class="card-body table-responsive">
                   
                    @if(count($requests) != 0)
                    <table id="datatable-buttons" class="table table-bordered"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>ID</th>
                                <th>Last Update</th>
                                <th>Remarks</th>
                                <th>Bill Image</th>
                                <th>Dispatch</th>
                                <th>Number of Orders</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <script>
                                var req_id = [];

                            </script>
                            @foreach($requests as $index => $request)
                            <tr id="dataRow{{$index}}">
                                <td>
                                    @if(@$request->created_at)
                                    <span class="text-muted">{{@$request->created_at}}</span>
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>{{@$request->zone2->name}}#{{@$request->id}}</td>
                                <td>
                                    @if(@$request->updated_at)
                                    <span class="text-muted">{{@$request->updated_at}}</span>
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>
                                    <input type="text" placeholder="Dispatch Remarks" value="{{@$request->remarks}}" class="form-control" id="remarks-{{@$request->id}}">
                                </td>
                                <td>
                                    <input class="form-control" type="file" name="file" id="file-{{@$request->id}}">
                                    @if(@$request->file_path)
                                    <img src="{{asset('storage/app/public/dispatch/'.@$request->file_path)}}" width="80px" height="80px" id="image-{{@$request->id}}">
                                    <div id="myModal-{{@$request->id}}" class="modal">

                                        <!-- The Close Button -->
                                        <span class="close-{{@$request->id}}">&times;</span>

                                        <!-- Modal Content (The Image) -->
                                        <img class="modal-content" id="img-{{@$request->id}}">

                                    </div>
                                    <style>
                                        /* Style the Image Used to Trigger the Modal */
                                        #image- {
                                                {
                                                $request->id
                                            }
                                        }

                                            {
                                            border-radius: 5px;
                                            cursor: pointer;
                                            transition: 0.3s;
                                        }

                                        #image- {
                                                {
                                                $request->id
                                            }
                                        }

                                        :hover {
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
                                        .close- {
                                                {
                                                $request->id
                                            }
                                        }

                                            {
                                            position: absolute;
                                            top: 15px;
                                            right: 35px;
                                            color: #f1f1f1;
                                            font-size: 40px;
                                            font-weight: bold;
                                            transition: 0.3s;
                                        }

                                        .close- {
                                                {
                                                $request->id
                                            }
                                        }

                                        :hover,
                                        .close- {
                                                {
                                                $request->id
                                            }
                                        }

                                        :focus {
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
                                        var modal = document.getElementById("myModal-{{$request->id}}");

                                        // Get the image and insert it inside the modal - use its "alt" text as a caption
                                        var img = document.getElementById("image-{{$request->id}}");
                                        var modalImg = document.getElementById("img-{{$request->id}}");
                                        img.onclick = function() {
                                            modal.style.display = "block";
                                            modalImg.src = this.src;
                                        }

                                        // Get the <span> element that closes the modal
                                        var span = document.getElementsByClassName("close-{{$request->id}}")[0];

                                        // When the user clicks on <span> (x), close the modal
                                        span.onclick = function() {
                                            modal.style.display = "none";
                                        }

                                    </script>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-primary dispatch" value={{@$request->id}}>Update</button>
                                </td>
                                <td>
                                    {{@$request->lists_count}}
                                </td>
                                <td>
                                    {{-- <a href="{{ route('dispatcher.dispatchList.showDispatch', $request->id) }}" class="btn btn-primary">
                                    <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('dispatcher.dispatchList.showDispatch', $request->id) }}" class="btn btn-warning">
                                        <i class="fa fa-pencil"></i>
                                    </a> --}}
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-secondary btn-rounded btn-black waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            Action
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="{{ route('dispatcher.dispatchList.showDispatch', @$request->id) }}" class="dropdown-item">
                                                <i class="fa fa-search"></i> More Details
                                            </a>
                                            {{-- <a href="{{ route('dispatcher.dispatchList.showDispatch', @$request->id) }}" class="dropdown-item">
                                                <i class="fa fa-search"></i> Means of transport
                                            </a> --}}

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Date</th>
                                <th>ID</th>
                                <th>Last Update</th>
                                <th>Remarks</th>
                                <th>Bill Image</th>
                                <th>Dispatch</th>
                                <th>Number of Orders</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
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
