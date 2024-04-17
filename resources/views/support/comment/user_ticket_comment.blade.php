@extends('support.layout.base')

@section('styles')
    <link rel="stylesheet" href="{{asset('main/vendor/jvectormap/jquery-jvectormap-2.0.3.css')}}">
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
@endsection





@section('content')

<div class="content-area py-1">

<div class="container-fluid">
    <div class="dash-content">
        <div class="row no-margin ride-detail">
            
            <div class="col-md-12">

                @if($ticket->count() > 0)
                    <div class="accordian-body">
                        <div class="col-md-12" style="background-color:#f5f5f5; padding:30px 20px 20px 20px;">
                            <div class="from-to row no-margin">
                                <div style="display:flex; font-size:12px; padding-left:5px;">
                                    <h4> <i class="ti-ticket"></i> {{ $ticket->title }} </h4>
                                </div>
                                <div style="display:flex; font-size:12px; padding-left:10px;">
                                    User:&nbsp;<b> {{$ticket->user->first_name}} </b> &nbsp; - &nbsp; {{$ticket->created_at->diffForHumans()}} &nbsp; - &nbsp; Priority:&nbsp;
                                    @if(@$ticket->priority=="urgent")
                                        <div style="color:red;"><b> Urgent </b></div>
                                    @elseif(@$ticket->priority=="high")
                                        <div><b> High </b></div>
                                    @elseif(@$ticket->priority=="medium")
                                        <div><b> Medium </b></div>
                                    @elseif(@$ticket->priority=="low")
                                        <div><b> Low </b></div>
                                    @else
                                        <div style="color:red;"><b> - </b></div>
                                    @endif
                                </div>

                                {{-- Edit Department --}}
                                <div style="display:flex; font-size:12px; padding-left:10px;">
                                    Department: &nbsp;
                                    <div class="edit">
                                        @if(@$ticket->dept_id!==0)
                                            <div style="color: maroon;"><b> {{$ticket->dept->dept}} </b></div>
                                        @else
                                            <div style="color: maroon;"><b> {{$ticket->department}} </b></div>
                                        @endif
                                    </div>
                                    
                                    <select class="txtedit col-md-3" id='department-{{$ticket->id}}'>
                                        @foreach ($depts as $dept)
                                            <option value="{{$dept->id}}" {{$ticket->dept_id==$dept->id?"selected":null}}> {{$dept->dept}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                            </div><br>
                            <div style="padding-left:10px;"> 
                                <div class="col-md-12"><h6> {{ $ticket->description }} </h6></div>

                                <div class="col-md-12">
                                    <div class="col-md-2" style="float:right;">
                                        <form method="POST" action="{{url('support/user_closeOpen/'.$ticket->id)}}">
                                            {{ csrf_field() }}
                                            
                                            @if($ticket->status=="open")
                                                <input type="hidden" name="status" id="status" value="close">
                                                <button type="submit" onclick="return confirm('Are you sure, you want to close?');" class=" btn btn-primary form-control">Close <i class="fa fa-ticket"></i></button>
                                            @else
                                                <input type="hidden" name="status" id="status" value="open">
                                                <button type="submit" onclick="return confirm('Are you sure, you want to close?');" class=" btn btn-primary form-control">Open <i class="fa fa-ticket"></i></button>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- User Comment Section -->
                        <div class="col-md-8">
                            <div class="col-lg-12" style="overflow-y:auto; margin-top:20px;"> <i class="fa fa-comments"></i> <b><i style="font-weight:bold; font-size:14px;">Comments:</i></b> </div>
                        
                            @if($comments != '0')
                                @foreach($comments as $comment)
                                <div class="col-lg-12" style="margin:5px 0px;">
                                    <div class="col-lg-12" style="background-color: #F5F5F5; padding:15px 15px 15px 17px;">
                                        <div style="display:flex; flex:1; justify-content:space-between;">
                                            @if(@$comment->dept_id!==0)
                                                <div><b> {{@$comment->dept->dept}} </b></div>
                                            @elseif($comment->dept_id==0 && $comment->is_read_user==0)
                                                <div><b> User </b></div>
                                            @else
                                                <div><b> {{@$comment->authorised_type}} </b></div>
                                            @endif

                                            <div> {{ @$comment->created_at->diffForHumans() }} </div>
                                        </div>
                                        <div style="padding-top:7px;">
                                            - {{ @$comment->comment }}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @endif 
                                
                            <!-- <div class="col-lg-12"> -->
                            <form method="POST" action="{{ url('support/ticket_reply/'.$ticket->id) }}">
                                {{ csrf_field() }}
                                <div class="col-lg-10">
                                    <input type="text" name="cs_comment" id="cs_comment" class="form-control" placeholder="Add Your Comment ...">
                                </div>
                                <div class="col-lg-2">
                                    <button type="submit" class="btn btn-primary form-control" style="font-size:14px;">Post</button>
                                </div>
                            </form>
                        </div>
                    </div>         


                @else
                    <hr>
                    <p style="text-align: center;">No Ticket Available</p>
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
                url: "{{url('/support/edit_department/')}}"+"/"+edit_id,
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

