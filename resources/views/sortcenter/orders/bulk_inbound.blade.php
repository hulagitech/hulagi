@extends('sortcenter.layout.master')

@section('title', 'Inbound Orders')

@section('content')

    <link rel="stylesheet" type="text/css" href="{{ asset('asset/front/css/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/front/css/typeaheadjs.css') }}">


    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0"><i class="fa fa-recycle"></i>Bulk Inbound Orders</h4>
                    </div>
                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box bg-white">
                <div class="row align-items-center">
                    <div class="col-md-1"></div>
                    <h2 class="col-md-4">{{ date('d M Y') }}</h2>
                    <h2 class="col-md-4">Sortcenter</h1>
                        <h3 class="col-md-2"><span id="dispatchCount">0</span></h3>
                        <div class="col-md-1"></div>
                </div>
                <form id="dispatchForm" method="POST" action="{{ url('sortcenter/bulk/inbound') }}" method="POST"
                    class="px-2">
                    {{ csrf_field() }}
                    <label>Orders</label>
                    <input class="typeahead form-control form-control-lg " type="text" style="background-color:none"
                        placeholder="Type in booking id" name="data" required id="data" autofocus>


                    <button type="button" class="btn btn-success mt-2" id="btn1">Inbound</button>
                    <input type="hidden" name="btn1" id="btn1value" />

                </form>
            </div>
        </div>
    </div>



    <!-- <div class="content-area py-1">
                                        <div class="container-fluid">
                                            <div class="box box-block bg-white">
                                                <h5 class="mb-1"> <i class="fa fa-recycle"></i> Bulk Inbound Orders </h5>
                                                <hr/>
                                                @if (session()->has('message'))
                                       <div class="alert alert-success">
                                        {{ session()->get('message') }}
                                       </div>
                                      @endif
                                            </div>
                                            <div class="box box-block bg-white">
                                                <div class="row">
                                                    <div class="col-md-1"></div>
                                                    <h2 class="col-md-4">{{ date('d M Y') }}</h2>
                                                    <h2 class="col-md-4">Sortcenter</h1>
                                                    <h3 class="col-md-2"><span id="dispatchCount">0</span></h3>
                                                    <div class="col-md-1"></div>
                                                </div>
                                                <form id="dispatchForm" method="POST" action="{{ url('sortcenter/bulk/inbound') }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <div class="form-group row">
                                                        <label for="data" class="col-xs-12 col-form-label">Orders</label>
                                                        <div class="col-xs-12">
                                                            <input class="form-control typeahead" type="text" style="background-color:none;" placeholder="Type in booking id" name="data" required id="data" autofocus>
                                                        </div>
                                                        
                                                    </div>
                                                    <button type="button" class="btn btn-success" id="btn1">Inbound</button>
                                                    <input type="hidden" name="btn1" id="btn1value"/>
                                                </form>
                                            </div>
                                        </div>
                                    </div> -->



    {{-- <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script> --}}
    <script src="{{ asset('asset/user/js/jquery.min.js') }}"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        $('#btn1').click(function() {
            $('#btn1value').val('1');
            $('#dispatchForm').submit();
        });
    </script>

    <script type="text/javascript" src="{{ asset('asset/front/js/typeahead.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset/front/js/bootstrap-tagsinput.js') }}"></script>
    <script>
        var zones = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: {
                url: "{{ url('/sortcenter/sortcenterOrders/') }}",
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

        $('.typeahead').change(function() {
            $("#dispatchCount").text($('.typeahead').val().split(",").length);
        });
        $('#submit').click(function() {
            console.log($('.typeahead').val());
        });
    </script>
@endsection
