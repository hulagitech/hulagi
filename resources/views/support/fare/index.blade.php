@extends('support.layout.master')

@section('title', 'Service Types ')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h4 class="page-title m-0">Fare Info</h4>
                </div>
                <div class="col-md-8 justify-content-end d-flex row">
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body table-responsive">
                @if (count($fares) != 0)

                <table id="datatable" class="table table-bordered"
                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Zone1</th>
                        <th>Zone2</th>
                        <th>KM</th>
                        <th>Fare (Upto 500g)</th>
                        <th>Fare (Above 500g)</th>
                        <th>Cargo</th>
                        <th>Delay(Days)</th>
                        <th>Extremely Delay(Days)</th>
                        {{-- <th>Action</th> --}}
                    </tr>
                 
                </thead>
                <tbody>
                @foreach($fares as $index => $fare)
				
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{@$fare->zone1->zone_name}}</td>
                        <td>{{@$fare->zone2->zone_name}}</td>
                        <td>
                            @if($fare->zone1==$fare->zone2)
                                @if($fare->km==1000)
                                    More than others
                                @else
                                    {{@$fare->km}}
                                @endif
                            @else
                                No distance required
                            @endif
                        </td>
                        <td>{{@$fare->fare_half_kg}}</td>
                        <td>{{@$fare->fare}}</td>
                        <td>
                            @if(@$fare->cargo=='1')
                                <span style="color: green"> Yes </span>
                            @else
                            <span style="color: red"> - </span>
                            @endif
                        </td>
                        <td>
                            @if(@$fare->delay_period)
                                {{$fare->delay_period}}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if(@$fare->extremely_delay_period)
                                {{$fare->extremely_delay_period}}
                            @else
                                -
                            @endif
                        </td>
                        {{-- <td>
                            <form action="{{ route('admin.fare.destroy',$fare->id) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <input type="hidden" value="{{$fare->id}}" name="id" />
                                <a href="{{ route('admin.fare.edit',$fare->id) }}" class="btn btn-success btn-secondary">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <button type="submit" class="btn btn-danger btn-secondary" onclick="return confirm('Are you sure?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td> --}}
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
						<th>ID</th>
                        <th>Zone1</th>
                        <th>Zone2</th>
                        <th>KM</th>
                        <th>Fare (Upto 500g)</th>
                        <th>Fare (Above 500g)</th>
                        <th>Cargo</th>
                        <th>Delay(Days)</th>
                        <th>Extremely Delay(Days)</th>
                        {{-- <th>Action</th> --}}
                    </tr>
                </tfoot>
            </table>
                

                @else
                <hr>
                <p style="text-align: center;">No  Rider Info Available</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

    @include('user.layout.partials.datatable')

@endsection

