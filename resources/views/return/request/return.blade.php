@extends('return.layout.master')

@section('title', 'Inbound Orders')

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
                <div class="col-md-4">
                    <h4 class="page-title m-0">Orders "To Be Return"</h4>
                </div>
                <div class="col-md-8 d-flex justify-content-end">
                    <form class="form-inline pull-right" method="POST" action={{url('return/inboundSearch')}}>
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
                    @if (count($return_orders) > 0)
                        <table id="datatable" class="table table-bordered"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Updated Date</th>
                            <th>ID</th>
                            <th>User</th>
                            <th>Pickup Add.</th>
                            <th>Pickup No.</th>
                            <th>DropOff Add.</th>
                            <th>DropOff Name</th>
                            <th>DropOff No.</th>
                            <th>Rider</th>
                            <th>COD</th>
                            <th>Vendor Remarks</th>
                            <th>Status</th>
                            {{-- <th>COD(Rs)</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <script> var req_id=[];</script>
                        @foreach($return_orders as $index => $return_order)
                        <script> req_id.push(<?php echo $return_order->id; ?>);
                        </script>
                        {{-- @if($return_order->status == 'CANCELLED'&&$return_order->status == 'REJECTED'&&$return_order->returned == 0&&$return_order->returned_to_hub == 0) --}}
                            <tr id="dataRow{{$index}}">
                                <td>
                                    @if($return_order->created_at)
                                        <span class="text-muted">{{$return_order->created_at->format('Y-m-d')}}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($return_order->updated_at)
                                        <span class="text-muted">{{$return_order->updated_at->format('Y-m-d')}}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $return_order->booking_id }}</td>
                                <td>
                                    @if(@$return_order->user)
                                        {{ @$return_order->user->first_name }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if($return_order->s_address)
                                        {{ @$return_order->s_address }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$return_order->user->mobile)
                                        {{ @$return_order->user->mobile }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if($return_order->d_address)
                                        {{ @$return_order->d_address }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$return_order->item->rec_name)
                                        {{ @$return_order->item->rec_name}} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$return_order->item->rec_mobile)
                                        {{ @$return_order->item->rec_mobile }} 
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(@$return_order->provider->first_name)
                                        {{ @$return_order->provider->first_name }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$return_order->cod)
                                        {{ @$return_order->cod }} 
                                    @else
                                        0
                                    @endif
                                </td>

                                <td>
                                    @if($return_order->special_note)
                                        <div class='edit'>
                                            {{ @$return_order->special_note}} 
                                        </div>
                                        <input type='text' class='txtedit' value="{{@$return_order->special_note}}" id='special_note-{{$index}}'>
                                    @else
                                        <div class='edit'>
                                        N/A
                                        </div>
                                        <input type='text' class='txtedit' value="N/A" id='special_note-{{$index}}'>
                                    @endif
                                </td>

                               

                                <td>
                                    @if($return_order->status)
                                        <div class='edit'>
                                            @if($return_order->status=="REJECTED")
                                                @if($return_order->returned)
                                                    RETURNED (Rejected
                                                @elseif($return_order->returned_to_hub == 1 && $return_order->returned == 0)
                                                    R.WAREHOUSE
                                                @else
                                                    TOBERETURNED (Rejected)
                                                @endif
                                            @elseif($return_order->status=="CANCELLED")
                                                @if($return_order->returned)
                                                    RETURNED (Cancelled)
                                                @else
                                                    TOBERETURNED (Cancelled)
                                                @endif
                                            @else
                                                {{ @$return_order->status}} 
                                            @endif
                                        </div>
                                        @if(($return_order->status=="REJECTED"||$return_order->status=="CANCELLED")&&$return_order->returned==0)
                                        <select  class= 'txtedit' id='status-{{$index}}'>
                                            <option <?php if($return_order->status=="REJECTED"){echo 'selected';} ?>>REJECTED</option>
                                            <option <?php if($return_order->status=="CANCELLED"){echo 'selected';} ?>>CANCELLED</option>
                                        </select>
                                        @else
                                        <div class='txtedit'>
                                            @if($return_order->status=="REJECTED")
                                                @if($return_order->returned)
                                                    RETURNED (Rejected)
                                                @else
                                                    TOBERETURNED (Rejected)
                                                @endif
                                            @elseif($return_order->status=="CANCELLED")
                                                @if($return_order->returned)
                                                    RETURNED (Cancelled)
                                                @else
                                                    TOBERETURNED (Cancelled)
                                                @endif
                                            @else
                                                {{ @$return_order->status}} 
                                            @endif
                                        </div>
                                        @endif
                                        {{--<input type='text' class='txtedit' value="{{@$request->status}}" id='status-{{$index}}'>--}}
                                    @else
                                        <div class='edit'>
                                        N/A
                                        </div>
                                        <select class='txtedit' id='status-{{$index}}'>
                                            <option <?php if($request->status=="REJECTED"){echo 'selected';} ?>>REJECTED</option>
                                            <option <?php if($request->status=="CANCELLED"){echo 'selected';} ?>>CANCELLED</option>
                                        </select>
                                    @endif
                                </td>
                                
                                {{-- <td>
                                    @if($return_order->cod)
                                        {{ @$return_order->cod}}
                                    @else
                                        -
                                    @endif 
                                </td> --}}

                                <td>
                                    <div style="display:flex;">
                                        <a href="#" class="returntohub btn btn-warning" name="returned_to_hub-{{$return_order->id}}">Return Warehouse</a>
                                        <span style="color: orange; display:none;" class="checkinhub"><i class="fa fa-check"></i></span>
                                        &nbsp;
                                        <a href="{{ route('return.order_details', $return_order->id) }}" target="_blank" class="btn btn-primary">Details</a>
                                    </div>
                                </td>
                            </tr>
                            {{-- @endif --}}
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Date</th>
                            <th>Updated Date</th>
                            <th>ID</th>
                            <th>User</th>
                            <th>Pickup Add.</th>
                            <th>Pickup No.</th>
                            <th>DropOff Add.</th>
                            <th>DropOff Name</th>
                            <th>DropOff No.</th>
                            <th>Rider</th>
                            <th>COD</th>
                            <th>Vendor Remarks</th>
                            <th>Status</th>
                            {{-- <th>COD(Rs)</th> --}}
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
                {{$return_orders->links('vendor.pagination.bootstrap-4')}}
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
        $(document).ready(function(){
            $(".returntohub").click(function(){
                //if(confirm('Are you sure, you want to Inbound ?')){ 
                    $(this).hide();
                    $(this).next(".checkinhub").show();
                    var id = this.name;
                    var split_data = id.split("-");
                    //var req_field = split_data[0];
                    var req_id = split_data[1];

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    
                    $.ajax({
                        url: "{{url('return/order_inhub')}}/"+req_id,
                        type: 'post',
                        success:function(response){
                           $.jnoty("Success", {
                            life: 1000,
                            theme: 'jnoty-success',
                            
                        });
                        },
                        error: function (request, error) {
                             $.jnoty("failed", {
                            life: 1000,
                            theme: 'jnoty-error',
                            
                        });
                        }
                    });               
                // }else{
                //     console.log('cancel');
                // }
            });
        });
    
</script>
<script>
    $(document).ready(function(){
            $('.edit').click(function(){
            // $('.txtedit').hide();
            $(this).next('.txtedit').show().focus();
            $(this).hide();
        });
                // Show Input element
        

        // Save data
        $(".txtedit").focusout(function(){
      
            // Get edit id, field name and value
            var id = this.id;
            var split_id = id.split("-");
            var field_name = split_id[0];
            var edit_id = split_id[1];
            var value = $(this).val();
            // if(field_name=="provider" && !confirm("Are you sure to assign \""+$("option:selected", this).text()+"\"?")){
            //     $(this).hide();
            //     $(this).prev('.edit').show();
            //     return;
            // }
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
                url: "{{url('return/requests')}}/"+req_id[edit_id],
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
            if(field_name=="status" && value=="CANCELLED"){
                if(!confirm("Add this item to return list?")){
                    $.ajax({
                        url: "{{url('return/requests')}}/"+req_id[edit_id],
                        type: 'post',
                        data: field_name+"=RETURNED",
                        success:function(response){
                            if(response.showError){
                                $.jnoty(respnse.error, {
                            life: 1000,
                            theme: 'jnoty-error',
                            
                        });
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
                }
                else{
                    
                    $.ajax({
                        url: "{{url('return/requests')}}/"+req_id[edit_id],
                        type: 'post',
                        data: field_name+"=TOBERETURNED",
                        success:function(response){
                            console.log(response); 
                            if(response.showError){
                                 $.jnoty(response.error, {
                            life: 1000,
                            theme: 'jnoty-error',
                            
                        });
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
                }
            }
        });

    });
</script>
@endsection


