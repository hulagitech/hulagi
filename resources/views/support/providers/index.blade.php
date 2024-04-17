@extends('support.layout.master')

@section('title', 'Drivers')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h4 class="page-title m-0">Patners Info</h4>
                </div>
                <div class="col-md-8 justify-content-end d-flex row">
                    <form class="form-inline pull-right" method="get" action={{url('support/providerSearch')}}>
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
                            <th>Documents</th>
                            <th>Online</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($providers as $index => $provider)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ @$provider->first_name }}</td>
                            <td>{{ @$provider->email }}</td>
                            <td>{{ @$provider->mobile }}</td>
                            <!--<td>{{ @$provider->total_requests }}</td>
                            <td>{{ @$provider->accepted_requests }}</td>
                            <td>{{ @$provider->total_requests - @$provider->accepted_requests }}</td>-->
                            <td>
                                @if(@$provider->pending_documents() > 0 || @$provider->service == null)
                                    <a class="btn btn-secondary btn-danger" ><span>{{ @$provider->pending_documents() }} Doc! </span></a>
                                @else
                                    <a class="btn btn-secondary btn-success" > Set!</a>
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
                                    @if(@$provider->status == 'approved')
                                    <a class="btn btn-secondary btn-success btn-block" href="{{ route('support.disapprove', $provider->id ) }}"><i class="fa fa-check"></i> {{@$provider->status}} </a>
                                    @else
                                    <a class="btn btn-secondary btn-danger btn-block" href="{{ route('support.approve', $provider->id ) }}"><i class="fa fa-ban"></i>  {{@$provider->status}}</a>
                                    @endif
                                    <button type="button" 
                                        class="btn btn-secondary btn-secondary btn-block dropdown-toggle"
                                        data-toggle="dropdown">Action
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
    
                                        <li>
                                            <a href="{{ route('support.provider.edit', $provider->id) }}" class="btn btn-default"><i class="fa fa-pencil"></i> Edit Profile</a>
                                        </li>
                                        
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
                            <th>Documents</th>
                            <th>Online</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
                {{$providers->links('vendor.pagination.bootstrap-4')}}

                @else
                <hr>
                <p style="text-align: center;">No  Rider Info Available</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

    @include('user.layout.partials.datatable')

@endsection

       