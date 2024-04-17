@extends('admin.layout.base')

@section('title', 'Order History')

@section('content')
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <h5 class="mb-1"> <i class="fa fa-recycle"></i> Order History</h5>
            <hr/>

            @if(isset($dates))
                <form class="form-inline pull-right" method="POST" action={{url('admin/dateSearch')}}>
                    {{csrf_field()}}
                    <div class="form-group">
                        <input type="text" class="form-control" name="searchField" placeholder="Full Search">
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="date">
                            <option>All</option>
                        @foreach ($dates as $date)
                            <option {{(isset($current) && $current['date']==$date)? "selected": ""}} value={{$date}}>{{$date}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="status">
                            <option {{(isset($current) && $current['status']=="All")? "selected": ""}}>All</option>
                            <option {{(isset($current) && $current['status']=="PENDING")? "selected": ""}}>PENDING</option>
                            <option {{(isset($current) && $current['status']=="SCHEDULED")? "selected": ""}}>SCHEDULED</option>
                            <option {{(isset($current) && $current['status']=="COMPLETED")? "selected": ""}}>COMPLETED</option>
                            <option {{(isset($current) && $current['status']=="REJECTED")? "selected": ""}}>REJECTED</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button name="search" class="btn btn-success">Search</button>
                    </div>
                </form>
            @endif

            @if(count($requests) != 0)
            <table class="table table-striped table-bordered dataTable" id="table-2" style="width:100%;">
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
               <script> var req_id=[];</script>
                @foreach($requests as $index => $request)
                    <tr id="dataRow{{$index}}">
                        <td>
                            @if($request->created_at)
                                <span class="text-muted">{{$request->created_at}}</span>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{$request->id}}</td>
                        <td>
                            @if($request->updated_at)
                                <span class="text-muted">{{$request->updated_at}}</span>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <input type="text" placeholder="Dispatch Remarks" value="{{$request->remarks}}" class="form-control" id="remarks-{{$request->id}}">
                        </td>
                        <td>
                            <input class="form-control" type="file" name="file" id="file-{{$request->id}}">
                            @if($request->file_path)
                                <img src="{{asset('storage/app/public/dispatch/'.$request->file_path)}}" width="80px" height="80px" id="image-{{$request->id}}">
                                <div id="myModal-{{$request->id}}" class="modal">

                                    <!-- The Close Button -->
                                    <span class="close-{{$request->id}}">&times;</span>
                                
                                    <!-- Modal Content (The Image) -->
                                    <img class="modal-content" id="img-{{$request->id}}">
                                
                                </div>
                                <style>
                                    /* Style the Image Used to Trigger the Modal */
                                    #image-{{$request->id}} {
                                        border-radius: 5px;
                                        cursor: pointer;
                                        transition: 0.3s;
                                    }

                                    #image-{{$request->id}}:hover {opacity: 0.7;}

                                    /* The Modal (background) */
                                    .modal {
                                        display: none; /* Hidden by default */
                                        position: fixed; /* Stay in place */
                                        z-index: 10000; /* Sit on top */
                                        padding-top: 100px; /* Location of the box */
                                        left: 0;
                                        top: 0;
                                        width: 100%; /* Full width */
                                        height: 100%; /* Full height */
                                        overflow: auto; /* Enable scroll if needed */
                                        background-color: rgb(0,0,0); /* Fallback color */
                                        background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
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
                                    .modal-content, #caption {
                                        animation-name: zoom;
                                        animation-duration: 0.6s;
                                    }

                                    @keyframes zoom {
                                    from {transform:scale(0)}
                                    to {transform:scale(1)}
                                    }

                                    /* The Close Button */
                                    .close-{{$request->id}} {
                                        position: absolute;
                                        top: 15px;
                                        right: 35px;
                                        color: #f1f1f1;
                                        font-size: 40px;
                                        font-weight: bold;
                                        transition: 0.3s;
                                    }

                                    .close-{{$request->id}}:hover,
                                    .close-{{$request->id}}:focus {
                                        color: #bbb;
                                        text-decoration: none;
                                        cursor: pointer;
                                    }

                                    /* 100% Image Width on Smaller Screens */
                                    @media only screen and (max-width: 700px){
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
                                    img.onclick = function(){
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
                            <button class="btn btn-primary dispatch" value={{$request->id}}>Update</button>
                        </td>
                        <td>
                            {{$request->count}}
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-secondary btn-rounded btn-black waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Action
                                </button>
                                <div class="dropdown-menu">
                                    <a href="{{ route('admin.zonedispatch.show', $request->id) }}" class="dropdown-item">
                                        <i class="fa fa-search"></i> More Details
                                    </a>
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

<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    $('.dispatch').click(function(){
        var val=$(this).val();
        var remarks=$("#remarks-"+val).val();
        var file=$("#file-"+val)[0].files[0];
        var fd = new FormData();
        if(file){
            fd.append('file', file);
        }
        fd.append('remarks',remarks);
        fd.append('id',val);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/zonedispatch/dispatchList')}}",
            type: 'post',
            processData: false,
            contentType: false,
            data: fd,
            success:function(response){
                console.log(response); 
                if(response.showError){
                    location.reload();
                    // alert(response.error);
                }
            },
            error: function (request, error) {
                console.log(request);
                alert("Error"+error);
            }
        });
    })
</script>
@endsection