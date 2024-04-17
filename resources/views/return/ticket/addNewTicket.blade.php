@extends('return.layout.base')

@section('styles')
    <link rel="stylesheet" href="{{asset('main/vendor/jvectormap/jquery-jvectormap-2.0.3.css')}}">
@endsection


<style>
    /* .table tr{
        padding-left:10px;
    } */
</style>


@section('content')

<div class="content-area py-1">

<div class="container-fluid">
    <div class="dash-content">
        <div class="row no-margin ride-detail">
            <div class="accordian-body">
                <div class="col-lg-12">
                    <h4 class="page-title"><i class="fa fa-ticket"></i> Add New Ticket </h4>
                    <hr>
                    <br>
                    <div class="row form-group">
                        <div class="col-lg-1">User Name</div>
                        <div class="col-lg-5">
                            <h5> {{ $user->first_name }} </h5>
                        </div>
                    </div>
                     
                    <form class="form" id="payment_info" method="POST" action="{{ url('return/create_ticket') }}">
                        {{ csrf_field() }}
                        
                        <div class="form-group row">
                            <label for="dept_id" class="col-lg-1 col-form-label"> Department </label>
                            <div class="col-lg-5">
                                <select name="dept_id" class="form-control" id="dept_id" required>
                                    @foreach ($depts as $dept)
                                        <option value="{{$dept->id}}">{{$dept->dept}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
    
                        <div class="row form-group">
                            <label for="title" style="top:7px;" class="col-lg-1">Title</label>
                            <div class="col-lg-5">
                                <input type="text" id="title" name="title" class="form-control" placeholder="Title" required>
                            </div>
                        </div>
    
                        <div class="row form-group">
                            <label for="description" style="top:7px;" class="col-lg-1">Description</label>
                            <div class="col-lg-5">
                                <textarea name="description" id="description" cols="30" rows="5" class="form-control" required> </textarea>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="description" style="top:7px;" class="col-lg-1">Priority</label>
                            <div class="col-lg-5">
                                <select name="priority" id="priority" class="form-control" required>
                                    <option value="">Select Priority</option>
                                    <option value="urgent">Urgent</option>
                                    <option value="high">High</option>
                                    <option value="medium">Medium</option>
                                    <option value="low">Low</option>
                                </select>
                            </div>
                        </div>
    
                        <div class="form-group">
                            <input type="hidden" id="user_id" name="user_id" value="{{ $user->id }}" class="form-control">
                            <button type="submit" name="submit" class="btn btn-success">Submit</button>
                            <a href="{{url('return/newticket')}}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</div>



@endsection