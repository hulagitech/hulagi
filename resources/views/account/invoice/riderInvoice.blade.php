@extends('account.layout.master')

@section('title', 'Todays user Payment')

@section('content')
<div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
                    <h5 class="mb-1">
                        <i class="fa fa-ticket"></i>&nbsp;Today's user Payment
                    </h5>
                   <table id="datatable" class="table table-bordered"
                                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Date</th>
                    <th>Invoice ID</th>
                    <th>Provider Name</th>
                    <th>COD</th>
                    <th>Action</th>
                </tr>
                </thead>
            <tbody>
                @foreach($invoices as $index => $invoice)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $invoice->created_at }}</td>
                        <td>PAY.{{ $invoice->invoice_no}}</td>
                        <td>{{ $invoice->rider->first_name}}</td>
                        <td>{{ $invoice->paid_amount}}</td>
                        <td>
                            <a href="{{ url('account/rider-invoice-details/'.$invoice->id) }}" target="_blank" class="btn btn-success btn-secondary"> <i class="ti-eye"></i> </a>
                        </td>
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

