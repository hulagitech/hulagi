@extends('user.layout.master')


@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Request Payment History</h4>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
                    @if ($invoices->count() > 0)
                        <table id="datatable" class="table table-bordered"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>Date</th>
                                    <th>Invoice ID</th>
                                    <th>COD</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $index => $invoice)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $invoice->created_at }}</td>
                                        <td>PAY.{{ $invoice->invoice_no }}</td>
                                        <td>{{ $invoice->paid_amount }}</td>
                                        <td>
                                            <a href="{{ url('pay_details/' . $invoice->id) }}" target="_blank"
                                                class="btn btn-success btn-secondary"> <i class="ti-eye"></i> </a>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <hr>
                        <p style="text-align: center;">No Payment History Available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

    @include('user.layout.partials.datatable')

@endsection
