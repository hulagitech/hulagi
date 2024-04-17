@extends('admin.layout.master')

@section('title', 'Pickup Users')

@section('content')
<div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-4">
                       <h4> <i class="fa fa-user"></i>&nbsp; Pickup User
                           @if(Setting::get('demo_mode', 0) == 1)
                           <span class="pull-right">(*personal information hidden in demo)</span>
                           @endif
                        </h4>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end">
                     <a href="{{ route('admin.pickup-user.create') }}" style="margin-left: 1em;" class="btn btn-secondary btn-success btn-rounded pull-right"><i class="fa fa-plus"></i> Add Pickup Manager</a>
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
                           <th>Enable</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($pickup_users as $index => $pickup_user)
                        <tr>
                           <td>{{ $index + 1 }}</td>
                           <td>{{ @$pickup_user->name }}</td>
                           @if(Setting::get('demo_mode', 0) == 1)
                           <td>{{ substr($return->email, 0, 3).'****'.substr($return->email, strpos($return->email, "@")) }}</td>
                           @else
                           <td>{{ @$pickup_user->email }}</td>
                           @endif
                           @if(Setting::get('demo_mode', 0) == 1)
                           <td>+919876543210</td>
                           @else
                           <td>{{ @$pickup_user->mobile }}</td>
                           @endif

                           <td>
                              @if(@$pickup_user->enable=='1')
                                 <div style="color:green;"> Yes </div>
                              @elseif(@$pickup_user->enable=='0')
                                 <div> - </div>
                              @endif
                           </td>

                           <td>
                              <form action="{{ route('admin.pickup-user.destroy', $pickup_user->id) }}" method="POST">
                                 {{ csrf_field() }}
                                 <input type="hidden" name="_method" value="DELETE">
                                 <a href="{{ route('admin.pickup-user.edit', $pickup_user->id) }}" class="btn btn-secondary btn-success"><i class="mdi mdi-account-edit"></i></a>
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
                           <th>Enable</th>
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
