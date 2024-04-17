@extends('admin.layout.base')

@section('title', 'Users ')

@section('content')

{{ $users->appends(\Request::except('page'))->links() }}
@endsection