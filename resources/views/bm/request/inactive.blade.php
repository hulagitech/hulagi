@extends('bm.layout.master')

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
                <div class="col-md-8">
                    <h4 class="page-title m-0">Customer Query Order</h4>
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
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body table-responsive">
                @if (count($request) != 0)
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
                        @foreach($request as $index=> $request)
                        <tr class="order">
                            <input type="hidden" value="{{@$request->id}}" class="form-control" id="order-{{@$request->id}}">
                            <th>{{$index+1}}</th>
                            <th>{{$request->created_at}}</th>
                            <th>{{$request->booking_id}}</th>
                            <th>{{@$request->user->first_name}}</th>
                            <th>{{$request->item->rec_name}}</th>
                            <th>{{$request->item->rec_mobile}}</th>
                            <th>{{$request->d_address}}</th>
                            <th>{{$request->status}}</th>
                            <td style="position:relative;">
                                <a href="{{ route('bm.order_detail', @$request->id) }}" class="btn btn-success shadow-box"> <i class="ti-comment"></i> </a>
                                
                                {{-- Count Comment Notification --}}
                                @if(@$request->noComment != '0')
                                    <span class="tag tag-danger" style="position:absolute; top:0px;">{{@$request->noComment}}</span>
                                @else
                                    <span>  </span>
                                @endif
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
                @else
                    <h6 class="no-result">No results found</h6>
                @endif
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
                    url: '{{ url('bm/getOrderDetails') }}/'+id,
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