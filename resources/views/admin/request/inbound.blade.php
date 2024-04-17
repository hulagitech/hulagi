@extends('admin.layout.base')

@section('title', 'Inbound Orders')

@section('content')

<style>
    .txtedit{
        display: none;
        width: 99%;
        height: 30px;
    }

    #weight{
        display: none;
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
                            <th>Created</th>
                            <th>ID</th>
                            <th>User</th>
                            <th>Pickup Add.</th>
                            <th>Pickup No.</th>
                            <th>DropOff Add.</th>
                            <th>DropOff Name</th>
                            <th>DropOff No.</th>
                            <th>Rider</th>
                            <th>Status</th>
                            <th>Kg</th>
                            <th>Fare</th>
                            <th>COD(Rs)</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($inbound_orders as $index => $inbound_order)
                            <tr id="dataRow{{$index}}">
                                <td>
                                    @if($inbound_order->created_at)
                                        <span class="text-muted">{{$inbound_order->created_at->format('Y-m-d')}}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($inbound_order->created_at)
                                        <span class="text-muted">{{$inbound_order->created_at->diffForHumans()}}</span>
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
                                    @if(@$inbound_order->provider->first_name)
                                        {{ @$inbound_order->provider->first_name }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$inbound_order->status)
                                        {{ @$inbound_order->status }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td style="width:4%;">
                                    @if($inbound_order->weight)
                                        <div class='edit'>
                                            {{ @$inbound_order->weight}} 
                                        </div>
                                        <input type='text' class='txtedit' value="{{@$inbound_order->weight}}" id='weight-{{$inbound_order->id}}'>
                                    @else
                                        <div class='edit'>
                                        0
                                        </div>
                                        <input type='text' class='txtedit' value="0" id='weight-{{$inbound_order->id}}'>
                                    @endif
                                </td>
                                <td>
                                    @if($inbound_order->amount_customer)
                                        <div class='edit'>
                                            {{ @$inbound_order->amount_customer}} 
                                        </div>
                                        <input type='text' class='txtedit' value="{{@$inbound_order->amount_customer}}" id='amount_customer-{{$inbound_order->id}}'>
                                    @else
                                        <div class='edit'>
                                        0
                                        </div>
                                        <input type='text' class='txtedit' value="0" id='amount_customer-{{$inbound_order->id}}'>
                                    @endif
                                </td>
                                <td>
                                    @if(@$inbound_order->cod)
                                        {{ @$inbound_order->cod }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                {{-- <td>
                                    @if($inbound_order->cod)
                                        <div class='edit'>
                                            {{ @$inbound_order->cod}} 
                                        </div>
                                        <input type='text' class='txtedit' value="{{@$inbound_order->cod}}" id='cod-{{$index}}'>
                                    @else
                                        <div class='edit'>
                                        0
                                        </div>
                                        <input type='text' class='txtedit' value="0" id='cod-{{$index}}'>
                                    @endif 
                                </td> --}}

                                <td>
                                    <div style="display:flex;">
                                        <a style="height: fit-content;" href="#" class="allinbound btn btn-warning" name="status-{{$inbound_order->id}}">Inbound</a>
                                        &nbsp;
                                        <span style="color: orange; display:none;" class="checkinbound"><i class="fa fa-check"></i></span>
                                        <form class="inboundAndPrint form-inline" target="_blank" method="GET" action="{{url('admin/printInvoice/'.$inbound_order->id)}}">
                                            <button type="button" class="btn btn-primary">Print</button>
                                            {{-- <a href="{{url('admin/printInvoice/'.$inbound_order->id)}}" target="_blank" class="btn btn-primary">Print</a> --}}
                                        </form>
                                        <span style="color: orange; display:none;" class="checkinbound"><i class="fa fa-check"></i></span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Date</th>
                            <th>Created</th>
                            <th>ID</th>
                            <th>User</th>
                            <th>Pickup Add.</th>
                            <th>Pickup No.</th>
                            <th>DropOff Add.</th>
                            <th>DropOff Name</th>
                            <th>DropOff No.</th>
                            <th>Rider</th>
                            <th>Status</th>
                            <th>Kg</th>
                            <th>Fare</th>
                            <th>COD(Rs)</th>
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
        $(document).ready(function(){
            $('.inboundAndPrint').click(function(){
                //if(confirm('Are you sure you want to Inbound ?')){
                    $(this).hide();
                    $(this).next(".checkinbound").show();
                    $(this).prevAll(".allinbound").hide();
                    $(this).parent().parent().parent().hide();
                    $(this).submit();
                //}
            })
            $(".allinbound").click(function(){
                if(confirm('Are you sure you want to Inbound ?')){ 
                    $(this).hide();
                    $(this).next(".checkinbound").show();
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
                        url: "{{url('admin/inbound_order')}}/"+req_id,
                        type: 'post',
                        success:function(response){
                            console.log(response);
                        },
                        error: function (request, error) {
                            console.log(request);
                            alert(" Can't do!! Error"+error);
                        }
                    });               
                }else{
                    console.log('cancel');
                }
            });
        });
    
</script>

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

            // alert("User_request_id: "+edit_id+" --> " +field_name+" = "+value);
            
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
                url: "{{url('admin/requests')}}/"+edit_id,
                type: 'put',
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
        });

    });
</script>

@endsection

