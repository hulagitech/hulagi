@extends('admin.layout.master')

@section('title', 'Order History')

@section('content')
<style>
    body {font-family: Arial, Helvetica, sans-serif;}

    /* The Modal (background) */
    .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    }

    /* The Close Button */
    .close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    }

    .close:hover,
    .close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
    }
</style>
<div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-4">
                          <h5 class="mb-1"><span class="s-icon"><i class="ti-infinite"></i></span>&nbsp; Inactive Order</h5>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end">
                    </div>
                </div>
            </div>
        </div>
</div>
<div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
              
            <table id="datatable" class="table table-bordered"
                        								style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Created At</th>
                        <th>Booking ID</th>
                        <th>Vendor Name</th>
                        <th>Receiver Name</th>
                        <th>Receiver Number</th>
                        <th>Drop Off Location</th>
                        <th>Status</th>
                        <th>Action</th>
                       
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $index=> $request)
                    <tr class="order">
                        <input type="hidden" value="{{@$request->id}}" class="form-control" id="order-{{@$request->id}}">
                        <td>{{$index+1}}</td>
                        <td>{{$request->created_at}}</td>
                        <td>{{$request->booking_id}}</td>
                        <td>{{@$request->user->first_name}}</td>
                        <td>{{$request->item->rec_name}}</td>
                        <td>{{$request->item->rec_mobile}}</td>
                        <td>{{$request->d_address}}</td>
                        <td>{{$request->status}}</td>
                        <td style="position:relative;">
                        <div class="btn-group" role="group">
                                <button type="button" class="btn btn-secondary btn-rounded btn-black waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Action
                                </button>
                                <div class="dropdown-menu">
                                    <a href="{{ route('admin.requests.show', $request->id) }}" class="dropdown-item">
                                        <i class="fa fa-search"></i> More Details
                                    </a>
                                    <a href="{{ url('/admin/requests/'.$request->id.'/logs') }}" class="dropdown-item">
                                        <i class="fa fa-search"></i> Logs
                                    </a>
                                    {{--<a href="{{ route('admin.requests.edit', $request->id) }}" class="dropdown-item">
                                    <i class="fa fa-pencil"></i>  Edit
                                    </a>--}}
                                    {{--<form action="{{ route('admin.requests.destroy', $request->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="dropdown-item">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </form>--}}
                                </div>
                            </div>
                        </td>
                    @endforeach

                </tbody>
                <tfoot>
                    <tr>
                        <th>SN</th>
                        <th>Created At</th>
                        <th>Booking ID</th>
                        <th>Vendor Name</th>
                        <th>Receiver Name</th>
                        <th>Receiver Number</th>
                        <th>Drop Off Location</th>
                        <th>Status</th>
                        <th>Action</th>
                </tfoot>
            </table>
            {{$requests->links('vendor.pagination.bootstrap-4')}}
                </div>

            </div>
        </div>
    </div>
</div>
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    
  </div>
<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
            $('.order').dblclick(function(){
                var id=$( this ).find( 'input' ).val();
                console.log(id);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ url('admin/getOrderDetails') }}/'+id,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'html',
                    success: function (data) {
                    $('.modal-content').html(data)
                    },
                    error: function (error) {
                        console.log("error");
                    },
                });
                modal.style.display = "block";
            });
</script>
@endsection
@section('scripts')

    @include('user.layout.partials.datatable')

@endsection
