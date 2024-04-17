@extends('admin.layout.master')

@section('title', 'Users ')

@section('styles')
<link rel="stylesheet" href="https://www.cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="https://code.jquery.com/jquery-1.8.2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
@endsection

@section('content')
<style>
  .morris-hover {
    position: absolute;
    z-index: 1000;
  }

  .morris-hover.morris-default-style {
    border-radius: 10px;
    padding: 6px;
    color: #666;
    background: rgba(255, 255, 255, 0.8);
    border: solid 2px rgba(230, 230, 230, 0.8);
    font-family: sans-serif;
    font-size: 12px;
    text-align: center;
  }

  .morris-hover.morris-default-style .morris-hover-row-label {
    font-weight: bold;
    margin: 0.25em 0;
  }

  .morris-hover.morris-default-style .morris-hover-point {
    white-space: nowrap;
    margin: 0.1em 0;
  }

  svg {
    width: 100%;
  }
</style>

<div class="row">
  <div class="col-sm-12">
    <div class="page-title-box">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h4 class="page-title m-0">Order Chart OF {{$user->first_name}}</h4>
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
            <div id="hello" class="morris-chart" style="height: 400px;width:100%"> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</div>

<script>
  data=<?php echo $stats; ?>,
 console.log(data)
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
</script>


@endsection