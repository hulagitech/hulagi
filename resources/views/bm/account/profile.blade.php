@extends('bm.layout.master')

@section('title', 'Update Profile')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-1">
                        <i class="dripicons-user"></i>&nbsp;user profile
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
				@if (Auth::user()->picture))
					<img class="rounded-circle" width="150"
						src=" {{ asset('storage/' . Auth::guard('bm')->user()->picture) }}" alt="your logo" width="200"
						height='200' />
				@else
					<img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Logo"
						class="rounded-circle" width="150">
				@endif

				<div class="mt-3">
					<h4> {{ Auth::guard('bm')->user()->name }}</h4>
					<p class="text-secondary mb-1"> {{ Auth::guard('bm')->user()->mobile }}</p>
					<p class="text-muted font-size-sm">{{ Auth::guard('bm')->user()->email }}</p>

				</div>
			</div>
		</div>
	</div>
</div>	
</div>
@endsection


