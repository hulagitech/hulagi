@extends('admin.layout.base')

@section('title', 'Show Notice')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Show Notice</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('admin.notices.index') }}"> Back</a>
            </div>
        </div>
    </div>
   
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Heading:</strong>
                {{ $notice->Heading }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Description:</strong>
                {{ $notice->Description }}
            </div>
        </div>
    </div>
@endsection