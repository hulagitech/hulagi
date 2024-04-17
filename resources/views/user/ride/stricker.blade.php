@extends('user.layout.master')

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
    .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
    }

    .switch input { 
    opacity: 0;
    width: 0;
    height: 0;
    }

    .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
    }

    .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
    }

    input:checked + .slider {
    background-color: #2196F3;
    }

    input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
    border-radius: 34px;
    }

    .slider.round:before {
    border-radius: 50%;
    }
    .fixed-btn {
    position: fixed;
    bottom: 2px;
    left: 2px;
    z-index: ;
}
</style>
 <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Inbound Orders</h4>
                        (Select the stricker you want to print)
                    </div>

                </div>

            </div>
        </div>
</div>
 <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
                    @if(count($inbound_orders) != 0)
            <form class=" form-inline"  method="POST"
                    action="{{ route('bulkinvocie') }}" target="_blank">
                    {{csrf_field()}}
                <table id="datatable" class="table table-bordered"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                            <th>Kg</th>
                            <th>Fare</th>
                            <th>COD(Rs)</th>
                            <th>Action</th>
                            <th>Select 
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inbound_orders as $index => $inbound_order)
                        <tr id="dataRow{{$index}}">
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
                        
                            <td style="width:4%;">
                                @if($inbound_order->weight)
                                <div class='edit'>
                                    {{ @$inbound_order->weight}}
                                </div>
                                <input type='text' class='txtedit' value="{{@$inbound_order->weight}}"
                                    id='weight-{{$inbound_order->id}}'>
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
                                <input type='text' class='txtedit' value="{{@$inbound_order->amount_customer}}"
                                    id='amount_customer-{{$inbound_order->id}}'>
                                @else
                                <div class='edit'>
                                    0
                                </div>
                                <input type='text' class='txtedit' value="0" id='amount_customer-{{$inbound_order->id}}'>
                                @endif
                            </td>
        
                            <td>
                                @if($inbound_order->cod)
                                <div class='edit'>
                                    {{ @$inbound_order->cod}}
                                </div>
                                <input type='text' class='txtedit' value="{{@$inbound_order->cod}}"
                                    id='cod-{{$inbound_order->id}}'>
                                @else
                                <div class='edit'>
                                    0
                                </div>
                                <input type='text' class='txtedit' value="0" id='cod-{{$inbound_order->id}}'>
                                @endif
                            </td>
        
                           <td style="position:relative">
                                            <a href="{{ url('/mytrips/detail?request_id='.$inbound_order->id) }}"   class="btn btn-dark">Detail</button>
                                            </a>
                                        </td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" value="{{ $inbound_order->id}}" name="order_id[]" class="single_check" checked>
                                    <span class="slider round"></span>
                                </label>
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
                            <th>Kg</th>
                            <th>Fare</th>
                            <th>COD(Rs)</th>
                            <th>Action</th>
                            <th>Select</th>
                        </tr>
                    </tfoot>
                </table>
                <div class="row">
                    <button type="submit" class="btn btn-lg btn-secondary pull-right fixed-btn" style="margin-right: 14px; font-size: 20px"><i class="fa fa-print text-danger"></i> Print</button> 

                </div>
            </form>
            @else
                <h6 class="no-result">No results found</h6>
            @endif 
                </div>
            </div>
        </div>
    </div>


<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    $(document).ready(function(){
            $('.loader').hide()
            $('.inboundAndPrint').click(function(){
                //if(confirm('Are you sure you want to Inbound ?')){
                    $(this).hide();
                    $(this).next(".checkinbound").show();
                    $(this).prevAll(".allinbound").hide();
                    $(this).parent().parent().parent().hide();
                    $(this).submit();
                //}
            })
            $( document ).ajaxStart(function() {
            });

     $( document ). ajaxComplete(function() {
       
     });
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
                        url: "{{url('inbound_order')}}/"+req_id,
                        type: 'post',
                        success:function(response){
                            toastr.success("Success!!")
                            $( ".preloader" ).hide();
                        },
                        error: function (request, error) {
                            toastr.error(" Can't do!! Error"+error);
                            $( ".preloader" ).show();

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
                url: "{{url('requests')}}/"+edit_id,
                type: 'post',
                data: field_name+"="+value,
                success:function(response){
                   
                    if(response.showError){
                        toastr.error(response.error);
                    }
                    toastr.success("Success!!")
                    $('.preloader').hide();
                },
                error: function (request, error) {
                
                    toastr.error("Error! Please refresh page and check if rider is unset.");
                    $('.preloader').show();
                }
            });
            // console.log($(this).html());
            
            // if(field_name=="status" && value=="CANCELLED"){
            //     if(!confirm("Add this item to return list?")){
            //         $.ajax({
            //             url: "{{url('admin/requests')}}/"+req_id[edit_id],
            //             type: 'put',
            //             data: field_name+"=RETURNED",
            //             success:function(response){
            //                 console.log(response); 
            //                 if(response.showError){
            //                     alert(response.error);
            //                 }
            //             },
            //             error: function (request, error) {
            //                 console.log(request);
            //                 alert("Error! Please refresh page and check if rider is unset.");
            //             }
            //         });
            //     }
            //     else{
            //         $.ajax({
            //             url: "{{url('admin/requests')}}/"+req_id[edit_id],
            //             type: 'put',
            //             data: field_name+"=TOBERETURNED",
            //             success:function(response){
            //                 console.log(response); 
            //                 if(response.showError){
            //                     alert(response.error);
            //                 }
            //             },
            //             error: function (request, error) {
            //                 console.log(request);
            //                 alert("Error! Please refresh page and check if rider is unset.");
            //             }
            //         });
            //     }
            // }
        });
    });
</script>
<script>
    $("#check_all").click(function(){
    $('.single_check').not(this).prop('checked', this.checked);
});
    $(document).ready(function(){

        $(".cargo").click(function(){

            // Get edit id, field name and value
            var id = this.id;
            var split_id = id.split("-");
            var field_name = split_id[0];
            var edit_id = split_id[1];
            var value = $(this).val();

            //alert(edit_id+" = "+field_name+" --> Value ="+ value);

            if(value == 1) {
                value = 0; 
            } else {
                value = 1; 
            }
            // alert("Are you sure to change Cargo??");
            if(field_name=="cargo" && !confirm("Are you sure to change Cargo??")){
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
                url: "{{url('changeCargo')}}/"+edit_id,
                type: 'post',
                data: field_name+"="+value,
                success:function(response){
                    console.log(response); 
                    if(response.showError){
                        alert(response.error);
                    }
                    toastr.success("Success!!")
                    $('.preloader').hide();
                    
                },
                error: function (request, error) {
                    console.log(request);
                    $('.preloader').show();
                    alert("Error! Please refresh page and check if rider is unset.");
                }
            });
        });
    });
</script>

@endsection