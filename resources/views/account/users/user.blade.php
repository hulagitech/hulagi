@extends('account.layout.master')

@section('title', 'User')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-print-none">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0"> User wallet</h4>
                </div>
                
            </div>
            
        </div>
    </div>
</div>
<div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
                 <table id="datatable-buttons" class="table table-bordered"
                        								style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>User Name</th>
                            <th>phone Number</th>
                            <th>Email</th>
                            <th>Total Order</th>
                            <th>Status</th>
                            <th>User Wallet</th>
                            <th>New Payable</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                
                    <tbody>
                    @foreach($users as  $index => $user)
                    <tr>
                            <th>{{$index+1}}</th>
                            <th>{{$user->first_name}}</th>
                            <th>{{$user->mobile}}</th>
                            <th>{{$user->email}}</th>
                            <th>{{$user->totalOrder}}</th>
                            @if($user->status)
                                <td><span class="btn btn-success btn-primary">Active </span> </td>
                            @else
                                <td><span class="btn btn-danger btn-primary">In Active </span> </td>
                            @endif
                            <th>{{$user->wallet_balance}}</th>
                            <th>{{ $users[$index]->newPayment}}</th>
                            @if($user->Settlement)
                            <th><span class="btn btn-success btn-rounded">Settled </span> <span> Settle Amount : {{$user->Settlement->amount}}</span></th>
                            @else
                            <th><a href="{{ url('account/user/settle/'.$user->id) }} " onclick="return confirm('Are you sure, you want to Settle this User ?')" class= "btn btn-danger btn-rounded">Sttelement</a></th>
                            @endif
                        </tr>
                        @endforeach

                    </tbody>
                
            </table>
                </div>

            </div>
        </div>
    </div>
</div>
                
@endsection
@section('scripts')

    @include('user.layout.partials.datatable')

@endsection