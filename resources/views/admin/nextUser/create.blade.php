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
                    <form action="{{ route('admin.nextDashboardUser.store') }}" method="POST"
                        enctype="multipart/form-data" role="form">
                        {{ csrf_field() }}
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="first_name">App Name</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value=""
                                    name="App_Name" required id="App_Name" placeholder="Eg:Bharyang">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="first_name">Company Full Name</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value=""
                                    name="Company_Full_Name" required id="Company_Full_Name" placeholder="Eg:Bharyang Venture PVT. LTD">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="mobile">Office Phone Number</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="" name="mobile"
                                    required id="mobile" placeholder="Enter Office Phone Number">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="mobile">Support Phone No:</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="" name="support"
                                    required id="support" placeholder="Support Mobile Number">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="mobile">Finance Phone No:</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="" name="finance"
                                    required id="finance" placeholder="Finance Mobile Number">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="mobile">Marketing Phone No:</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="" name="marketing"
                                    required id="marketing" placeholder="Marketing Mobile Number">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="email">Email</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="" name="email"
                                    required id="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="email">Location</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="" name="location"
                                    required id="location" placeholder="Eg:Sankhamul; Kathmandu">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="email">Facebook Link</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="" name="website_facebook"
                                     id="facebook" placeholder="Eg:Your facebook Page link">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="email">Linkedin Link</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="" name="webiste_linkedin"
                                     id="linkedin" placeholder="Eg:Your Company Linkdedin Link">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="email">Instagram Link</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="" name="webiste_instagram"
                                     id="instagram" placeholder="Eg:Your Instagram Page Link">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="email">WebSite Link</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="" name="websitelink"
                                    required id="website" placeholder="Eg:www.bharynag.com">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="email">Sub Domin Link</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="" name="subdomain_link"
                                     id="subdomain" placeholder="Eg:http://portal.bharyang.com">
                            </div>
                        </div>
                         <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="picture">Black App Logo</label>
                            </div>
                            <div class="col-md-10">
                                <input type="file" accept="image/*" name="avatar" class="dropify form-control-file"
                                    id="picture" aria-describedby="fileHelp">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="picture">White App Logo</label>
                            </div>
                            <div class="col-md-10">
                                <input type="file" accept="image/*" name="White_App_logo" class="dropify form-control-file"
                                    id="white_logo" aria-describedby="fileHelp">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="picture">App Icon</label>
                            </div>
                            <div class="col-md-10">
                                <input type="file" accept="image/*" name="icon" class="dropify form-control-file"
                                    id="icon" aria-describedby="fileHelp">
                            </div>
                        </div>
                        <div class="row form-group align-items-center justify-content-end">
                            <a href="{{ route('admin.nextDashboardUser.index') }}" class="btn btn-danger mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary mr-2">Add Domain User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
