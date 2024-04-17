@extends('bm.layout.base')

@section('title', 'Edit Draft')

@section('content')
{{-- CSS and JS for tagsinput and typeahead --}}
<link rel="stylesheet" type="text/css" href="{{asset('asset/front/css/bootstrap-tagsinput.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('asset/front/css/typeaheadjs.css')}}">
<div class="content-area py-1" id="bm-panel">

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<h4 style="text-transform:uppercase;"><i class="fa fa-arrow-up"></i> Out Going</h4>
			</div>
		</div> 
		<div class="row">
			<div class="col-md-12">
				 <nav class="navbar navbar-light bg-white b-a mb-2">
					<button class="navbar-toggler hidden-md-up" data-toggle="collapse" data-target="#process-filters" aria-controls="process-filters" aria-expanded="false" aria-label="Toggle Navigation"></button>
					<div class="collapse navbar-toggleable-sm" id="process-filters">
						<ul class="nav navbar-nav bm-nav">
							<li class="nav-item bm-tab active">
								<a href={{route("bm.dispatchList.index")}}><span class="nav-link bm-link">New Dispatch</span></a>
							</li>
							<li class="nav-item bm-tab">
								<a href={{route("bm.dispatchList.myDispatch")}}><span class="nav-link bm-link">Dispatched</span></a>
							</li>
							<li class="nav-item bm-tab">
								<a href={{route("bm.dispatchList.completeReached")}}><span class="nav-link bm-link">Complete Reached</span></a>
							</li>
                            <li class="nav-item bm-tab">
								<a href={{route("bm.dispatchList.incompleteReached")}}><span class="nav-link bm-link">Incomplete Reached</span></a>
							</li>
							<li class="nav-item bm-tab">
								<a href={{route("bm.dispatchList.draft")}}><span class="nav-link bm-link">Draft</span></a>
							</li>
							<li class="nav-item bm-tab">
								<a href={{route("bm.dispatchList.return")}}><span class="nav-link bm-link">Return</span></a>
							</li>
							<li class="nav-item bm-tab">
								<a href={{route("bm.dispatchList.returnedDispatched")}}><span class="nav-link bm-link">Return Dispatched</span></a>
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</div>
		<div class="row" style="padding-left: 50px;">
            <h4>Dispatch Draft</h4>
		</div>
		@if(session()->has('message'))
			<div class="alert alert-success">
				{{ session()->get('message') }}
			</div>
		@endif
		<div class="content-area py-1">
			<div class="container-fluid">
                <div class="col-md-10">
                    <div class="box box-block bg-white">
                        @if(count($requests)>0)
                        <div class="row">
                            <div class="col-md-1"></div>
                            <h2 class="col-md-4">{{date('d M Y')}}</h2>
                            <h1 class="col-md-4">{{$searched_bm->name}}</h1>
                            <h3 class="col-md-2"><span id="dispatchCount">0</span>/{{$requests->count()-$zone_d_lists->count()}}</h3>
                            {{-- <h3 class="col-md-2"><span id="dispatchCount">0</span>/{{$remain_dispatch_nos->count()}}</h3> --}}
                            <div class="col-md-1"></div>
                        </div>
                        <form id="dispatchForm" method="POST" action="{{url('bm/dispatchList/myDraft/'.$zone_d_lists[0]->dispatch_id)}}">
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <div class="col-xs-12 col-form-label"> Total Orders: <b>{{$requests->count()}}</b> &nbsp;&nbsp;&nbsp; Saved in Draft: <b>{{$zone_d_lists->count()}}</b> </div>
                                <div class="col-xs-12">
                                    <input class="form-control typeahead" type="text" style="background-color:none;" placeholder="Type in booking id" name="data" required id="data" autofocus
									value="@foreach($zone_d_lists as $zone_d_list){{$zone_d_list->request->booking_id}},@endforeach">
                                </div>
							</div>
							<input type="hidden" name="bm" value="{{$searched_bm->id}}"/>
                            {{-- <button class="btn btn-warning" id="submit">Save</button> --}}
                            <button type="button" class="btn btn-success" id="btn1">Dispatch</button>
							<input type="hidden" name="btn1" id="btn1value"/>
							<button type="button" class="btn btn-warning" id="btn2">Update in Draft</button>
							<input type="hidden" name="btn2" id="btn2value"/>
                            {{-- <a href="#" class="saveDraft btn btn-warning"> Save to Draft </a> --}}
                        </form>
                        @else
							No Orders for the bm "{{$searched_bm->name}}"
                        @endif
                    </div>
                </div>
			</div>
		</div>
		
		<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<script>
			$('#btn1,#btn2').click(function(){
				var id=$(this).attr('id');
				if(id=="btn1"){
					$('#btn1value').val('1');
					$('#btn2value').val('0');
				}
				else{
					$('#btn2value').val('1');
					$('#btn1value').val('0');
				}
				$('#dispatchForm').submit();
			})
			var id=[];
			var index=0;
			$('.dispatch').on("change",function(){
				// if($(this).attr('checked'))
				if($(this).is(':checked')){
					id[index]=$(this).attr('id');
					index++;
					// console.log(id);
				}
				else{
					var remove=id.indexOf($(this).attr('id'));
					if(remove>-1){
						id.splice(remove,1);
						// console.log(id);
						index--;
					}
				}
			})
		</script>

		<script type="text/javascript" src="{{asset('asset/front/js/typeahead.min.js')}}"></script>
		<script type="text/javascript" src="{{asset('asset/front/js/bootstrap-tagsinput.js')}}"></script>
		<script>
			var zones = new Bloodhound({
				datumTokenizer: Bloodhound.tokenizers.whitespace,
				queryTokenizer: Bloodhound.tokenizers.whitespace,
				// url points to a json file that contains an array of country names, see
				// https://github.com/twitter/typeahead.js/blob/gh-pages/data/countries.json
				prefetch: {
					url: "{{url('/bm/dispatchOrders/'.$searched_bm->id)}}",
					cache: false
				},
			});
			zones.initialize();
			$('.typeahead').tagsinput({
			typeaheadjs: {
				name: 'zones',
				source: zones.ttAdapter()
			}
			});
			$('.typeahead').change(function(){
				$("#dispatchCount").text($('.typeahead').val().split(",").length);
			});
			$('#submit').click(function(){
				console.log($('.typeahead').val());
			});
		</script>

	</div>

</div>

@endsection



@section('styles')
    <style type="text/css">
        .bm-nav li span {
            /* // background-color: transparent; */
            color: #000!important;
            padding: 5px 12px;
        }
        .bm-nav li span:hover,
        .bm-nav li span:focus,
        .bm-nav li span:active {
            background-color: #20b9ae;
            color: #fff!important;
            padding: 5px 12px;
        }
        .bm-nav li.active span,
        .bm-nav li span:hover,
        .bm-nav li span:focus,
        .bm-nav li span:active {
            background-color: #20b9ae;
            color: #fff!important;
            padding: 5px 12px;
        }
    </style>
@endsection