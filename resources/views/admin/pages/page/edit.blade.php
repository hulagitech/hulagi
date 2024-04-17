@extends('admin.layout.master')

@section('title', 'Update Page ')

@section('content')
 <div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h5 style="margin-bottom: 2em;"><i class="ti-layout-media-left-alt"></i>&nbsp;Update Page</h5><hr>
                </div>
               
            </div>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
                 <form class="form-horizontal" action="{{route('admin.page.update', $service->id )}}" method="POST" enctype="multipart/form-data" role="form">
                {{csrf_field()}}
				
                <input type="hidden" name="_method" value="PATCH">
                <div class="col-md-10">
                    <div class="tab-content">
                        <div class="tab-pane active" id="home" role="tabpanel" aria-expanded="false">
                            <div class="form-group row">
                                <label for="name" class="col-md-12 col-form-label">Page Name</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="{{ $service->en_title }}" name="en_title" required id="en_title" placeholder="Title">
                                </div>
                            </div>
                                                        
                            <div class="form-group row">
                                <label for="meta_keys" class="col-md-12 col-form-label">Meta Keys</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="{{ $service->en_meta_keys }}" name="en_meta_keys" required id="meta_keys" placeholder="Meta Keys">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="meta_description" class="col-md-12 col-form-label">Meta Description</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="{{ $service->en_meta_description }}" name="en_meta_description" required id="meta_description" placeholder="Meta Description">
                                </div>
                            </div>

                             <div class="form-group row">                    
                                <label for="image" class="col-md-12 col-form-label">Page Image</label>
                                <div class="col-md-10">
                                    @if(isset($service->image))
                                    <img style="height: 90px; margin-bottom: 15px; border-radius:2em;" src="{{ $service->image }}">
                                    @endif
                                    <input type="file" accept="image/*" name="image" class="dropify form-control-file" id="image" aria-describedby="fileHelp">
                                </div>
                            </div>
                     
                            <div class="form-group row">
                                <label for="description" class="col-md-12 col-form-label">Description</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" id="myeditor"  type="number"  name="en_description" required  placeholder="Description" rows="4">{{ $service->en_description }}</textarea>
                                </div>
                            </div>

                            
                        </div>
                       
                       
                        
                    </div>
                </div>               
				
                <div class="form-group row">
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <button type="submit" class="btn btn-success shadow-box btn-block">Update</button>
                    </div>
                    <div class="col-xs-12 col-sm-6 offset-md-4 col-md-3">
                        <a href="{{route('admin.page.index')}}" class="btn btn-danger btn-block">Cancel</a>
                    </div>
                    
                </div>
            </form>
				
				{{--<form class="form-horizontal" action="{{ route('admin.notices.update',$notice->id) }}" method="POST" >
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

				</form>--}}
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

