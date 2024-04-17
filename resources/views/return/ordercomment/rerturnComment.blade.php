@extends('return.layout.master')

@section('title', 'All Order Comment')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-1">
                        <i class="fa fa-plus fa-ticket"></i>&nbsp;Unsolve Order Comments
                     </h5>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body table-responsive">
                 <table id="datatable-buttons" class="table table-bordered"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>

                            <th>S.n</th>
                            <th>Booking ID</th>
                            {{-- <th>User Id</th> --}}
                            <th>User Name</th>
                            <th>Contact No.</th>
                            <th>Refered Dept.</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                   {{-- {{ dd($allOrderComments)}} --}}
                    <tbody>
                        @foreach ($allOrderComments as $index => $allOrderComment)
                            @if ($allOrderComment->ur->dept_id == $dep)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ @$allOrderComment->ur->booking_id }}</td>
                                    {{-- <td>{{ $allOrderComment->ur->user_id }}</td> --}}
                                    <td>{{ @$allOrderComment->user->first_name }}</td>
                                    <td>{{ @$allOrderComment->user->mobile }}</td>
                                    <td>
                                        @if (@$allOrderComment->ur->dept_id !== 0)
                                            {{ @$allOrderComment->ur->dept->dept }}
                                        @else
                                            Customer Service
                                        @endif
                                    </td>
                                    <td style="position:relative;">
                                        <a href="{{ route('return.order_details', $allOrderComment->request_id) }}"
                                            class="btn btn-success btn-secondary"> <i class="ti-comment"></i> </a>
                                        {{-- Count Comment Notification --}}
                                        @if (@$allOrderComment->noComment != '0')
                                            <span class="tag tag-danger"
                                                style="position:absolute; top:0px;">{{ @$allOrderComment->noComment }}</span>
                                        @else
                                            <span> </span>
                                        @endif
                                    </td>
                                </tr>

                            @endif
                        @endforeach
                    </tbody>
                </table>
                {{ $allOrderComments->appends(\Request::except('page'))->links() }}
            </div>

        </div>
    </div>
</div>
@endsection
@section('script')
   @include('user.layout.partials.datatable')

@endsection