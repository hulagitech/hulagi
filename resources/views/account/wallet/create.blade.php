@extends('account.layout.base')

@section('title', 'Payment Detail')

@section('content')

    <div class="row" style="padding:20px;">
        <div class="col-lg-12">
            <div style="display:flex; flex:1; justify-content:space-between;">
                <div>
                    <h4 class="page-title"><i class="fa fa-angle-right"></i> Add A/C Detail </h4>
                </div>
                {{-- <div style="padding-right: 20px;">
                    <form class="form-inline pull-right" method="POST" action={{url('admin/dateSearch')}}>
                        <div style="display: flex;">
                            <div class="form-group">
                                <input type="text" class="form-control" name="searchField" placeholder="Search User's Info">
                            </div>
                            <div class="form-group">
                                <button name="search" class="btn btn-success"> <i class="fa fa-search"></i> </button>
                            </div>
                        </div>
                    </form>
                </div> --}}
            </div>
            <hr>
            
            <form class="form"  method="POST" action="{{ route('account.user_ac') }}">
                {{ csrf_field() }}
                {{-- {{ method_field('POST') }} --}}

                <div class="col-lg-3">
                    <select class="user_id  form-control" id="user_id" name="user_id">
                        <option value=""> Select User </option>
                        @foreach (@$users as $user)
                            <option value="{{@$user->id}}"> {{@$user->first_name}} @if(@$user->mobile) - ({{ $user->mobile }}) @endif </option>
                            {{-- <option value="{{$user->id}}" {{$user_req->user_id==$user->id?"selected":null}}> {{$user->user}} </option> --}}
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-12" style="padding-top: 20px;">
                    <h5><b>Khalti Detail Info.</b></h5>
                    <div class="row form-group">
                        <div class="col-lg-3">
                            <input type="text" id="khalti_id" name="khalti_id" class="form-control" placeholder="Khalti Id">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-lg-3">
                            <input type="text" id="khalti_username" name="khalti_username" class="form-control" placeholder="Khalti Username">
                        </div>
                    </div>
                </div>
                

                <br>
                <div class="col-md-12" style="padding-top: 20px;">
                    <h5><b>Bank Detail Info.</b></h5>
                    <div class="row form-group">
                        <div class="col-lg-3">
                            <input type="text" id="bank_name" name="bank_name" class="form-control" placeholder="Bank Name">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-lg-3">
                            <input type="text" id="branch" name="branch" class="form-control" placeholder="Branch Name">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-lg-3">
                            <input type="text" id="ac_no" name="ac_no" class="form-control" placeholder="Bank A/C Number">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-lg-3">
                            <input type="text" id="ac_name" name="ac_name" class="form-control" placeholder="A/C Holder Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-success">Submit</button>
                        <a href="{{route('account.wallet')}}" class="btn btn-danger btn-secondary">Cancel</a>
                    </div>
                </div>    
            </form>
        </div>
    </div>
@endsection