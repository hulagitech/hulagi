@extends('account.layout.master')

@section('title', 'Payment Detail')

@section('content')

    <div class="row" style="padding:20px;">
        <div class="col-md-12">
            <div>
                <h4 class="page-title"><i class="fa fa-angle-right"></i> Edit Bank Detail </h4>
            </div>
            <hr>
            
            <form class="form"  method="POST" action="{{ route('account.edit_bankDetail', @$detail->id) }}">
                {{ csrf_field() }}

                <div class="row form-group">
                    <label for="user_id" class="col-md-2 col-form-label"> User Name </label>
                    <div class="col-md-10">
                        <select class="col-md-3 form-control" id="user_id" name="user_id">
                            <option value=""> Select User </option>
                            @foreach (@$users as $user)
                                <option value="{{$user->id}}" {{$detail->user_id==$user->id?"selected":null}}> {{@$user->first_name}} @if(@$user->mobile) - ({{ $user->mobile }}) @endif </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row form-group" style="padding-top: 20px;">
                    <label for="bank_name" class="col-md-2 col-form-label">Bank Name</label>
                    <div class="col-md-3">
                        <input type="text" id="bank_name" name="bank_name" value="{{ $detail->bank_name }}" class="form-control" placeholder="Bank Name" required>
                    </div>
                </div>

                <div class="row form-group">
                    <label for="branch" class="col-md-2 col-form-label">Branch</label>
                    <div class="col-md-3">
                        <input type="text" id="branch" name="branch" value="{{ $detail->branch }}" class="form-control" placeholder="Branch Name" required>
                    </div>
                </div>

                <div class="row form-group">
                    <label for="ac_no" class="col-md-2 col-form-label">A/C No.</label>
                    <div class="col-md-3">
                        <input type="text" id="ac_no" name="ac_no" value="{{ $detail->ac_no }}" class="form-control" placeholder="Bank A/C Number" required>
                    </div>
                </div>

                <div class="row form-group">
                    <label for="ac_name" class="col-md-2 col-form-label">A/C Name</label>
                    <div class="col-md-3">
                        <input type="text" id="ac_name" name="ac_name" value="{{ $detail->ac_name }}" class="form-control" placeholder="A/C Holder Name" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="status" class="col-md-2 col-form-label">Status</label>
                    <div class="col-md-10">
                        <label for="status">Enable</label>
                        <input type="radio" id="Enable" name="status" value="1" @if(isset($detail->status)) @if(@$detail->status=='1') checked @endif @else checked @endif>
                        <label for="status">Disable</label>
                        <input type="radio" id="Disable" name="status" value="0" @if(isset($detail->status)) @if(@$detail->status=='0') checked @endif @endif>
                    </div>
                </div>

                <div class="form-group row">
                    <button type="submit" name="submit" class="btn btn-success btn-secondary">Submit</button>
                    <a href="{{route('account.bank_infos')}}" class="btn btn-danger btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection