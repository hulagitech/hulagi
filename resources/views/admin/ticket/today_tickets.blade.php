@extends('admin.layout.master')

@section('title', 'Todays Ticket')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h4> <i class="fa fa-user"></i>&nbsp; Today's Tickets
                       
                    </h4>
                </div>
                <div class="col-md-8 d-flex justify-content-end">
                    
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body table-responsive">
                <table id="datatable-buttons" class="table table-bordered"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Created at:</th>
                            <th>User Name</th>
                            <th><i class="ti-ticket"></i>Title</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $index => $ticket)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>{{ $ticket->created_at->diffForHumans() }}</td>
                            <td>{{ @$ticket->user->first_name }}</td>
                            <td>{{ $ticket->title }}</td>
                            <td>{{ $ticket->description }}
                            </td>

                            <td style="position:relative;">
                                <a href="{{ url('admin/today_ticket_comment/'.$ticket->id) }}"
                                    class="btn btn-success btn-secondary"><i class="ti-comment"></i></a>

                                {{-- Count Comment Notification --}}
                                @if($ticket->noComment != '0')
                                <span class="tag tag-danger"
                                    style="position:absolute; top:0px;">{{$ticket->noComment}}</span>
                                @else
                                <span> </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $tickets->links('vendor.pagination.bootstrap-4') }}
            </div>

        </div>
    </div>
</div>
</div>
@endsection
@section('scripts')

@include('user.layout.partials.datatable')

@endsection
