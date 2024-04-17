@extends('support.layout.master')

@section('title', 'Users ')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h4 class="page-title m-0">Users</h4>
                </div>
                <div class="col-md-8 justify-content-end d-flex row">
                    <form class="form-inline pull-right" method="GET" action={{url('support/userSearch')}}>
                        {{csrf_field()}}
                        <div class="form-group">
                            <input type="text" class="form-control" name="searchField" placeholder="Full Search">
                        </div>


                        <div class="form-group">
                            <button name="search" class="btn btn-success">Search</button>
                        </div>
                    </form>
                    {{-- <a href="{{ route('support.user.create') }}" style="margin-left: 1em;" class="btn btn-secondary btn-rounded btn-success pull-right"><i class="fa fa-plus"></i> Add New User</a> --}}
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
                            <th>Name</th>
                            <th>Total Order</th>
                            <th>Status</th>
                            <th>Company Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Business/Person</th>
                            <th>Agreement</th>
                            {{-- <th>Rating</th> --}}
                            {{-- <th>Wallet Amount</th> --}}
                            <th > Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->first_name }}</td>
                            <td>
                                <a href="{{ route('support.user.request', $user->id) }}">{{$user->totalOrder}}</a></td>
                            @if($user->status)
                            <td> <span class="btn btn-success btn-primary">Active</span> </td>
                            @else
                            <td><span class="btn btn-danger btn-primary">Inactive </span></td>
                            @endif

                            <td>{{ $user->company_name }}</td>
                            @if(Setting::get('demo_mode', 0) == 1)
                            <td>{{ substr($user->email, 0, 3).'****'.substr($user->email, strpos($user->email, "@")) }}
                            </td>
                            @else
                            <td>{{ $user->email }}</td>
                            @endif
                            @if(Setting::get('demo_mode', 0) == 1)
                            <td>+919876543210</td>
                            @else
                            <td>{{ $user->mobile }}</td>
                            @endif
                            <td>@if($user->Business_Person)
                                {{$user->Business_Person}}
                                @else
                                Person
                                @endif
                            </td>
                            <td>{{$user->Agreement}}</td>
                            {{-- <td>{{ $user->rating }}</td> --}}
                            {{-- <td>{{ currency($user->wallet_balance) }}</td> --}}
                            <td class="row">
                                {{-- <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST"> --}}
                                    {{-- {{ csrf_field() }} --}}
                                    {{-- <input type="hidden" name="_method" value="DELETE"> --}}
                                    {{-- <a href="{{ route('support.user.request', $user->id) }}"
                                        class="btn btn-info"><i class="fa fa-search"></i></a> --}}
                                    <a href="{{ route('support.user.edit', $user->id) }}"
                                        class="btn btn-pink"><i class="mdi mdi-pencil-outline"></i></a>
                                    <a href="{{ route('support.user.order', $user->id) }}"
                                        class="btn btn-success"><i class="ion ion-md-add"></i></a>
                                    {{-- <button class="btn btn-secondary btn-danger"
                                        onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>
                                    --}}
                                    {{--
                                </form> --}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Total Order</th>
                            <th>Status</th>
                            <th>Company Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Business/Person</th>
                            <th>Agreement</th>
                            {{-- <th>Rating</th> --}}
                            {{-- <th>Wallet Amount</th> --}}
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
                {{$users->links('vendor.pagination.bootstrap-4')}}

                @else
                <hr>
                <p style="text-align: center;">No Pickup Rider Info Available</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

    @include('user.layout.partials.datatable')

@endsection

