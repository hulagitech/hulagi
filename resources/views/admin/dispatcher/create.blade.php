@extends('admin.layout.master')

@section('title', 'Add Dispatcher ')

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
                        <h4 class="page-title m-0">Add Dispatcher</h4>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.dispatch-manager.store') }}" method="POST" enctype="multipart/form-data"
                        role="form">
                        {{ csrf_field() }}
                        <div class="form-group row align-items-center">
                            <label for="name" class="col-md-2 text-right">Full Name</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{ old('name') }}" name="name" required
                                    id="name" placeholder="Full Name">
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label for="email" class="col-md-2 text-right">Email</label>
                            <div class="col-md-10">
                                <input class="form-control" type="email" required name="email"
                                    value="{{ old('email') }}" id="email" placeholder="Email">
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label for="password" class="col-md-2 text-right">Password</label>
                            <div class="col-md-10">
                                <input class="form-control" type="password" name="password" id="password"
                                    placeholder="Password">
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label for="password_confirmation" class="col-md-2 text-right">Password
                                Confirmation</label>
                            <div class="col-md-10">
                                <input class="form-control" type="password" name="password_confirmation"
                                    id="password_confirmation" placeholder="Re-type Password">
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label for="mobile" class="col-md-2 text-right">Mobile</label>
                            <div class="col-md-10">
                                <input class="form-control" type="number" value="{{ old('mobile') }}" name="mobile"
                                    required id="mobile" placeholder="Mobile">
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label for="zone" class="col-md-2 text-right">Zone</label>
                            <div class="col-md-10">
                                <input class="form-control typeahead" type="text" placeholder="Type in and select zones"
                                    name="zone" required id="zone">
                                {{-- <select class="form-control" name="zone_id" required id="zone">
							@foreach ($zones as $zone)
								<option value="{{$zone->id}}">{{$zone->zone_name}}</option>
							@endforeach
						</select> --}}
                            </div>
                        </div>
                        <div class="row form-group align-items-center justify-content-end">
                            <a href="{{ route('admin.dispatch-manager.index') }}" class="btn btn-danger mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary mr-2">Add Dispatcher</button>
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
