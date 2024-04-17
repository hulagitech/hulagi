@extends('pickup.layout.master')

@section('title', 'Order details ')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Pickup Remaining</h4>
                    </div>
                    <div class="col-md-4 justify-content-end d-flex">
                    
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
                    @if (count($remaining_data) != 0)
                        <table id="datatable-buttons" class="table table-bordered"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Vendor Name</th>
                                    <th>Vender Location</th>
                                    <th>Number</th>
                                    <th>Number of Order</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($remaining_data as $index => $data)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ @$data->user->first_name }}</td>
                                        <td>{{ $data->s_address }}</td>
                                        <td>{{ @$data->user->mobile }}</td>
                                        <?php $count = App\UserRequests::whereIn('status', ['PENDING', 'ACCEPTED', 'PICKEDUP'])
                                            ->whereDate(
                                                'created_at',
                                                '<=',
                                                Carbon\Carbon::today()
                                                    ->setTime(11, 00, 00)
                                                    ->toDateTimeString(),
                                            )
                                            ->where('user_id', $data->user_id)
                                            ->count(); ?>
                                        <td>{{ $count }}</td>
                                    </tr>
    
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>SN</th>
                                    <th>Vendor Name</th>
                                    <th>Vender Location</th>
                                    <th>Number</th>
                                    <th>Number of Order</th>
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







