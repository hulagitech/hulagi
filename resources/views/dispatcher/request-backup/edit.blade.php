@extends('admin.layout.base')

@section('title', 'Update Order ')

@section('content')

<div class="content-area py-1">
    <div class="container-fluid">
    	<div class="box box-block bg-white">
    	    <a href="{{ url()->previous() }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> Back</a>

			<h5 style="margin-bottom: 2em;">Update Order</h5>

            <form class="form-horizontal" action="{{route('admin.requests.update', $request->id )}}" method="POST" enctype="multipart/form-data" role="form">
            	{{csrf_field()}}
            	<input type="hidden" name="_method" value="PATCH">
				<div class="form-group row">
					<label for="first_name" class="col-xs-2 col-form-label">User Name</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ @$request->user->first_name }}" name="first_name" required id="first_name" placeholder="Name">
					</div>
                </div>
				<div class="form-group row">
					<label for="provider_id" class="col-xs-2 col-form-label">Provider Name</label>
					<div class="col-xs-10">
                        <select class="form-control" name="provider_id" id="provider_id">
                            <option value="Select Rider">Select Rider</option>
                            <?php
                                foreach ($provider as $p) {
                                    if($p["first_name"]==@$request->provider->provider_name){
                                        echo "<option value='$p[id]' selected>$p[first_name]</option>";
                                    }
                                    else{
                                        echo "<option value='$p[id]'>$p[first_name]</option>";
                                    }
                                }
                            ?>
                        </select>
						{{-- <input class="form-control" type="text" value="{{ @$request->provider->provider_name }}" name="provider_name"    id="first_name" placeholder="Name"> --}}
					</div>
				</div>
				
				
				
				
				{{-- <div class="form-group row">
					<label for="first_name" class="col-xs-2 col-form-label">Order Scheduled Time</label>
					<div class="col-xs-10">
						<input type="date" class="form-control" name="schedule_at" id="schedule_at" placeholder="Date" required="" value="{{ date('Y-m-d',strtotime($request->expires_at)) }}">
					</div>
					

                </div> --}}
                
                <div class="form-group row">
					<label for="status" class="col-xs-2 col-form-label">Order Status</label>
					<div class="col-xs-10">
                        <select class="form-control" name="status" id="status">
                            <?php
                                $statuses=['PENDING','CANCELLED','ACCEPTED','STARTED','ARRIVED','PICKEDUP','DROPPED','COMPLETED','SCHEDULED','WAITING'];
                                foreach ($statuses as $s) {
                                    if($s==$request->status){
                                        echo "<option value=$s selected>$s</option>";
                                    }
                                    else{
                                        echo "<option value=$s>$s</option>";
                                    }
                                }
                            ?>
                        </select>
					</div>
					

				</div>
				
				<div class="form-group row">
					<label for="zipcode" class="col-xs-2 col-form-label"></label>
					<div class="col-xs-10">
						<button type="submit" class="btn btn-primary">Update Order</button>
						<a href="{{route('admin.requests.scheduled')}}" class="btn btn-default">Cancel</a>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <h4>Scheduled Trip details</h4>
            
            <div class="row">
                <div class="col-md-6">
                    <dl class="row">
                        

                        <dt class="col-sm-4">Total Distance :</dt>
                        <dd class="col-sm-8">{{ @$request->distance ? round($request->distance) : '-' }} </dd>
                         
                        @if($request->status == 'SCHEDULED')
                        <dt class="col-sm-4">Order Scheduled Time :</dt>
                        <dd class="col-sm-8">
                            @if($request->schedule_at != "0000-00-00 00:00:00")
                                {{ date('jS \of F Y h:i:s A', strtotime($request->schedule_at)) }} 
                            @else
                                - 
                            @endif
                        </dd>
                        @else
                        <dt class="col-sm-4">Order Time :</dt>
                        <dd class="col-sm-8">
                            @if($request->started_at != "0000-00-00 00:00:00")
                                {{ date('jS \of F Y h:i:s A', strtotime($request->created_at)) }} 
                            @else
                                - 
                            @endif
                         </dd>
                        {{--
                        <dt class="col-sm-4">Order End Time :</dt>
                        <dd class="col-sm-8">
                            @if($request->finished_at != "0000-00-00 00:00:00") 
                                {{ date('jS \of F Y h:i:s A', strtotime($request->finished_at)) }}
                            @else
                                - 
                            @endif
                        </dd>--}}
                        @endif
                        
                        <dt class="col-sm-4">Pickup Address :</dt>
                        <dd class="col-sm-8">{{ $request->s_address ? $request->s_address : '-' }}</dd>

                        <dt class="col-sm-4">Drop Address :</dt>
                        <dd class="col-sm-8">{{ $request->d_address ? $request->d_address : '-' }}</dd>

                        @if($request->payment)
                        <dt class="col-sm-4">Base Price :</dt>
                        <dd class="col-sm-8">{{ currency($request->payment->fixed) }}</dd>

                        <dt class="col-sm-4">Tax Price :</dt>
                        <dd class="col-sm-8">{{ currency($request->payment->tax) }}</dd>

                        <dt class="col-sm-4">Total Amount :</dt>
                        <dd class="col-sm-8">{{ currency($request->payment->total) }}</dd>
                        @endif

                        {{-- <dt class="col-sm-4">Order Status : </dt>
                        <dd class="col-sm-8">
                            {{ $request->status }}
                        </dd> --}}
                        @if(!empty($promocode->promocode))
                        <dt class="col-sm-12"></dt>
                        <dt class="col-sm-12"><h4>Promocode </h4></dt>
                        
                        
                        <dt class="col-sm-4">Promo Code : </dt>
                        <dd class="col-sm-8">
                            {{$promocode->promocode->promo_code}}
                        </dd>
                        <dt class="col-sm-4">Discount : </dt>
                        <dd class="col-sm-8">
                            {{$promocode->promocode->discount}}
                        </dd>
                        <dt class="col-sm-4">Applied Date :</dt>
                        <dd class="col-sm-8">
                            @if($promocode->created_at != "0000-00-00 00:00:00") 
                                {{ date('jS \of F Y h:i:s A', strtotime($promocode->created_at)) }}
                            @else
                                - 
                            @endif
                        </dd>
                        @endif

                    </dl>
                </div>
                <div class="col-md-6">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
