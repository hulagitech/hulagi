@extends('account.layout.base')

@section('title', 'All Order Comment')

@section('content')


<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <h5 class="mb-1">
                <i class="fa fa-comments"></i>&nbsp; User A/C Details
            </h5>
            <hr>
            <a href="{{ route('account.add_ac') }}" style="margin-left: 1em;" class="btn btn-secondary btn-success btn-rounded pull-right"><i class="fa fa-plus"></i> Add A/C Detail</a>
            <table class="table table-striped table-bordered dataTable" id="table-2"style="width:100%;">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>User Name</th>
                        <th>Khalti Id</th>
                        <th>Username</th>
                        <th>Status</th>
                        <th>Bank Name</th>
                        <th>Branch</th>
                        <th>A/C No.</th>
                        <th>A/C Holder Name</th>
                        <th> Status </th>
                        <th> Action </th>
                    </tr>
                    </thead>
                <tbody>
                    @foreach($users as $index => $user)
                        <tr>
                            <td>{{ @$index+1 }}</td>
                            <td>{{ @$user->first_name }}</td>
                            <td>{{ @$user->khalti->khalti_id }}</td>
                            <td>{{ @$user->khalti->khalti_username }}</td>
                            <td>
                                @if(@$user->khalti->status==1)
                                    <div style="color: green;"> <b> Enable </b> </div>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ @$user->bank->bank_name }}</td>
                            <td>{{ @$user->bank->branch }}</td>
                            <td>{{ @$user->bank->ac_no }}</td>
                            <td>{{ @$user->bank->ac_name }}</td>
                            <td>
                                @if(@$user->bank->status==1)
                                    <div style="color: green;"> <b> Enable </b> </div>
                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                {{-- <a href="{{ route('account.edit_ac', @$request->id) }}" class="btn btn-primary">
                                    <i class="fa fa-eye"></i>
                                </a> --}}
                                <a href="#" class="btn btn-primary">
                                    <i class="fa fa-eye"></i>
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