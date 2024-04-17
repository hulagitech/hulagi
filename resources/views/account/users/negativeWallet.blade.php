@extends('account.layout.base')
@section('title', $page)
@section('content')
<style type="text/css">
</style>
    <div class="content-area py-1">
        <div class="container-fluid">
            <div class="box box-block bg-white">
            	<h3>Negative Wallet User statement</h3>
            	<div class="row">
                    <div class="row row-md mb-2" style="padding: 15px;">
                        <div class="col-md-12">
                            <div class="">
                                <div class="box-block clearfix">
                                    <div class="float-xs-right">
                                        <form class="form-inline pull-right" method="POST" action="{{ route('account.ride.negative.wallet') }}">
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
                                @if(count($users) != 0)
                                    <table class="table table-striped table-bordered dataTable" id="table-2" width="100%">
                                        <thead>
                                            <tr>
                                                <td>Name</td>
                                                <td>Mobile</td>
                                                <td>Total Orders</td>
                                                <td>Remaining Payment</td>
                                                <td>New Payment</td>
                                                <td>Payment Logs</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $diff = ['-success','-info','-warning','-danger']; ?>
                                                @foreach($users as $index => $user)
                                                {{-- @if ($user->wallet_balance<0||$user->new_payment<0) --}}
                                                    <tr>
                                                        <td>
                                                            <a href="user/{{$user->id}}/request">
                                                            {{$user->first_name}} 
                                                            {{$user->last_name}}
                                                            </a>
                                                        </td>
                                                        <td>
                                                            {{$user->mobile}}
                                                        </td>	
                                                        <td>
                                                            @if($user->rides_count)
                                                                {{$user->rides_count}}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        
                                                        <td>
                                                            @if($user->payment)
                                                                {{$user->wallet_balance}}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{@$user->newPayment}}
                                                        </td>
                                                        
                                                        
                                                        <td>
                                                            <a href="user/{{$user->id}}" class="btn btn-primary">View Payment</a>
                                                        </td>
                                                       
                                                        
                                                    </tr>
                                                    <!-- Model Start -->
                                                    {{-- @endif --}}
                                                @endforeach
                                        <tfoot>
                                            <tr>
                                                <td>Name</td>
                                                <td>Mobile</td>
                                                <td>Total Orders</td>
                                                <td>Remaining Payment</td>
                                                <td>New Payment</td>
                                                <td>Payment Logs</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                @else
                                {{$users->links('vendor.pagination.bootstrap-4')}}
                                <h6 class="no-result">No results found</h6>
                                @endif 
                            </div>
                        </div>
                    </div>
            	</div>
            </div>
        </div>
    </div>

@endsection
