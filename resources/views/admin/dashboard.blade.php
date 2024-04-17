@extends('admin.layout.master')

@section('title', 'Dashboard ')

@section('styles')
    <link rel="stylesheet" href="https://www.cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="https://code.jquery.com/jquery-1.8.2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <link rel="stylesheet" href="{{ asset('asset/admin/vendor/jvectormap/jquery-jvectormap-2.0.3.css') }}">
@endsection

@section('content')
    <style>

        svg {
            width: 100%;
        }

    </style>
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Today's Order</h4>
                    </div>
                    <div class="col-md-4">

                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Order Report</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="hello" class="morris-chart" style="height: 400px"></div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Bar Report</h4>
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="bar-chart" style="height: 400px"> </div>
                                
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        <div class="col-lg-12">
                
        </div>
        
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-primary mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">All Orders Today</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $rides }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-success mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Pending Orders</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $pending_rides }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-info mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Assigned Orders</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $assigned }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-primary mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Sortcenter</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $sortcenter }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-pink mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Accepted Orders</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $accepted_rides }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-primary mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Pickedup Orders</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $picked_rides }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-success mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Delivering</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $delivering }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-primary mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Completed Orders</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $completed_rides }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-info mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Rejected Orders</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $rejected_rides }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-pink mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Cancelled Orders</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $cancel_rides }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-success mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Scheduled Orders</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $scheduled_rides }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-primary mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Inside KTM Orders</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $inKtm }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-primary mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Outside KTM Orders</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $outKtm }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-pink mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Inter City Orders</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $interCity }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <h4 class="page-title m-0">All Orders</h4>
                    </div>
                    <div class="col-md-4">

                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-primary mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">All Orders Today</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $total_rides }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-success mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Pending Orders</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $total_pending_rides }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-info mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Assigned Orders</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $total_assigned }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-primary mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Sortcenter Orders</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $total_sortcenter }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-pink mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Accepted Orders</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $total_accepted_rides }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-primary mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Pickedup Orders</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $total_picked_rides }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-success mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Delivering Orders</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $total_delivering }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-primary mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Completed Orders</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $total_completed_rides }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-info mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Rejected Orders</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $total_rejected_rides }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-pink mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Cancelled Orders</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $total_cancel_rides }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-success mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Scheduled Orders</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $total_scheduled_rides }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-primary mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Inside KTM Orders</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $total_inKtm }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-primary mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Outside KTM Orders</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $total_outKtm }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card bg-pink mini-stat text-white">
                <div class="p-3 mini-stat-desc">
                    <div class="clearfix">
                        <h6 class="text-uppercase mt-0 float-left text-white-50">Inter City Orders</h6>
                        <h4 class="mb-3 mt-0 float-right">{{ $total_interCity }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        new Morris.Line({
            // ID of the element in which to draw the chart.
            element: 'hello',
            // Chart data records -- each entry in this array corresponds to a point on
            // the chart.
            data: <?php echo $total_stats; ?>,
            // The name of the data record attribute that contains x-values.
            xkey: 'date',
            // A list of names of data record attributes that contain y-values.
            ykeys: ['value'],
            // Labels for the ykeys -- will be displayed when you hover over the
            // chart.
            labels: ['Value']
        });

        // console.log('hi	');
        // // var data = <?php echo $stats; ?>
        // // console.log(data);
        $(document).ready(function() {

            barChart();
            //   lineChart();
            //   areaChart();
            //   donutChart();

            $(window).resize(function() {
                window.barChart.redraw();
                // window.lineChart.redraw();
                // window.areaChart.redraw();
                // window.donutChart.redraw();
            });
        });

        function barChart() {
            window.barChart = Morris.Bar({
                element: 'bar-chart',
                data: <?php echo $stats; ?>,
                xkey: 'user',
                ykeys: ['orders'],
                labels: ['orders'],
                lineColors: ['#1e88e5'],
                lineWidth: '2px',
                resize: true,
                redraw: true
            });
        }
    </script>
    
   
@endsection
