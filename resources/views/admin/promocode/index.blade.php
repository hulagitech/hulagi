@extends('admin.layout.master')

@section('title', 'Promocodes ')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h4> <i class="fa fa-user"></i>&nbsp; Promocodes

                    </h4>
                </div>
                <div class="col-md-8 d-flex justify-content-end">
                    <a href="{{ route('admin.promocode.create') }}" style="margin-left: 1em;"
                        class="btn btn-secondary btn-success btn-rounded pull-right"><i class="fa fa-plus"></i> Add New
                        Promocode</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body table-responsive">
                @if (count($promocodes) != 0)
                <table id="datatable" class="table table-bordered"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Promocode </th>
                            <th>Discount_type</th>
                            <th>Business/Person</th>
                            <th>Discount </th>
                            <th>Expiration</th>
                            <th>Status</th>
                            <th>Total Limit</th>
                            <th>User Limit</th>
                            <th>Used Count</th>
                            <th>Zone</th>
                            <th>Restricted Zone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($promocodes as $index => $promo)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$promo->promo_code}}</td>
                            <td>{{$promo->Discount_type}}</td>
                            <td>@if($promo->user_type==1)
                                Business
                                @elseif($promo->user_type==2)
                                Person
                                @else
                                Both
                                @endif
                            </td>
                            <td>{{$promo->discount}}</td>
                            <td>
                                {{date('d-m-Y',strtotime($promo->expiration))}}
                            </td>
                            <td>
                                @if(date("Y-m-d") <= $promo->expiration)
                                    <span class="tag tag-success">Valid</span>
                                    @else
                                    <span class="tag tag-danger">Expiration</span>
                                    @endif
                            </td>
                            <td>{{$promo->set_limit}}</td>
                            <td>{{$promo->number_of_time}}</td>
                            <td>
                                {{count($promo->promocodeUsage)}}
                            </td>
                            <td>
                                @foreach($promo->promozone as $zone){{@$zone->Zones->zone_name}},@endforeach
                            </td>
                            <td>
                                @foreach($promo->promozone as $zone){{@$zone->RestrictedZones->zone_name}},@endforeach
                            </td>
                            <td>
                                <form action="{{ route('admin.promocode.destroy', $promo->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    <!-- <input type="hidden" name="_method" value="DELETE"> -->
                                    <a href="{{ route('admin.promocode.edit', $promo->id) }}"
                                        class="btn btn-secondary btn-success"><i class="fas fa-pen"></i></a>
                                    <!-- <button class="btn btn-danger btn-secondary" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button> -->
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Promocode </th>
                            <th>Discount_type</th>
                            <th>Business/Person</th>
                            <th>Discount </th>
                            <th>Expiration</th>
                            <th>Status</th>
                            <th>Total Limit</th>
                            <th>User Limit</th>
                            <th>Used Count</th>
                            <th>Zone</th>
                            <th>Restricted Zone</th>
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

@endsection
@section('scripts')

@include('user.layout.partials.datatable')

@endsection