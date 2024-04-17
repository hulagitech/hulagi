@extends('admin.layout.master')

@section('title', 'Add New Dept.')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="row align-items-center">
				<div class="col-md-4">
				   <h4> <i class="fa fa-user"></i>&nbsp;Add Department.
					</h4>
				</div>
				<div class="col-md-8 d-flex justify-content-end">
				 {{-- <a href="{{ route('admin.dept.create') }}" style="margin-left: 1em;" class="btn btn-secondary btn-success btn-rounded pull-right"><i class="fa fa-plus"></i> Add New Department</a> --}}
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
					<form   action="{{ route('admin.dept.store') }}" method="POST" enctype="multipart/form-data" role="form">
					{{ csrf_field() }}

					
					<div class="row form-group align-items-center">
						<div class="col-md-2 text-right">
							<label for="password">Department</label>
						</div>
						<div class="col-md-10">
							<input type="text" name="dept" id="dept" class="form-control" placeholder="Department Name" required>
							
						</div>
					</div>
					<div class="row form-group align-items-center justify-content-end">
						<a href="{{ route('admin.user.index') }}" class="btn btn-danger mr-2">Cancel</a>
						<button type="submit" class="btn btn-primary mr-2">Create Department</button>
					</div>

				</form>
			</div>
		</div>
	</div>
</div>

@endsection

