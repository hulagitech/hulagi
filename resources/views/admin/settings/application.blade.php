@extends('admin.layout.master')
@section('title', 'Site Settings')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Business
                            Settings</h4>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.settings.store') }}" method="POST" enctype="multipart/form-data"
                        role="form">
                        {{ csrf_field() }}
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="name">Buisness Name</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text"
                                    value="{{ Setting::get('site_title', 'iLyft') }}" name="site_title" required
                                    id="site_title" placeholder="Business Name">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="name">Buisness Logo</label>
                            </div>
                            <div class="col-md-10">
                                @if (Setting::get('site_logo') != '')
                                    <img style="height: 90px; margin-bottom: 15px;"
                                        src="{{ url(Setting::get('site_logo', asset('logo-black.png'))) }}">
                                @endif
                                <input type="file" accept="image/*" name="site_logo" class="dropify form-control-file"
                                    id="site_logo" aria-describedby="fileHelp">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="name">Buisness White Logo</label>
                            </div>
                            <div class="col-md-10">
                                @if (Setting::get('site_logo') != '')
                                    <img style="height: 90px; margin-bottom: 15px;"
                                        src="{{ url(Setting::get('white_site_logo', asset('logo-black.png'))) }}">
                                @endif
                                <input type="file" accept="image/*" name="white_site_logo" class="dropify form-control-file"
                                    id="site_logo" aria-describedby="fileHelp">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="name">Buisness Icon</label>
                            </div>
                            <div class="col-md-10">
                                @if (Setting::get('site_icon') != '')
                                    <img style="height: 90px; margin-bottom: 15px;"
                                        src="{{ url(Setting::get('site_icon', asset('icon.png'))) }}">
                                @endif
                                <input type="file" accept="image/*" name="site_icon" class="dropify form-control-file"
                                    id="site_icon" aria-describedby="fileHelp">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="name">Copyright Content</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text"
                                    value="{{ Setting::get('site_copyright', '&copy; ' . date('Y') . ' Appoets') }}"
                                    name="site_copyright" id="site_copyright" placeholder="Site Copyright">
                            </div>
                        </div>

                        <div class="row form-group align-items-center">
                            <label for="store_link_user" class="col-md-2 text-right">Playstore User</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text"
                                    value="{{ Setting::get('store_link_user', '') }}" name="store_link_user"
                                    id="store_link_user" placeholder="Playstore User">
                            </div>
                        </div>

                        <div class="row form-group align-items-center">
                            <label for="store_link_provider" class="col-md-2 text-right">Playstore Driver</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text"
                                    value="{{ Setting::get('store_link_provider', '') }}" name="store_link_provider"
                                    id="store_link_provider" placeholder="Playstore Driver">
                            </div>
                        </div>

                        <div class="row form-group align-items-center">
                            <label for="store_link_android" class="col-md-2 text-right">Appstore User</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text"
                                    value="{{ Setting::get('store_link_android', '') }}" name="store_link_android"
                                    id="store_link_android" placeholder="Appstore User">
                            </div>
                        </div>

                        <div class="row form-group align-items-center">
                            <label for="store_link_ios" class="col-md-2 text-right">Appstore Driver</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{ Setting::get('store_link_ios', '') }}"
                                    name="store_link_ios" id="store_link_ios" placeholder="Appstore Driver">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <label for="store_link_ios" class="col-md-2 text-right">Distance Unit</label>
                            <div class="col-md-10">

                                <select class="form-control" id="sel1" name="unit">
                                    <option value="none">---- Select distance unit----</option>
                                    <option value="KM" <?php if (Setting::get('unit') == 'KM') {
    echo 'selected';
} ?>>KM</option>
                                    <option value="MILES" <?php if (Setting::get('unit') == 'MILES') {
    echo 'selected';
} ?>>MILES</option>

                                </select>
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <label for="provider_select_timeout" class="col-md-2 text-right">Driver Acceptence
                                Timeout</label>
                            <div class="col-md-10">
                                <input class="form-control" type="number"
                                    value="{{ Setting::get('provider_select_timeout', '60') }}"
                                    name="provider_select_timeout" required id="provider_select_timeout"
                                    placeholder="Provider Timout">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <label for="provider_search_radius" class="col-md-2 text-right">Provider Search
                                Radius</label>
                            <div class="col-md-10">
                                <input class="form-control" type="number"
                                    value="{{ Setting::get('provider_search_radius', '100') }}"
                                    name="provider_search_radius" required id="provider_search_radius"
                                    placeholder="Provider Search Radius">
                            </div>
                        </div>

                        <div class="row form-group align-items-center">
                            <label for="sos_number" class="col-md-2 text-right">Emergency Number</label>
                            <div class="col-md-10">
                                <input class="form-control" type="number"
                                    value="{{ Setting::get('sos_number', '911') }}" name="sos_number" required
                                    id="sos_number" placeholder="SOS Number">
                            </div>
                        </div>

                        <div class="row form-group align-items-center">
                            <label for="contact_number" class="col-md-2 text-right">Contact Number</label>
                            <div class="col-md-10">
                                <input class="form-control" type="number"
                                    value="{{ Setting::get('contact_number', '911') }}" name="contact_number" required
                                    id="contact_number" placeholder="Contact Number">
                            </div>
                        </div>

                        <div class="row form-group align-items-center">
                            <label for="contact_email" class="col-md-2 text-right"> Email</label>
                            <div class="col-md-10">
                                <input class="form-control" type="email"
                                    value="{{ Setting::get('contact_email', '') }}" name="contact_email" required
                                    id="contact_email" placeholder="Contact Email">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <label for="contact_email" class="col-md-2 text-right">Schedule Trigger Time</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text"
                                    value="{{ Setting::get('schedule_req_time', '') }}" name="schedule_req_time" required
                                    id="schedule_req_time" placeholder="Schedule Request Time">
                            </div>
                        </div>

                        <div class="row form-group align-items-center">
                            <label for="store_link_ios" class="col-md-2 text-right">Driver Phone Validation</label>
                            <div class="col-md-10">
                                <select class="form-control" id="driver_phone" name="driver_phone">
                                    <option value="none">---- Select distance unit----</option>
                                    <option value="Y" <?php if (Setting::get('driver_phone') == 'Y') {
    echo 'selected';
} ?>>Y</option>
                                    <option value="N" <?php if (Setting::get('driver_phone') == 'N') {
    echo 'selected';
} ?>>N</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <label for="store_link_ios" class="col-md-2 text-right">Driver Email Validation</label>
                            <div class="col-md-10">
                                <select class="form-control" id="driver_email" name="driver_email">
                                    <option value="none">---- Select distance unit----</option>
                                    <option value="Y" <?php if (Setting::get('driver_email') == 'Y') {
    echo 'selected';
} ?>>Y</option>
                                    <option value="N" <?php if (Setting::get('driver_email') == 'N') {
    echo 'selected';
} ?>>N</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <label for="store_link_ios" class="col-md-2 text-right">User Phone Validation</label>
                            <div class="col-md-10">
                                <select class="form-control" id="user_phone" name="user_phone">
                                    <option value="none">---- Select distance unit----</option>
                                    <option value="Y" <?php if (Setting::get('user_phone') == 'Y') {
    echo 'selected';
} ?>>Y</option>
                                    <option value="N" <?php if (Setting::get('user_phone') == 'N') {
    echo 'selected';
} ?>>N</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <label for="store_link_ios" class="col-md-2 text-right">User Email Validation</label>
                            <div class="col-md-10">
                                <select class="form-control" id="user_email" name="user_email">
                                    <option value="none">---- Select distance unit----</option>
                                    <option value="Y" <?php if (Setting::get('user_email') == 'Y') {
    echo 'selected';
} ?>>Y</option>
                                    <option value="N" <?php if (Setting::get('user_email') == 'N') {
    echo 'selected';
} ?>>N</option>
                                </select>
                            </div>
                        </div>

                        <div class="row form-group align-items-center">
                            <label for="contact_email" class="col-md-2 text-right">Order Cancellation Minute</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text"
                                    value="{{ Setting::get('ride_cancal_min', '') }}" name="ride_cancal_min" required
                                    id="ride_cancal_min" placeholder="In Second">
                            </div>
                        </div>

                        <div class="row form-group align-items-center">
                            <label for="contact_email" class="col-md-2 text-right">Order Cancellation
                                Charges($)</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text"
                                    value="{{ Setting::get('ride_cancal_chage', '') }}" name="ride_cancal_chage" required
                                    id="ride_cancal_chage" placeholder="In $">
                            </div>
                        </div>
                        <!-- <div class="row form-group align-items-center">
                                                                                                                                                                     <label for="contact_email" class="col-md-2 text-right">Schedule Time</label>
                                                                                                                                                                     <div class="col-md-10">
                                                                                                                                                                      <input class="form-control" type="text" value="{{ Setting::get('schedule_time', '') }}" name="schedule_time" required id="schedule_time" placeholder="Schedule Time">
                                                                                                                                                                     </div>
                                                                                                                                                                    </div> -->
                        <div class="row form-group align-items-center">
                            <label for="social_login" class="col-md-2 text-right">Chat</label>
                            <div class="col-md-10">
                                <select class="form-control" id="chat" name="chat">
                                    <option value="1" @if (Setting::get('chat', 0) == 1) selected @endif>Enable</option>
                                    <option value="0" @if (Setting::get('chat', 0) == 0) selected @endif>Disable</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <label for="social_login" class="col-md-2 text-right">Social Login User</label>
                            <div class="col-md-10">
                                <select class="form-control" id="social_login" name="social_login">
                                    <option value="1" @if (Setting::get('social_login', 0) == 1) selected @endif>Enable</option>
                                    <option value="0" @if (Setting::get('social_login', 0) == 0) selected @endif>Disable</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <label for="social_login" class="col-md-2 text-right">Social Login Driver</label>
                            <div class="col-md-10">
                                <select class="form-control" id="social_login_driver" name="social_login_driver">
                                    <option value="1" @if (Setting::get('social_login_driver', 0) == 1) selected @endif>Enable</option>
                                    <option value="0" @if (Setting::get('social_login_driver', 0) == 0) selected @endif>Disable</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group align-items-center justify-content-end">
                            <button type="submit" class="btn btn-primary mr-2">Update </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
