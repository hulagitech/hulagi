@extends('admin.layout.master')



@section('title', 'Add  New')



@section('content')
 <div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h5 style="margin-bottom: 2em;"><i class="ti-layout-media-left-alt"></i>&nbsp;Add New Page</h5><hr>
                </div>
               
            </div>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
            
            <form class="form-horizontal" action="{{route('admin.page.store')}}" method="POST" enctype="multipart/form-data" role="form">

                {{ csrf_field() }}

                <div class="col-md-10">
                    <div class="tab-content">
                        <div class="tab-pane active" id="home" role="tabpanel" aria-expanded="false">
                            <div class="form-group row">
                                <label for="name" class="col-md-12 col-form-label">Page Name</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="{{ old('en_title') }}" name="en_title" required id="en_title" placeholder="Title">
                                </div>
                            </div>
                                                        
                            <div class="form-group row">
                                <label for="meta_keys" class="col-md-12 col-form-label">Meta Keys</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="{{ old('en_meta_keys') }}" name="en_meta_keys" required id="meta_keys" placeholder="Meta Keys">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="meta_description" class="col-md-12 col-form-label">Meta Description</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="{{ old('en_meta_description') }}" name="en_meta_description" required id="meta_description" placeholder="Meta Description">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="picture" class="col-md-12 col-form-label">Page Image</label>
                                <div class="col-md-10">
                                    <input type="file" accept="image/*" name="image" class="dropify form-control-file" id="picture" aria-describedby="fileHelp">
                                </div>
                            </div>

                     
                            <div class="form-group row">
                                <label for="description" class="col-md-12 col-form-label">Description</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" id="myeditor"  type="number"  name="en_description" required  placeholder="Description" rows="4">{{ old('en_description') }}</textarea>
                                </div>
                            </div>

                            
                        </div>
                       
                       
                        
                    </div>
                </div>

                <div class="form-group row">

                    <div class="col-md-10">

                        <div class="row">
                           <div class="col-m4-12 ">

                                <button type="submit" class="btn btn-success shadow-box btn-block">Save</button>

                            </div>
                            <div class="col-m4-12 ">

                                <a href="{{ route('admin.page.index') }}" class="btn btn-danger btn-block">Cancel</a>

                            </div>

                        </div>

                    </div>

                </div>

            </form>
				
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')

<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>

<script type="text/javascript">

    CKEDITOR.replace('myeditor');

</script>

@endsection



