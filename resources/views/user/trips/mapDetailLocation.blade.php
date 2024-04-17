<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div id="siteNotice">
    </div>
    <div id="bodyContent" style="width:250px;">
        <div style="width:100%" class="row">
            <div class="col-md-1"></div>
            <div class="col-md-5 p-0">Receiver Name : </div>
            <div class="col-md-5 p-0">
                <b>{{$rq->item->rec_name}}</b>
            </div>
        </div>
        <br>
        <div style="width:100%" class="row">
            <div class="col-md-1"></div>

            <div class="col-md-5 p-0">Receiver Mobile : </div>
            <div class="col-md-5 p-0">
                <b>{{$rq->item->rec_mobile}}</b>
            </div>
        </div>
        <br>
        <div style="width:100%" class="row">
            <div class="col-md-1"></div>

            <div class="col-md-5 p-0">Receiver Address : </div>
            <div class="col-md-5 p-0">
                <b>{{$rq->item->rec_address}}</b>
            </div>
        </div>
        <br>
        <div style="width:100%">
            <h6> {{$rq->status}}</h6>
        </div>

    </div>

</body>
</html>
