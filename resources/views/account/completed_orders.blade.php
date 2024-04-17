@extends('account.layout.master')

@section('title', 'Completed Orders ')

@section('content')
<div class="row">
   <div class="col-sm-12">
      <div class="page-title-box">
            <div class="row align-items-center">
               <div class="col-md-6">
                 <h5 class="mb-1"><span class="s-icon"><i class="ti-zoom-in"></i></span> &nbsp;Today Completed Order </h5>
               </div>
               <div class="col-md-6">
                   <div class="float-right">
                        <form class="form-inline" action="{{route('account.completed.order')}}">
							<label class="sr-only" for="inlineFormInputName2">From</label>
							<input type="date" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" name="from_date" value="{{ $_GET['from_date'] ?? '' }}">

							<label class="sr-only" for="inlineFormInputGroupUsername2">To</label>
							<div class="input-group mb-2 mr-sm-2">
								<div class="input-group-prepend">
								</div>
								<input type="date" class="form-control" id="inlineFormInputGroupUsername2" name="to_date" value="{{ $_GET['to_date'] ?? '' }}">
							</div>

							

							<button type="submit" class="btn btn-primary mb-2">Submit</button>
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
                            <th>Date</th>
                            <th>Order Id</th>
                            <th>Vendor Name</th>
                            <th>Rider Name</th>
                            <th> Status</th>
                            <th>COD</th>
                            <th>Fare</th>
                        </tr>
                        </thead>
                    <tbody>
                        @foreach($completed_rides as $index => $rides)
                        @if($rides->request->status=="COMPLETED"||$rides->request->status=="REJECTED")
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $rides->completed_date}}</td>
                                <td>{{ $rides->request->booking_id }}</td>
                                <td>{{ $rides->request->user->first_name}}</td>
                                <td>
                                    @if ($rides->complete)    
                                    {{ $rides->complete->first_name}}
                                    @else
                                    null
                                    @endif
                                    </td>
                                <td>{{ $rides->request->status}}</td><td>
                                    @if ($rides->request->status == 'REJECTED')
                                        0
                                    @else
                                        {{ $rides->request->cod }}
                                    @endif   
                                </td>
                                <td>{{ $rides->request->amount_customer}}</td>
                            </tr>
                            @endif
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