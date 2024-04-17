@extends('support.layout.master')

@section('title', 'All Order Comment')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h4 class="page-title m-0">Close Ticket</h4>
                </div>
                <div class="col-md-8 justify-content-end d-flex row">

                </div>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body table-responsive">
                @if (count($tickets) != 0)
                <table id="datatable" class="table table-bordered"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th><i class="ti-ticket"></i> Title</th>
                            <th>Refered Dept.</th>
                            <th>User Name</th>
                            <th>Priority</th>
                            <th>Created By</th>
                            <th></th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $index => $ticket)
                        <tr>
                            <td>{{ $index+1 }}</td>

                            <td>{{ $ticket->title }}</td>

                            <td>
                                @if(@$ticket->dept_id!==0)
                                <div> {{$ticket->dept->dept}} </div>
                                @else
                                <div> {{$ticket->department}} </div>
                                @endif
                            </td>

                            <td>{{ @$ticket->user->first_name }}</td>

                            <td>
                                @if(@$ticket->priority=="urgent")
                                <div style="color:red;"> Urgent </div>
                                @elseif(@$ticket->priority=="high")
                                <div> High </div>
                                @elseif(@$ticket->priority=="medium")
                                <div> Medium </div>
                                @elseif(@$ticket->priority=="low")
                                <div> Low </div>
                                @else
                                <div> - </div>
                                @endif
                            </td>

                            <td>
                                @if(@$ticket->createdby_cs=='1')
                                <div>CS</div>
                                @else
                                <div>User</div>
                                @endif
                            </td>

                            <td>{{ @$ticket->created_at->diffForHumans() }}</td>

                            <td style="position:relative;">
                                <a href="{{ url('support/ticket_comment/'.$ticket->id) }}"
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
                {{-- {{$users->links('vendor.pagination.bootstrap-4')}} --}}

                @else
                <hr>
                <p style="text-align: center;">No data Fpound</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

@include('user.layout.partials.datatable')

@endsection