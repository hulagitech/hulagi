@extends('account.layout.master')

@section('title', 'Esewa user Payment')

@section('content')
 <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Esewa User Payment  Detail</h4>
                    </div>
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-2">
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
                    <th>S.N</th>
                    <th>Date</th>
                    <th>Esewa ID</th>
                    <th>User Name</th>
                    <th>Amount</th>
                    <th>Load Amount</th>
                </tr>
                </thead>
            <tbody>
                @foreach($Esewa as $index => $invoice)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $invoice->created_at }}</td>
                        <td>{{ $invoice->Payment_ID}}</td>
                        <td>{{ $invoice->User_Name}}</td>
                        <td>{{ $invoice->Amount}}</td>
                        <td>{{ $invoice->Load_Amount}}</td>
                    </tr>
                @endforeach
            </tbody>
         </table>
         {{ $Esewa->appends(\Request::except('page'))->links() }}
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')

    @include('user.layout.partials.datatable')

@endsection