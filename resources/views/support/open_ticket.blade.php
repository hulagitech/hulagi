@extends('support.layout.master')

@section('title', 'Support')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h4 class="page-title m-0">{{$title}}</h4>
                </div>
                <div class="col-md-8 justify-content-end d-flex row">
                    
                </div>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body table-responsive">
                @if (count($data) != 0)
                <table id="datatable-buttons" class="table table-bordered"
                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
               <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Subject</th>
                  <th>Message</th>
                  <th>Action</th>
               </tr>
            </thead>
            
            <tbody>
               @foreach($data as $index => $user)
               <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  @if($user->transfer==1)
                  <td>Customer Relationship</td>
                  @elseif($user->transfer==2)
                  <td>Dispatcher Relationship</td>
                  @else
                  <td>Account Relationship</td>
                  @endif
                  <td>{{ $user->message }}</td>
                  <td>
                  <a href="{{ route('support.openTicketDetails', $user->id) }}" class="btn btn-success btn-secondary"><i class="fa fa-eye"></i></a>
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>
                @else
                <hr>
                <p style="text-align: center;">No data Found</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

    @include('user.layout.partials.datatable')

@endsection
