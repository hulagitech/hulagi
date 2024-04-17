@extends('admin.layout.master')

@section('title', 'Department Info')

@section('content')


<div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-4">
                       <h4> <i class="fa fa-user"></i>&nbsp;Departments Info.
                           @if(Setting::get('demo_mode', 0) == 1)
                           <span class="pull-right">(*personal information hidden in demo)</span>
                           @endif
                        </h4>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end">
                     <a href="{{ route('admin.dept.create') }}" style="margin-left: 1em;" class="btn btn-secondary btn-success btn-rounded pull-right"><i class="fa fa-plus"></i> Add New Department</a>
                    </div>
                </div>
            </div>
        </div>
</div>
<div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
                    <table id="datatable" class="table table-bordered"
                                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <tr>
                            <th>ID</th>
                            <th>Department</th>
                            <th>Enable</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    
                            </thead>
                            <tbody>
                            @foreach($depts as $index => $dept)
                            
                                <tr>
                                    <td>{{ $index + 1 }}</td>                        
                                    <td>{{@$dept->dept}}</td>
                                    <td>
                                        @if(@$dept->enable=='1')
                                        <span style="color: green"> Yes </span>
                                        @else
                                        <span style="color: red"> - </span>
                                        @endif
                                    </td>
                                    <td>{{@$dept->created_at->diffForhumans() }}</td>
                                    <td>
                                        
                                        <a href="{{ route('admin.dept.edit',$dept->id) }}" class="btn btn-warning btn-secondary">
                                            <i class="mdi mdi-account-edit"></i>
                                        </a>
                                        {{-- <a href="{{ route('admin.dept.destroy',$dept->id) }}" class="btn btn-danger btn-secondary" onclick="return confirm('Are you sure?')">
                                            <i class="fa fa-trash"></i>
                                        </a> --}}
                                    

                                        {{-- <form action="{{ route('admin.dept.destroy', $dept->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="DELETE">
                                            <a href="{{ route('admin.dept.edit', $dept->id) }}" class="btn btn-secondary btn-success"><i class="mdi mdi-account-edit"></i></a>
                                            <button class="btn btn-danger btn-secondary" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>
                                        </form> --}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Department</th>
                                    <th>Enable</th>
                                    <th>Created At</th>
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