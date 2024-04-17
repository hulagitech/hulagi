@extends('bm.layout.master')

@section('title', 'Recent Trips ')

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
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h4 class="page-title m-0">Order by date</h4>
                </div>
                <div class="col-md-8 d-flex justify-content-end">
                    @if(isset($dates))
                    <form class="form-inline pull-right" method="POST" action={{url('bm/recent-trips')}}>
                        {{csrf_field()}}
                        <div class="form-group">
                            <input type="text" class="form-control" name="searchField" placeholder="Full Search">
                        </div>
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
                                <option {{(request()->status && request()->status=="SORTCENTER")? "selected":
                                    ""}}>SORTCENTER</option>
                                <option {{(request()->status && request()->status=="DELIVERING")? "selected":
                                    ""}}>DELIVERING</option>
                                <option {{(request()->status && request()->status=="CANCELLED")? "selected":
                                    ""}}>CANCELLED</option>
                                <option {{(request()->status && request()->status=="SCHEDULED")? "selected":
                                    ""}}>SCHEDULED</option>
                                <option {{(request()->status && request()->status=="REJECTED")? "selected":
                                    ""}}>REJECTED</option>
                                <option {{(request()->status && request()->status=="COMPLETED")? "selected":
                                    ""}}>COMPLETED</option>

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
                            <th>Last Update</th>
                            <th>User</th>
                            <th>Pickup Add.</th>
                            <th>Pickup Number</th>
                            <th>DropOff Add.</th>
                            <th>DropOff Name</th>
                            <th>DropOff Number</th>
                            <th>Rider</th>
                            <th>Status</th>
                            <th>Cargo</th>
                            <th>COD(Rs)</th>
                            <th>Remarks</th>

                            <th>Recent Comment</th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        <script>
                            var req_id=[];
                        </script>
                        @foreach($requests as $index => $request)
                        <script>
                            req_id.push(<?php echo $request->id; ?>);
                        </script>
                        <tr id="dataRow{{$index}}">
                            <td>
                                @if(@$request->created_at)
                                <span class="text-muted">{{@$request->created_at}}</span>
                                @else
                                -
                                @endif
                            </td>
                            <td>{{ @$request->booking_id }}</td>

                            <td>
                                @if(@$request->updated_at)
                                @if(@$request->status=="PENDING" || @$request->status=="ACCEPTED")
                                <span class="text-muted">{{@$request->updated_at->diffForHumans()}}</span>
                                @else
                                <span class="text-muted">{{@$request->updated_at}}</span>
                                @endif
                                @else
                                -
                                @endif
                            </td>
                            <td>
                                @if(@$request->user)
                                {{ @$request->user->first_name }}
                                @else
                                N/A
                                @endif
                            </td>
                            <td>
                                @if(@$request->s_address)
                                {{ @$request->s_address }}
                                @else
                                N/A
                                @endif
                            </td>
                            <td>
                               @if(@$request->Pickedup_number)
                            {{ @$request->Pickedup_number }}(P)
                            @elseif(@$request->user->mobile)
                                {{ @$request->user->mobile }}
                            @else
                                N/A
                            @endif
                            </td>
                            <td>
                                @if(@$request->d_address)
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
                            {{-- <td>
                                @if(@$request->distance)
                                {{ @$request->distance }}
                                @else
                                N/A
                                @endif
                            </td> --}}
                            <td>
                                @if(@$request->provider)
                                <div class='edit'>
                                    {{ @$request->provider->first_name}}
                                </div>
                                <select class='txtedit' id='provider-{{@$index}}'>
                                    <option>N/A</option>
                                    @foreach($totalRiders as $rider)
                                    <option value={{$rider['id']}} <?php if($request->
                                        provider==$rider['first_name']){echo 'selected';} ?>>{{$rider['first_name']}}
                                    </option>
                                    @endforeach
                                </select>
                                {{--<input type='text' class='txtedit' value="{{@$request->status}}"
                                    id='status-{{@$index}}'>--}}
                                @else
                                <div class='edit'>
                                    N/A
                                </div>
                                <select class='txtedit' id='provider-{{@$index}}'>
                                    <option>Select Rider</option>
                                    @foreach($totalRiders as $rider)
                                    <option value={{$rider['id']}} <?php if(@$request->
                                        provider==$rider['first_name']){echo 'selected';} ?>>{{@$rider['first_name']}}
                                    </option>
                                    @endforeach
                                </select>
                                @endif
                            </td>
                            <td>
                                @if(@$request->status)
                                <div class='edit'>
                                    @if(@$request->status=="REJECTED")
                                    @if(@$request->returned)
                                    RETURNED (Rejected
                                    @elseif(@$request->returned_to_hub == 1 && @$request->returned == 0)
                                    R.WAREHOUSE
                                    @else
                                    TOBERETURNED (Rejected)
                                    @endif
                                    @elseif(@$request->status=="CANCELLED")
                                    @if(@$request->returned)
                                    RETURNED (Cancelled)
                                    @else
                                    TOBERETURNED (Cancelled)
                                    @endif
                                    @elseif(@$request->status=="SORTCENTER")
                                    {{ @@$request->status}}
                                    @if(@$request->dispatched)
                                    ({{ @@$request->zone_1->zone_name }})
                                    @else
                                    ({{ @@$request->zone_2->zone_name }})
                                    @endif
                                    @else
                                    {{ @@$request->status}}
                                    @endif
                                </div>
                                <select class='txtedit' id='status-{{@$index}}'>
                                    <option <?php if(@$request->status=="SORTCENTER"){echo 'selected';} ?>>SORTCENTER
                                    </option>
                                    <option <?php if(@$request->status=="DELIVERING"){echo 'selected';} ?>>DELIVERING
                                    </option>
                                    <option <?php if(@$request->status=="COMPLETED"){echo 'selected';} ?>>COMPLETED
                                    </option>
                                    <option <?php if(@$request->status=="SCHEDULED"){echo 'selected';} ?>>SCHEDULED
                                    </option>
                                    <option <?php if(@$request->status=="REJECTED"){echo 'selected';} ?>>REJECTED
                                    </option>

                                </select>
                                {{--<input type='text' class='txtedit' value="{{@@$request->status}}"
                                    id='status-{{@$index}}'>--}}
                                @else
                                <div class='edit'>
                                    N/A
                                </div>
                                <select class='txtedit' id='status-{{@$index}}'>
                                    <option <?php if(@$request->status=="SORTCENTER"){echo 'selected';} ?>>SORTCENTER
                                    </option>
                                    <option <?php if(@$request->status=="DELIVERING"){echo 'selected';} ?>>DELIVERING
                                    </option>
                                    <option <?php if(@$request->status=="COMPLETED"){echo 'selected';} ?>>COMPLETED
                                    </option>
                                    <option <?php if(@$request->status=="SCHEDULED"){echo 'selected';} ?>>SCHEDULED
                                    </option>
                                    <option <?php if(@$request->status=="REJECTED"){echo 'selected';} ?>>REJECTED
                                    </option>

                                </select>
                                @endif
                            </td>
                             <td style="width:4%;">
                            @if(@$request->cargo)
                                <label class="switch">
                                    <input type="checkbox" class="cargo" @if(isset($request->cargo)) @if(@$request->cargo=='1') checked @endif @endif id='cargo-{{$index}}' disabled>
                                    <span class="slider round"></span>
                                </label>
                            @else
                                <label class="switch">
                                    <input type="checkbox" value="{{@$request->cargo}}" class="cargo" id='cargo-{{@$request->id}}' disabled>
                                    <span class="slider round"></span>
                                </label>
                            @endif
                        </td>
                            <td>
                                @if(@$request->cod)
                                <div class='edit'>
                                    {{ @@$request->cod}}
                                </div>
                                <input type='text' class='txtedit' value="{{@@$request->cod}}" id='cod-{{@$index}}'>
                                @else
                                <div class='edit'>
                                    0
                                </div>
                                <input type='text' class='txtedit' value="0" id='cod-{{@$index}}'>
                                @endif
                            </td>

                            {{--
                            <td>{{ @$request->payment_mode }}</td>
                            <td>
                                @if(@$request->paid)
                                Paid
                                @else
                                Not Paid
                                @endif
                            </td> --}}

                            <td>
                                @if(@$request->special_note)
                                <div class='edit'>
                                    {{ @$request->special_note}}
                                </div>
                                <input type='text' class='txtedit' value="{{@$request->special_note}}"
                                    id='special_note-{{@$index}}'>
                                @else
                                <div class='edit'>
                                    N/A
                                </div>
                                <input type='text' class='txtedit' value="N/A" id='special_note-{{@$index}}'>
                                @endif
                            </td>

                            <td>
                                @if(@$request->RecentComment)
                                {{ @$request->RecentComment->comments}}
                                @else
                                N/A
                                @endif
                            </td>
                            <td style="position:relative;" class="row">
                                <a href="{{ route('bm.order_detail', @$request->id) }}"
                                    class="btn btn-success shadow-box m-2"> <i class="ti-comment"></i> </a>

                                {{-- Count Comment Notification --}}
                                @if(@$request->noComment != '0')
                                <span class="tag tag-danger"
                                    style="position:absolute; top:0px;">{{@$request->noComment}}</span>
                                @else
                                <span> </span>
                                @endif
                                @if(@$request->status=="DISPATCHED")
                                <a class="received btn btn-info m-2" style="color: #fff;"
                                    name="received-{{$request->id}}"> <i class="fa fa-arrow-down"></i></a>
                                <span style="color: orange; display:none;" class="checkreceived"><i
                                        class="fa fa-check"></i></span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Date</th>
                            <th>ID</th>
                            <th>Last Update</th>
                            <th>User</th>
                            <th>Pickup Add.</th>
                            <th>Pickup Number</th>
                            <th>DropOff Add.</th>
                            <th>DropOff Name</th>
                            <th>DropOff Number</th>
                            <th>Rider</th>
                            <th>Status</th>
                            <th>Cargo</th>
                            {{-- <th>Km</th>
                            <th>Fare</th> --}}
                            <th>COD(Rs)</th>
                            <th>Remarks</th>

                            <th>Recent Comment</th>
                            <th> Action </th>
                        </tr>
                    </tfoot>
                </table>
                <div style="display: flex;justify-content: center;">
                    <b>Load More (Total: {{@$requests->total()}})</b>
                </div>
                <div style="display: flex;justify-content: center;">
                    {{ @$requests->appends(\Request::except('page'))->links() }}
                </div>
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
                url: "{{url('bm/requests')}}/"+req_id[edit_id],
                type: 'put',
                data: field_name+"="+value,
                success:function(response){
                    console.log(response); 
                    if(response.showError){
                        alert(response.error);
                    }
                    alert("Success !!");
                     $.jnoty("Success", {
                            life: 1000,
                            theme: 'jnoty-success',
                            
                        });
                    //toastr["info"]("I was launched via jQuery!");    
                        
                    // showToastr("Success !!");
                    // if(!response.error){
                    //     showToastr("Success !!");
                    //     setTimeout(response, 3000);
                    // }
                    // $.jnoty("Your order is placed successfully", {
                    //     life: 5000,
                    //     header: 'Success',
                    //     theme: 'jnoty-success',
                    //     icon: 'fa fa-check-circle fa-2x'
                    // });
                },
                error: function (request, error) {
                    console.log(request);
                    alert("Error! Please refresh page and check if rider is unset.");
                }
            });
            // console.log($(this).html());
            if(field_name=="status" && value=="CANCELLED"){
                if(!confirm("Add this item to return list?")){
                    $.ajax({
                        url: "{{url('bm/requests')}}/"+req_id[edit_id],
                        type: 'put',
                        data: field_name+"=RETURNED",
                        success:function(response){
                             $.jnoty("Success", {
                            life: 1000,
                            theme: 'jnoty-success',
                            
                        });
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
                }
                else{
                    $.ajax({
                        url: "{{url('bm/requests')}}/"+req_id[edit_id],
                        type: 'put',
                        data: field_name+"=TOBERETURNED",
                        success:function(response){
                            console.log(response); 
                             $.jnoty("Success", {
                            life: 1000,
                            theme: 'jnoty-success',
                            
                        });
                            if(response.showError){
                                alert(response.error);
                            }
                        },
                        error: function (request, error) {
                            console.log(request);
                            alert("Error! Please refresh page and check if rider is unset.");
                        }
                    });
                }
            }
        });
    });
</script>



@endsection
@section('scripts')

@include('user.layout.partials.datatable')

@endsection
