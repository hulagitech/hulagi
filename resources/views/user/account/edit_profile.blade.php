@extends('user.layout.master')



@section('content')

    @include('common.notify')

    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Update Profile</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ url('profile') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="">Profile Image</label>

                            <br>
                            @if (isset(Auth::user()->picture))
                                <img class="profile_preview mb-2" id="profile_image_preview"
                                    src="{{ asset('storage/' . Auth::user()->picture) }}" alt="your logo" width="200"
                                    height='200' />
                                <br>
                            @endif
                            <input type="file" id="profile_img_upload_btn" name="picture" class="upload"
                                accept="image/x-png, image/jpeg" />
                        </div>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control form-control-lg" placeholder="Enter your name"
                                name="first_name" value="{{ Auth::user()->first_name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control form-control-lg" readonly
                                value="{{ Auth::user()->email }}" placeholder=" Enter email" required>
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                                else.</small>
                        </div>
                        <div class="form-group">
                            <label>Contact Number</label>
                            <input type="number" class="form-control form-control-lg" placeholder="Enter your mobile number"
                                name="mobile" value="{{ Auth::user()->mobile }}" required>
                        </div>
                        <div class="form-group">
                            <label>Are you a buisness or a person?</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="BORP" id="BORP" value="Business">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Business
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="BORP" id="BORP" value="Person">
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Person
                                </label>

                            </div>

                        </div>
                        <div class="form-group">
                            <label>VAT/PAN Number</label>
                            <input type="number" class="form-control form-control-lg" placeholder="Enter your VAT number"
                                name="vatpan" value="{{ Auth::user()->VAT_PAN }}" >
                        </div>
                        <div class="form-group">
                            <div class="info" style="background-color: #e7f3fe;border-left: 6px solid #2196F3;">
                                <p style="padding:1rem;"><strong>Info!</strong> If you are business 15% addition vat is
                                    applicable</p>
                            </div>
                            <div class="info" style="background-color: #e7f3fe;border-left: 6px solid #2196F3;">
                                <p style="padding:1rem;"><strong>Info!</strong>Government may charge you 15% TDX of your
                                    earning when you work as
                                    person or freelances</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Enter your document picture</label> <br>
                            @if (isset(Auth::user()->Document))
                                <img class="profile_preview mb-2" id="profile_image_preview"
                                    src="{{ asset('storage/' . Auth::user()->Document) }}" alt="your logo" width="200"
                                    height='200' />
                                <br>
                            @endif

                            <input type="file" name="document" class="upload" accept="image/x-png, image/jpeg" />
                        </div>

                        <div class="form-group ">

                            <label>New Password</label>

                            <input class="form-control form-control-lg" name="password" type="password"
                                placeholder="Enter your password">

                        </div>

                        <div class="form-group">

                            <label>Confirm Password</label>

                            <input type="text" class="form-control form-control-lg" name="confirm_password" type="password"
                                placeholder="Confirm your password">

                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

@endsection
