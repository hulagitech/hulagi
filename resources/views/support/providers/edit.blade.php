@extends('support.layout.master')
@section('title', 'Update Provider ')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Partner Profile</h4>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('support.provider.update', $provider->id) }}" method="POST"
                        enctype="multipart/form-data" role="form">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PATCH">
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="first_name">Name</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{ $provider->first_name }}"
                                    name="first_name" required id="first_name" placeholder="Name">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="picture">Picture</label>
                            </div>
                            <div class="col-md-10">
                                @if (isset($provider->avatar))
                                    <img style="height: 90px; margin-bottom: 15px; border-radius:2em;"
                                        src="{{ asset('/storage/app/public/' . $provider->avatar) }}"
                                        class="img-fluid">
                                @endif
                                <input type="file" accept="image/*" name="avatar" class="dropify form-control-file"
                                    id="picture" aria-describedby="fileHelp">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="mobile">Name</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{ $provider->mobile }}" name="mobile"
                                    required id="mobile" placeholder="Mobile">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="email">Email</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{ $provider->email }}" name="email"
                                    required id="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="type">Type</label>
                            </div>
                            <div class="col-md-10">
                                <select name="type" id="type" class="form-control" required>
                                    <option value="freelance" {{ $provider->type == 'freelance' ? 'selected' : null }}>
                                        Freelance
                                    </option>
                                    <option value="pickup" {{ $provider->type == 'pickup' ? 'selected' : null }}>
                                        Pickup
                                    </option>
                                    <option value="both" {{ $provider->type == 'both' ? 'selected' : null }}> Both
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="zone">Zone</label>
                            </div>
                            <div class="col-md-10">
                                <select name="zone_id" class="form-control" id="zone" required>
                                    @foreach ($zones as $zone)
                                        <option value="{{ $zone->id }}"
                                            {{ $provider->zone_id == $zone->id ? 'selected' : null }}>
                                            {{ $zone->zone_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="service_type">Vehicle</label>
                            </div>
                            <div class="col-md-10">
                                <select name="service_type" class="form-control" id="service_type" required>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}" <?php echo old('service_type', $provider->service->service_type_id) == $service->id ? 'selected' : ''; ?>>
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="service_number">Vehicle number</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text"
                                    value="{{ old('service_number', $provider->service->service_number) }}"
                                    name="service_number" required id="service_number" placeholder="Cab Number">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="service_model">Vehicle Model</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text"
                                    value="{{ old('service_model', $provider->service->service_model) }}"
                                    name="service_model" required id="service_model" placeholder="Cab Model">
                            </div>
                        </div>

                        <div class="row form-group align-items-center justify-content-end">
                            <a href="{{ route('support.provider.index') }}" class="btn btn-danger mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary mr-2">Update Driver</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Update password</h4>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ url('support/changeprovidorpassword') }}" method="POST"
                        enctype="multipart/form-data" role="form">
                        {{ csrf_field() }}

                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="password">Password</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="" name="password" required id="password"
                                    placeholder="Password">
                                <input class="form-control" type="hidden" value="{{ $provider->id }}" name="id"
                                    required id="id">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="password_confirmation">Confirm Password</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="" name="password_confirmation" required
                                    id="password_confirmation" placeholder="Confirm Password">
                            </div>
                        </div>
                        <div class="row form-group align-items-center justify-content-end">
                            <a href="{{ route('support.provider.index') }}" class="btn btn-danger mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary mr-2">Update Password</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
 
@endsection
