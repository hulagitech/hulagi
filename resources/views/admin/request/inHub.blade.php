@extends('admin.layout.base')

@section('title', 'Orders In Hub')

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
            <h5 class="mb-1"> <i class="fa fa-recycle"></i> Returned "Orders In Sortcenter" </h5>
            {{-- <div style="display: flex;">
                <form class="form-inline pull-right" method="POST" action={{url('admin/dateSearch')}}>
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
                            <option {{(request()->status && request()->status=="PENDING")? "selected": ""}}>PENDING</option>
                            <option {{(request()->status && request()->status=="PICKEDUP")? "selected": ""}}>PICKEDUP</option>
                            <option {{(request()->status && request()->status=="ACCEPTED")? "selected": ""}}>ACCEPTED</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button name="search" class="btn btn-success">Search</button>
                    </div>
                </form>
            </div> --}}
            
            <hr/>
            

            @if(count(@$all_inHub) != 0)
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
                            <th>Rider</th>
                            <th>Return Rider</th>
                            <th>Status</th>
                            {{-- <th>COD(Rs)</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach(@$all_inHub as $index => $inHub)
                            <tr id="dataRow{{$index}}">
                                <td>
                                    @if(@$inHub->created_at)
                                        <span class="text-muted">{{@$inHub->created_at->format('Y-m-d')}}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ @$inHub->booking_id }}</td>
                                <td>
                                    @if(@$inHub->user)
                                        {{ @$inHub->user->first_name }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$inHub->s_address)
                                        {{ @$inHub->s_address }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$inHub->user->mobile)
                                        {{ @$inHub->user->mobile }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$inHub->d_address)
                                        {{ @$inHub->d_address }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$inHub->item->rec_name)
                                        {{ @$inHub->item->rec_name}} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$inHub->item->rec_mobile)
                                        {{ @$inHub->item->rec_mobile }} 
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(@$inHub->provider->first_name)
                                        {{ @$inHub->provider->first_name }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$inHub->returnRider)
                                        <div class='edit'>
                                            {{ @$inHub->returnRider->first_name}} 
                                        </div>
                                        <select class='txtedit' id='return_rider-{{@$inHub->id}}'>
                                            <option>N/A</option>
                                            @foreach(@$totalRiders as $rider)
                                                <option value={{@$rider['id']}} <?php if(@$inHub->returnRider==$rider['first_name']){echo 'selected';} ?>>{{@$rider['first_name']}}</option>
                                            @endforeach
                                        </select>
                                        {{--<input type='text' class='txtedit' value="{{@$request->status}}" id='status-{{$index}}'>--}}
                                    @else
                                        <div class='edit'>
                                        N/A
                                        </div>
                                        <select class='txtedit' id='return_rider-{{@$inHub->id}}'>
                                            <option>Select Rider</option>
                                            @foreach(@$totalRiders as $rider)
                                                <option value={{@$rider['id']}} <?php if(@$inHub->returnRider==$rider['first_name']){echo 'selected';} ?>>{{@$rider['first_name']}}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </td>
                                <td>
                                    @if(@$inHub->status)
                                        {{ @$inHub->status }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                {{-- <td>
                                    @if($inHub->cod)
                                        {{ @$inHub->cod}}
                                    @else
                                        -
                                    @endif 
                                </td> --}}

                                <td>
                                    <div style="display:flex;">
                                        <a href="#" class="return_complete btn btn-primary" name="returned-{{@$inHub->id}}">Return Completed</a>
                                        <span style="color: orange; display:none;" class="checked"><i class="fa fa-check"></i></span>
                                        {{-- &nbsp;
                                        <a href="{{url('admin/printInvoice/'.$inHub->id)}}" target="_blank" class="btn btn-primary">Returned</a> --}}
                                    </div>
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
                            <th>Rider</th>
                            <th>Return Rider</th>
                            <th>Status</th>
                            {{-- <th>COD(Rs)</th> --}}
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
@endsection


<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
        $(document).ready(function(){
            $(".return_complete").click(function(){
                //if(confirm('Are you sure, you want to Inbound ?')){ 
                    $(this).hide();
                    $(this).next(".checked").show();
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
                        url: "{{url('admin/returnCompleted')}}/"+req_id,
                        type: 'post',
                        success:function(response){
                            console.log(response);
                        },
                        error: function (request, error) {
                            console.log(request);
                            alert(" Return rider has not assign !!! "+error);
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
            var req_id = split_id[1];
            var value = $(this).val();
            //alert(req_id+" ---> "+field_name+" = "+value);
            
            if(field_name=="return_rider" && !confirm("Are you sure to assign \""+$("option:selected", this).text()+"\"?")){
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
                url: "{{url('admin/returnRider')}}/"+req_id,
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

