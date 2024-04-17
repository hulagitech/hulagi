@extends('admin.layout.master')

@section('title', 'Update Dispatcher ')

@section('content')
    {{-- CSS and JS for tagsinput and typeahead --}}
    <script type="text/javascript" src="{{ asset('asset/front/js/typeahead.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset/front/js/bootstrap-tagsinput.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/front/css/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/front/css/typeaheadjs.css') }}">

    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Update Dispatcher</h4>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.dispatch-manager.update', $dispatcher->id) }}" method="POST"
                        enctype="multipart/form-data" role="form">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PATCH">
                        <div class="form-group row align-items-center">
                            <label for="name" class="col-md-2">Full Name</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{ $dispatcher->name }}" name="name"
                                    required id="name" placeholder="Full Name">
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label for="email" class="col-md-2">Email</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{ $dispatcher->email }}" readonly="true"
                                    name="email" required id="email" placeholder="Full Name">
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label for="mobile" class="col-md-2">Mobile</label>
                            <div class="col-md-10">
                                <input class="form-control" type="number" value="{{ $dispatcher->mobile }}"
                                    name="mobile" required id="mobile" placeholder="Mobile">
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label for="zone" class="col-md-2">Zone</label>
                            <div class="col-md-10">
                                <input class="form-control typeahead" type="text" placeholder="Type in and select zones"
                                    name="zone" required id="zone" value="@foreach ($dispatcher->zones as $zone){{ @$zone->zone->zone_name }},@endforeach">
                                {{-- <select class="form-control" name="zone" required id="zone">
							@foreach ($zones as $zone)
								<option value="{{$zone->id}}" {{$dispatcher->zone_id==$zone->id?"selected":null}}>{{$zone->zone_name}}</option>
							@endforeach
						</select> --}}
                            </div>
                        </div>
						 <div class="row form-group align-items-center justify-content-end">
                            <a href="{{ route('admin.dispatch-manager.index') }}" class="btn btn-danger mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary mr-2">Update Dispatcher</button>
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
                        <h4 class="page-title m-0">Update Dispatcher password</h4>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('admin.changeDispacherPassword') }}" method="POST"
                        enctype="multipart/form-data" role="form">
                        {{ csrf_field() }}
                        <div class="form-group row align-items-center">
                            <label for="mobile" class="col-md-2">Password</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="" name="password" required id="password"
                                    placeholder="Password">
                                <input class="form-control" type="hidden" value="{{ $dispatcher->id }}" name="id"
                                    required id="id">
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label for="mobile" class="col-md-2">Confirm Password</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="" name="password_confirmation" required
                                    id="password_confirmation" placeholder="Confirm Password">
                            </div>
                        </div>
                         <div class="row form-group align-items-center justify-content-end">
                            <a href="{{ route('admin.dispatch-manager.index') }}" class="btn btn-danger mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary mr-2">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        var zones = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            // url points to a json file that contains an array of country names, see
            // https://github.com/twitter/typeahead.js/blob/gh-pages/data/countries.json
            prefetch: {
                url: "{{ url('/admin/allZones') }}",
                cache: false
            },
        });
        zones.initialize();
        $('.typeahead').tagsinput({
            typeaheadjs: {
                name: 'zones',
                source: zones.ttAdapter()
            }
        });
        $('#submit').click(function() {
            console.log($('.typeahead').val());
        });
    </script>
@endsection
