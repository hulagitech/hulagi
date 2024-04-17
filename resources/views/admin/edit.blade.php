

@extends('layout.layout')
@section('content')

<h1>Edit Notices</h1>
<hr>
<form action="{{url('notices', [$notice->id])}}" method="POST">
    <input type="hidden" name="_method" value="PUT">
    {{ csrf_field() }}
    <div class="form-group">
        <label for="title">Notice Heading</label>
        <input type="text" value="{{$notice->Heading}}" class="form-control" id="taskTitle"  name="Heading" >
    </div>
    <div class="form-group">
        <label for="description">Notice Description</label>
        <input type="text" value="{{$notice->Description}}" class="form-control" id="taskDescription" name="Description" >
    </div>
    
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
             <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
     
    <button type="submit" class="btn btn-primary">Submit</button>

</form>
@endsection

