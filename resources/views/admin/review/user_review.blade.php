@extends('admin.layout.master')

@section('title', 'User Reviews ')

@section('content')
<div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-4">
                      <h5 class="mb-1"><i class="ti-star"></i>&nbsp;User Reviews</h5>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end">
                    
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
                            <th>Request ID</th>
                            <th>User Name</th>
                            <th>Driver Name</th>
                            <th>Rating</th>
                            <th>Date & Time</th>
                            <th>Comments</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($Reviews as $index => $review)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$review->request_id}}</td>
                            <td>{{$review->user['first_name']}}</td>
                            <td>{{$review->provider['first_name']}}</td>
                            <td>
                                <div className="rating-outer">
                                    <input type="hidden" value="{{$review->user_rating}}" name="rating" class="rating"/>
                                </div>
                            </td>
                            <td>{{$review->created_at}}</td>
                            <td>{{$review->user_comment}}</td>
                            
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Request ID</th>
                            <th>User Name</th>
                            <th>Driver Name</th>
                            <th>Rating</th>
                            <th>Date & Time</th>
                            <th>Comments</th>
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