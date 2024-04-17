@foreach($requests as $request)
<div class="container">
        <div class="dropdown">
            <h1>
        <button class="btn btn-primary dropdown-toggle btn-lg" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{$request->booking_id}}
        </button>
    </h1>
    </div>
        <h3>Order Details</h3>
        <div class="row">
            <div class="col-md-6">
                <h5>  {{$request->s_address}} <i class="fa-fa-arrow-right">TO </i>   {{$request->d_address}}</h5>
                <p>Order Created: {{$request->created_at}}</p>
                <p>Pickup Number:{{ $request['Pickedup_number'] ? $request->Pickedup_number : $request->user->mobile }}</p>
                <p>COD Charge: {{$request->cod}}</p>
                <p>Delivery Charge:{{ currency(@$request['amount_customer']) }}</p>
                <p>Receiver Name:{{$request->item->rec_name}}</a></p>
                <p>Receiver Number: {{$request->item->rec_mobile}}</p>
                <p>Delivery Address: {{ $request['d_address'] ? $request->d_address : '-' }}</p>
                <p>Total Distance:{{ @$request['distance'] ? round($request->distance) : '-' }} KM</p>
                <p>Rider Assigned:@if($request->provider)
                       {{ @$request['provider']['first_name'] }}</dd>
                        @else
                       Provider not yet assigned!</dd>
                        @endif</p>
            </div>
            <div class="col-md-6">
                <p>Vendor Name: {{ @$request->user->first_name }}</p>
                <p>Status:{{$request->status}}</p>
                <p>Remarks: {{$request->remark}}</p>
                <p>Rider Remarks:</p>
                <p>Delivery Type:{{ $request['service_type']['name'] }}</p>

                                                    
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <h3>Order Log</h3>
                @foreach($request->logs as $log)
                 
                    <li> {{ @$log->description }} -- {{$log->created_at}}</li>
                 
                @endforeach
                
            </div>
        </div>
        <hr>
        <h3>Order Comments </h3>
        @foreach($request->comments as $comment)
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                        <div class="col-md-3">
                            <p class="card-title"><b>{{@$comment->authorised_type}}</b></p>
                        </div>
                        <div class="col-md-9">
                            <p class="card-text">{{$comment->comments}}<small><br>{{ $comment->created_at->diffForHumans() }}</small></p>
                        </div>
                    </div>
                    </div>
                </div>
            @endforeach
        <hr>
</div>
@endforeach