@extends('bm.layout.master')

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
                <div class="col-md-4">
                    <h4 class="page-title m-0"> Remaining Order of  {{$requests[0]->user->first_name}}</h4>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="container-fluid">
        <div class="card m-b-30">
            <div class="card-body table-responsive">
                @if(count($requests) != 0)
            <table id="datatable" class="table table-bordered"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>ID</th>
                        <th>Pickup Add.</th>
                        <th>Pickup No.</th>
                        <th>DropOff Add.</th>
                        <th>DropOff Name</th>
                        <th>DropOff No.</th>
                        <th>Rider</th>
                        <th>Status</th>
                        <th>COD(Rs)</th>
                        <th>Remarks</th>
                        
                    </tr>
                </thead>
                <tbody>
               <script> var req_id=[];</script>
                @foreach($requests as $index => $request)
                <script> req_id.push(<?php echo $request->id; ?>);</script>
                    <tr id="dataRow{{$index}}">
                        <td>
                            @if($request->created_at)
                                <span class="text-muted">{{$request->created_at}}</span>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $request->booking_id }}</td>
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
                            @if($request->d_address)
                                {{ @$request->d_address }} 
                            @else
                                N/A
                            @endif
                        </td>
                         <td>
                            @if(@$request->item->rec_name)
                                {{ @$request->item->rec_name}} 
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if(@$request->item->rec_mobile)
                                {{ @$request->item->rec_mobile }} 
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if($request->provider)
                                <div class='edit'>
                                    {{ @$request->provider->first_name}} 
                                </div>
                                <select class='txtedit' id='provider-{{$index}}'>
                                    <option>N/A</option>
                                    @foreach($totalRiders as $rider)
                                        <option value={{$rider['id']}} <?php if($request->provider==$rider['first_name']){echo 'selected';} ?>>{{$rider['first_name']}}</option>
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
                                        <option value={{$rider['id']}} <?php if($request->provider==$rider['first_name']){echo 'selected';} ?>>{{$rider['first_name']}}</option>
                                    @endforeach
                                </select>
                            @endif
                        </td>
                        <td>
                            @if($request->status)
                                        {{ @$request->status}} 
                                        @else
                                        N/A
                                    @endif
                                
                        </td>

                        <td>
                            @if($request->cod)
                                    {{ @$request->cod}} 
                                
                            @else
                                0
                            @endif 
                        </td>
                        <td>
                            @if($request->special_note)
                                    {{ @$request->special_note}} 
                            @else
                                N/A
                            @endif
                        </td>
                        
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Date</th>
                        <th>ID</th>
                        <th>Pickup Add.</th>
                        <th>Pickup No.</th>
                        <th>DropOff Add.</th>
                        <th>DropOff Name</th>
                        <th>DropOff No.</th>
                        <th>Rider</th>
                        <th>Status</th>
                        <th>COD(Rs)</th>
                        <th>Remarks</th>
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
@section('scripts')

@include('user.layout.partials.datatable')

@endsection

