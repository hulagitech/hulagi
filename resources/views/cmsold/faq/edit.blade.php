@extends('cms.layout.base')

@section('title', 'Update Page ')

@section('content')
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <!-- <a href="{{ route('cms.faq.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i>Back</a> -->

            <h5 style="margin-bottom: 2em;"><span class="s-icon"><i class="ti-layout"></i></span>&nbsp;Update Page</h5><hr>
            <form class="form-horizontal" action="{{route('cms.faq.update', $service->id )}}" method="POST" enctype="multipart/form-data" role="form">
                {{csrf_field()}}
				
                <input type="hidden" name="_method" value="PATCH">
                <div class="form-group row">
                    <label for="name" class="col-xs-2 col-form-label">Page Name</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ $service->en_title }}" name="title" required id="title" placeholder="Title">
                    </div>
                </div>
				
				<div class="form-group row">
                    <label for="slug" class="col-xs-2 col-form-label">Page Slug</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ $service->slug }}" name="slug" required id="slug" placeholder="slug">
                    </div>
                </div>
				
				<div class="form-group row">
                    <label for="meta_keys" class="col-xs-2 col-form-label">Meta Keys</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ $service->en_meta_keys }}" name="meta_keys" required id="meta_keys" placeholder="Meta Keys">
                    </div>
                </div>
				
				<div class="form-group row">
                    <label for="meta_description" class="col-xs-2 col-form-label">Meta Description</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ $service->en_meta_description }}" name="meta_description" required id="meta_description" placeholder="Meta Description">
                    </div>
                </div>
                
               <div class="form-group row">
                    <label for="question" class="col-xs-2 col-form-label">Question</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ $service->en_question }}" name="question" required id="question" placeholder="Question">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="provider_name" class="col-xs-2 col-form-label">Description</label>
                    <div class="col-xs-10">
                        <textarea class="form-control" name="description" required id="myeditor" placeholder="Description">{{ $service->en_description }}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    
                    <label for="image" class="col-xs-2 col-form-label">Page Image</label>
                    <div class="col-xs-10">
                        @if(isset($service->image))
                        <img style="height: 90px; margin-bottom: 15px; border-radius:2em;" src="{{ $service->image }}">
                        @endif
                        <input type="file" accept="image/*" name="image" class="dropify form-control-file" id="image" aria-describedby="fileHelp">
                    </div>
                </div>
				
                <div class="form-group row">
                    <div class="col-xs-12 col-sm-6 col-md-3 offset-md-2">
                        <button type="submit" class="btn btn-success btn-secondary btn-block">Update</button>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3  offset-md-4">
                        <a href="{{route('cms.faq.index')}}" class="btn btn-danger btn-secondary btn-block">Cancel</a>
                    </div>
                    
                </div>
            </form>
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

