

<h1>Add New Notice</h1>
<hr>
<form action="/notices" method="post">
{{ csrf_field() }}
    <div class="form-group">
        <label for="title">Notice Heading</label>
        <input type="text" class="form-control" id="taskTitle"  name="Heading">
    </div>
    <div class="form-group">
        <label for="description">Notice Description</label>
        <input type="text" class="form-control" id="taskDescription" name="Description">
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