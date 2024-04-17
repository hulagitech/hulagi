@extends('return.layout.master')

@section('title', 'Order History')

@section('content')
<style>
    .txtedit{
        display: none;
        width: 99%;
        height: 30px;
    }
</style>
<div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-12">
                            <h5 class="mb-1"> <i class="fa fa-recycle"></i> Order History</h5>
                            <hr/>

                            
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
                    @if(count($requests) != 0)
                    <table id="datatable" class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Pickup Address</th>
                            <th>Pickup Number</th>
                            <th>Driver</th>
                            <th>Orders</th>
                            <th>Return</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <script> var req_id=[];</script>
                    @foreach($requests as $index => $request)
                    <script> req_id.push(<?php echo $request->user_id; ?>);</script>
                        <tr id="dataRow{{$index}}" class="{{$request->user->new_wallet($request->user->id)<0 ? 'text-danger':''}}">
                            <td>
                                @if(@$request->user)
                                    {{ @$request->user->first_name}} ({{$request->user->new_wallet($request->user->id)<0 ? 'Rs '.$request->user->new_wallet($request->user->id) : ''}})
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
                                {{@$request->r?$request->r:0}}
                            </td>
                            <td>
                                {{@$request->count}}
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <a href="{{route('return.details',$request->user_id)}}" class="btn btn-success">View Details</a>
                                    </div>
                                </div>
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
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
                @endif
                <h6 class="no-result">No results found</h6>
                </div>

            </div>
        </div>
    </div>
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
                url: "{{url('return/returnRider')}}/"+req_id[edit_id],
                type: 'post',
                data: field_name+"="+value,
                success:function(response){
                    if(response.showError){
                        toastr.error(response.error);
                    }
                        $.jnoty("Success", {
                            life: 1000,
                            theme: 'jnoty-success',
                            
                        });
                },
                error: function (request, error) {
                        $.jnoty("Error Refresh Page and check if the Rider is unsent", {
                            life: 1000,
                            theme: 'jnoty-error',
                            
                        });
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

@endsection
