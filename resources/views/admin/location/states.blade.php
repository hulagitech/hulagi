@extends('admin.layout.master')

@section('title', 'State')

@section('content')
<div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h4 class="page-title m-0">States </h4>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end">
                            <a href="{{ route('admin.location.create') }}" style="margin-left: 1em;" class="btn btn-secondary btn-success btn-rounded pull-right"><i class="fa fa-plus"></i> Add State</a>
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
                            <th>ID</th>
                            <th>Name</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($states as $index => $state)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$state->name}}</td>
                            <td>{{ date('Y-m-d: H:i:A', strtotime( $state->created_at ) )}}</td>
                            <td>
                                <form action="{{ route('admin.state.destroy', $state->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    
                                    <input type="hidden" name="_method" value="DELETE">
                                    <a href="{{ route('admin.state.edit', $state->id) }}" class="btn btn-secondary btn-success"><i class="fa fa-edit"></i></a>
                                    <button class="btn btn-danger btn-secondary" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                           <th>ID</th>
                            <th>Name</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
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