@extends('sortcenter.layout.master')

@section('title', 'Orders In Hub')

@section('content')
<style>
    .txtedit {
        display: none;
        width: 99%;
        height: 30px;
    }
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-1">
                        <i class="fa fa-recycle"></i> &nbsp;Inside Valley Orders In Sortcenter
                    </h5>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body table-responsive">
                @if (count($requests) != 0)
                <table id="datatable-buttons" class="table table-bordered"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time Stamp </th>
                            <th>ID</th>
                            <th>User</th>
                            <th>Pickup Add.</th>
                            <th>Pickup No.</th>
                            <th>DropOff Add.</th>
                            <th>DropOff Name</th>
                            <th>DropOff No.</th>
                            <th>Rider</th>
                            <th>COD(Rs)</th>
                            <th>Remark</th>
                            {{-- <th>Return Rider</th>
                            <th>Status</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <script>
                            var req_id=[];
                        </script>
                        @foreach ($requests as $index => $inHub)
                        <script>
                            req_id.push(<?php echo $inHub->id; ?>);
                        </script>

                        <tr id="dataRow{{ $index }}">
                            <td>
                                @if ($inHub->created_at)
                                <span class="text-muted">{{ $inHub->created_at->format('Y-m-d') }}</span>
                                @else
                                -
                                @endif
                            </td>
                            <td>
                                @if ($inHub->created_at)
                                <span class="text-muted">{{ $inHub->created_at->diffForhumans() }}</span>
                                @else
                                -
                                @endif
                            </td>
                            <td>{{ $inHub->booking_id }}</td>
                            <td>
                                @if (@$inHub->user)
                                {{ @$inHub->user->first_name }}
                                @else
                                N/A
                                @endif
                            </td>
                            <td>
                                @if ($inHub->s_address)
                                {{ @$inHub->s_address }}
                                @else
                                N/A
                                @endif
                            </td>
                            <td>
                                @if (@$inHub->user->mobile)
                                {{ @$inHub->user->mobile }}
                                @else
                                N/A
                                @endif
                            </td>
                            <td>
                                @if ($inHub->d_address)
                                {{ @$inHub->d_address }}
                                @else
                                N/A
                                @endif
                            </td>
                            <td>
                                @if (@$inHub->item->rec_name)
                                {{ @$inHub->item->rec_name }}
                                @else
                                N/A
                                @endif
                            </td>
                            <td>
                                @if (@$inHub->item->rec_mobile)
                                {{ @$inHub->item->rec_mobile }}
                                @else
                                -
                                @endif
                            </td>
                            <td>
                                @if($inHub->provider)
                                <div class='edit'>
                                    {{ @$inHub->provider->first_name}}
                                </div>
                                <select class='txtedit' id='provider-{{$index}}'>
                                    <option>N/A</option>
                                    @foreach($totalRiders as $rider)
                                    <option value={{$rider['id']}} <?php if($inHub->provider==$rider['first_name']){echo
                                        'selected';} ?>>{{$rider['first_name']}}</option>
                                    @endforeach
                                </select>
                                {{--<input type='text' class='txtedit' value="{{@$inHub->status}}"
                                    id='status-{{$index}}'>--}}
                                @else
                                <div class='edit'>
                                    N/A
                                </div>
                                <select class='txtedit' id='provider-{{$index}}'>
                                    <option>Select Rider</option>
                                    @foreach($totalRiders as $rider)
                                    <option value={{$rider['id']}} <?php if($inHub->provider==$rider['first_name']){echo
                                        'selected';} ?>>{{$rider['first_name']}}</option>
                                    @endforeach
                                </select>
                                @endif
                            </td>
                            <td>
                                @if ($inHub->cod)
                                {{ @$inHub->cod }}
                                @else
                                0
                                @endif
                            </td>
                            <td>
                                @if (@$inHub->item->special_note)
                                {{ @$inHub->item->special_note }}
                                @else
                                N/A
                                @endif
                            </td>

                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button"
                                        class="btn btn-secondary btn-rounded btn-black waves-effect dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('sortcenter.order_details', $inHub->id) }}"
                                            class="dropdown-item">
                                            <i class="fa fa-search"></i> More Details
                                        </a>

                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Date</th>
                            <th>Time stamp</th>
                            <th>ID</th>
                            <th>User</th>
                            <th>Pickup Add.</th>
                            <th>Pickup No.</th>
                            <th>DropOff Add.</th>
                            <th>DropOff Name</th>
                            <th>DropOff No.</th>
                            <th>Rider</th>
                            <th>COD(Rs)</th>
                            <th>Remark</th>
                            {{-- <th>Return Rider</th>
                            <th>Status</th> --}}
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
                @else
                <h6 class="no-result">No results found</h6>
                @endif
            </div>
        </div>
    </div>
</div>


@section('scripts')

    @include('user.layout.partials.datatable')

@endsection

<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    $(document).ready(function(){
 
        // Show Input element
        $('.edit').click(function(){
            // $('.txtedit').hide();
            $(this).next('.txtedit').show().focus();
            $(this).hide();
        });

        // Save data
        $(".txtedit").focusout(function(){
        
            // Get edit id, field name and value
            var id = this.id;
            var split_id = id.split("-");
            var field_name = split_id[0];
            var edit_id = split_id[1];
            var value = $(this).val();
            
           
            if(field_name=="provider" && !confirm("Are you sure to assign \""+$("option:selected", this).text()+"\"?")){
                $(this).hide();
                $(this).prev('.edit').show();
                return;
            }
            // Hide Input element
            $(this).hide();

            // Hide and Change Text of the container with input elmeent
            $(this).prev('.edit').show();
            if($(this).is('select')){
                var val=$(this).find("option:selected").text();
                $(this).prev('.edit').text(val);    
            }
            else{
                $(this).prev('.edit').text(value);
            }
            
            // Sending AJAX request
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $.ajax({
                url: "{{url('sortcenter/riderAssign')}}/"+req_id[edit_id],
                type: 'post',
                data: field_name+"="+value,
                success:function(response){
                    console.log(response); 
                    if(response.showError){
                        alert(response.error);
                    }

                    toastr.success('Success');
                    $('.preloader').hide();

                  
                },
                error: function (request, error) {
                    toastr.error("Error! Please refresh page and check if rider is unset.");
                    $('.preloader').show(); 
                }
            });
            // console.log($(this).html());
           
        });

    });
</script>
@endsection