@extends('support.layout.master')

@section('title', 'Open Ticket Details')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Queries Detail</h4>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('support.transfer', $data->id) }}" method="POST" enctype="multipart/form-data"
                        role="form">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PATCH">
                        <div class="row form-group">
                            <div class="col-md-2 text-right">
                                <label for="first_name">Name</label>
                            </div>
                            <div class="col-md-10">
                                <span class="text-capitalize">{{ $data->name }}</span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2 text-right">
                                <label for="first_name">Email</label>
                            </div>
                            <div class="col-md-10">
                                <span>{{ $data->email }}</span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2 text-right">
                                <label for="first_name">Message</label>
                            </div>
                            <div class="col-md-10">
                                <span>{{ $data->message }}</span>
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="first_name">Transfer To Other
                                    Department</label>
                            </div>
                            <div class="col-md-10">
                                <select class="form-control" name="transfer" id="transfer" required>
                                    <option value=""> Please Select </option>
                                    <option value="1" {{ $data->transfer == 1 ? 'selected' : '' }}>Customer
                                        Relationship</option>
                                    <option value="2" {{ $data->transfer == 2 ? 'selected' : '' }}>Dispatcher
                                        Department</option>
                                    <option value="3" {{ $data->transfer == 3 ? 'selected' : '' }}>Account
                                        Department</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="first_name">Status</label>
                            </div>
                            <div class="col-md-10">
                                <select class="form-control" name="status" required>
                                    <option value=""> Please Select </option>
                                    <option value="1" {{ $data->status == 1 ? 'selected' : '' }}}>Open</option>
                                    <option value="0" {{ $data->status == 0 ? 'selected' : '' }}}>Close</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="first_name">Reply</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{ $data->reply }}" name="reply"
                                    required id="reply" placeholder="Reply">
                            </div>
                        </div>
                        <div class="row form-group align-items-center justify-content-end">
                            <a href="{{ route('support.openTicket', 'open') }}" class="btn btn-danger mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary mr-2">Reply</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



@endsection
