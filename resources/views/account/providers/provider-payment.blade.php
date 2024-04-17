@extends('account.layout.base')
@section('title', 'Update Log ')
@section('content')
<div class="content-area py-1">
    <div class="container-fluid">
    	<div class="box box-block bg-white">
    	    <!-- <a href="{{ route('admin.user.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> Back</a> -->

			<h5 style="margin-bottom: 2em;"><i class="ti-user"></i>&nbsp;Update Rider Log</h5><hr>

            <form class="form-horizontal" action="{{route('account.providers.update', $log->id )}}" method="POST" enctype="multipart/form-data" role="form">
            	{{csrf_field()}}
				<div class="form-group row">
					<label for="Amount" class="col-xs-2 col-form-label">Amount</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ $log->amount }}" name="amount"  placeholder="Amount">
					</div>
				</div>
				<div class="form-group row">
					<label for="remarks" class="col-xs-2 col-form-label">Remarks</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ $log->remarks }}" name="remarks" placeholder="remarks">
					</div>
				</div>
                <div class="form-group row">
					<label for="remarks" class="col-xs-2 col-form-label">Transaction Type</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ $log->transaction_type }}" name="remarks" placeholder="remarks" readonly >
					</div>
				</div>
				<div class="form-group row">
					<label for="zipcode" class="col-xs-2 col-form-label"></label>
					<div class="col-xs-10">
						<button type="submit" class="btn btn-primary">Update Log</button>
                        <a href="{{route('account.providers.delete',[$log->id, $log->provider_id])}}" class="btn btn-danger">Delete Log</a>
						<a href="{{url('account/statement/provider/'.$log->provider_id.'/log')}}" class="btn btn-default">Cancel</a>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>
@endsection
