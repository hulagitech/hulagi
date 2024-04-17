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
                <div style="position: relative; top: 16px;padding-left:20px;">
                    <h5>{{$user->first_name ?? 'Passanger'}}</h5>
                    <p>Passanger</p>
                </div>
            </div>
        <br>
        <div style="width:100%" class="row">
            <div style="position: relative; top: 10px; padding-left:20px;">
                <h5>{{$rq->provider->first_name ?? "Driver"}}</h5>
                <p>Driver</p>
            </div>
        </div>
        <br>
        <div style="width:100%;padding-left:20px;" class="row">
            <p><b>From:</b> {{$rq->s_address}} </p>
            <p><b>To:</b> {{$rq->d_address}}</p>
            <p><b>Status:</b> {{$rq->status}}</p>
        </div>
        <div>
            <select class='txtedit' id='provider-{{$rq->user_id}}'>
                <option>Select Rider</option>
                @foreach($totalRiders as $rider)
                    <option value={{$rider['id']}}>{{$rider['first_name']}}</option>
                @endforeach
            </select>
        </div>
</body>
</html>