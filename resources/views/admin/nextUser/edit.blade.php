@extends('admin.layout.master')
@section('title', 'Domain User')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Add Domain User</h4>
                    </div>
                    @if(session()->has('message'))
                        <div class="alert alert-danger">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.nextDashboardUser.update',$user->id) }}" method="POST"
                        enctype="multipart/form-data" role="form">
                        	{{csrf_field()}}
					        {{ method_field('PUT') }}
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="App_Name">App Name</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{$user->APP_NAME}}"
                                    name="App_Name" required id="App_Name" placeholder="Enter App Name" readonly>
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="App_Name">Company Full Name</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{$user->Company_Full_Name}}"
                                    name="Company_Full_Name" required id="App_Name" placeholder="Enter App Name">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="mobile">Phone No</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{$user->phone}}" name="mobile"
                                    required id="mobile" placeholder="Mobile">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="mobile">Support Phone No</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{$user->support}}" name="support"
                                    required id="support" placeholder="support mobile No">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="mobile">Finance Phone No</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{$user->finance}}" name="finance"
                                    required id="mobile" placeholder="Mobile">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="mobile">Marketing Phone No</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{$user->marketing}}" name="marketing"
                                    required id="mobile" placeholder="Mobile">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="email">Email</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{$user->Email}}" name="email"
                                    required id="email" placeholder="Email" readonly>
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="email">Location</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{$user->location}}" name="location"
                                    required id="location" placeholder="location">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="email">Facebook Link</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{$user->website_facebook}}" name="website_facebook"
                                     id="facebook" placeholder="Eg:Your facebook Page link">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="email">Linkedin Link</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{$user->webiste_linkedin}}" name="webiste_linkedin"
                                     id="linkedin" placeholder="Eg:Your Company Linkdedin Link">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="email">Instagram Link</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{$user->webiste_instagram}}" name="webiste_instagram"
                                     id="instagram" placeholder="Eg:Your Instagram Page Link">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="email">WebSite Link</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{$user->websitelink}}" name="websitelink"
                                    required id="website" placeholder="Eg:www.bharynag.com">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="email">Sub Domin Link</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{$user->subdomain_link}}" name="subdomain_link"
                                     id="subdomain" placeholder="Eg:portal.bharyang.com">
                            </div>
                        </div>
                         <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="picture">Black App Logo</label>
                            </div>
                            @if (isset($user->App_logo))
                                    <img style="height: 90px; margin-bottom: 15px; border-radius:2em;"
                                        src="{{  asset('storage/' .$user->App_logo) }}">
                                @endif
                            <div class="col-md-10">
                                <input type="file" accept="image/*" name="avatar" class="dropify form-control-file"
                                    id="picture" aria-describedby="fileHelp">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="picture">White App Logo</label>
                            </div>
                            @if (isset($user->White_App_logo))
                                    <img style="height: 90px; margin-bottom: 15px; border-radius:2em;"
                                        src="{{  asset('storage/' .$user->White_App_logo) }}">
                                @endif
                            <div class="col-md-10">
                                <input type="file" accept="image/*" name="White_App_logo" class="dropify form-control-file"
                                    id="picture" aria-describedby="fileHelp">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="picture">App Icon</label>
                            </div>
                             @if (isset($user->App_icon))
                                    <img style="height: 90px; margin-bottom: 15px; border-radius:2em;"
                                        src="{{  asset('storage/' .$user->App_icon) }}">
                                @endif
                            <div class="col-md-10">
                                <input type="file" accept="image/*" name="icon" class="dropify form-control-file"
                                    id="icon" aria-describedby="fileHelp">
                            </div>
                        </div>
                        <div class="row form-group align-items-center justify-content-end">
                            <a href="{{ route('admin.nextDashboardUser.index') }}" class="btn btn-danger mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary mr-2">Update Domain User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
