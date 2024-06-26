@extends('admin.layout.base')

@section('title', 'Update Service Type ')

@section('content')
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <!-- <a href="{{ route('admin.blog.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i>Back</a> -->

            <h5 style="margin-bottom: 2em;"><i class="ti-layout-media-left-alt"></i>&nbsp;Update Blog Post</h5><hr>
            <form class="form-horizontal" action="{{route('admin.blog.update', $service->id )}}" method="POST" enctype="multipart/form-data" role="form">
                {{csrf_field()}}
				
                <input type="hidden" name="_method" value="PATCH">
                <div class="col-md-10">
                    <ul class="nav nav-tabs m-b-0-5" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-expanded="false">En</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profile" role="tab" aria-expanded="true">Ar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profile_1" role="tab" aria-expanded="true">Fr</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profile_2" role="tab" aria-expanded="true">Ru</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profile_3" role="tab" aria-expanded="true">Es</a>
                        </li>
                        
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="home" role="tabpanel" aria-expanded="false">
                            <div class="form-group row">
                                <label for="name" class="col-xs-12 col-form-label">Page Name</label>
                                <div class="col-xs-10">
                                    <input class="form-control" type="text" value="{{ $service->en_title }}" name="en_title" required id="en_title" placeholder="Title">
                                </div>
                            </div>

                             <div class="form-group row">                    
                                <label for="image" class="col-xs-12 col-form-label">Page Image</label>
                                <div class="col-xs-10">
                                    @if(isset($service->image))
                                    <img style="height: 90px; margin-bottom: 15px; border-radius:2em;" src="{{ $service->image }}">
                                    @endif
                                    <input type="file" accept="image/*" name="image" class="dropify form-control-file" id="image" aria-describedby="fileHelp">
                                </div>
                            </div>
                     
                            <div class="form-group row">
                                <label for="description" class="col-xs-12 col-form-label">Description</label>
                                <div class="col-xs-10">
                                    <textarea class="form-control" id="myeditor"  type="number"  name="en_description" required  placeholder="Description" rows="4">{{ $service->en_description }}</textarea>
                                </div>
                            </div>

                            
                        </div>
                        <div class="tab-pane" id="profile" role="tabpanel" aria-expanded="true">
                             <div class="form-group row">
                                <label for="name" class="col-xs-12 col-form-label">Page Name</label>
                                <div class="col-xs-10">
                                    <input class="form-control arabic-content" type="text" value="{{ $service->ar_title }}" name="ar_title" id="ar_title" placeholder="Title">
                                </div>
                            </div>
                     
                            <div class="form-group row">
                                <label for="description" class="col-xs-12 col-form-label">Description</label>
                                <div class="col-xs-10">
                                    <textarea class="form-control arabic-content" id="ar_myeditor"  type="number"  name="ar_description"  placeholder="Description" rows="4">{{ $service->ar_description }}</textarea>
                                </div>
                            </div>
                        </div>
                       
                       <div class="tab-pane" id="profile_1" role="tabpanel" aria-expanded="true">
                             <div class="form-group row">
                                <label for="name" class="col-xs-12 col-form-label">Page Name</label>
                                <div class="col-xs-10">
                                    <input class="form-control" type="text" value="{{ $service->fr_title }}" name="fr_title" id="fr_title" placeholder="Title">
                                </div>
                            </div>
                     
                            <div class="form-group row">
                                <label for="description" class="col-xs-12 col-form-label">Description</label>
                                <div class="col-xs-10">
                                    <textarea class="form-control" id="fr_description"  type="number"  name="fr_description"  placeholder="Description" rows="4">{{ $service->fr_description }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="profile_2" role="tabpanel" aria-expanded="true">
                             <div class="form-group row">
                                <label for="name" class="col-xs-12 col-form-label">Page Name</label>
                                <div class="col-xs-10">
                                    <input class="form-control" type="text" value="{{ $service->ru_title }}" name="ru_title" id="ru_title" placeholder="Title">
                                </div>
                            </div>
                     
                            <div class="form-group row">
                                <label for="description" class="col-xs-12 col-form-label">Description</label>
                                <div class="col-xs-10">
                                    <textarea class="form-control" id="ar_myeditor"  type="number"  name="ru_description"  placeholder="Description" rows="4">{{ $service->ru_description }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="profile_3" role="tabpanel" aria-expanded="true">
                             <div class="form-group row">
                                <label for="name" class="col-xs-12 col-form-label">Page Name</label>
                                <div class="col-xs-10">
                                    <input class="form-control" type="text" value="{{ $service->sp_title }}" name="sp_title" id="sp_title" placeholder="Title">
                                </div>
                            </div>
                     
                            <div class="form-group row">
                                <label for="description" class="col-xs-12 col-form-label">Description</label>
                                <div class="col-xs-10">
                                    <textarea class="form-control" id="ru_myeditor"  type="number"  name="sp_description"  placeholder="Description" rows="4">{{ $service->sp_description }}</textarea>
                                </div>
                            </div>
                        </div>
                       
                        
                    </div>
                </div> 
				
                <div class="form-group row">
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <button type="submit" class="btn btn-success btn-block btn-secondary">Save</button>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3  offset-md-4">
                        <a href="{{route('admin.blog.index')}}" class="btn btn-danger btn-block btn-secondary">Cancel</a>
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

