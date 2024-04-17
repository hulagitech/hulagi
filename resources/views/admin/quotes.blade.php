@extends('admin.layout.master')

@section('title', 'Dispatcher ')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-1">
                        <i class="mdi mdi-bike"></i> &nbsp; Get Quotes Information
                    </h5>
                </div>
                <div class="col-md-4 d-flex justify-content-end">
                    {{-- <a href="{{ route('admin.fare.create') }}" style="margin-left: 1em;" class="btn btn-secondary btn-success btn-rounded pull-right"><i class="fa fa-plus"></i> Add New Plan</a> --}}
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body table-responsive">
                @if (count($quotes) != 0)
                <table id="datatable" class="table table-bordered"
            style="border-collapse: collapse; border-spacing: 0; width: 100%;">   
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quotes as $index => $quote)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ @$quote->name }}</td>
                    <td>{{ @$quote->email }}</td>
                    <td>{{ @$quote->phone }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
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
@section('scripts')

@include('user.layout.partials.datatable')

@endsection
@endsection
