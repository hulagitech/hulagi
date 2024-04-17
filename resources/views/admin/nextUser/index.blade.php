@extends('admin.layout.master')

@section('title', 'Domain User ')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-1">
                        <i class="fa fa-recycle"></i> &nbsp;All Domain User
                    </h5>
                </div>
                 @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                <div class="col-md-4 d-flex justify-content-end">
                    <a href="{{ route('admin.nextDashboardUser.create') }}" style="margin-left: 1em;" class="btn btn-secondary btn-rounded btn-success pull-right"><i class="fa fa-plus"></i> Add New Domain User</a>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body table-responsive">
                @if (count($users) != 0)
                <table id="datatable" class="table table-bordered"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>App Name</th>
                            <th>Company Full Name</th>
                            <th>Email</th>
                            <th>Office Phone No</th>
                            <th>Support Phone No</th>
                            <th>Finance Phone No</th>
                            <th>Marketing Phone No</th>
                            <th>Location</th>
                            <th>Facebook Link</th>
                            <th>Insatagram Link</th>
                            <th>Linkedin Link</th>
                            <th>Website Link</th>
                            <th>Subdomain Link</th>
                            <th>White Logo</th>
                            <th>Black Logo</th>
                            <th>App Icon</th>
                            <th class="w-50">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->APP_NAME }}</td>
                            <td>{{$user->Company_Full_Name}}</td>
                            <td>{{ $user->Email }}</td>
                            <td>
                                {{ $user->phone }}
                            </td>
                            <td>{{ $user->support }}</td>
                            <td>{{ $user->finance }}</td>
                            <td>{{ $user->marketing }}</td>
                            <td>
                                {{$user->location}}
                            </td>
                            <td>{{$user->wesite_facebook}}</td>
                          <td>{{$user->website_instagram}}</td>
                          <td>{{$user->website_linkedin}}</td>
                          <td>{{$user->websitelink}}</td>
                          <td>{{$user->subdomain_link}}</td>
                             <td>
                                <img src="{{ @$user->subdomain_link.'/storage/'.@$user->White_App_logo }}" alt="White Logo" style="width: 50px;">
                             </td>

                            <td><img src="{{  @$user->subdomain_link.'/storage/' .$user->App_logo }}" alt="White Logo" style="width: 50px;"></td>
                            <td><img src="{{   @$user->subdomain_link.'/storage/' .$user->App_icon }}" alt="White Logo" style="width: 50px;"></td>
                            <td> 
                                <!-- <a href="{{ route('admin.nextDashboardUser.show', $user->id) }}"
                                    class="btn btn-danger btn-primary m-1"><i class="fas fa-search"></i></a> -->
                                <a href="{{ route('admin.nextDashboardUser.edit', $user->id) }}"
                                    class="btn btn-secondary btn-success m-1"><i class="mdi mdi-pencil"></i></a>
                                <form class="btn btn-secondary btn-danger m-1"action="{{ route('admin.nextDashboardUser.destroy',$user->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
        
                                    <button type="submit"  class="btn-danger" ><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>App Name</th>
                             <th>Company Full Name</th>
                            <th>Email</th>
                            <th>Office Phone No</th>
                            <th>Support Phone No</th>
                            <th>Finance Phone No</th>
                            <th>Marketing Phone No</th>
                            <th>Location</th>
                            <th>Facebook Link</th>
                            <th>Insatagram Link</th>
                            <th>Linkedin Link</th>
                            <th>Website Link</th>
                            <th>Subdomain Link</th>
                            <th>White Logo</th>
                            <th>Black Logo</th>
                            <th>App Icon</th>
                            <th class="w-50">Action</th>
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

@section('scripts')

@include('user.layout.partials.datatable')

@endsection
@endsection