@extends('support.layout.master')

@section('title', 'Dashboard ')
@section('styles')
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
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h4 class="page-title m-0">Order By Date</h4>
                </div>
                <div class="col-md-8 justify-content-end d-flex row">
                    @if(isset($dates))
                    <form class="form-inline pull-right" method="POST" action={{url('support/dateSearch')}}>
                        {{csrf_field()}}
                        <div class="form-group">
                            <input type="text" class="form-control" name="searchField" placeholder="Full Search">
                        </div>
                        {{-- <div class="form-group">
                            <input type="date" class="form-control" name="date">
                            <!-- <select class="form-control" name="date">
                                <option>All</option>
                            @foreach ($dates as $date)
                                <option {{(isset(request()->date) && request()->date==$date)? "selected": ""}} value={{$date}}>{{$date}}</option>
                            @endforeach
                            </select> -->
                        </div> --}}
                        <div class="form-group">
                            <label for="from_date" style="padding-top:5px;"> From: <label>
                            <input type="date" class="form-control" name="from_date">
                        </div>
                        <div class="form-group">
                            <label for="to_date" style="padding-top:5px;"> To: <label>
                            <input type="date" class="form-control" name="to_date">
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="status">
                                <option {{(request()->status && request()->status=="All")? "selected": ""}}>All</option>
                                <option {{(request()->status && request()->status=="PENDING")? "selected": ""}}>PENDING</option>
                                <option {{(request()->status && request()->status=="PICKEDUP")? "selected": ""}}>PICKEDUP</option>
                                <option {{(request()->status && request()->status=="ASSIGNED")? "selected": ""}}>ASSIGNED</option>
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
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body table-responsive">
                @if (count($requests) != 0)

                <table id="datatable" class="table table-bordered"
                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>

                        <th>S.N</th>
                        <th>Date</th>
                        <th>Last Update</th>
                        <th>ID</th>
                        <th>User</th>
                        <th>Pickup Add.</th>
                        <th>Pickup No.</th>
                        <th>DropOff Add.</th>
                        <th>DropOff Name</th>
                        <th>DropOff No.</th>
                        <th>Km</th>
                        <th>Rider</th>
                        <th>Status</th>
                        <th>Weight</th>
                        <th>Cargo</th>
                        <th>Fare</th>
                        <th>COD(Rs)</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                    <script> var req_id=[];</script>
                    @foreach($requests as $index => $request)
                    <tr id="dataRow{{$index}}">
                        <td>
                           {{$loop->iteration}}
                        </td>
                        <td>
                            @if(@$request->created_at)
                                <span class="text-muted">{{@$request->created_at}}</span>
                            @else
                                -
                            @endif
                        </td>
                        
                        <td>
                            @if(@$request->updated_at)
                               
                                    <span class="text-muted">{{@$request->updated_at}}</span>
    
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ @$request->booking_id }}</td>
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
                                <div class='edit'>
                                    {{ @$request->item->rec_mobile}} 
                                </div>
                                <input type='text' class='txtedit' value="{{@$request->item->rec_mobile}}" id='rec_mobile-{{$request->id}}'>
                            @else
                                <div class='edit'>
                                    0
                                </div>
                                <input type='text' class='txtedit' value="0" id='rec_mobile-{{$request->id}}'>
                            @endif
                        </td>
                        <td>
                            @if(@$request->distance)
                                {{ @$request->distance }} 
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if(@$request->provider->first_name)
                                {{ @$request->provider->first_name }} 
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if($request->status)
                                <div class='edit'>
                                @if($request->status=="REJECTED")
                                        @if($request->returned)
                                            RETURNED (Rejected
                                        @elseif($request->returned_to_hub == 1 && $request->returned == 0)
                                            R.WAREHOUSE
                                        @else
                                            TOBERETURNED (Rejected)
                                        @endif
                                    @elseif($request->status=="CANCELLED")
                                        @if($request->returned)
                                            RETURNED (Cancelled)
                                        @else
                                            TOBERETURNED (Cancelled)
                                        @endif
                                    @elseif($request->status=="SORTCENTER")
                                        {{ @$request->status}} 
                                        @if($request->dispatchList)
                                            @if($request->dispatchList->received==1)
                                                ({{ @$request->zone_2->zone_name }})
                                            @else
                                                ({{ @$request->zone_1->zone_name }})
                                            @endif
                                        @endif
                                    @else
                                        {{ @$request->status}} 
                                    @endif
                                </div>
                                @if($request->status=="PENDING"||$request->status=="ACCEPTED")
                                <select class='txtedit' id='status-{{$request->id}}'>
                                    <option <?php if($request->status=="CANCELLED"){echo 'selected';} ?>>CANCELLED</option>
                                </select>
                                @else
                                <div class='txtedit'>
                                @if($request->status=="REJECTED")
                                        @if($request->returned)
                                            RETURNED (Rejected
                                        @elseif($request->returned_to_hub == 1 && $request->returned == 0)
                                            R.WAREHOUSE
                                        @else
                                            TOBERETURNED (Rejected)
                                        @endif
                                    @elseif($request->status=="CANCELLED")
                                        @if($request->returned)
                                            RETURNED (Cancelled)
                                        @else
                                            TOBERETURNED (Cancelled)
                                        @endif
                                    @elseif($request->status=="SORTCENTER")
                                        {{ @$request->status}}
                                        @if($request->dispatched)
                                            @if($request->dispatchList->received==1)
                                                ({{ @$request->zone_2->zone_name }})
                                            @else
                                                ({{ @$request->zone_1->zone_name }})
                                            @endif
                                        @endif
                                    @else
                                        {{ @$request->status}} 
                                    @endif
                                </div>
                                @endif
                                {{--<input type='text' class='txtedit' value="{{@$request->status}}" id='status-{{$index}}'>--}}
                            @else
                                <div class='edit'>
                                N/A
                                </div>
                                <select class='txtedit' id='status-{{$index}}'>
                                    <option <?php if($request->status=="CANCELLED"){echo 'selected';} ?>>CANCELLED</option>
                                </select>
                            @endif
                        </td>
                        <td>{{$request->weight}}</td>
                        <td style="width:4%;">
                            @if($request->cargo)
                                <label class="switch">
                                    <input type="checkbox" class="cargo" @if(isset($request->cargo)) @if(@$request->cargo=='1') checked @endif @endif id='cargo-{{$index}}'>
                                    <span class="slider round"></span>
                                </label>
                            @else
                                <label class="switch">
                                    <input type="checkbox" value="{{$request->cargo}}" class="cargo" id='cargo-{{$request->id}}'>
                                    <span class="slider round"></span>
                                </label>
                            @endif
                        </td>
                        <td>
                            {{-- @if($request->payment != "")
                            {{ currency($request->payment->total) }} --}}
                            @if($request->amount_customer)
                                <div>
                                    {{ @$request->amount_customer}} 
                                </div>
                            @else
                                <div>
                                0
                                </div>
                            @endif
                        </td>
                        <td>
                            @if($request->cod)
                                <div>
                                    {{ @$request->cod}} 
                                </div>
                                {{-- <input type='text' class='txtedit' value="{{@$request->cod}}" id='cod-{{$index}}'> --}}
                            @else
                                <div>
                                0
                                </div>
                                {{-- <input type='text' class='txtedit' value="0" id='cod-{{$index}}'> --}}
                            @endif  
                        </td>
                        <td>
                            @if($request->special_note)
                                <div>
                                    {{ @$request->special_note}} 
                                </div>
                              
                            @else
                                <div>
                                N/A
                                </div>
                              
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                {{-- <button type="button" class="btn btn-secondary btn-rounded btn-primary waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> --}}
                                    Action
                                </button>
                                <div class="dropdown-menu ">
                                    <a href="{{ route('support.order_details', $request->id) }}" class="dropdown-item">
                                        <i class="fa fa-search"></i> More Details
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>S.N</th>
                        <th>Date</th>
                        <th>Last Update</th>
                        <th>ID</th>
                        <th>User</th>
                        <th>Pickup Add.</th>
                        <th>Pickup No.</th>
                        <th>DropOff Add.</th>
                        <th>DropOff Name</th>
                        <th>DropOff No.</th>
                        <th>Km</th>
                        <th>Rider</th>
                        <th>Status</th>
                        <th>Weight</th>
                        <th>Cargo</th>
                        <th>Fare</th>
                        <th>COD(Rs)</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>

                {{$requests->links('vendor.pagination.bootstrap-4')}}

                @else
                <hr>
                <p style="text-align: center;">No Order Available</p>
                @endif
            </div>
        </div>
    </div>
</div>


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

            //confirm(edit_id+" ---> "+field_name+"="+value);
            
            if(field_name=="rec_mobile" && !confirm("Are you sure, you want to change \""+value+"\" Dropoff No.?")){
                $(this).hide();
                $(this).prev('.edit').show();
                return;
            }
            if(field_name=="status" && !confirm("Are you sure, you want to cancel order?")){
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
                url: "{{url('/support/dropoff_no/')}}"+"/"+edit_id,
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
                    alert("Error! Please refresh page");
                }
            });
            
        });

    });
</script>


<script>
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
                url: "{{url('support/changeCargo')}}/"+edit_id,
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
        });
    });
</script>
@endsection
@section('scripts')

    @include('user.layout.partials.datatable')

@endsection