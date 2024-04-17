@extends('admin.layout.master')

@section('title', 'Drivers')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-1">
                        <i class="mdi mdi-bike"></i> &nbsp;{{$title}} Valley Patner Info
                    </h5>
                </div>
                <div class="col-md-4 d-flex justify-content-end">
                    <form class="form-inline pull-right" method="get" action={{url('admin/providerSearch')}}>
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
                @if (count($providers) != 0)
                <table id="datatable" class="table table-bordered"
                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <!--<th>Total Ride</th>
                    <th>Accepted Ride</th>
                    <th>Cancelled Ride</th>-->
                    <th>New Payable</th>
                    <th>Documents</th>
                    <th>Online</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($providers as $index => $provider)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><a href="provider/{{$provider->id}}/log">{{ @$provider->first_name }}</a></td>
                    <td>{{ @$provider->email }}</td>
                    <td>{{ @$provider->mobile }}</td>
                    <!--<td>{{ @$provider->total_requests }}</td>
                    <td>{{ @$provider->accepted_requests }}</td>
                    <td>{{ @$provider->total_requests - @$provider->accepted_requests }}</td>-->
                    <td>{{@$provider->newPayable}}</td>
                    <td>
                        @if(@$provider->pending_documents() > 0 || @$provider->service == null)
                            <a class="btn btn-secondary btn-danger" href="{{route('admin.provider.document.index', $provider->id )}}"><span>{{ @$provider->pending_documents() }} Doc! </span></a>
                        @else
                            <a class="btn btn-secondary btn-success" href="{{route('admin.provider.document.index', $provider->id )}}">All Set!</a>
                        @endif
                    </td>
                    <td>
                        @if(@$provider->service)
                            @if(@$provider->service->status == 'active')
                                <label class="btn btn-secondary btn-primary">Yes</label>
                            @else
                                <label class="btn btn-secondary btn-warning">No</label>
                            @endif
                        @else
                            <label class="btn btn-secondary btn-danger">N/A</label>
                        @endif
                    </td>
                    <td>
                        <div class="input-group-btn">
                            {{--
                            @if(@$provider->status == 'approved')
                            <a class="btn btn-secondary btn-danger btn-block" href="{{ route('admin.provider.disapprove', $provider->id ) }}"><i class="fa fa-ban"></i></a>
                            @else
                            <a class="btn btn-secondary btn-success btn-block" href="{{ route('admin.provider.approve', $provider->id ) }}"><i class="fa fa-check"></i></a>
                            @endif--}}
                            <button type="button" 
                                class="btn btn-secondary btn-secondary btn-block dropdown-toggle"
                                data-toggle="dropdown">Action
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('admin.provider.request', $provider->id) }}" class="btn btn-default"><i class="fa fa-search"></i> Details</a>
                                </li>
                                <li>
                                   <a href="{{ route('admin.provider.request', $provider->id) }}" class="btn btn-default"><i class="fa fa-search"></i> Payment Log </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.provider.edit', $provider->id) }}" class="btn btn-default"><i class="far fa-edit"></i> Edit Profile</a>
                                </li>
                                <!-- <li>
                                    <form action="{{ route('admin.provider.destroy', $provider->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button class="btn btn-default look-a-like" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i> Delete</button>
                                    </form>
                                </li> -->
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <!--<th>Total Requests</th>
                    <th>Accepted Requests</th>
                    <th>Cancelled Requests</th>-->
                    <th>NewPayable</th>
                    <th>Documents</th>
                    <th>Online</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
        <div style="display: flex;justify-content: center;"> 
            <b>Load More (Total: {{@$providers->total()}})</b>
        </div>
        <div style="display: flex;justify-content: center;"> 
            {{@$providers->links('vendor.pagination.bootstrap-4') }}
        </div>
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

