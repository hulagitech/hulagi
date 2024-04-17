@extends('admin.layout.base')

@section('title', 'Users ')

@section('content')
<div class="content-area py-1">
        <div class="box box-block bg-white">
            <h5 class="mb-1"></h5><span class="s-icon"><i class="ti-user"></i></span>&nbsp;Users Info</h5>
            <hr/>
            <table class="table table-striped table-bordered dataTable" id="table-2" style="width:100%;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Total Order</th>
                        <th>Last 7 days Order</th>
                        <th>Status</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Wallet Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->first_name }}</td>
                        <td>{{$user->totalOrder}}</td>
                        <td>
                            {{$user->status}}
                        </td>
                        @if($user->settlement)
                        <td>
                            <span class="btn btn-warning btn-primary">Settled</span>
                            <span style="color:Red;">Amount:{{$user->settlement->amount}}</span>
                        </td>
                        @elseif( $user->status)
                        <td> <span class="btn btn-Success btn-primary">Active</span>  </td>
                        @else
                        <td> <span class="btn btn-danger btn-primary">Inactive</span></td>
                        @endif
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->mobile }}</td>
                        <td>{{ currency($user->newPayment) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Total Order</th>
                        <th>Last 7 days Order</th>
                        <th>Status</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Wallet Amount</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection