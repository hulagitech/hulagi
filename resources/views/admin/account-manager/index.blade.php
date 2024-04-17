@extends('admin.layout.master')

@section('title', 'Account Manager ')

@section('content')
<div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-4">
                       <h4><i class="ti-layout-grid2-thumb"></i>&nbsp;Account Manager</h4>
                        @if(Setting::get('demo_mode', 0) == 1)
                        <span class="pull-right">(*personal information hidden in demo)</span>
                        @endif
                    </div>
                    <div class="col-md-8 d-flex justify-content-end">
                     <!-- <a href="{{ route('admin.account-manager.create') }}" style="margin-left: 1em;" class="btn btn-secondary btn-success btn-rounded pull-right"><i class="fa fa-plus"></i> Add New Account Manager</a> -->
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
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Postion</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($accounts as $index => $account)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $account->name }}</td>
                                @if(Setting::get('demo_mode', 0) == 1)
                                <td>{{ substr($account->email, 0, 3).'****'.substr($account->email, strpos($account->email, "@")) }}</td>
                                @else
                                <td>{{ $account->email }}</td>
                                @endif
                                @if(Setting::get('demo_mode', 0) == 1)
                                <td>+919876543210</td>
                                @else
                                <td>{{ $account->mobile }}</td>
                                @endif
                                <td>
                                    @if($account->head==1)
                                <span class="btn btn-primary">Account Head</span>
                                @else
                                <span class="btn btn-success">Accountant</span>
                                @endif
                                </td>
                                
                                <td>
                                    <form action="{{ route('admin.account-manager.destroy', $account->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="DELETE">
                                        <a href="{{ route('admin.account-manager.edit', $account->id) }}" class="btn btn-success btn-secondary"><i class="mdi mdi-account-edit"></i></a>
                                        <button class="btn btn-danger btn-secondary" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Postion</th>
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