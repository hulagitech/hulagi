@extends('account.layout.master')

@section('title', 'Payment Detail')

@section('content')

    <div class="row" style="padding:20px;">
        <div class="col-lg-12">
            <div>
                <h4 class="page-title"><i class="fa fa-angle-right"></i> Add Bank Detail </h4>
            </div>
            <hr>
            
            <form class="form"  method="POST" action="{{ route('account.add_bankDetail') }}">
                {{ csrf_field() }}
                {{-- {{ method_field('POST') }} --}}

                <div class="row form-group">
                    <label for="user_id" class="col-md-2 col-form-label"> User Name </label>
                    <div class="col-md-3">
                        <select class="user_id  form-control" id="user_id" name="user_id">
                            {{-- <option value=""> Select User </option> --}}
                            @foreach (@$users as $user)
                                <option value="{{@$user->id}}"> {{@$user->first_name}} @if(@$user->mobile) - ({{ $user->mobile }}) @endif </option>
                                {{-- <option value="{{$user->id}}" {{$user_req->user_id==$user->id?"selected":null}}> {{$user->user}} </option> --}}
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row form-group" style="padding-top: 20px;">
                    <label for="bank_name" class="col-md-2 col-form-label">Bank Name</label>
                    <div class="col-lg-3">
                        <input type="text" id="bank_name" name="bank_name" class="form-control" placeholder="Bank Name" required>
                    </div>
                </div>

                <div class="row form-group">
                    <label for="branch" class="col-md-2 col-form-label">Branch</label>
                    <div class="col-lg-3">
                        <input type="text" id="branch" name="branch" class="form-control" placeholder="Branch Name" required>
                    </div>
                </div>

                <div class="row form-group">
                    <label for="ac_no" class="col-md-2 col-form-label">A/C No.</label>
                    <div class="col-lg-3">
                        <input type="text" id="ac_no" name="ac_no" class="form-control" placeholder="Bank A/C Number" required>
                    </div>
                </div>

                <div class="row form-group">
                    <label for="ac_name" class="col-md-2 col-form-label">A/C Name</label>
                    <div class="col-lg-3">
                        <input type="text" id="ac_name" name="ac_name" class="form-control" placeholder="A/C Holder Name" required>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-success btn-secondary">Submit</button>
                    <a href="{{route('account.bank_infos')}}" class="btn btn-danger btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection