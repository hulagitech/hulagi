@extends('admin.layout.base')

@section('title', 'Order History')

@section('content')
<style>
    .txtedit{
        display: none;
        width: 99%;
        height: 30px;
    }
</style>
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <h5 class="mb-1"> <i class="fa fa-recycle"></i> Order History</h5>
            <hr/>

            @if(isset($dates))
                <form class="form-inline pull-right" method="POST" action={{url('admin/dateSearch')}}>
                    {{csrf_field()}}
                    <div class="form-group">
                        <input type="text" class="form-control" name="searchField" value="{{ request()->searchField}}" placeholder="Full Search">
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="date">
                            <option>All</option>
                        @foreach ($dates as $date)
                            <option {{(isset(request()->date) && request()->date==$date)? "selected": ""}} value={{$date}}>{{$date}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="status">
                            <option {{(request()->status && request()->status=="All")? "selected": ""}}>All</option>
                            <option {{(request()->status && request()->status=="PENDING")? "selected": ""}}>PENDING</option>
                            <option {{(request()->status && request()->status=="PICKEDUP")? "selected": ""}}>PICKEDUP</option>
                            <option {{(request()->status && request()->status=="CANCELLED")? "selected": ""}}>CANCELLED</option>
                            <option {{(request()->status && request()->status=="DELIVERING")? "selected": ""}}>DELIVERING</option>
                            <option {{(request()->status && request()->status=="ACCEPTED")? "selected": ""}}>ACCEPTED</option>
                            <option {{(request()->status && request()->status=="SORTCENTER")? "selected": ""}}>SORTCENTER</option>
                            <option {{(request()->status && request()->status=="SCHEDULED")? "selected": ""}}>SCHEDULED</option>
                            <option {{(request()->status && request()->status=="COMPLETED")? "selected": ""}}>COMPLETED</option>
                            <option {{(request()->status && request()->status=="REJECTED")? "selected": ""}}>REJECTED</option>
                            <option {{(request()->status && request()->status=="TOBERETURNED")? "selected": ""}}>TOBERETURNED</option>
                            <option {{(request()->status && request()->status=="RETURNED")? "selected": ""}}>RETURNED</option>
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
                        <th>User</th>
                        <th>Pickup Address</th>
                        <th>Pickup Number</th>
                        <th>Driver</th>
                        <th>Orders</th>
                        <th>Return</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
               <script> var req_id=[];</script>
                @foreach($requests as $index => $request)
                <script> req_id.push(<?php echo $request->user_id; ?>);</script>
                    <tr id="dataRow{{$index}}">
                        <td>
                            @if(@$request->user)
                                {{ @$request->user->first_name }} 
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if($request->s_address)
                                {{ @$request->s_address }} 
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if(@$request->user->mobile)
                                {{ @$request->user->mobile }} 
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            <div class='edit'>
                                Select Rider
                            </div>
                            <select class='txtedit' id='provider-{{$index}}'>
                                <option>Select Rider</option>
                                @foreach($totalRiders as $rider)
                                    <option value={{$rider['id']}}>{{$rider['first_name']}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            {{@$request->count}}
                        </td>
                        <td>
                            {{@$request->r?$request->r:0}}
                        </td>
                        <td>
                            PENDING
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>User</th>
                        <th>Pickup Address</th>
                        <th>Pickup Number</th>
                        <th>Driver</th>
                        <th>Orders</th>
                        <th>Return</th>
                        <th>Status</th>
                    </tr>
                </tfoot>
            </table>
            @else
            <h6 class="no-result">No results found</h6>
            @endif 
        </div>
    </div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
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
            
            if(field_name=="provider" && !confirm("Are you sure to assign \""+$("option:selected", this).text()+"\"?")){
                $(this).hide();
                $(this).prev('.edit').show();
                return;
            }
            if(field_name=="provider" && $("option:selected", this).text()=="Select Rider"){
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
                url: "{{url('admin/bulkAssign')}}/"+req_id[edit_id],
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
                    alert("Error! Please refresh page and check if rider is unset.");
                }
            });
            // console.log($(this).html());
        
        });

    });
</script>
<script>
    var ajax_call = function() {
        $.ajax({
          url: 'searchingajax',
          type: 'get',
          success: function(data){
          }
        });
        $.ajax({
          url: 'ajaxforofflineprovider',
          type: 'get',
          success: function(data){
              //alert(data);
          }
        });
        //your jQuery ajax code
    };
    var interval = 1000 * 60 * 1; // where X is your every X minutes
    setInterval(ajax_call, interval);
</script>
