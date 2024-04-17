@extends('pickup.layout.base')

@section('title', 'Inbound Orders')

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
            <h5 class="mb-1"> <i class="fa fa-recycle"></i> Inbound Orders </h5>
            
            <hr/>
            

            @if(count($inbound_orders) != 0)
            <table class="table table-striped table-bordered dataTable" id="table-2" style="width:100%;">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>ID</th>
                        <th>User</th>
                        <th>Pickup Add.</th>
                        <th>Pickup No.</th>
                        <th>DropOff Add.</th>
                        <th>DropOff Name</th>
                        <th>DropOff No.</th>
                        <th>COD(Rs)</th>
                        <th>Status</th>
                        <th>Rider</th>
                        
                    </tr>
                </thead>
    
                <tbody>
                    <script> var req_id=[];</script>
                    @foreach($inbound_orders as $index => $inbound_order)
                <script> req_id.push(<?php echo $inbound_order->id; ?>);</script>

                    <tr id="dataRow{{$index}}">
                        <td>
                            @if($inbound_order->created_at)
                            <span class="text-muted">{{$inbound_order->created_at->format('Y-m-d')}}</span>
                            @else
                            -
                            @endif
                        </td>
                   
                        <td>{{ $inbound_order->booking_id }}</td>
                        <td>
                            @if(@$inbound_order->user)
                            
                                {{ @$inbound_order->user->first_name }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td>
                            @if($inbound_order->s_address)
                            {{ @$inbound_order->s_address }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td>
                            @if(@$inbound_order->user->mobile)
                            {{ @$inbound_order->user->mobile }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td>
                            @if($inbound_order->d_address)
                            {{ @$inbound_order->d_address }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td>
                            @if(@$inbound_order->item->rec_name)
                            {{ @$inbound_order->item->rec_name}}
                            @else
                            N/A
                            @endif
                        </td>
                        <td>
                            @if(@$inbound_order->item->rec_mobile)
                            {{ @$inbound_order->item->rec_mobile }}
                            @else
                            N/A
                            @endif
                        </td>
                        
                        
                        
                        
                        <td>
                            @if($inbound_order->cod)
                            
                            {{ @$inbound_order->cod}}
                            @else
                            0
                            @endif
                                

                           
                        </td>
                        <td>
                            @if($inbound_order->status)
                            
                            {{ @$inbound_order->status}}
                            @endif  
                        </td>
                        <td>
                            @if($inbound_order->provider)
                                <div class='edit'>
                                    {{ @$inbound_order->provider->first_name}} 
                                </div>
                                <select class='txtedit' id='provider-{{$index}}'>
                                    <option>N/A</option>
                                    @foreach($totalRiders as $rider)
                                        <option value={{$rider['id']}} <?php if($inbound_order->provider==$rider['first_name']){echo 'selected';} ?>>{{$rider['first_name']}}</option>
                                    @endforeach
                                </select>
                                {{--<input type='text' class='txtedit' value="{{@$request->status}}" id='status-{{$index}}'>--}}
                            @else
                                <div class='edit'>
                                N/A
                                </div>
                                <select class='txtedit' id='provider-{{$index}}'>
                                    <option>Select Rider</option>
                                    @foreach($totalRiders as $rider)
                                        <option value={{$rider['id']}} <?php if($inbound_order->provider==$rider['first_name']){echo 'selected';} ?>>{{$rider['first_name']}}</option>
                                    @endforeach
                                </select>
                            @endif
                        </td>
                       
                        
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Date</th>
                        <th>ID</th>
                        <th>User</th>
                        <th>Pickup Add.</th>
                        <th>Pickup No.</th>
                        <th>DropOff Add.</th>
                        <th>DropOff Name</th>
                        <th>DropOff No.</th>
                        <th>COD</th>
                        <th>Status</th>
                        <th>Rider</th>
                        {{-- <th>Rider</th>
                                <th>Status</th> --}}
                        
                        
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
            
            if(field_name=="provider" && !confirm("Are you sure to assign \""+$("option:selected", this).text()+"\"?")){
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
                url: "{{url('pickup/requests')}}/"+req_id[edit_id],
                type: 'post',
                data: field_name+"="+value,
                success:function(response){
                    if(response.error){
                                toastr.error(response.message);
                            }
                            toastr.success(response.message);

                   
                },
                error: function (request,error) {
                    console.log(request.statusText);
                    toastr.error("Error,Something went wrong!!")
                }
            });
            // console.log($(this).html());
            if(field_name=="status" && value=="CANCELLED"){
                if(!confirm("Add this item to return list?")){
                    $.ajax({
                        url: "{{url('pickup/requests')}}/"+req_id[edit_id],
                        type: 'post',
                        data: field_name+"=RETURNED",
                        success:function(response){
                            if(response.error){
                                toastr.error(response.message);
                            }
                            toastr.success(response.message);
                        },
                        error: function (request, error) {
                            console.log(request);
                            toastr.error("Error,Something went wrong!!");
                        }
                    });
                }
                else{
                    $.ajax({
                        url: "{{url('pickup/requests')}}/"+req_id[edit_id],
                        type: 'post',
                        data: field_name+"=TOBERETURNED",
                        success:function(response){
                            if(response.error){
                                toastr.error(response.message);
                            }
                            toastr.success(response.message)
                        },
                        error: function (request, error) {
                            toastr.error("Error,Something went wrong!!");
                        }
                    });
                }
            }
        });

    });
</script>

@endsection