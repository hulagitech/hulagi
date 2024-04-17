@extends('sortcenter.layout.master')

@section('title', 'All Tickets')
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
                    <form class="form" id="payment_info" method="POST"
                    action="{{ url('sortcenter/create_ticket') }}">
                        {{ csrf_field() }}
                        {{-- {{ method_field('POST') }} --}}

                        <div class="row form-group">
                            <label for="title" style="top:7px;" class="col-lg-2">User Name</label>
                            <div class="col-lg-10">
                                <h5 style="text-transform: capitalize"> {{ $user->first_name }} </h5>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="dept_id" style="top:7px;" class="col-lg-2"> Department </label>
                            <div class="col-lg-10">
                                <select name="dept_id" class="form-control" id="dept_id" required>
                                    @foreach ($depts as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->dept }}</option>
                                    @endforeach
                                </select>
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
                            <label for="priority" style="top:7px;" class="col-lg-2"> Priority </label>
                            <div class="col-lg-10">
                                <select name="priority" class="form-control" id="priority" required>
                                    <option value="">Select Priority</option>
                                    <option value="urgent">Urgent</option>
                                    <option value="high">High</option>
                                    <option value="medium">Medium</option>
                                    <option value="low">Low</option>
                                </select>
                            </div>
                        </div>




                        <div class="form-group text-right">
                            <a href="{{ url('sortcenter/newticket') }}" class="btn btn-danger">Cancel</a>

                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            <input type="hidden" id="user_id" name="user_id" value="{{ $user->id }}"
                                class="form-control">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

