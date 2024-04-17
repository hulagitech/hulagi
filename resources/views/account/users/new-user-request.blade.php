@extends('account.layout.base')

@section('title', $page)

@section('content')

    <style type="text/css">

    </style>

    <div class="content-area py-1">
        <div class="container-fluid">
            <div class="box box-block bg-white">
                <h3>{{ $page }}</h3>

                <div class="row">

                    <div class="row row-md mb-2" style="padding: 15px;">
                        <div class="col-md-12">
                            <div class="">
                                <div class="box-block clearfix">
                                    {{-- <h5 class="float-xs-left">Earnings</h5> --}}
                                    {{--<div class="float-xs-right">
                                        <form class="form-inline pull-right" method="POST"
                                            action="{{ url('account/statement/user') }}">
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="searchField"
                                                    placeholder="Full Search">
                                            </div>
                                            <div class="form-group">
                                                <button name="search" class="btn btn-success">Search</button>
                                            </div>
                                        </form>
                                    </div>--}}
                                </div>

                                @if (count($users) != 0)
                                    <table class="table table-striped table-bordered dataTable" id="table-2" width="100%">
                                        <thead>
                                            <tr>
                                                <td>Name</td>
                                                <td>Mobile</td>
                                                <td>Total Order</td>
                                                <th>Status</th>
                                                <td>Payment Requested Done</td>
                                                <td>Actions</td>
                                                {{-- <td>Add Excel File</td> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $diff = ['-success', '-info', '-warning', '-danger']; ?>
                                            @foreach ($users as $index => $user)
                                                <tr>
                                                    <td>
                                                        <a href="{{url('account/statement/user/'.$user->id.'/request')}}">
                                                            {{ $user->first_name }}
                                                            {{ $user->last_name }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        {{ $user->mobile }}
                                                    </td>
                                                    <td>
                                                        {{ $user->totalOrder }}
                                                    </td>
                                                    <td>
                                                        @if($user->status)
                                                        <span class="btn btn-success btn-primary">Active </span>
                                                    @else
                                                        <span class="btn btn-danger btn-primary">Inactive</span>
                                                    @endif
                                                   </td>
                                                   <td>{{$user->payment_request_count}}</td>
                                                    
                                                    <td>
                                                            <a href="{{url('account/statement/user/details/'.$user->id)}}">
                                                                <button type="button"
                                                                class="btn btn-secondary btn-rounded btn-success waves-effect">
                                                                Details
                                                            </button>
                                                            </a>
                                                    </td>
                                                </tr>
                                                <!-- Model Start -->

                                            @endforeach

                                        <tfoot>
                                            <tr>
                                                <td>Name</td>
                                                <td>Mobile</td>
                                                <td>Total Order</td>
                                                <th>Status</th>
                                                <td>Payment Requested Done</td>
                                                <td>Actions</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                @else
                                    <h6 class="no-result">No results found</h6>
                                @endif

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
