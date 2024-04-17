@extends('support.layout.master')

@section('title', 'All Order Comment')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h4 class="page-title m-0">{{@$tickets[0]->user->first_name}} All Tickets</h4>
                </div>
                <div class="col-md-8 justify-content-end d-flex ">
                    <a href="{{ url('support/user_add_ticket/' . @$tickets[0]->user->id) }}"
                        style="padding: 6px 20px 6px 20px;" class="btn btn-success pull-right btn-secondary">+ &nbsp;  Add</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body table-responsive">
                @if (count($tickets)>0)
                
                <table id="datatable" class="table table-bordered"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                    <thead>
                        <tr>
                            <th> S.N </th>
                            <th> Refered Dept. </th>
                            <th> <i class="ti-ticket"></i> Title </th>
                            <th> Priority </th>
                            <th> Status </th>
                            <th width="10%"> Created By </th>
                            <th width="10%"> </th>
                            <th> Action </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($tickets as $index => $ticket)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>
                                @if (@$ticket->dept_id !== 0)
                                <div> {{ $ticket->dept->dept }} </div>
                                @else
                                <div> {{ $ticket->department }} </div>
                                @endif
                            </td>

                            <td>{{ $ticket->title }}</td>

                            <td>
                                @if (@$ticket->priority == 'urgent')
                                <div style="color:red;"> Urgent </div>
                                @elseif(@$ticket->priority=="high")
                                <div> High </div>
                                @elseif(@$ticket->priority=="medium")
                                <div> Medium </div>
                                @elseif(@$ticket->priority=="low")
                                <div> Low </div>
                                @endif
                            </td>

                            <td>
                                @if ($ticket->status == 'open')
                                <div style="color:green;"> Open </div>
                                @else
                                <div style="color:red;"> Close </div>
                                @endif
                            </td>

                            <td>
                                @if (@$ticket->createdby_cs == '1')
                                <div>CS</div>
                                @else
                                <div>User</div>
                                @endif
                            </td>

                            <td>{{ $ticket->created_at->diffForHumans() }}</td>

                            <td style="position:relative;">
                                <a href="{{ url('support/user_ticket_comment/' . $ticket->id) }}"
                                    class="btn btn-success btn-secondary"><i class="ti-comment"></i></a>


                                @if ($ticket->noComment != '0')
                                <span class="tag tag-danger" style="position:absolute; top:0px;"> {{$ticket->noComment}} </span>
                                @else
                                <span> </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    
                </table>
                @else
                <hr>
                <p style="text-align: center;">No Ticket </p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

@include('user.layout.partials.datatable')

@endsection

{{-- @extends('support.layout.base')

@section('title', 'All Order Comment')

@section('content')
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <h5 class="mb-1">

                <i class="fa fa-ticket"></i>&nbsp;User All Tickets
            </h5>


            <div>

            </div>
            <table class="table table-striped table-bordered dataTable" id="table-2" style="width:100%;">
                <thead>
                    <tr>
                        <th> S.N </th>
                        <th> Refered Dept. </th>
                        <th> <i class="ti-ticket"></i> Title </th>
                        <th> Priority </th>
                        <th> Status </th>
                        <th width="10%"> Created By </th>
                        <th width="10%"> </th>
                        <th> Action </th>
                    </tr>
                </thead>

                @if (isset($tickets))
                <tbody>
                    @foreach ($tickets as $index => $ticket)
                    <tr>
                        <td>{{ $index + 1 }}</td>

                        <td>
                            @if (@$ticket->dept_id !== 0)
                            <div> {{ $ticket->dept->dept }} </div>
                            @else
                            <div> {{ $ticket->department }} </div>
                            @endif
                        </td>

                        <td>{{ $ticket->title }}</td>

                        <td>
                            @if (@$ticket->priority == 'urgent')
                            <div style="color:red;"> Urgent </div>
                            @elseif(@$ticket->priority=="high")
                            <div> High </div>
                            @elseif(@$ticket->priority=="medium")
                            <div> Medium </div>
                            @elseif(@$ticket->priority=="low")
                            <div> Low </div>
                            @endif
                        </td>

                        <td>
                            @if ($ticket->status == 'open')
                            <div style="color:green;"> Open </div>
                            @else
                            <div style="color:red;"> Close </div>
                            @endif
                        </td>

                        <td>
                            @if (@$ticket->createdby_cs == '1')
                            <div>CS</div>
                            @else
                            <div>User</div>
                            @endif
                        </td>

                        <td>{{ $ticket->created_at->diffForHumans() }}</td>

                        <td style="position:relative;">
                            <a href="{{ url('support/user_ticket_comment/' . $ticket->id) }}"
                                class="btn btn-success btn-secondary"><i class="ti-comment"></i></a>


                            @if ($ticket->noComment != '0')
                            <span class="tag tag-danger" style="position:absolute; top:0px;">{{ style =
                                'position:absolute; top:0px;' > $ticket->noComment }}</span>
                            @else
                            <span> </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection --> --}}