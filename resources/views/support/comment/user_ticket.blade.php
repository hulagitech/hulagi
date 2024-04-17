@extends('support.layout.master')

@section('title', 'All Order Comment')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h4 class="page-title m-0">Order By Date</h4>
                </div>
                <div class="col-md-8 justify-content-end d-flex row">
                    <form class="form-inline pull-right" method="GET" action={{url('support/searchUser')}}>
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" class="form-control" name="searchField" id="searchField" placeholder="Full Search">
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
                @if(isset($users))
            <table id="datatable-buttons" class="table table-bordered"
            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
                <tr>
                    <th> S.N </th>
                    <th> <i class="fa fa-user"></i> User Name </th>
                    <th> <i class="fa fa-mobile"></i> Mobile </th>
                    <th> Email </th>
                    <th> Company </th>
                    <th> Action </th>
                </tr>
            </thead>

           
                <tbody>
                    @foreach($users as $index => $user)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>{{ $user->first_name }}</td>
                            <td>{{ $user->mobile }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->company_name }}</td>
                            <td>
                                <a href="{{ url('support/user_all_tickets/'.$user->id) }}" class="btn btn-info btn-secondary"><i class="ti-align-justify"></i></a>
                                <a href="{{ url('support/user_add_ticket/'.$user->id) }}" class="btn btn-success btn-secondary">+  &nbsp;  <i class="fa fa-plus fa-ticket"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
          
        </table>
                {{-- {{$users->links('vendor.pagination.bootstrap-4')}} --}}

                @else
                <hr>
                <p style="text-align: center;">Search user</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

    @include('user.layout.partials.datatable')

@endsection

