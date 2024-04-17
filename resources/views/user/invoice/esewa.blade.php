@extends('user.layout.master')


@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Esewa Payment History</h4>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
                    @if ($esewa->count() > 0)
                        <table id="datatable" class="table table-bordered"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                    <th>S.N</th>
                                    <th>Date</th>
                                    <th>Paid Amount</th>
                                    <th>Load Amount</th>
                                    <th>Payment ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($esewa as $index => $invoice)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ date('d-m-Y', strtotime($invoice->created_at)) }}</td>
                                        <td>{{ $invoice->Amount }}</td>
                                        <td>{{$invoice->Load_Amount}}</td>
                                        <td>{{$invoice->Payment_ID}}</td>

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
