@extends('account.layout.master')

@section('title', 'Todays user Payment')

@section('content')
<div class="row">
   <div class="col-sm-12">
      <div class="page-title-box">
            <div class="row align-items-center">
               <div class="col-md-6">
                 <h5 class="mb-1"><span class="s-icon"><i class="ti-zoom-in"></i></span> &nbsp;Zones </h5>
               </div>
               <div class="col-md-6">
                   <div class="float-right">
                        <form class="form-inline pull-right" method="POST" action={{url('account/userSearchPayment')}}>
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="from_date" style="padding-top:5px;"> From: <label>
                            <input type="date" class="form-control" name="from_date" value="{{ $_GET['from_date'] ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label for="to_date" style="padding-top:5px;"> To: <label>
                            <input type="date" class="form-control" name="to_date" value="{{ $_GET['to_date'] ?? '' }}">
                        </div>
                        <div class="form-group">
                            <button name="search" class="btn btn-success">Search</button>
                        </div>
                </form>
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
                <table id="datatable-buttons" class="table table-bordered"
                        								style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Amount</th>
                            <th>Vendor Name</th>
                            <th>Remarks</th>
                        </tr>
                        </thead>
                    <tbody>
                        @foreach($payable as $index => $invoice)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ currency(($invoice->changed_amount)) }}</td>
                                <td>{{ $invoice->user->first_name}}</td>
                                <td>{{ $invoice->remarks}}</td>    
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