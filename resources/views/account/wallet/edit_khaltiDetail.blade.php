@extends('account.layout.base')

@section('title', 'Payment Detail')

@section('content')

    <div class="row" style="padding:20px;">
        <div class="col-md-12">
            <div>
                <h4 class="page-title"><i class="fa fa-angle-right"></i> Add Bank Detail </h4>
            </div>
            <hr>
            
            <form class="form"  method="POST" action="{{ route('account.edit_khaltiDetail', @$detail->id) }}">
                {{ csrf_field() }}

                <div class="row form-group">
                    <label for="user_id" class="col-md-2 col-form-label"> User Name </label>
                    <div class="col-md-3">
                        <select class="col-md-3 form-control" id="user_id" name="user_id">
                            <option value=""> Select User </option>
                            @foreach (@$users as $user)
                                <option value="{{$user->id}}" {{$detail->user_id==$user->id?"selected":null}}> {{@$user->first_name}} @if(@$user->mobile) - ({{ $user->mobile }}) @endif </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row form-group" style="padding-top: 20px;">
                    <label for="khalti_id" class="col-md-2 col-form-label">Khalti Id</label>
                    <div class="col-md-3">
                        <input type="text" id="khalti_id" name="khalti_id" value="{{ $detail->khalti_id }}" class="form-control" placeholder="Khalti Id" required>
                    </div>
                </div>

                <div class="row form-group">
                    <label for="khalti_username" class="col-md-2 col-form-label">Khalti Username</label>
                    <div class="col-md-3">
                        <input type="text" id="khalti_username" name="khalti_username" value="{{ $detail->khalti_username }}" class="form-control" placeholder="Khalti Username" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="status" class="col-md-2 col-form-label">Status</label>
                    <div class="col-md-10">
                        <label for="status">Enable</label>
                        <input type="radio" id="status" name="status" value="1" @if(isset($detail->status)) @if(@$detail->status=='1') checked @endif @else checked @endif>
                        <label for="status">Disable</label>
                        <input type="radio" id="status" name="status" value="0" @if(isset($detail->status)) @if(@$detail->status=='0') checked @endif @endif>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-success btn-secondary">Submit</button>
                    <a href="{{route('account.khalti_infos')}}" class="btn btn-danger btn-secondary">Cancel</a>
                </div> 
            </form>
        </div>
    </div>
@endsection