@extends('website.app')

@section('content')
        <object data="{{asset("asset/img/PuryauServices.pdf")}}" type="application/pdf" width="100%" height="600">
            <iframe src="https://docs.google.com/viewer?url={{asset("asset/img/PuryauServices.pdf")}}&embedded=true" width="100%" height="100%"></iframe>
        </object>
@endsection
