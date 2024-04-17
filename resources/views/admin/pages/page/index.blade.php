@extends('admin.layout.master')

@section('title', 'Page')

@section('content')
<div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h4 class="page-title m-0">&nbsp;Page</h4>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end">
                        <a href="{{ route('admin.page.create') }}" style="margin-left: 1em;" class="btn shadow-box btn-success btn-rounded pull-right"><i class="fa fa-plus"></i>Add New</a>
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

                <thead>

                    <tr>

                        <th>ID</th>

                        <th style="width: 300px;"> Title</th>               

                        <th style="width: 800px;"> Description</th>

                        <th>Image</th>

                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                @foreach($page as $index => $service)

                    <tr>

                        <td>{{ $index + 1 }}</td>

                        <td>{{ $service->en_title }}</td>

                        <td>{!! Illuminate\Support\Str::limit($service->en_description, 80) !!}</td>
                        <td>

                            @if($service->image) 

                                <img src="{{$service->image}}" style="height: 50px" >

                            @else

                                N/A

                            @endif

                        </td>

                        <td style="width: 100px">

                            <form action="{{ route('admin.page.destroy', $service->id) }}" method="POST">

                                {{ csrf_field() }}

                                {{ method_field('DELETE') }}

                                <a href="{{ route('admin.page.edit', $service->id) }}" class="btn shadow-box btn-primary"><i class="fas fa-edit"></i>

                                </a>

                                <button class="btn btn-danger shadow-box" onclick="return confirm('Are you sure?')">

                                    <i class="fa fa-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                @endforeach

                </tbody>

               

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

