@extends('return.layout.master') 

@section('title', 'Order details ')

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
                          <h4 class="page-title m-0"> Order History</h4>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end">
                          <form class="form-inline pull-right" method="GET" action={{url('return/riderSearch')}}>
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="searchField" placeholder="Full Search">
                                    </div>
                                    <div class="form-group">
                                        <button name="search" class="btn btn-success">Search</button>
                                    </div>
                                </form>
                    </div>
                </div>
            </div>
        </div>
</div>
            
    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
                    @if (count($providers) > 0)
                        <table id="datatable-buttons" class="table table-bordered"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>SN</th>
                                <th>Rider Name</th>
                                <th>Rider Number</th>
                                <th>No of rejected</th>
                                <th>No of cancelled</th>
                                <th>No of Delivering(for 5 days)</th>
                                <th>No of Scheduled(for 6 days)</th>
                                <th>TO Be Returned</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($providers as $key => $provider)
                                <tr class="order">
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $provider->first_name }}</td>
                                    <td>{{ $provider->mobile }}</td>
                                    <td >
                                        <div class='edit'>
                                            <a href="{{ route('return.rider.remaining', [$provider->id, 'REJECTED']) }}">
                                                {{ $provider->rejectedRemaining->count() }}
                                            </a>
                                            <input type='hidden' class='txtedit' value="REJECTED-{{$provider->id}}" id='REJECTED-{{$key}}'>
                                        </div>
                                    </td>
                                    <td>
                                        <div class='edit'>
                                            <a href="{{ route('return.rider.remaining', [$provider->id, 'CANCELLED']) }}">
                                                {{ $provider->cancelledRemaining->count() }}
                                            </a>
                                            <input type='hidden' class='txtedit' value="CANCELLED-{{$provider->id}}" id='CANCELLED-{{$key}}'>
                                        </div>
                                    </td>
                                    <td >
                                        <div class='edit'>
                                            <a href="{{ route('return.rider.remaining', [$provider->id, 'DELIVERING']) }}">
                                                {{$provider->delivering_delay}}</a>
                                            <input type='hidden' class='txtedit' value="DELIVERING-{{$provider->id}}" id='DELIVERING-{{$key}}'>
                                        </div>
                                    </td>
                                    <td >
                                        <div class='edit'>
                                            <a href="{{ route('return.rider.remaining', [$provider->id, 'SCHEDULED']) }}">
                                                {{$provider->schedule_delay}}
                                            </a>
                                            <input type='hidden' class='txtedit' value="SCHEDULED-{{$provider->id}}" id='SCHEDULED-{{$key}}'>
                                        </div>
                                    </td>
                                    <td ><div class='edit'>
                                            <a href="{{ route('return.rider.remaining', [$provider->id, 'REJECTED']) }}">{{$provider->rejectedRemaining->count()}}
                                            </a>
                                            <input type='hidden' class='txtedit' value="REJECTEDTO-{{$provider->id}}" id='SCHEDULED-{{$key}}'>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>SN</th>
                                <th>Rider Name</th>
                                <th>Rider Number</th>
                                <th>No of rejected</th>
                                <th>No of cancelled</th>                                
                                <th>No of Delivering(for 5 days)</th>
                                <th>No of Scheduled(for 6 days)</th>
                                <th>TO Be Returned</th>
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
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
    
        </div>
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
    $('.edit').dblclick(function(){
      //to get the value inside input
        var value=$( this ).find( 'input' ).val();
        var split_id = value.split("-");
        var status = split_id[0];
        var id = split_id[1];
        console.log(status);
        console.log(id);
       
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('return/getRiderStatusDetails') }}/"+status+"/"+id,
            type: 'post',
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
        $('.preloader').hide();
    });
</script>
@endsection

