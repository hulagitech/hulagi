@extends('dispatcher.layout.master')

@section('title', 'Recent Trips ')

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
                        <h5 class="mb-1"> <i class="fa fa-recycle"></i> In Coming Received / Detail</h5>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end">
                            {{-- @if(isset($dates))
                        <form class="form-inline pull-right" method="POST" action={{url('admin/dateSearch')}}>
                            {{csrf_field()}}
                            <div class="form-group">
                                <input type="text" class="form-control" name="searchField" placeholder="Full Search">
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="date">
                                    <option>All</option>
                                @foreach ($dates as $date)
                                    <option {{(isset($current) && $current['date']==$date)? "selected": ""}} value={{$date}}>{{$date}}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="status">
                                    <option {{(isset($current) && $current['status']=="All")? "selected": ""}}>All</option>
                                    <option {{(isset($current) && $current['status']=="PENDING")? "selected": ""}}>PENDING</option>
                                    <option {{(isset($current) && $current['status']=="SCHEDULED")? "selected": ""}}>SCHEDULED</option>
                                    <option {{(isset($current) && $current['status']=="COMPLETED")? "selected": ""}}>COMPLETED</option>
                                    <option {{(isset($current) && $current['status']=="REJECTED")? "selected": ""}}>REJECTED</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button name="search" class="btn btn-success">Search</button>
                            </div>
                        </form>
                    @endif--}}
        
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
                    <table id="datatable-buttons" class="table table-bordered"
                        								style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>ID</th>
                                <th>Last Update</th>
                                <th>User</th>
                                <th>Pickup Add.</th>
                                <th>Pickup No.</th>
                                <th>DropOff Add.</th>
                                <th>DropOff Name</th>
                                <th>DropOff No.</th>
                                {{-- <th>Rider</th> --}}
                                <th>Vendor Remarks</th>
                                {{-- <th>Receive</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                       <script> var req_id=[];</script>
                        @foreach($requests as $index => $request)
                            <tr id="dataRow{{$index}}">
                                <td>
                                    @if(@$request->request->created_at)
                                        <span class="text-muted">{{@$request->request->created_at}}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ @$request->request->booking_id }}</td>
                                <td>
                                    @if(@$request->request->updated_at)
                                        <span class="text-muted">{{@$request->request->updated_at}}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->request->user)
                                        {{ @$request->request->user->first_name }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->request->s_address)
                                        {{ @$request->request->s_address }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->request->user->mobile)
                                        {{ @$request->request->user->mobile }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->request->d_address)
                                        {{ @$request->request->d_address }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                 <td>
                                    @if(@$request->request->item->rec_name)
                                        {{ @$request->request->item->rec_name}} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->request->item->rec_mobile)
                                        {{ @$request->request->item->rec_mobile }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->request->special_note)
                                        {{ @$request->request->special_note}} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                {{-- <td>
                                    <a class="received btn btn-info" style="color: #fff;" name="received-{{$request->id}}"> <i class="fa fa-arrow-down"></i> Receive</a>
                                    <span style="color: orange; display:none;" class="checkreceived"><i class="fa fa-check"></i></span>
                                </td> --}}
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Date</th>
                                <th>ID</th>
                                <th>Update On</th>
                                <th>User</th>
                                <th>Pickup Add.</th>
                                <th>Pickup No.</th>
                                <th>DropOff Add.</th>
                                <th>DropOff Name</th>
                                <th>DropOff No.</th>
                                {{-- <th>Rider</th> --}}
                                <th>Vendor Remarks</th>
                                {{-- <th>Receive</th> --}}
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

            //confirm(edit_id+" ---> "+field_name+"="+value);
            
            if(field_name=="provider" && !confirm("Are you sure, you want to Assign \""+value+"\" rider?")){
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
                url: "{{url('/dispatcher/rider_assign/')}}"+"/"+edit_id,
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


@endsection

@section('styles')
    <style type="text/css">
        .dispatcher-nav li span {
            /* // background-color: transparent; */
            color: #000!important;
            padding: 5px 12px;
        }

        .dispatcher-nav li span:hover,
        .dispatcher-nav li span:focus,
        .dispatcher-nav li span:active {
            background-color: #20b9ae;
            color: #fff!important;
            padding: 5px 12px;
        }

        .dispatcher-nav li.active span,
        .dispatcher-nav li span:hover,
        .dispatcher-nav li span:focus,
        .dispatcher-nav li span:active {
            background-color: #20b9ae;
            color: #fff!important;
            padding: 5px 12px;
        }
    </style>
@endsection
 @section('scripts')

    @include('user.layout.partials.datatable')

@endsection
