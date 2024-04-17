@extends('admin.layout.master')

@section('title', 'Locations ')

@section('content')
<div class="row">
   <div class="col-sm-12">
      <div class="page-title-box">
            <div class="row align-items-center">
               <div class="col-md-8">
                 <h5 class="mb-1"><span class="s-icon"><i class="ti-zoom-in"></i></span> &nbsp;Zones </h5>
               </div>
               <div class="col-md-4">
                   <div class="float-right">
                        <a href="{{ route('admin.zone.create') }}" style="margin-left: 1em;" class="btn btn-secondary btn-success btn-rounded w-min-sm m-b-0-25 waves-effect waves-light pull-right"><i class="fa fa-plus"></i> Add New Location</a>
                  </div> 
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
                            <th>Zone Name</th>
                            <th>Country</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Currency</th>
                            <th>Status</th>
                            <th>Zone Fare</th>
                            <th style="width:50px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($zones as $index => $zone)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$zone->zone_name}}</td>
                            <td>{{$zone->country}}</td>
                            <td>{{$zone->state}}</td>
                            <td>{{$zone->city}}</td>
                            <td>{{$zone->currency}}</td>
                            <td>{{$zone->status}}</td>
                               <td>@foreach(@$zone->ZoneAssign($zone->id) as $zone_name)
                                {{@$zone_name->zone2->zone_name}},
                                @endforeach
                            </td>
                            <td style="width: 100px;">
                                <form action="{{ route('admin.zone.destroy', $zone->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="DELETE">
                                    <a href="{{ route('admin.zone.edit', $zone->id) }}" class="btn btn-secondary btn-black"><i class="fa fa-eye"></i></a>
                                    <button class="btn btn-secondary btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Zone Name</th>
                            <th>Country</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Currency</th>
                            <th>Status</th>
                            <th>Zone Fare</th>
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

