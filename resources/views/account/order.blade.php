@extends('account.layout.base')

@section('title', 'Complaint')

@section('content')
<div class="content-area py-1">
   <div class="container-fluid">
      <div class="box box-block bg-white">
      	<h5 class="mb-1">
           <i class="ti-receipt"></i>&nbsp; Order before 31 Ashar
         </h5><hr>
         <table class="table table-striped table-bordered dataTable" id="table-2"style="width:100%;">
            <thead>
               <tr>
                  <th>SN</th>
                  <th>Created_at</th>
                  <th>Booking_id</th>
                  <th>status</th>
                  <th>fare</th>
               </tr>
            </thead>
            <tbody>
               @foreach($request as $index => $user)
               <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $user->created_at }}</td>
                  <td>{{ $user->booking_id }}</td>
                  <td>{{$user->status}}</td>
                  <td>{{$user->fare}}</td>
                  @endforeach
            </tbody>
         </table>
         {{$request->links('vendor.pagination.bootstrap-4')}}
      </div>
   </div>
</div>
@endsection