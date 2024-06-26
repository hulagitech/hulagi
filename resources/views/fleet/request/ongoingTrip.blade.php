@extends('fleet.layout.base')
@section('title', 'Request History ')
@section('content')
<div class="content-area py-1">
   <div class="container-fluid">
      <div class="row row-md">
         <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="box box-block bg-success mb-2">
               <div class="t-content">
                  <h5 class="text-uppercase mb-1">Total Rides</h5>
                  <h5 class="text-uppercase mb-1">{{ $totalrequest }}</h5>
               </div>
            </div>
         </div>
         <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="box box-block bg-primary mb-2">
               <div class="t-content">
                  <h5 class="text-uppercase mb-1">Total Paid </h5>
                  <h5 class="text-uppercase mb-1">{{ $totalpaidamount }} </h5>
               </div>
            </div>
         </div>
         <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="box box-block bg-warning mb-2">
               <div class="t-content">
                  <h5 class="text-uppercase mb-1">Total Cancel Rides</h5>
                  <h5 class="text-uppercase mb-1">{{ $totalcanceltrip }}</h5>
               </div>
            </div>
         </div>
      </div>
      <div class="box box-block bg-white">
         <h5 class="mb-1"><i class="fa fa-recycle"></i>&nbsp;Rides</h5><hr>
         @if(count($requests) != 0)
         <table class="table table-striped table-bordered dataTable" id="table-2"style="width:100%";>
            <thead>
               <tr>
                  <th>ID</th>
                  <th>User </th>
                  <th>Provider</th>
                  <th>Date &amp; Time</th>
                  <!-- <th>Ride Type</th>
                  <th>Assigned By</th> -->
                  <th>Status</th>
                  <th>Amount</th>
                  <th>Payment Mode</th>
                  <th>Payment Status</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
               @if( $requests->count() )
               @foreach($requests as $index => $request)
               <tr>
                  <td>{{ $request->booking_id }}</td>
                  <td>
                     @if(isset($request->user->first_name))
                     {{ $request->user->first_name }} {{ $request->user->last_name }}
                     @else
                     N/A
                     @endif
                  </td>
                  <td>
                     @if(isset($request->provider->first_name))
                     {{ $request->provider->first_name }} {{ $request->provider->last_name }}
                     @else
                     N/A
                     @endif
                  </td>
                  <td>
                     @if($request->created_at)
                     <span class="text-muted">{{$request->created_at->diffForHumans()}}</span>
                     @else
                     -
                     @endif
                  </td>
                 <!--  <td>{{( $request->corporate_id   == 0 ) ? 'INDIVIDUAL' : 'CORPORATE'}}</td>
                  <td>{{( $request->cab_company_id   == 0 ) ? 'FlashTaxi' : 'Cab Company'}}</td> -->
                  <td>{{ $request->status }}</td>
                  <td>
                     {{-- @if($request->payment != "")
                     {{ currency($request->payment->total) }} --}}
                     @if($request->cod != "")
                     {{ currency($request->cod) }}
                     @else
                     N/A
                     @endif
                  </td>
                  <td>{{ $request->payment_mode }}</td>
                  <td>
                     @if($request->paid)
                     Paid
                     @else
                     Not Paid
                     @endif
                  </td>
                  <td>
                     <div class="btn-group" role="group">
                        <button type="button" class="btn btn-success btn-secondary waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Action
                        </button>
                        <div class="dropdown-menu">
                           <a href="{{ route('fleet.requests.show', $request->id) }}" class="dropdown-item">
                           <i class="fa fa-search"></i>  Details
                           </a>
                           <form action="{{ route('fleet.requests.destroy', $request->id) }}" method="POST">
                              {{ csrf_field() }}
                              {{ method_field('DELETE') }}
                              <button type="submit" class="dropdown-item">
                              <i class="fa fa-trash"></i> Delete
                              </button>
                           </form>
                        </div>
                     </div>
                  </td>
               </tr>
               @endforeach
               @endif
            </tbody>
         </table>
         @else
         <h6 class="no-result">No results found</h6>
         @endif 
      </div>
   </div>
</div>
@endsection