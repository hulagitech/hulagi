@extends('account.layout.base')

@section('styles')
    <link rel="stylesheet" href="{{asset('main/vendor/jvectormap/jquery-jvectormap-2.0.3.css')}}">
@endsection


<style>
    .table tr{
        padding-left:10px;
    }

    .txtedit{
        display: none;
        width: 99%;
        height: 30px;
    }
</style>


@section('content')

<div class="content-area py-1">

<div class="container-fluid">
    <div class="dash-content">
        <div class="row no-margin ride-detail">
            
            <div class="col-md-12">

                @if($comments->count() > 0)
                    <div class="accordian-body">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div style="background-color:#f5f5f5; padding:30px 20px 30px 20px;">
                                    <div class="from-to row no-margin">
                                        <table style="width:100%;">
                                            <tr>
                                                <th width="13%"><h4>Booking ID:</h4></th>
                                                @if(@$user_req->booking_id)
                                                    <td width="57%"><h4>{{@$user_req->booking_id}}</h4> </td>
                                                @else
                                                    <td> -- </td>
                                                @endif

                                                <th width="13%"></th>
                                                <td><h4 style="background: #00FA9A; text-align:center; padding:5px;">{{@$user_req->status}}</h4></td>
                                            </tr>
                                            <tr>
                                                <th><h6>User Name:</h6></th>
                                                @if(@$user_req->user->first_name)
                                                    <td><h6>{{@$user_req->user->first_name}}</h6> </td>
                                                @else
                                                    <td> -- </td>
                                                @endif
                                                
                                                <th><h6>COD:</h6></th>
                                                @if(@$user_req->cod)
                                                    <td><h6>{{@$user_req->cod}}</h6> </td>
                                                @else
                                                    <td> -- </td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th><h6>Pick-Up Location:</h6></th>
                                                @if(@$user_req->s_address)
                                                    <td><h6>{{@$user_req->s_address}}</h6> </td>
                                                @else
                                                    <td> -- </td>
                                                @endif
                                                
                                                <th><h6>Rider:</h6></th>
                                                @if(@$user_req->provider->first_name)
                                                    <td><h6>{{@$user_req->provider->first_name}}</h6> </td>
                                                @else
                                                    <td> -- </td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th><h6>Drop-Up Location:</h6></th>
                                                @if(@$user_req->s_address)
                                                    <td><h6>{{@$user_req->s_address}}</h6> </td>
                                                @else
                                                    <td> -- </td>
                                                @endif

                                                <th><h6>Rider Number:</h6></th>
                                                @if(@$user_req->provider->mobile)
                                                    <td><h6>{{@$user_req->provider->mobile}}</h6> </td>
                                                @else
                                                    <td> -- </td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th><h6>Receiver Name:</h6></th>
                                                @if(@$user_req->item->rec_name)
                                                    <td><h6>{{@$user_req->item->rec_name}}</h6> </td>
                                                @else
                                                    <td> -- </td>
                                                @endif

                                                <th><h6></h6></th>
                                                <td><h6></h6></td>
                                            </tr>
                                            <tr>
                                                <th><h6>Receiver Number:</h6></th>
                                                @if(@$user_req->item->rec_mobile)
                                                    <td><h6>{{@$user_req->item->rec_mobile}}</h6> </td>
                                                @else
                                                    <td> -- </td>
                                                @endif

                                                <th><h6></h6></th>
                                                <td>
                                                    @if($user_req->comment_status=="0")
                                                        <form method="POST" action="{{url('account/solved/'.$user_req->id)}}">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="status" id="status" value="1">
                                                            <button type="submit" onclick="return confirm('Are you sure, Is it solve?');"  class="btn btn-primary form-control">Solved</button>
                                                        </form>
                                                    @else
                                                        <form method="POST" action="{{url('account/unsolve/'.$user_req->id)}}">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="status" id="status" value="0">
                                                            <button type="submit" onclick="return confirm('Are you sure, you want to make unsolve?');" class="btn btn-primary form-control">Unsolve</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><h6> Department: </h6></th>
                                                <td colspan="3">
                                                    @if(@$user_req->dept_id!==0)
                                                        <div style="color: maroon;"><b> {{@$user_req->dept->dept}} </b></div>
                                                    @else
                                                        <div style="color: maroon;"><b> Customer Service </b></div>
                                                    @endif
                                                <td>

                                                {{-- <td colspan="3">
                                                    <div class="edit">
                                                        @if(@$user_req->dept_id!==0)
                                                            <div style="color: maroon;"><b> {{@$user_req->dept->dept}} </b></div>
                                                        @else
                                                            <div style="color: maroon;"><b> Customer Service </b></div>
                                                        @endif
                                                    </div>
                
                                                    <select class="txtedit col-md-3" id='department-{{$user_req->id}}'>
                                                        @foreach ($depts as $dept)
                                                            <option value="{{$dept->id}}" {{$user_req->dept_id==$dept->id?"selected":null}}> {{$dept->dept}} </option>
                                                        @endforeach
                                                    </select>
                                                </td> --}}
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- User Comment Section -->
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-lg-12" style="overflow-y:auto; margin-top:20px;"> <i class="fa fa-comments"></i> <b><i style="font-weight:bold; font-size:14px;">Comments:</i></b> </div>

                                    
                                    @foreach($comments as $comment)
                                    <div class="col-lg-12" style="margin:5px 0px;">
                                        <div class="col-lg-12" style="background-color: #F5F5F5; padding:15px 15px 15px 17px;">
                                            <div style="display:flex; flex:1; justify-content:space-between;">
                                                
                                                @if(@$comment->dept_id!==0)
                                                    @if(@$comment->dept->dept=='Dispatcher')
                                                        <div><b> {{@$comment->dept->dept}} - {{@$comment->zone}} </b></div>
                                                    @else
                                                        <div><b> {{@$comment->dept->dept}} </b></div>
                                                    @endif
                                                @elseif($comment->dept_id==0 && $comment->is_read_user==0)
                                                    <div><b> User </b></div>
                                                @else
                                                    <div><b> {{@$comment->authorised_type}} </b></div>
                                                @endif

                                                {{-- @if(@$comment->authorised_type=='cs')
                                                    <div> <b>CS</b> </div>
                                                @elseif(@$comment->authorised_type=='user')
                                                    <div> <b>User</b> </div>
                                                @elseif(@$comment->authorised_type=='admin')
                                                    <div> <b>Admin</b> </div>
                                                @elseif(@$comment->authorised_type=='rider')
                                                    <div> <b>Rider</b> </div>
                                                @endif --}}

                                                <div> {{ @$comment->created_at->diffForHumans() }} </div>
                                            </div>
                                            <div style="padding-top:7px;">
                                                - {{ @$comment->comments }}
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                                    <!-- <div class="col-lg-12"> -->
                                    <form method="POST" action="{{ url('account/order_reply/'.$user_req->id) }}">
                                        {{ csrf_field() }}
                                        <div class="col-lg-10">
                                            <input type="text" name="comment" id="comment" class="form-control" placeholder="Add Your Comment ...">
                                        </div>
                                        <div class="col-lg-2">
                                            <button type="submit" class="btn btn-primary form-control" style="font-size:14px;">Post</button>
                                        </div>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>

                    </div>         


                @else
                    <hr>
                    <p style="text-align: center;">No Comment Available</p>
                @endif

            </div>
        </div>
    </div>
</div>

</div>



<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- 
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

            //alert(edit_id+" ---> "+field_name+"="+value);
            
            if(field_name=="department" && !confirm("Are you sure, you want to change \""+$("option:selected", this).text()+"\" department?")){
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
                url: "{{url('account/edit_dept_order/')}}"+"/"+edit_id,
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
</script> --}}

@endsection