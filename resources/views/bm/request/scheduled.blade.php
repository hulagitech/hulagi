@extends('bm.layout.master')

@section('title', 'Recent Trips ')

@section('content')


<style>
    .txtedit {
        display: none;
        width: 99%;
        height: 30px;
    }
      .switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 34px;
    }
    
    .switch input { 
      opacity: 0;
      width: 0;
      height: 0;
    }
    
    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }
    
    .slider:before {
      position: absolute;
      content: "";
      height: 26px;
      width: 26px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }
    
    input:checked + .slider {
      background-color: #2196F3;
    }
    
    input:focus + .slider {
      box-shadow: 0 0 1px #2196F3;
    }
    
    input:checked + .slider:before {
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(26px);
    }
    
    /* Rounded sliders */
    .slider.round {
      border-radius: 34px;
    }
    
    .slider.round:before {
      border-radius: 50%;
    }

</style>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h4 class="page-title m-0">Scheduled</h4>
                </div>
                <div class="col-md-8 d-flex justify-content-end">
                   
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="container-fluid">
        <div class="card m-b-30">
            <div class="card-body table-responsive">
               
                @if(count($requests) != 0)
                <table id="datatable" class="table table-bordered"
                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>ID</th>
                        <th>Last Update</th>
                        <th>User</th>
                        <th>Pickup Add.</th>
                        <th>Pickup No.</th>
                        <th>DropOff Add.</th>
                        <th>DropOff Name</th>
                        <th>DropOff No.</th>
                        <th>Cargo</th>
                        <th>Rider</th>
                        <th>COD</th>
                        <th>Vendor Remarks</th>
                        <th> Action </th>
                        {{-- <th>Receive</th> --}}
                    </tr>
                </thead>
                <tbody>
                    <script>
                        var req_id = [];

                    </script>
                    @foreach($requests as $index => $request)
                    <tr id="dataRow{{$index}}">
                        <td>
                            @if(@$request->created_at)
                            <span class="text-muted">{{@$request->created_at}}</span>
                            @else
                            -
                            @endif
                        </td>
                        <td>{{ @$request->booking_id }}</td>
                        <td>
                            @if(@$request->updated_at)
                            <span class="text-muted">{{@$request->updated_at->diffForHumans()}}</span>
                            @else
                            -
                            @endif
                        </td>
                        <td>
                            @if(@$request->user)
                            {{ @$request->user->first_name }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td>
                            @if(@$request->s_address)
                            {{ @$request->s_address }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td>
                            @if(@$request->user->mobile)
                            {{ @$request->user->mobile }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td>
                            @if(@$request->d_address)
                            {{ @$request->d_address }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td>
                            @if(@$request->item->rec_name)
                            {{ @$request->item->rec_name}}
                            @else
                            N/A
                            @endif
                        </td>
                        <td>
                            @if(@$request->item->rec_mobile)
                            {{ @$request->item->rec_mobile }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td>
                                 @if(@$request->cargo)
                                <label class="switch">
                                    <input type="checkbox" class="cargo" @if(isset($request->cargo)) @if(@$request->cargo=='1') checked @endif @endif id='cargo-{{$index}}' disabled>
                                    <span class="slider round"></span>
                                </label>
                            @else
                                <label class="switch">
                                    <input type="checkbox" value="{{@$request->cargo}}" class="cargo" id='cargo-{{@$request->id}}' disabled>
                                    <span class="slider round"></span>
                                </label>
                            @endif
                        </td>

                        <td>
                            @if(@$request->provider)
                            {{ @$request->provider->first_name}}
                            @else
                            N/A
                            @endif
                        </td>

                        <td>
                            @if(@$request->cod)
                            {{ @$request->cod}}
                            @else
                            N/A
                            @endif
                        </td>

                        <td>
                            @if(@$request->special_note)
                            {{ @$request->special_note}}
                            @else
                            N/A
                            @endif
                        </td>

                        <td style="position:relative;" width="5%">
                            <a href="{{ route('bm.order_detail', @$request->id) }}" class="btn btn-success shadow-box"> <i class="ti-comment"></i> </a>

                            {{-- Count Comment Notification --}}
                            @if($request->noComment != '0')
                            <span class="tag tag-danger" style="position:absolute; top:0px;"> {{$request->noComment}}</span>
                            @else
                            <span> </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Date</th>
                        <th>ID</th>
                        <th>Update On</th>
                        <th>User</th>
                        <th>Pickup Add.</th>
                        <th>Pickup No.</th>
                        <th>DropOff Add.</th>
                        <th>DropOff Name</th>
                        <th>DropOff No.</th>
                        <th>Rider</th>
                        <th>COD</th>
                        <th>Vendor Remarks</th>
                        <th> Action </th>
                        {{-- <th>Receive</th> --}}
                    </tr>
                </tfoot>
            </table>
                {{$requests->links('vendor.pagination.bootstrap-4')}}
                @else
                <h6 class="no-result">No results found</h6>
                @endif 
            </div>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">


<script>
    $(document).ready(function() {

        // Show Input element
        $('.edit').click(function() {
            $('.txtedit').hide();
            $(this).next('.txtedit').show().focus();
            $(this).hide();
        });

        // Save data
        $(".txtedit").focusout(function() {
            // Get edit id, field name and value
            var id = this.id;
            var split_id = id.split("-");
            var field_name = split_id[0];
            var edit_id = split_id[1];
            var value = $(this).val();

            //alert(edit_id+" ---> "+field_name+"="+value);

            if (field_name == "provider" && !confirm("Are you sure, you want to Assign \"" + value + "\" rider?")) {
                $(this).hide();
                $(this).prev('.edit').show();
                return;
            }
            // Hide Input element
            $(this).hide();

            // Hide and Change Text of the container with input elmeent
            $(this).prev('.edit').show();
            if ($(this).is('select')) {
                var val = $(this).find("option:selected").text();
                $(this).prev('.edit').text(val);
            } else {
                $(this).prev('.edit').text(value);
            }

            // Sending AJAX request
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{url('/bm/rider_assign/')}}" + "/" + edit_id
                , type: 'post'
                , data: field_name + "=" + value
                , success: function(response) {
                    console.log(response);
                    if (response.showError) {
                        alert(response.error);
                    }
                }
                , error: function(request, error) {
                    console.log(request);
                    alert("Error! Please refresh page");
                }
            });
        });
    });

</script>




@section('scripts')

@include('user.layout.partials.datatable')

@endsection
@endsection