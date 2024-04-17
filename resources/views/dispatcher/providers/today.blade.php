@extends('dispatcher.layout.master')

@section('title', $page)

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Today's Completed Orders</h4>
                    </div>
                    <div class="col-md-4">
                        <div class="float-right">
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
                    <div class="row ">
                        <div class="col-md-12 mt-4">
                            <div class="float-md-right">
                                <form class="form-inline" action="{{ route('dispatcher.provider.today', $id) }}">
                                    <label class="sr-only" for="inlineFormInputName2">From</label>
                                    <input type="date" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2"
                                        name="from_date">

                                    <label class="sr-only" for="inlineFormInputGroupUsername2">To</label>
                                    <div class="input-group mb-2 mr-sm-2">
                                        <div class="input-group-prepend">
                                        </div>
                                        <input type="date" class="form-control" id="inlineFormInputGroupUsername2"
                                            name="to_date">
                                    </div>



                                    <button type="submit" class="btn btn-primary mb-2">Submit</button>
                                </form>

                            </div>
                        </div>
                    </div>
                    <table id="datatable" class="table table-bordered"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Order Id</th>
                                <th>Vendor Name</th>
                                <th> Status</th>
                                <th>COD</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($completed_rides as $index => $rides)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $rides->request->booking_id }}</td>
                                    <td>{{ $rides->request->user->first_name }}</td>
                                    <td>{{ $rides->request->status }}</td>
                                    <td>Rs.{{ $rides->request->cod }}</td>
                                </tr>
                            @endforeach

                            <td>Total</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Rs.{{ $sum }}</td>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>


@endsection
@section('scripts')
    @include('user.layout.partials.datatable')

@endsection
