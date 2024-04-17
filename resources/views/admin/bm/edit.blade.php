@extends('admin.layout.master')

@section('title', 'Edit Branch Manager')

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
                        <h4 class="page-title m-0">Edit Branch Manager</h4>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.branch-manager.update', $bm->id) }}" method="POST"
                        enctype="multipart/form-data" role="form">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PATCH">
                        <div class="row form-group align-items-center">
                            <label for="name" class="col-md-2 text-right">Full Name</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{ $bm->name }}" name="name" required
                                    id="name" placeholder="Full Name">
                            </div>
                        </div>

                        <div class="row form-group align-items-center">
                            <label for="email" class="col-md-2 text-right">Email</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{ $bm->email }}" readonly="true"
                                    name="email" required id="email" placeholder="Full Name">
                            </div>
                        </div>

                        <div class="row form-group align-items-center">
                            <label for="mobile" class="col-md-2 text-right">Mobile</label>
                            <div class="col-md-10">
                                <input class="form-control" type="number" value="{{ $bm->mobile }}" name="mobile"
                                    required id="mobile" placeholder="Mobile">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <label for="Dispatcher" class="col-md-2 text-right">Dispatcher</label>
                            <div class="col-md-10 w-100">
                                <input class="form-control typeahead w-100" type="text"
                                    placeholder="Type in and select dispatcher" name="dispatcher" required id="dispatcher"
                                    value="@foreach ($bm->dispatcher as $dispatcher){{ @$dispatcher->dispatcher->name }},@endforeach">

                            </div>
                        </div>


                        <div class="row form-group align-items-center">
                            <label for="enable" class="col-md-2 text-right">Enable</label>
                            <div class="col-md-10">
                                <label for="yes">Yes</label>
                                <input type="radio" id="yes" name="enable" value="1" @if (isset($bm->enable)) @if (@$bm->enable == '1') checked @endif @else checked @endif>
                                <label for="no">No</label>
                                <input type="radio" id="no" name="enable" value="0" @if (isset($bm->enable)) @if (@$bm->enable == '0') checked @endif @endif>
                            </div>
                        </div>
                        <div class="row form-group align-items-center justify-content-end">
                            <a href="{{ route('admin.branch-manager.index') }}" class="btn btn-danger mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary mr-2">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        var dispatcher = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            // url points to a json file that contains an array of country names, see
            // https://github.com/twitter/typeahead.js/blob/gh-pages/data/countries.json
            prefetch: {
                url: "{{ url('/admin/allDispatcher') }}",
                cache: false
            },
        });
        dispatcher.initialize();

        $('.typeahead').tagsinput({
            typeaheadjs: {
                name: 'dispatcher',
                source: dispatcher.ttAdapter()
            }
        });


        $('#branchit').click(function() {
            console.log($('.typeahead').val());
        });
    </script>

@endsection
