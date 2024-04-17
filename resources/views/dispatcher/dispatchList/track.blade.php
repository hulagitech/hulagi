@extends('dispatcher.layout.master')

@section('title', 'Recent Trips ')

@section('content')


    <style>
        .txtedit {
            display: none;
            width: 99%;
            height: 30px;
        }

    </style>


    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Track Dispatched Order</h4>
                    </div>
                    <div class="col-md-4">
                        <div class="float-right">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
                    @if (isset($dates))
                        <form class="form-inline float-right mb-4" method="POST"
                            action={{ url('dispatcher/dispatchList/track') }}>
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input type="text" class="form-control" name="searchField" placeholder="Full Search">
                            </div>
                            <div class="form-group">
                                <button name="search" class="btn btn-success">Search</button>
                            </div>
                        </form>
                        
                    @endif

                    <div class="table-responsive">
                        @if (count($requests) != 0)
                            <table id="datatable" class="table table-bordered"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>ID</th>
                                        <th>Last Update</th>
                                        <th>User</th>
                                        <th>Pickup Add.</th>
                                        <th>Pickup Number</th>
                                        <th>DropOff Add.</th>
                                        <th>DropOff Name</th>
                                        <th>DropOff Number</th>
                                        <th>Dispatch Name</th>
                                        <th>Status</th>
                                        <th>Receive</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <script>
                                        var req_id = [];
                                    </script>
                                    @foreach ($requests as $index => $request)
                                        <script>
                                            req_id.push(<?php echo $request->id; ?>);
                                        </script>
                                        <tr id="dataRow{{ $index }}">
                                            <td>
                                                @if ($request->created_at)
                                                    <span class="text-muted">{{ $request->created_at }}</span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $request->booking_id }}</td>
                                            <td>
                                                @if ($request->updated_at)
                                                    @if ($request->status == 'PENDING' || $request->status == 'ACCEPTED')
                                                        <span
                                                            class="text-muted">{{ $request->updated_at->diffForHumans() }}</span>
                                                    @else
                                                        <span class="text-muted">{{ $request->updated_at }}</span>
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if (@$request->user)
                                                    {{ @$request->user->first_name }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if ($request->s_address)
                                                    {{ @$request->s_address }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if (@$request->user->mobile)
                                                    {{ @$request->user->mobile }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if ($request->d_address)
                                                    {{ @$request->d_address }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if (@$request->item->rec_name)
                                                    {{ @$request->item->rec_name }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if (@$request->item->rec_mobile)
                                                    {{ @$request->item->rec_mobile }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                {{ @$request->dispatchList->bulk->zone2->zone_name }}#{{ @$request->dispatchList->bulk->id }}
                                            </td>
                                            <td>
                                                @if (@$request->dispatchList->bulk->draft == 1)
                                                    <alert type="success">Draft</alert>
                                                @elseif(@$request->dispatchList->bulk->incomplete_received==1)
                                                    <div type="alert alert-danger">Incomplete Received</div>
                                                @elseif(@$request->dispatchList->bulk->received_all==1)
                                                    Received
                                                @else
                                                    Dispatch Ongoing
                                                @endif
                                            </td>
                                            <td>

                                                @if (@!$request->dispatchList->received)
                                                    <a class="received btn btn-info" style="color: #fff;"
                                                        name="received-{{ @$request->dispatchList->id }}"> <i
                                                            class="fa fa-arrow-down"></i> Receive</a>
                                                    <span style="color: orange; display:none;" class="checkreceived"><i
                                                            class="fa fa-check"></i></span>

                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <h6 class="no-result">No results found</h6>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        $(document).ready(function() {
            $(".received").click(function() {
                $(this).hide();
                $(this).next(".checkreceived").show();
                var id = this.name;
                var split_id = id.split("-");
                var field_name = split_id[0];
                var edit_id = split_id[1];
                console.log(edit_id);
                // $(this).hide();
                // $(this).next(".checkreceived").show();
                // var id = this.name;
                // var split_id = id.split("-");
                // var field_name = split_id[0];
                // var edit_id = split_id[1];
                var value = false;
                if (this.checked) {
                    value = true;
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('dispatcher/dispatchList/eachReceive') }}/" + edit_id,
                    type: 'post',
                    data: field_name + "=" + value,
                    success: function(response) {
                        if (response.showError) {

                        }
                        toastr.success("Success!!")
                    },
                    error: function(request, error) {
                        console.log(request);
                        alert(" Can't do!! Error" + error);
                    }
                });
            });
        });
    </script>

@endsection
@section('scripts')
    @include('user.layout.partials.datatable')

@endsection
