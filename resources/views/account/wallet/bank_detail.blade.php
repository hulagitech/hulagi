@extends('account.layout.master')

@section('title', 'All Order Comment')

@section('content')
<div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h4 class="page-title m-0">User Bank Details</h4>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end">
                	 <a href="{{ route('account.add_bank_info') }}" style="margin-left: 1em;" class="btn btn-secondary btn-success btn-rounded pull-right"><i class="fa fa-plus"></i> Add A/C Detail</a>
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
                        <th>S.N</th>
                        <th>User Name</th>
                        <th>Contact No.</th>
                        <th>Bank Name</th>
                        <th>Branch</th>
                        <th>A/C No.</th>
                        <th>A/C Holder Name</th>
                        {{-- <th> Status </th> --}}
                        <th> Action </th>
                    </tr>
                    </thead>
                <tbody>
                    @foreach($details as $index => $detail)
                        <tr>
                            <td>{{ @$index+1 }}</td>
                            <td>{{ @$detail->user->first_name }}</td>
                            <td>{{ @$detail->user->mobile }}</td>
                            <td>{{ @$detail->bank_name }}</td>
                            <td>{{ @$detail->branch }}</td>
                            <td>{{ @$detail->ac_no }}</td>
                            <td>{{ @$detail->ac_name }}</td>
                            {{-- <td>
                                @if(@$detail->bank->status==1)
                                    <div style="color: green;"> <b> Enable </b> </div>
                                @else
                                    -
                                @endif
                            </td> --}}

                            <td>
                                {{-- <a href="{{ route('account.edit_ac', @$request->id) }}" class="btn btn-primary">
                                    <i class="fa fa-eye"></i>
                                </a> --}}
                                <a href="#" class="btn btn-primary">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('account.edit_bank_info', @$detail->id) }}" class="btn btn-warning">
                                    <i class="mdi mdi-square-edit-outline"></i>
                                </a>
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


<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
@endsection
@section('scripts')

    @include('user.layout.partials.datatable')

@endsection