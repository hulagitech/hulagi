@extends('admin.layout.master')

@section('title', 'Edit Dept.')

@section('content')

<div class="content-area py-1">
    <div class="container-fluid">
    	<div class="box box-block bg-white">
			<h5><i class="fa fa-sitemap"></i>&nbsp;Edit Department Info.</h5><hr>
            <form class="form-horizontal"  action="{{ route('admin.dept.update',$dept->id) }}" method="POST" enctype="multipart/form-data" role="form">
            	{{csrf_field()}}
            	
            	<div class="form-group row">
					<label for="dept" class="col-xs-2 col-form-label">Department</label>
					<div class="col-xs-4">
                        <input type="text" name="dept" id="dept" class="form-control" value="{{$dept->dept}}" placeholder="Department Name" required>
					</div>
				</div>

				<div class="form-group row">
                    <div class="col-xs-12 col-sm-6 offset-md-2 col-md-3">
                    	<button type="submit" class="btn btn-success btn-secondary" id="alertbox">Update</button>
                    	<a href="{{route('admin.dept.index')}}" class="btn btn-danger btn-secondary">Cancel</a>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>

@endsection

