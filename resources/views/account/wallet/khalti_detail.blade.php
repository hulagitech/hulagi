@extends('account.layout.base')

@section('title', 'All Order Comment')

@section('content')


<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <h5 class="mb-1">
                <i class="fa fa-comments"></i>&nbsp; User Khalti Details
            </h5>
            <hr>
            <a href="{{ route('account.add_khalti_info') }}" style="margin-left: 1em;" class="btn btn-secondary btn-success btn-rounded pull-right"><i class="fa fa-plus"></i> Add A/C Detail</a>
            <table class="table table-striped table-bordered dataTable" id="table-2"style="width:100%;">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>User Name</th>
                        <th>Contact No.</th>
                        <th>Khalti Id</th>
                        <th>Khalti Username</th>
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
                            <td>{{ @$detail->khalti_id }}</td>
                            <td>{{ @$detail->khalti_username }}</td>
                            {{-- <td>
                                @if(@$detail->khalti->status==1)
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
                                <a href="{{ route('account.edit_khalti_info', @$detail->id) }}" class="btn btn-warning">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
@endsection