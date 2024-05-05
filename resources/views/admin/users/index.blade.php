@extends('admin.layout.master')

@section('title', 'Users ')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-1">
                        <i class="fa fa-recycle"></i> &nbsp;All User
                    </h5>
                </div>
                <div class="col-md-4 d-flex justify-content-end">
                    <form class="form-inline pull-right" method="get" action={{url('admin/userSearch')}}>
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
                @if (count($users) != 0)
                <table id="datatable" class="table table-bordered"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Domain Type User</th>
                            <th>Name</th>
                            <th>Total Order</th>
                            <th>7 days Order</th>
                            <th>Status</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Wallet Balance</th>
                            <th>Agreement</th>
                            <th>Type</th>
                            <th>Discount Percentage</th>
                            <th class="w-50">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><b>{{$user->user_type}}</b></td>
                            <td>{{ $user->first_name }}</td>
                            <td>{{ $user->total }}</td>
                            <td>
                                {{ $user->status }}
                            </td>
                            @if ($user->settlement)
                            <td>
                                <span class="btn btn-warning btn-success">Settled</span>
                                <span style="color:Red;">Amount:{{ $user->settlement->amount }}</span>
                            </td>
                            @elseif( $user->status)
                            <td> <span class="btn btn-Success btn-primary">Active</span> </td>
                            @else
                            <td> <span class="btn btn-danger btn-primary">Inactive</span></td>
                            @endif
                            <td>{{ $user->email }}</td>
                           
                            <td>{{ $user->mobile }}</td>
                            <td>{{ number_format($user->new_wallet($user->id),2) }}</td>

                            <td>{{ $user->Agreement }} <br> @if($user->Agreement=="YES"){{$user->agreement_Date}}<br>{{$user->remarks}}@endif</td>
                            <td>{{ $user->Business_Person ? $user->Business_Person : 'Person' }}
                            </td>
                            <td>{{ $user->discount_percentage }}</td>
                            <td>
                                <a href="{{ route('admin.user.request', $user->id) }}"
                                    class="btn btn-danger btn-primary m-1"><i class="fas fa-search"></i></a>
                                <a href="{{ route('admin.user.edit', $user->id) }}"
                                    class="btn btn-secondary btn-success m-1"><i class="mdi mdi-pencil"></i></a>
                                <a href="{{ route('admin.user.Chart', $user->id) }}"
                                    class="btn btn-secondary btn-primary m-1"><i class="fas fa-chart-area"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Domain Type User</th>
                            <th>Name</th>
                            <th>Total Order</th>
                            <th>7 days Order</th>
                            <th>Status</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Wallet Balance</th>
                            <th>Agreement</th>
                            <th>Type</th>
                            <th>Discount Percentage</th>
                            <th>Action</th>
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
@section('scripts')

@include('user.layout.partials.datatable')

@endsection