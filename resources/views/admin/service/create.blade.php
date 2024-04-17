@extends('admin.layout.base')

@section('title', 'Add Category Type ')

@section('content')
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <!-- <a href="{{ route('admin.service.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> Back</a> -->

            <h5 style="margin-bottom: 2em;"><i class="ti-car"></i>&nbsp;Add Category</h5><hr>

            <form class="form-horizontal" action="{{route('admin.service.store')}}" method="POST" enctype="multipart/form-data" role="form">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label for="name" class="col-xs-12 col-form-label">Category Name</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ old('name') }}" name="name" required id="name" placeholder="Cab Name">
                    </div>
                </div>

                <!-- <div class="form-group row">
                    <label for="provider_name" class="col-xs-12 col-form-label">Vehicle Type</label>
                    <div class="col-xs-10">
                        <select name="provider_name" required id="provider_name" class="form-control">
                            <option value="Economy">Economy</option>
                            <option value="Premium">Premium</option>
                            <option value="Outstation">Outstation</option>
                            <option value="Rental">Rental</option>
                            <option value="Pool">Pool</option>
                        </select>
                    </div>
                </div> -->

                <div class="form-group row">
                    <label for="picture" class="col-xs-12 col-form-label">Category Icon</label>
                    <div class="col-xs-10">
                        <input type="file" accept="image/*" name="image" class="dropify form-control-file" id="picture" aria-describedby="fileHelp">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fixed" class="col-xs-12 col-form-label">Base Price ({{ currency() }})</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ old('fixed') }}" name="fixed" required id="fixed" placeholder="Base Price">
                    </div>
                </div>
                <div class="form-group row" >
                    <label for="distance" class="col-xs-12 col-form-label">Base Distance (KM)</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="0" name="distance" required id="distance" placeholder="Base Distance">
                    </div>
                </div>
                <span style="display:none">
                <div class="form-group row">
                    <label for="minute" class="col-xs-12 col-form-label">Unit Time Pricing ({{ currency() }})</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="hidden" value="0" name="minute" required id="minute" placeholder="Unit Time Pricing">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="price" class="col-xs-12 col-form-label">Unit Distance Price (KM)</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="hidden" value="0" name="price" required id="price" placeholder="Unit Distance Price">
                    </div>
                </div>
                 </span>
                <div class="form-group row">
                    <label for="capacity" class="col-xs-12 col-form-label">Weight Capacity</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ old('capacity') }}" name="capacity" required id="capacity" placeholder="Capacity">
                    </div>
                </div>


                <input class="form-control" type="hidden" value="MIN" name="calculator" >
                
                <!--<div class="form-group row">-->
                <!--    <label for="calculator" class="col-xs-12 col-form-label">Pricing Logic</label>-->
                <!--    <div class="col-xs-10">-->
                <!--        <select class="form-control" id="calculator" name="calculator">-->
                <!--            <option value="MIN">@lang('servicetypes.MIN')</option>-->
                <!--            <option value="HOUR">@lang('servicetypes.HOUR')</option>-->
                <!--            <option value="DISTANCE">@lang('servicetypes.DISTANCE')</option>-->
                <!--            <option value="DISTANCEMIN">@lang('servicetypes.DISTANCEMIN')</option>-->
                <!--            <option value="DISTANCEHOUR">@lang('servicetypes.DISTANCEHOUR')</option>-->
                <!--        </select>-->
                <!--    </div>-->
                <!--</div>-->

                <div class="form-group row">
                    <label for="description" class="col-xs-12 col-form-label">Description</label>
                    <div class="col-xs-10">
                        <textarea class="form-control" type="text" value="{{ old('description') }}" name="description" required id="description" placeholder="Description" rows="4"></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-xs-10">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <button type="submit" class="btn btn-success btn-secondary btn-block">Add Category</button>
                            </div>
                            <div class="col-xs-12 col-sm-6 offset-md-6 col-md-3">
                                <a href="{{ route('admin.service.index') }}" class="btn btn-danger btn-block btn-secondary">Cancel</a>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
