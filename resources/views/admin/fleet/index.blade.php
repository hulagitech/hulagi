@extends('admin.layout.base')

@section('title', 'Delivery Agency ')

@section('content')
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <h5 class="mb-1">
                <i class="ti-rocket"></i>&nbsp;Delivery Agency<hr>
               </h5>
            <a href="{{ route('admin.fleet.create') }}" style="margin-left: 1em;" class="btn btn-secondary btn-success pull-right btn-rounded"><i class="fa fa-plus"></i> Add New Delivery Agency</a>
            <table class="table table-striped table-bordered dataTable" id="table-2"  width=100%>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Manager</th>
                        <th>Delivery Agency</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Icon</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fleets as $index => $fleet)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $fleet->name }}</td>
                        <td>{{ $fleet->company }}</td>
                        <td>{{ $fleet->email }}</td>
                        <td>{{ $fleet->mobile }}</td>
                        <td><img src="{{img($fleet->logo)}}" style="height: 100px;"></td>
                        <td>
                            <form action="{{ route('admin.fleet.destroy', $fleet->id) }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="DELETE">
                                <a href="{{ route('admin.provider.index') }}?fleet={{$fleet->id}}" class="btn btn-black btn-secondary"> <i class="fa fa-search"></i></a>
                                 <a href="{{ route('admin.fleet.edit', $fleet->id) }}" class="btn btn-success btn-secondary"><i class="fa fa-pencil"></i></a>
                                <button class="btn btn-danger btn-secondary" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                      <th>ID</th>
                        <th>Manager</th>
                        <th>Delivery Agency</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Icon</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection