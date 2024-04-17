@extends('sortcenter.layout.master')

@section('title', 'Rider details ')

@section('content')

<style>
    .txtedit {
        display: none;
        width: 99%;
        height: 30px;
    }

    #weight {
        display: none;
    }
</style>
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h4 class="page-title m-0">Search rider</h4>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end">
                        <form class="form-inline pull-right" method="GET" action={{url('sortcenter/searchRider')}}>
                            {{csrf_field()}}
                            <div class="form-group">
                                <input type="text" class="form-control" name="searchField" placeholder="Full Search">
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
                    @if(count($riders) > 0)
                    <table id="datatable" class="table table-bordered"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>No of deliverying</th>
                                <th>No of schedule</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($riders as $index => $rider)
                            <tr id="dataRow{{$index}}">
                                <td>
                                    {{$index+1}}
                                </td>
                                <td>
                                    {{$rider->first_name}}
                                </td>
                                <td>{{$rider->mobile}}</td>
                                <td>
                                    <a href="rider/{{$rider->id}}/DELIVERING"
                                        style="color:black;">{{count($rider->delivering)}}</a>
                                </td>
                                <td>
                                    <a href="rider/{{$rider->id}}/SCHEDULED"
                                        style="color:black;">{{count($rider->schedule)}}</a>
                                </td>
                            </tr>
                            
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>SN</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>No of deliverying</th>
                                <th>No of schedule</th>
                            </tr>
                        </tfoot>
                    </table>
                    {{$riders->links('vendor.pagination.bootstrap-4')}}
                    @else
                    <h6 class="no-result">No results found</h6>
                    @endif
                </div>

            </div>
        </div>
    </div>


    @endsection
    @section('scripts')

    @include('user.layout.partials.datatable')

@endsection