@extends('admin.layout.master')


@section('title', 'Add Notice ')

@section('content')
 <!--TINYMC JS-->
 <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
 <div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h4> <i class="fa fa-plus"></i>&nbsp; Update Notice

                    </h4>
                </div>
               
            </div>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				
				<form class="form-horizontal" action="{{ route('admin.notices.update',$notice->id) }}" method="POST" >
					{{csrf_field()}}
					{{ method_field('PUT') }}
				
					<div class="row form-group align-items-center">
						<div class="col-md-2 text-right">
							<label for="first_name">Heading </label>
						</div>
						<div class="col-md-10">
							<input class="form-control" type="text" value="{{ $notice->Heading }}" name="Heading" required id="Heading" placeholder="Heading">
						</div>
					</div>
					<div class="row form-group align-items-center">
						<div class="col-md-2 text-right">
							<label for="first_name">Description </label>
						</div>
						<div class="col-md-10">
							<textarea  id="Description" class="form-control" style="height:150px" name="Description" required id="Description" placeholder="Description">{{ $notice->Description }}</textarea>
						</div>
					</div>
					
					
					<div class="row form-group align-items-center justify-content-end">
						<a href="{{route('admin.notices.index')}}" class="btn btn-danger mx-2">Cancel</a>
						<button type="submit" class="btn btn-primary mr-2">update Notice</button>
					</div>

				</form>
			</div>
		</div>
	</div>
</div>




<script>

tinymce.init({
  selector: 'textarea#Description',
  height: 500,
  menubar: false,
  plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table paste code help wordcount'
  ],
  toolbar: 'undo redo | formatselect | ' +
  'bold italic backcolor | alignleft aligncenter ' +
  'alignright alignjustify | bullist numlist outdent indent | ' +
  'removeformat | help',
  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
});


</script>

@endsection


