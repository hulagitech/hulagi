@extends('admin.layout.master')

@section('title', 'Add Branch Manager')


<style>
    .matched {
        display: none;
        color: red;
    }

</style>


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
                        <h4 class="page-title m-0">Add Branch Manager</h4>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.branch-manager.store') }}" method="POST" enctype="multipart/form-data"
                        role="form">
                        {{ csrf_field() }}
                        <div class="form-group row align-items-center">
                            <label for="name" class="col-md-2 text-right">Full Name</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{ old('name') }}" name="name" id="name"
                                    placeholder="Full Name" required>
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label for="email" class="col-md-2 text-right">Email</label>
                            <div class="col-md-10">
                                <input class="form-control" type="email" name="email" value="{{ old('email') }}"
                                    id="email" placeholder="Email" required>
                                <span class="matched">*</span>
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
                                    id="mobile" placeholder="Mobile" required>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label for="Dispatcher" class="col-md-2 text-right">Dispatcher</label>
                            <div class="col-md-10">
                                <input class="form-control typeahead" type="text"
                                    placeholder="Type in and select dispatcher" name="dispatcher" required id="dispatcher">
                                {{-- <select class="form-control" name="dispatcher_id" required id="zone">
							@foreach ($dispatchers as $dispatcher)
								<option value="{{$dispatcher->id}}">{{@$dispatcher->name}}</option>
							@endforeach
						</select> --}}
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


<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    $(document).ready(function() {
        $("#email").focusout(function() {
            var field_name = this.name;
            var value = $(this).val();
            //alert(field_name+"="+value);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ url('admin/bm_email') }}",
                type: 'post',
                data: field_name + "=" + value,
                success: function(response) {
                    console.log(response);
                    //alert(exist);
                    //alert(response);
                    if (response) {
                        alert("Your Email has already taken");
                        // $(this).next('.matched').show();
                        // $(this).next('#email').focus();
                    }
                },
                error: function(request, error) {
                    console.log(request);
                    alert(" Can't do!! Error" + error);
                }
            });
        });
    });
</script>
