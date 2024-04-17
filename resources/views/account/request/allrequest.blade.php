@extends('account.layout.master')

@section('title', 'Total Reques')

@section('content')
<div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h4 class="page-title m-0">Total Requested Till Now</h4>
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
                                                <td>Vendor Name</td>
                                                <td>Mobile</td>
                                                <td>Total Order</td>
                                                <th>Status</th>
                                                <td>Requested at</td>
                                                <td>Requested Amount</td>
                                                <td>Wallet Amount</td>
                                                <td>Payment Requested</td>
                                                <td>Actions</td>
                                                {{-- <td>Add Excel File</td> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $diff = ['-success', '-info', '-warning', '-danger']; ?>
                                            @foreach ($users as $index => $user)
                                                <tr>
                                                    <td>
                                                        <a href="statement/user/{{ $user->id }}/request">
                                                            {{ $user->first_name }}
                                                            {{ $user->last_name }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        {{ $user->mobile }}
                                                    </td>
                                                    <td>
                                                        {{ $user->totalOrder }}
                                                    </td>
                                                   
                                                    @if($user->status)
                                                        <td> <span class="btn btn-success btn-primary">Active</span> </td>
                                                    @else
                                                        <td> <span class="btn btn-danger btn-primary">Inactive </span></td>
                                                    @endif
                                                  
                                                    
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
                                                        {{ $user->newPayment}}
                                                    </td>
                                                  
                                                    <td>
                                                        @if ($user->requested_at && $user->requested_at->is_paid == false)
                                                            <span class="tag tag-danger">Yes</span>
                                                        @else
                                                            <span class="tag tag-success">No</span>
                                                        @endif
                                                    </td>
                                                    {{-- <td>
                                                        <form method="POST" action="update/{{ $user->id }}">
                                                            {{ csrf_field() }}
                                                            <input type="number" class="form-control" name="paid" /> <br />
                                                            <input type="text" class="form-control" name="remarks"
                                                                placeholder="Remarks if available" />
                                                            <button type="submit" class='btn btn-primary'>Payment
                                                                Done</button>
                                                        </form>
                                                    </td> --}}
                                                    
                                                    <td>
                                                            <a href="statement/user/details/{{ $user->id }}">
                                                                <button type="button"
                                                                class="btn btn-secondary btn-rounded btn-success waves-effect">
                                                                Details
                                                            </button>
                                                            </a>
                                                    </td>
                                                </tr>
                                                <!-- Model Start -->

                                            @endforeach

                                        <tfoot>
                                            <tr>
                                                <td>Name</td>
                                                <td>Mobile</td>
                                                <td>Total Order</td>
                                                <th>Status</th>
                                                <td>Requested at</td>
                                                <td>Requested Amount</td>
                                                <td>Wallet Amount</td>
                                                <td>Payment Requested</td>
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
</div>
@endsection
