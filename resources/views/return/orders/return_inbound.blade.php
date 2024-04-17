@extends('return.layout.master')

@section('title', 'Inbound Orders')

@section('content')

<link rel="stylesheet" type="text/css" href="{{asset('asset/front/css/bootstrap-tagsinput.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('asset/front/css/typeaheadjs.css')}}">

<div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0"><i class="fa fa-recycle"></i>Inbound Orders</h4>
                    </div>
                    @if(session()->has('message'))
			<div class="alert alert-success">
				{{ session()->get('message') }}
			</div>
		    @endif
                </div>

            </div>
        </div>
    </div>
 <div class="row">
        <div class="col-12">
            <div class="page-title-box">
            <div class="page-title-box bg-white">
                <div class="row align-items-center">
                    <div class="col-md-1"></div>
                    <h2 class="col-md-4">{{date('d M Y')}}</h2>
                    <h2 class="col-md-4">Sortcenter</h1>
                    <h3 class="col-md-2"><span id="dispatchCount">0</span></h3>
                    <div class="col-md-1"></div>
                </div>
                <form id="dispatchForm" method="POST" action="{{url('return/inbound')}}" method="POST" class="px-2">
                {{ csrf_field() }}
                <label>Orders</label>
                <div class="form-group row">
                <div class="col-12">
                        <input class="form-control form-control-lg typeahead" type="text" style="background-color:none;"  value="{{ old('data') }}" placeholder="Type in booking id" name="data" required id="data" autofocus>
                    </div>
                </div>
                <button type="button" class="btn btn-success mb-1" id="btn1">Return Inbound</button>
                <input type="hidden" name="btn1" id="btn1value"/>
                </div>
            </form>
                    </div>
                   
                </div>

            </div>
        </div>
</div>
        



<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    $('#btn1').click(function(){
        $('#btn1value').val('1');
        $('#dispatchForm').submit();
    });
</script>

    <script type="text/javascript" src="{{asset('asset/front/js/typeahead.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('asset/front/js/bootstrap-tagsinput.js')}}"></script>
    <script>
        var zones = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: {
                url: "{{url('/sortcenter/sortcenterOrders/')}}",
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

        $('.typeahead').change(function(){
            $("#dispatchCount").text($('.typeahead').val().split(",").length);
        });
        $('#submit').click(function(){
            console.log($('.typeahead').val());
        });
    </script>
@endsection


