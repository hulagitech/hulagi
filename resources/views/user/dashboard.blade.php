@extends('user.layout.master')
@section('title', 'Dashboard ')
@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/admin/vendor/jvectormap/jquery-jvectormap-2.0.3.css') }}">
    <style>
    .someDiv {
    line-height: 1.5em;
    height: 3em;       /* height is 2x line-height, so two lines will display */
    overflow: hidden;  /* prevents extra lines from being visible */
    }
    .dotline {
   overflow: hidden;
   text-overflow: ellipsis;
   display: -webkit-box;
   -webkit-line-clamp: 2; /* number of lines to show */
   -webkit-box-orient: vertical;
}
    </style>

@endsection
@section('content')


    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Dashboard</h4>
                    </div>
                    <div class="col-md-4">
                        <div class="float-right">
                            <div class="dropdown">
                                <!-- <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="ti-settings mr-1"></i> Settings
                                </button> -->
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Separated link</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title end breadcrumb -->

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Pending Orders</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $pending_ride }}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-info"></span><span class="ml-2">
                            </span>
                    </div>

                </div>
                <div class="p-3">
                    <div class="float-right">
                        <a href="trip/pending" class="text-white-50"><i class="mdi mdi-eye-outline h5"></i></a>
                    </div>
                    <p class="font-14 m-0"><a href="trip/pending" style="color: white;">View More Details</a></p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-info mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Processing Order</h6>
                        <h4 class="mb-3 mt-0 float-right">{{$process_ride }}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-danger"></span><span class="ml-2"></span>
                    </div>
                </div>
                <div class="p-3">
                    <div class="float-right">
                        <a href="trip/processing" class="text-white-50"><i class="mdi mdi-eye-outline h5"></i></a>
                    </div>
                    <p class="font-14 m-0"><a href="trip/processing" style="color: white;">View More Details</a></p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-pink mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Scheduled Order</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $scheduled_rides }}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-primary"></span> <span class="ml-2">
                             </span>
                    </div>
                </div>
                <div class="p-3">
                    <div class="float-right">
                        <a href="trip/schedule" class="text-white-50"><i class="mdi mdi-eye-outline h5"></i></a>
                    </div>
                    <p class="font-14 m-0"><a href="trip/schedule" style="color: white;">View More Details</a></p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-success mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Completed Order</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $Complete_ride }}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-info"></span> <span class="ml-2"></span>
                    </div>
                </div>
                <div class="p-3">
                    <div class="float-right">
                        <a href="trip/complete" class="text-white-50"><i class="mdi mdi-eye-outline h5"></i></a>
                    </div>
                    <p class="font-14 m-0"><a href="trip/complete" style="color: white;">View More Details</a></p>
                </div>
            </div>
        </div>
         <div class="col-xl-3 col-md-6">
            <div class="card bg-success mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">REJECTED ORDER</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $rejected_rides }}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-info"></span> <span class="ml-2">
                            </span>
                    </div>
                </div>
                <div class="p-3">
                    <div class="float-right">
                        <a href="trip/reject" class="text-white-50"><i class="mdi mdi-eye-outline h5"></i></a>
                    </div>
                    <p class="font-14 m-0"><a href="trip/reject" style="color: white;">View More Details</a></p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-pink mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Cancel Order</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $cancel_rides }}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-primary"></span> <span class="ml-2">
                            </span>
                    </div>
                </div>
                <div class="p-3">
                    <div class="float-right">
                        <a href="trip/cancel" class="text-white-50"><i class="mdi mdi-eye-outline h5"></i></a>
                    </div>
                    <p class="font-14 m-0"><a href="trip/cancel" style="color: white;">View More Details</a></p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Returned Order</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $returned }}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-danger"></span> <span class="ml-2">
                            </span>
                    </div>
                </div>
                <div class="p-3">
                    <div class="float-right">
                        <a href="trip/returned" class="text-white-50"><i class="mdi mdi-eye-outline h5"></i></a>
                    </div>
                    <p class="font-14 m-0"><a href="trip/returned" style="color: white;">View More Details</a></p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Return Remaining</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $not_returned }}</h4>
                    </div>
                    <div>
                        <span class="badge badge-light text-info"></span> <span class="ml-2">
                            </span>
                    </div>

                </div>
                <div class="p-3">
                    <div class="float-right">
                        <a href="trip/return" class="text-white-50"><i class="mdi mdi-eye-outline h5"></i></a>
                    </div>
                    <p class="font-14 m-0"><a href="trip/return" style="color: white;">View More Details</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- end row -->

    <div class="row">
        <div class="col-xl-9">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Order Report</h4>
                    <div class="row">
                        <div class="col-lg-8">
                            <div id="hello" class="morris-chart" style="height: 300px"></div>
                        </div>
                        <div class="col-lg-4">
                            <div>
                                <h5 class="font-14 mb-5">Total Order Report</h5>

                                <div>
                                    <h5 class="mb-3"> {{$all_ride}} Order</h5>
                                    <p class="text-muted mb-4">Success is not final, failure is not fatal: it is the courage to continue that counts.</p>
                                    <a href="{{ url('mytrips') }}" class="btn btn-primary btn-sm">Load more <i
                                            class="mdi mdi-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">My Order</h4>
                    <div id="lol" class="morris-chart" style="height: 300px"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title mb-4"><a href="{{url('notice')}}" style="color: black;">Latest Notice</a></h4>
                    <div class="latest-massage">
                    @if (count($user_notices) > 0)
                                @foreach ($user_notices as $index=>$notice)
                                <a href="{{url('notice')}}" class="latest-message-list">
                                    <div class="border-bottom position-relative">
                                        <div class="message-time">
                                            <p class="m-0 text-muted"><span class="text-muted">{{ $notice->created_at->diffForHumans() }}</span></p>
                                        </div><br>
                                        <div class="float-left user mr-3">
                                            <h5 class="bg-primary text-center rounded-circle text-white mt-0">{{ $index +1 }}</h5>
                                        </div>
                                        <div class="massage-desc " >
                                            <h5 class="font-14 mt-0 text-dark someDiv">{{ $notice->Heading }} </h5>
                                            <!-- <div class="dotline">
                                            {!!$notice->Description!!}
                                            </div> -->
                                        </div>
                                    </div>
                                </a>
                                @if ($loop->iteration == 3) 
                                    @break;
                                @endif
                                 @endforeach
                                 <div class=text-right><a href="{{url('notice')}}">View more</a></div>
                        @else
                        
                            <div class="border-bottom position-relative">
                                <span>No Notice Availabel</span>
                            </div>
                            
                        @endif
                        
                    </div>

                </div>
            </div>

        </div>
        <!-- end col -->

        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title mb-4"><a href="{{url('all_comments')}}" style="color: black;">Recent Ticket</a></h4>
                    <ol class="activity-feed mb-0">
                        @if(count($tickets)>0)
                        @foreach($tickets as $index=>$comment)
                        <li class="feed-item">
                            <div class="feed-item-list">
                                <span class="date text-white-50">{{$comment->created_at->diffForHumans()}}</span>
                                <span class="activity-text text-white">{{ $comment->title }}</span><br>
                                <div class="dotline"> <small class="activity-text text-white ">{{ $comment->description }}</small></div>
                               
                                <span class="activity-text text-white"><a href="{{ url('ticket/comment/' . $comment->id) }}"
                                                style="text-decoration:none;">

                                    <button type="submit" style="margin: top 0px;color:white;" class="btn btn-link">View detail</button></a>
                                    </form></span>
                            </div>
                        </li>
                        @if ($loop->iteration == 3) 
                                    @break;
                                @endif
                        @endforeach
                        <div class=text-right><a href="{{url('ticket')}}">View more</a></div>
                        @else
                        <li class="feed-item">
                            <div class="feed-item-list">
                                <span class="date text-white-50"></span>
                                <span class="activity-text text-white">You don't have recent Comment</span>
                            </div>
                        </li>
                        @endif

                        <!-- <li class="feed-item">
                            <div class="feed-item-list">
                                <span class="date text-white-50">Jan 10</span>
                                <span class="activity-text text-white">Responded to need “Volunteer
                                    Activities”</span>
                            </div>
                        </li>
                        <li class="feed-item">
                            <div class="feed-item-list">
                                <span class="date text-white-50">Jan 09</span>
                                <span class="activity-text text-white">Added an interest “Volunteer
                                    Activities”</span>
                            </div>
                        </li>
                        <li class="feed-item">
                            <div class="feed-item-list">
                                <span class="date text-white-50">Jan 08</span>
                                <span class="activity-text text-white">Joined the group “Boardsmanship
                                    Forum”</span>
                            </div>
                        </li>
                        <li class="feed-item">
                            <div class="feed-item-list">
                                <span class="date text-white-50">Jan 07</span>
                                <span class="activity-text text-white">Responded to need “In-Kind
                                    Opportunity”</span>
                            </div>
                        </li> -->
                    </ol>

                </div>
            </div>
        </div>
        <!-- end col -->

        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title mb-4">Social Source</h4>
                    <div class="text-center">
                        <div class="social-source-icon lg-icon mb-3">
                        <a href="https://www.facebook.com/hulagilogistics" target="_blank" rel="noopener noreferrer"><i class="mdi mdi-facebook h2 bg-primary text-white"></i></a>
                        </div>
                        <h5 class="font-16" class="text-dark"><a href="https://www.facebook.com/hulagilogistics" target="_blank" rel="noopener noreferrer">Facebook </a></h5>
                        <p class="text-muted">Social media is not a media. The key is to listen, engage, and build relationships.</p>
                        
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-4">
                            <div class="social-source text-center mt-3">
                                <div class="social-source-icon mb-2">
                                <a href="https://www.facebook.com/hulagilogistics" target="_blank" rel="noopener noreferrer"><i class="mdi mdi-facebook h5 bg-primary text-white"></i>
                                </div></i></a> 
                                <p class="font-14 text-muted mb-2">4000 +</p>
                                <h6><a href="https://www.facebook.com/hulagilogistics" target="_blank" rel="noopener noreferrer">Facebook</a></h6>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="social-source text-center mt-3">
                                <div class="social-source-icon mb-2">
                                    <i class="mdi mdi-linkedin h5 bg-info text-white"></i>
                                </div>
                                <p class="font-14 text-muted mb-2">500 +</p>
                                <h6><a href="https://www.linkedin.com/company/hulagilogistics/" target="_blank" rel="noopener noreferrer">linkedin</a></h6>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="social-source text-center mt-3">
                                <div class="social-source-icon mb-2">
                                <a href="https://www.instagram.com/hulagi_logistics/?hl=en" target="_blank" rel="noopener noreferrer"> <i class="mdi mdi-instagram h5 bg-pink text-white"></i></a>
                                </div>
                                <p class="font-14 text-muted mb-2">2000 +</p>
                                <h6> <a href="https://www.instagram.com/hulagi_logistics/?hl=en" target="_blank" rel="noopener noreferrer">Instagram</a></h6>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-xl-9">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title mb-4">Recent Order</h4>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">SN.</th>
                                    <th scope="col">Order Placed</th>
                                    <th scope="col">Booking ID</th>
                                    
                                    <th scope="col">Receiver Name</th>
                                    
                                    <th scope="col">Status</th>
                                    <th scope="col">Details</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $diff = ['-success', '-info', '-warning', '-danger']; ?>
                            @foreach ($trips as $index => $ride)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>
                                    <span class="text-muted">{{ $ride->created_at->diffForHumans() }}</span>
                                </td>
                                <td>{{$ride->booking_id}}</td>
                                <td>{{ $ride->item['rec_name'] }}</td>
                                
                                <td>
                                    {{$ride->status}}
                                </td>
                                <td>

                                    <span class="underline">
                                        <form action="{{ url('/mytrips/detail') }}">

                                            <input type="hidden" value="{{ $ride->id }}" name="request_id">

                                            <button type="submit" style="margin-top: 0px;"
                                                class="btn btn-dark ">Details</button>

                                        </form>
                                    </span>


                                </td>   
                             </tr>
                             @if ($loop->iteration == 8) 
                                    @break;
                                @endif
                             @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title mb-4"><a href="{{url('payment_history')}}" style="color: black;">Payment History</a> </h4>
                    <table class="table table-striped mb-0">
                        <tbody>
                            @if(count($invoices)>0)
                            @foreach($invoices as $index => $invoice)
                            <tr>
                                <td><i class="far fa-file-pdf text-primary h2"></i></td>
                                <td>
                                    <h7 class="mt-0">{{ $invoice->created_at->diffForHumans() }}</h7>
                                    <p class="text-muted mb-0">Invoice-Id:{{ $invoice->invoice_no}} <br>Paid</p>
                                </td>
                                <td>
                                    <a href="{{ url('pay_details/'.$invoice->id) }}" class="btn btn-primary btn-sm">
                                        <i class="ti-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @if ($loop->iteration == 4) 
                                    @break;
                                @endif
                            @endforeach
                            <div class=text-right><a href="{{url('payment_history')}}">View more</a></div>
                            @else
                            <span>You don't have recent payment history</span>
                            @endif
                            
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')

<script>
    new Morris.Line({
  // ID of the element in which to draw the chart.
  element: 'hello',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: <?php echo $stats; ?>,
  // The name of the data record attribute that contains x-values.
  xkey: 'date',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['value'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['Value']
});
new Morris.Donut({
  element: 'lol',
  colors: [
    'Magenta',
    'lightgreen',
    'goldenrod',],
  data: <?php echo json_encode($donutData) ?>,
  formatter: function (x) { return x }
}).on('click', function(i, row){
  console.log(i, row);
});

// new Morris.Donut('lol', , ['#4bbbce', '#5985ee', '#46cd93']);


// ! function($) {
//     "use strict";

//     var Dashboard = function() {};

//     //creates line chart
//     Dashboard.prototype.createLineChart = function(element, data, xkey, ykeys, labels, lineColors) {
//             Morris.Line({
//                 element: element,
//                 data: data,
//                 xkey: xkey,
//                 ykey: ykey,
//                 labels: labels,
//                 hideHover: 'auto',
//                 gridLineColor: '#eef0f2',
//                 resize: true, //defaulted to true
//                 lineColors: lineColors
//             });
//         },

        



//         Dashboard.prototype.init = function() {

//             //create line chart
//             var $data = <?php echo $stats; ?>;
//             this.createLineChart('hello', $data, 'date', 'value', 'Series A', '#5985ee');


//         //init
//         $.Dashboard = new Dashboard,
//         $.Dashboard.Constructor = Dashboard
// }(window.jQuery),

// //initializing
// function($) {
//     "use strict";
//     $.Dashboard.init();
// }(window.jQuery);
</script>
@endsection
