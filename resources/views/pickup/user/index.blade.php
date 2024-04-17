@extends('pickup.layout.master')

@section('title', 'Order details  ')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Users</h4>
                    </div>
                    <div class="col-md-4 justify-content-end d-flex">
                        <form class="form-inline pull-right" method="GET" action={{url('pickup/userSearch')}}>
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input type="text" class="form-control" name="searchField" placeholder="Full Search" style="border-radius: .25rem 0 0 0.25rem;">
                            </div>
                            <div class="form-group">
                                <button name="search" class="btn btn-primary" style="padding: 7px 12px 8px;border-radius: 0 .25rem 0.25rem 0;">Search</button>
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
                                    <th>Name</th>
                                    <th>Company Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->first_name }}</td>
                                    
                                    <td>{{ $user->company_name }}</td>
                                    @if(Setting::get('demo_mode', 0) == 1)
                                    <td>{{ substr($user->email, 0, 3).'****'.substr($user->email, strpos($user->email, "@")) }}</td>
                                    @else
                                    <td>{{ $user->email }}</td>
                                    @endif
                                    @if(Setting::get('demo_mode', 0) == 1)
                                    <td>+919876543210</td>
                                    @else
                                    <td>{{ $user->mobile }}</td>
                                    @endif
                                    {{-- <td>{{ $user->rating }}</td> --}}
                                    {{-- <td>{{ currency($user->wallet_balance) }}</td> --}}
                                    <td>
                                        {{-- <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST"> --}}
                                            {{-- {{ csrf_field() }} --}}
                                            {{-- <input type="hidden" name="_method" value="DELETE"> --}}
                                            {{-- <a href="{{ route('pickup.user.request', $user->id) }}" class="btn btn-primary "><i class="dripicons-search"></i></a> --}}
                                            <a href="{{ route('pickup.user.order', $user->id) }}" class="btn btn-secondary btn-success"> <i class="mdi mdi-library-plus"></i> new Order</a>
                                            {{-- <button class="btn btn-secondary btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button> --}}
                                        {{-- </form> --}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Company Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
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