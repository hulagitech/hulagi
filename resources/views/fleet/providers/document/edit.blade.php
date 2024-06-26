@extends('fleet.layout.base')

@section('title', 'Provider Documents ')

@section('content')
<div class="content-area py-1">
    <div class="container-fluid">
        
        <div class="box box-block bg-white">
            <h5 class="mb-1">Driver Name: {{ $Document->provider->first_name }}</h5>
            <h5 class="mb-1">Document: {{ $Document->document->name }}</h5>
            <embed src="{{ asset('storage/'.$Document->url) }}" width="100%" height="100%" />

            <div class="row">
                <div class="col-xs-6">
                    <form action="{{ route('fleet.provider.document.update', [$Document->provider->id, $Document->id]) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <button class="btn btn-block btn-success btn-secondary" type="submit">Approve</button>
                    </form>
                </div>

                <div class="col-xs-6">
                    <form action="{{ route('fleet.provider.document.destroy', [$Document->provider->id, $Document->id]) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="btn btn-block btn-danger btn-secondary" type="submit">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection