@extends('account.layout.master')

@section('title', 'Total Request')

@section('content')
<div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h4 class="page-title m-0"><i class="fa fa-comments"></i>&nbsp; Negative Wallet User's Till Now</h4>
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
                                   <table id="datatable-buttons" class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <td>User Name</td>
                                                <td>Mobile</td>
                                                <td>Total Order</td>
                                                <th>Status</th>
                                                <td>Wallet Amount</td>
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
                                                        <td><span class="btn btn-success btn-primary">Active  </span></td>  
                                                    @else
                                                          <td><span class="btn btn-danger btn-primary">Inactive  </span></td> 
                                                    @endif
                                                  
                                                    <td>
                                                        {{ $user->newPayment}}
                                                    </td>
                                            @endforeach

                                        <tfoot>
                                            <tr>
                                            <td>User Name</td>
                                                <td>Mobile</td>
                                                <td>Total Order</td>
                                                <th>Status</th>
                                                <td>Wallet Amount</td>
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
@section('scripts')

    @include('user.layout.partials.datatable')

@endsection
