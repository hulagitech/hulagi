@extends('admin.layout.master')
@section('title', 'Contacts')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-1">
                        <i class="fas fa-question-circle"></i> &nbsp; Queries Information
                    </h5>
                </div>
                <div class="col-md-4 d-flex justify-content-end">
                    {{-- <a href="{{ route('admin.fare.create') }}" style="margin-left: 1em;" class="btn btn-secondary btn-success btn-rounded pull-right"><i class="fa fa-plus"></i> Add New Plan</a> --}}
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
                <table id="datatable" class="table table-bordered"
            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
               <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Message</th>
                  
               </tr>
            </thead>
            <tbody>
               @foreach($data as $index => $user)
               <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td>{{ $user->message }}</td>
                  
               </tr>
               @endforeach
            </tbody>
         </table>
                @else
                <h6 class="no-result">No results found</h6>
                @endif
            </div>
        </div>
    </div>
</div>
@section('scripts')

@include('user.layout.partials.datatable')

@endsection
@endsection

