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
            <div class="card-body">
                  <h4>Payment Details</h4>
				<br>
                <div class="row">
                    <div class="col-md-6">
                        <h5>Khalti Info.</h5>
                        <br>
                        @if (isset($user->khaltiDetail))
                            <table>
                                <tr>
                                    <th style="width:15%"> Khalti Id: </th>
                                    <td style="padding-left:10px;">
                                        @if ($user->khaltiDetail->khalti_id)
                                            {{ $user->khaltiDetail->khalti_id }}
                                        @else
                                            --
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width:15%"> Username: </th>
                                    <td style="padding-left:10px;">
                                        @if ($user->khaltiDetail->khalti_username)
                                            {{ $user->khaltiDetail->khalti_username }}
                                        @else
                                            --
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h5> Bank Info. </h5>
                        <br>
                        @if (isset($user->bankDetail))
                            <table>
                                <tr style="padding:10px;">
                                    <th style="width:50%"> Bank Name: </th>
                                    <td style="padding-left:10px;">
                                        @if ($user->bankDetail->bank_name)
                                            {{ $user->bankDetail->bank_name }}
                                        @else
                                            --
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width:50%"> Branch: </th>
                                    <td style="padding-left:10px;">
                                        @if ($user->bankDetail->branch)
                                            {{ $user->bankDetail->branch }}
                                        @else
                                            --
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width:50%"> A/C Number: </th>
                                    <td style="padding-left:10px;">
                                        @if ($user->bankDetail->ac_no)
                                            {{ $user->bankDetail->ac_no }}
                                        @else
                                            --
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width:50%"> A/C Holder Name: </th>
                                    <td style="padding-left:10px;">
                                        @if ($user->bankDetail->ac_name)
                                            {{ $user->bankDetail->ac_name }}
                                        @else
                                            --
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
           @if (count($payments) != 0)
                <table id="datatable-buttons" class="table table-bordered"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <!-- <td>Changed Amount</td> -->
                                <th>Wallet</th>
                                <th>Account</th>
                                <th>Remarks</th>
                                @if(Auth::user()->head == 1)
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            <?php $diff = ['-success', '-info', '-warning', '-danger']; ?>
                            @foreach ($payments as $index => $payment)
                                <tr>
                                    <td>
                                        @if ($payment->created_at)
                                            <span class="text-muted">{{ $payment->created_at }}</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <!-- <td>
                        {{ $payment->changed_amount }}
                        </td> -->


                                    <?php if ($payment->remarks) {
                                    $new_pr = explode(' ', $payment->remarks);

                                    // $new_pr1 = $new_pr[0];
                                    $new_pr2 = isset($new_pr[1]) ? $new_pr[1] : null;
                                    // print_r($new_pr1." ".$new_pr2);

                                    if ($new_pr2 == 'from') { ?>
                                    <td style="color:green;">
                                        {{ number_format($payment->changed_amount,2) }}
                                    </td>
                                    <?php } else { ?>
                                    <td> -- </td>
                                    <?php }

                                    if ($new_pr2 != 'from' || $new_pr2 == ' ') { ?>
                                    <td style="color:red;">
                                        {{ $payment->changed_amount }}
                                    </td>
                                    <?php } else { ?>
                                    <td> -- </td>
                                    <?php }
                                    } ?>
                                    <!-- Testing end section -->

                                    <td>
                                        {{ $payment->remarks }}
                                    </td>
                                     @if(Auth::user()->head == 1)
                                    <td>
                                       
                                        <a href={{url('account/destroy/paymenthistory/'.$payment->id)}} onclick="return confirm('Are you sure, you want to Settle this User ?')" class='btn btn-danger '> delete</a>
  
                                    </td>
                                     @endif
                                </tr>
                            @endforeach

                        <tfoot>
                            <tr>
                                <td>Date</td>
                                <!-- <td>Changed Amount</td> -->
                                <td>Wallet</td>
                                <td>Account</td>
                                <td>Remarks</td>
                                 @if(Auth::user()->head == 1)
                                <th>Action</th>
                                @endif
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
