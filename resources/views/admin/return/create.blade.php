@extends('admin.layout.master')
@section('title', 'Update User ')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Create Return Manager</h4>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
					  <form class="form-horizontal" action="{{route('admin.return-manager.store')}}" method="POST" enctype="multipart/form-data" role="form">
                        {{ csrf_field() }}
                    
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="first_name">Full Name </label>
                            </div>
                            <div class="col-md-10">
								<input class="form-control" type="text" value="{{ old('name') }}" name="name" required id="name" placeholder="Full Name">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="first_name">Email </label>
                            </div>
                            <div class="col-md-10">
								<input class="form-control" type="email" required name="email" value="{{old('email')}}" id="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
								<label for="first_name">Password</label>
                            </div>
                            <div class="col-md-10">
								<input class="form-control" type="password" name="password" id="password" placeholder="Password">  </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="first_name">Confirm Password </label>
                            </div>
                            <div class="col-md-10">
								<input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="Re-type Password">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="col-md-2 text-right">
                                <label for="first_name">Mobile </label>
                            </div>
                            <div class="col-md-10">
								<input class="form-control" type="number" value="{{ old('mobile') }}" name="mobile" required id="mobile" placeholder="Mobile">
                            </div>
                        </div>
                     
						
                        <div class="row form-group align-items-center justify-content-end">
                            <a href="{{route('admin.return-manager.index')}}" class="btn btn-danger mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary mr-2">Create User</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
  
@endsection




<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
	$(document).ready(function(){
		$("#email").focusout(function(){
			var field_name = this.name;
			var value = $(this).val();
			//alert(field_name+"="+value);

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			
			$.ajax({
				url: "{{url('admin/return_email')}}",
				type: 'post',
				data: field_name+"="+value,
				success:function(response){
					console.log(response);
					//alert(exist);
					//alert(response);
					if (response.exist){
						alert("Your Email has already taken");
						// $(this).next('.matched').show();
						// $(this).next('#email').focus();
					}					
				},
				error: function (request, error) {
					console.log(request);
					alert(" Can't do!! Error"+error);
				}
			});
		});
	});
</script>
