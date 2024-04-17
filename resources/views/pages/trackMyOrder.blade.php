@extends('website.app')

@section('content')

		<div class="signup">
        	<div class="signup_box">
            	<h3>{{ Setting::get('site_title') }} | Track My Order</h3>
                <div class="container">
                    <form method="GET" action={{url('/trackMyOrder')}}>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="bookingID">Booking ID:</label>
                                @if(@$bookingID)
                                    <input type="text" class="form-control" id="bookingID" name="bookingID" placeholder="Booking ID" value="{{$bookingID}}"/>
                                @else
                                    <input type="text" class="form-control" id="bookingID" name="bookingID" placeholder="Booking ID"/>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="dropoffNumber">DropOff Number:</label>
                                @if(@$dropoffNumber)
                                    <input type="text" class="form-control" id="dropoffNumber" name="dropoffNumber" placeholder="DropOff Number" value="{{$dropoffNumber}}"/>
                                @else
                                    <input type="text" class="form-control" id="dropoffNumber" name="dropoffNumber" placeholder="DropOff Number"/>
                                @endif
                            </div>
                        </div>
                        <button style="margin-top:10px;" type="submit" class="btn btn-primary">Track</button> 
                    </form>
                    {{-- Check if track has been done --}}
                    @if(@$bookingID)
                        @if(@$order)
                            <table class="table">
                                <thead>
                                    <th>Booking ID</th>
                                    <th>Created Date</th>
                                    <th>Customer's Name</th>
                                    <th>Status</th>
                                    <th>Receiver's Name</th>
                                    <th>Receiver's Number</th>
                                    <th>Rider's Name</th>
                                    <th>Rider's Number</th>
                                    <th>Rider's Remarks</th>
                                </thead>
                                <tbody>
                                    <td>{{@$order->booking_id}}</td>
                                    <td>{{@$order->created_at}}</td>
                                    <td>{{@$order->user->first_name}}</td>
                                    <td>{{@$order->status}}</td>
                                    <td>{{@$order->item->rec_name}}</td>
                                    <td>{{@$order->item->rec_mobile}}</td>
                                    <td>{{@$order->provider->first_name}}</td>
                                    @if(@$order->status!="COMPLETED")
                                        <td>{{@$order->provider->mobile}}</td>
                                    @else
                                        <td>-</td>
                                    @endif
                                    @if(@$order->log)
                                        <td>{{@$order->log->complete_remarks}}</td>
                                    @else
                                        <td>-</td>
                                    @endif
                                </tbody>
                            </table>
                        @else
                            No Matching Order Found!!
                        @endif
                    @endif
                </div>
            </div>
        </div>
@endsection