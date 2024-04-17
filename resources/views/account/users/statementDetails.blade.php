@extends('account.layout.master')

@section('title', $page)

@section('content')
<div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h4 class="page-title m-0">{{ $page }}</h4>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end">
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
                                                <td>Name</td>
                                                <td>Mobile</td>
                                                <td>Total Orders</td>
                                                <td>Remaining Payment</td>
                                                <td>New Payment</td>
                                                <td>Requested at</td>
                                                <td>Requested Amount</td>
                                                <td>Payment Requested</td>
                                                <td>Make Payment</td>
                                                <td>Ations</td>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $diff = ['-success', '-info', '-warning', '-danger']; ?>
                                            @foreach ($users as $index => $user)
                                                <tr>
                                                    <td>
                                                        <a href="{{url('account/statement/user/'.$user->id.'/request')}}">
                                                            {{ $user->first_name }}
                                                            {{ $user->last_name }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        {{ $user->mobile }}
                                                    </td>
                                                    <td>
                                                        @if ($user->rides_count)
                                                            {{ $user->rides_count }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    {{-- <td>
																	@if ($user->payment)
																		{{currency($user->payment[0]->overall-$user->payment->alreadyPaid)}}
																	@else
																	 	-
																	@endif
																</td>
																<td>
																	@if ($user->payment)
																		{{currency($user->payment[0]->commission)}}
																	@else
																	 	-
																	@endif
																</td> --}}
                                                    <td>
                                                        @if ($user->payment)
                                                            <span class="text-muted">{{ $user->wallet_balance }}</span>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="text-success"> {{ number_format(@$user->newPayment,2) }}</span>
                                                    </td>
                                                    <td>
                                                        @if ($user->payment_req)
                                                            <span>{{ $user->requested_at->updated_at->diffForHumans() }}</span>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($user->payment_req)
                                                            <span
                                                                class="text-danger">{{ $user->payment_req->requested_amt }}</span>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                  
                                                    <td>
                                                        @if ($user->requested_at && $user->requested_at->is_paid == false)
                                                            <span class="tag tag-danger">Yes</span>
                                                        @else
                                                            <span class="tag tag-success">No</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <form method="POST" action="{{route('account.update.statement',$user->id)}}">
                                                            {{ csrf_field() }}
                                                            <input type="number" class="form-control" name="paid" /> <br /><br />
                                                            <input type="text" class="form-control" name="remarks"
                                                                placeholder="Remarks if available" /><br /><br />
                                                            <button type="submit" class='btn btn-primary'>Payment
                                                                Done</button>
                                                        </form>
                                                    </td>
                                                    <td style="text-align:center" width="18%">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <a href="{{route('account.statement.log',$user->id)}}">
                                                                       <span class="btn btn-sm btn-success">Log</span> 
                                                                    
                                                            </div>
                                                            <div class="col-md-4">
                                                                <a href="{{route('account.statement.payment',$user->id)}}" >
                                                                         <span class="btn btn-sm btn-primary">Payment</span> 
                                                                   
                                                                </a>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <a href="{{route('account.statement.log.order',$user->id)}}" >
                                                                          <span class="btn btn-sm btn-info">Order Log</span> 
                                                                
                                                                </a>
                                                            </div>
                                                        </div> 
                                                    </td>
                                                </tr>
                                            
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td>Name</td>
                                                <td>Mobile</td>
                                                <td>Total Orders</td>
                                                <td>Remaining Payment</td>
                                                <td>New Payment</td>
                                                <td>Requested at</td>
                                                <td>Requested Amount</td>
                                                <td>Payment Requested</td>
                                                <td>Make Payment</td>
                                                <td>Actions</td>
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
