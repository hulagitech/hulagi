@extends('admin.layout.master')

@section('title', 'Track Order ')

@section('content')
<div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h4 class="page-title m-0">Delay Order </h4>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end">
                        <form class="form-inline pull-right" method="POST" action={{route('admin.requests.trackPost')}}>
                            {{csrf_field()}}
                            <div class="form-group">
                                <input type="text" class="form-control" name="searchField" placeholder="Booking ID">
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
<div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
             @if(isset($rider_history))

                 
                <table id="datatable" class="table table-bordered"
                        								style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                          <tr>
                              <td>Date</td>
                              <td>Update Date</td>
                              <td>Booking ID</td>
                              <td>Status</td>
                              <td>Rider</td>

                          </tr>
                        </thead>
                        <tbody>
                        @foreach($rider_history as $index => $request)
                            <tr>
                                <td>
                                  {{$request->created_at}}
                                </td>
                                <td>
                                    {{$request->updated_at}}
                                </td>
                                <td>
                                    {{$request->request->booking_id}}
                                </td>
                                <td>
                                    {{$request->status}}
                                </td>
                                <td>
                                    {{$request->rider->first_name}}
                                </td>
                                
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Date</td>
                                <td>Update Date</td>
                                <td>Booking ID</td>
                                <td>Status</td>
                                <td>Rider</td>
  
                            </tr>
                        </tfoot>
                    </table>
                @else
                    No Orders Found
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
