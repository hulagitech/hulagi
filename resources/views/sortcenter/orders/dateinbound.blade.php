@extends('sortcenter.layout.master')

@section('title', 'Inbound Orders')

@section('content')


<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h4 class="page-title m-0">Order by date</h4>
                </div>
                <div class="col-md-8 d-flex justify-content-end">
                    <form class="form-inline pull-right" method="GET" action={{url('sortcenter/inbound')}}>
                        {{csrf_field()}}
                        <div class="form-group">
                            <input type="text" class="form-control" name="searchField" placeholder="Full Search">
                        </div>
                        <div class="form-group">
                            <label for="from_date" style="padding-top:5px;"> Date: <label>
                                    <input type="date" class="form-control" name="date">
                        </div>
                        <div class="form-group">
                            <button name="search" class="btn btn-success">Search</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body table-responsive">
                @if (count($inbound) != 0)
                <table id="datatable" class="table table-bordered"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Date</th>
                            <th>Booking ID</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($inbound as $index => $bound)
                        <tr>
                            <td>
                                {{$index+1}}
                            </td>
                            <td>{{$bound->created_at}}</td>
                            <td>{{$bound->Booking_id}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>S.N</th>
                            <th>Date</th>
                            <th>Booking ID</th>
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

@endsection