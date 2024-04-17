@extends('user.layout.master')

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
                    <form class="form" id="payment_info" method="POST" action="{{ url('/ticket') }}">
                        {{ csrf_field() }}
                        {{-- {{ method_field('POST') }} --}}

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

                                <select name="dept_id" id="dept_id" style="height: 40px;" class="form-control" required>
                                    @foreach ($depts as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->dept }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <a href="{{ url('ticket') }}" class="btn btn-danger">Cancel</a>

                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
