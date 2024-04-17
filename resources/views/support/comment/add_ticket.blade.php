@extends('support.layout.master')

@section('title', 'Add New Ticket')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0">Add new ticket</h4>
                </div>

            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form" id="payment_info" method="POST" action="{{ url('support/create_ticket') }}">
                    {{ csrf_field() }}
                    {{-- {{ method_field('POST') }} --}}
                    <div class="row ">
                        <label for="title" style="top:7px;" class="col-lg-2">User Name</label>
                        <div class="col-lg-10">

                            <h5> {{ $user->first_name }} </h5>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="title" style="top:7px;" class="col-lg-2">Title</label>
                        <div class="col-lg-10">
                            <input type="text" id="title" name="title" class="form-control" placeholder="Title"
                                required>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="description" style="top:7px;" class="col-lg-2">Description</label>
                        <div class="col-lg-10">
                            <textarea name="description" id="description" cols="30" rows="5" class="form-control"
                                required> </textarea>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="dept_id" style="top:7px;" class="col-lg-2">Department</label>
                        <div class="col-lg-10">
                            <select name="dept_id" class="form-control" id="dept_id" required>
                                @foreach ($depts as $dept)
                                <option value="{{$dept->id}}">{{$dept->dept}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="dept_id" style="top:7px;" class="col-lg-2">Priority</label>
                        <div class="col-lg-10">
                            <select name="priority" id="priority" class="form-control" required>
                                        <option value="">Select Priority</option>
                                        <option value="urgent">Urgent</option>
                                        <option value="high">High</option>
                                        <option value="medium">Medium</option>
                                        <option value="low">Low</option>
                                    </select>
                        </div>
                    </div>

                    {{-- <div class="form-group">
                        <input type="hidden" id="user_id" name="user_id" value="{{ $user->id }}"
                            class="form-control">
                        <button type="submit" name="submit" class="btn btn-success">Submit</button>
                        <a href="{{url('support/add_newticket')}}" class="btn btn-danger">Cancel</a>
                    </div> --}}
                    <div class="form-group text-right">
                        <a href="{{ url('ticket') }}" class="btn btn-danger">Cancel</a>
                        <input type="hidden" id="user_id" name="user_id" value="{{ $user->id }}"
                        class="form-control">
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection




{{-- @extends('support.layout.base')

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

                        <form class="form" id="payment_info" method="POST" action="{{ url('support/create_ticket') }}">
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
                                    <input type="text" id="title" name="title" class="form-control" placeholder="Title"
                                        required>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="description" style="top:7px;" class="col-lg-1">Description</label>
                                <div class="col-lg-5">
                                    <textarea name="description" id="description" cols="30" rows="5"
                                        class="form-control" required> </textarea>
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
                                <input type="hidden" id="user_id" name="user_id" value="{{ $user->id }}"
                                    class="form-control">
                                <button type="submit" name="submit" class="btn btn-success">Submit</button>
                                <a href="{{url('support/add_newticket')}}" class="btn btn-danger">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



@endsection --}}