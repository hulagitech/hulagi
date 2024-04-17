@extends('user.layout.master')
@section('styles')
    <link rel="stylesheet" href="{{ asset('main/vendor/jvectormap/jquery-jvectormap-2.0.3.css') }}">
@endsection
@section('content')

<div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Fare Plan List</h4>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
                        <table id="datatable" class="table table-bordered"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                <th>ID</th>
                                <th>Zone1</th>
                                <th>Zone2</th>
                                <th>Fare</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($fares as $index => $fare)
                    
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{@$fare->zone1->zone_name}}</td>
                                        <td>{{@$fare->zone2->zone_name}}</td>
                                        @if(Auth::user()->Business_Person=="Business")
                                        <td>Rs.{{@$fare->fare}}</td>
                                        @else
                                        <td>Rs.{{@$fare->fare*@$fare->Percentage_increase/100+@$fare->fare}}</td>
                                        @endif
                                        
                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                    <tr>
						<th>ID</th>
                        <th>Zone1</th>
                        <th>Zone2</th>
                        <th>Fare</th>
                    </tr>
                </tfoot>
                        </table>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @include('user.layout.partials.datatable')
@endsection