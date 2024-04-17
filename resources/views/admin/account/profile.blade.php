@extends('admin.layout.master')

@section('title', 'Update Profile')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-1">
                        <i class="dripicons-user"></i>&nbsp;Admin profile
                     </h5>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="container row">
	<div class="col-4"></div>	
	<div class="col-4">
	<div class="card w-100 ">
		<div class="card-body">
			<div class="d-flex flex-column align-items-center text-center">
				
					<img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Logo"
						class="rounded-circle" width="150">

				<div class="mt-3">
					<h4> {{ Auth::guard('admin')->user()->name }}</h4>
					<p class="text-secondary mb-1"> {{ auth::guard('admin')->user()->mobile }}</p>
					<p class="text-muted font-size-sm">{{ auth::guard('admin')->user()->email }}</p>

				</div>
			</div>
		</div>
	</div>
</div>	
</div>
@endsection



{{-- 

@extends('admin.layout.base')

@section('title', 'Update Profile ')

@section('content')

<div class="content-area py-1">
    <div class="container-fluid">
    	<div class="box box-block bg-white">

			<h5 style="margin-bottom: 2em;">Update Profile</h5>

            <form class="form-horizontal" action="{{route('admin.profile.update')}}" method="POST" enctype="multipart/form-data" role="form">
            	{{csrf_field()}}

				<div class="form-group row">
					<label for="name" class="col-xs-2 col-form-label">Name</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ Auth::guard('admin')->user()->name }}" name="name" required id="name" placeholder=" Name">
					</div>
				</div>

				<div class="form-group row">
					<label for="email" class="col-xs-2 col-form-label">Email</label>
					<div class="col-xs-10">
						<input class="form-control" type="email" required name="email" value="{{ isset(Auth::guard('admin')->user()->email) ? Auth::guard('admin')->user()->email : '' }}" id="email" placeholder="Email">
					</div>
				</div>

				<div class="form-group row">
					<label for="picture" class="col-xs-2 col-form-label">Picture</label>
					<div class="col-xs-10">
						@if(isset(Auth::guard('admin')->user()->picture))
	                    	<img style="height: 90px; margin-bottom: 15px; border-radius:2em;" src="{{img(Auth::guard('admin')->user()->picture)}}">
	                    @endif
						<input type="file" accept="image/*" name="picture" class=" dropify form-control-file" aria-describedby="fileHelp">
					</div>
				</div>

				<div class="form-group row">
					<label for="zipcode" class="col-xs-2 col-form-label"></label>
					<div class="col-xs-10">
						<button type="submit" class="btn btn-primary">Update Profile</button>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>

@endsection --}}
