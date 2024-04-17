@extends('admin.layout.master')

@section('title', 'admins ')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-1">
                        <i class="fa fa-recycle"></i> &nbsp;All admin
                    </h5>
                </div>
                <div class="col-md-4 d-flex justify-content-end">
                    <form class="form-inline pull-right" method="get" action={{url('admin/adminSearch')}}>
                        {{csrf_field()}}
                        <div class="form-group">
                            <input type="text" class="form-control" name="searchField" placeholder="Full Search">
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
                @if (count($admins) != 0)
                <table id="datatable" class="table table-bordered"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Admin For</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $index => $admin)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><b>{{$admin->name}}</b></td>
                            <td>{{ $admin->email }}</td>
                            <td>{{$admin->admin_type}}</td>
                            <td>
                                <a href="{{ route('admin.admin.edit', $admin->id) }}"
                                    class="btn btn-secondary btn-success m-1"><i class="mdi mdi-pencil"></i></a>
                                <form action="{{ route('admin.admin.destroy', $admin->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure, you want to delete  this Admin User?')" class="btn btn-secondary btn-danger m-1"><i
                                            class="mdi mdi-delete"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                             <th>SN</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                        </tr>
                    </tfoot>
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