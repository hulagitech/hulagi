@extends('account.layout.master')

@section('title', 'Payment')

@section('content')
<style>
    .txtedit{
        display: none;
        width: 99%;
        height: 30px;
    }
</style>
<div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h4 class="page-title m-0">Rider Payment Bill</h4>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end">
                          <form class="form-inline pull-right" method="POST" action={{url('account/riderSearchPayment/billSearch')}}>
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="from_date" style="padding-top:5px;"> From: <label>
                                    <input type="date" class="form-control" name="from_date">
                                </div>
                                <div class="form-group">
                                    <label for="to_date" style="padding-top:5px;"> To: <label>
                                    <input type="date" class="form-control" name="to_date">
                                </div>
                                <div class="form-group pl-2">
                                    <button name="search" class="btn btn-success">Search</button>
                                </div>
                        </form>
                    </div>
                    <div class="col-md-12 d-flex justify-content-end pt-2">
                         <form class="form-inline pull-right" method="POST" action={{url('account/bill/provider')}}>
                            {{csrf_field()}}
                            <div class="form-group">
                                <input type="text" class="form-control" name="searchField" placeholder="Full Search">
                            </div>
                            <div class="form-group pl-2">
                                <button name="search" class="btn btn-success">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>
<div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
                  <table id="datatable-buttons" class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
             <thead>
                 <tr>
                     <th>S.N</th>
                     <th>Submitted At</th>
                     <th>Rider Name</th>
                     <th>Bill Image</th>
                     <th>Amount</th>
                     <td>Remarks</td>
                     <th>Action</th>
                 </tr>
                 </thead>
             <tbody>
                 @foreach($bill as $index => $rides)
                     <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $rides->created_at}}</td>
                        <td>{{ $rides->Provider->first_name}}</td>
                        <td>
                        <a href="{{ asset('storage/'.$rides['url']) }}" target="_blank"><img src="{{ asset('storage/'.$rides['url']) }}"  width="300px" height="300px"></a>
                        </td>
                        <td>
                        @if($rides->verify_done==1)    
                        {{$rides->amount}}
                        @else
                        <div class='edit'>
                            {{$rides->amount}}
                            </div>
                            <input type='text' class='txtedit' placeholder="Enter The Amount" id='amount-{{$rides->id}}'>
                            <input type='text' class='txtedit' placeholder="Remarks" id='remarks-{{$rides->id}}'>
                            <button class="buttonUpdate txtedit">Submit</button></td>
                        @endif
                        <td>{{ $rides->Remarks}}</td>
                        <td>
                            @if($rides->verify_done==0)
                            <a href="{{ route('account.bill.provider.verify', $rides->id) }}" class="btn btn-danger btn-rounded" >Verify</a>
                            @else
                            <a href="#" class="btn btn-success btn-rounded">Verified</a>
                            @endif

                            @if($rides->payment_done==0)
                            <a href="{{ route('account.bill.provider.payment', $rides->id) }}" class="btn btn-danger btn-rounded" >Payment</a>
                            @else
                            <a href="#" class="btn btn-success btn-rounded">Paid</a>
                            @endif
                            <a href="{{ route('account.bill.destroy', $rides->id) }}" class="btn btn-danger btn-rounded" >Delete</a>
                            
                        </td>
                     </tr>
                 @endforeach
             </tbody>
          </table>
          {{ $bill->appends(\Request::except('page'))->links() }}
                </div>

            </div>
        </div>
    </div>
</div>


 <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
		
		$(document).ready(function(){
	 
			// Show Input element
			$('.edit').click(function(){
				$('.txtedit').hide();
				$(this).next('.txtedit').show().focus();
				$(this).next('.txtedit').next('.txtedit').show();
				$(this).next('.txtedit').next('.txtedit').next('.txtedit').show();
				// $(this).hide();
			});

			$(".buttonUpdate").click(function(){
			
			// Get edit id, field name and 
			var amount=$(this).prev('.txtedit').prev('.txtedit');
			var remarks=$(this).prev('.txtedit');
			var id = amount[0].id;
			var split_id = id.split("-");
			var field_name = split_id[0];
			var edit_id = split_id[1];
			var sendValue=amount.val();
			var remarksText=remarks.val();
			var value = amount.val();
			amount.val("");
			remarks.val("");
			// Hide Input element
			// $(this).hide();
			$('.txtedit').hide();

			amount.prev('.edit').text(value);

			// Sending AJAX request
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				url: "{{url('account/bill/payment/provider')}}/"+edit_id,
				type: 'post',
				data: field_name+"="+sendValue+"&remarks="+remarksText,
				success:function(response){
					console.log(response); 
				},
				error: function (request, error) {
					console.log(request);
					alert(" Can't do!! Error"+error);
				}
			});
			// console.log($(this).html());
		
		});
	
		});
	</script>

@endsection
 @section('scripts')

    @include('user.layout.partials.datatable')

@endsection