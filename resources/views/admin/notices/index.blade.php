
@extends('admin.layout.master')

@section('title', 'Notice')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-1">
                        <i class="mdi mdi-bike"></i> &nbsp; Notices
                    </h5>
                </div>
                <div class="col-md-4 d-flex justify-content-end">
                    <a href="{{ route('admin.notices.create') }}" style="margin-left: 1em;" class="btn btn-secondary btn-rounded btn-success pull-right"><i class="fa fa-plus"></i> Add New Notice</a>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body table-responsive">
                @if (count($notices) != 0)
                <table id="datatable" class="table table-bordered"
                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th width="25%">Heading</th>
                            <th width="50%">Description</th>
                            <th>Domain type</th>
                            <th width="20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($notices as $index => $notice)
                     <tr>
                            <td>{{ $index+1}}</td>
                            <td>{{ $notice->Heading }}</td>
                            <td>{!! $notice->Description !!}</td>
                            <td>{{$notice->domain_name}}</td>
                            <td>
                            <form action="{{ route('admin.notices.destroy',$notice->id) }}" method="POST">
       
                                
    
                                <a class="btn btn-primary" href="{{ route('admin.notices.edit',$notice->id) }}" class="btn btn-secondary btn-primary"><i class="fas fa-edit"></i></a>
    
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
    
                                <button type="submit"  class="btn btn-danger" class="btn btn-secondary btn-success"><i class="fas fa-trash"></i></button>
                                </form>
                            
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Heading</th>
                            <th>Description</th>
                            <th>Domain type</th>
                            <th>Action</th>
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

