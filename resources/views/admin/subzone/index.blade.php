@extends('admin.layout.master')

@section('title', 'Sub Zones ')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-4">
                   <h5 class="mb-1"><span class="s-icon"><i class="ti-zoom-in"></i></span> &nbsp;Subzones </h5>
                </div>
                <div class="col-md-8 d-flex justify-content-end">
                    <a href="{{ route('admin.subzone.create') }}" style="margin-left: 1em;" class="btn btn-secondary btn-success btn-rounded w-min-sm m-b-0-25 waves-effect waves-light pull-right"><i class="fa fa-plus"></i> Link New Zones</a>
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
                            <th>Main Zone</th>
                            <th>Sub Zones</th>
                            <th style="width:50px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $counter=0; @endphp
                    @foreach($zones as $index => $zone)
                        <tr>
                            <td>{{$counter + 1}}</td>
                            <td>{{$zone[0]->mainZone->zone_name}}</td>
                            <td>
                                @foreach ($zone as $key=>$sub)
                                    {{$sub->subZone->zone_name}}@if(!$loop->last),@endif
                                @endforeach
                            </td>
                            <td style="width: 100px;">
                                <form action="{{ route('admin.subzone.destroy', $sub->main) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <a href="{{ route('admin.subzone.edit', $sub->main) }}" class="btn btn-secondary btn-success">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <button type="submit" class="btn btn-danger btn-secondary" onclick="return confirm('Are you sure?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @php $counter++; @endphp
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Main Zone</th>
                            <th>Sub Zones</th>
                            <th style="width:50px;">Action</th>
                        </tr>
                    </tfoot>
                </table>

            </div>

        </div>
    </div>
</div>

@endsection
@section('scripts')

@include('user.layout.partials.datatable')

@endsection