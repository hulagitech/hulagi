@extends('bm.layout.master')

@section('title', 'Recent Trips ')

@section('content')
<div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h5 class="mb-1"> <i class="fa fa-truck"></i> Pending Receive / Bulk Detail</h5>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end">
        
                    </div>
                </div>
            </div>
        </div>
</div>
<div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
                 @if(count($requests) != 0)
                    <table id="datatable-buttons" class="table table-bordered"
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
                                <th>Vendor Remarks</th>
                                <th>Receive</th>
                            </tr>
                        </thead>
                        <tbody>
                       <script> var req_id=[];</script>
                        @foreach($requests as $index => $request)
                            <tr id="dataRow{{$index}}">
                                <td>
                                    @if(@$request->request->created_at)
                                        <span class="text-muted">{{@$request->request->created_at}}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ @$request->request->booking_id }}</td>
                                <td>
                                    @if(@$request->request->updated_at)
                                        <span class="text-muted">{{@$request->request->updated_at}}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->request->user)
                                        {{ @$request->request->user->first_name }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->request->s_address)
                                        {{ @$request->request->s_address }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->request->user->mobile)
                                        {{ @$request->request->user->mobile }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->request->d_address)
                                        {{ @$request->request->d_address }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                 <td>
                                    @if(@$request->request->item->rec_name)
                                        {{ @$request->request->item->rec_name}} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->request->item->rec_mobile)
                                        {{ @$request->request->item->rec_mobile }} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@$request->request->special_note)
                                        {{ @$request->request->special_note}} 
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(@!$request->received)
                                        <a class="received btn btn-info" style="color: #fff;" name="received-{{$request->id}}"> <i class="fa fa-arrow-down"></i> Receive</a>
                                        <span style="color: orange; display:none;" class="checkreceived"><i class="fa fa-check"></i></span>
                                    @else
                                        <a class="received btn btn-info" style="color: #fff; display:none;" name="received-{{$request->id}}"> <i class="fa fa-arrow-down"></i> Receive</a>
                                        <span style="color: orange;" class="checkreceived"><i class="fa fa-check"></i></span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
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
                                <th>Vendor Remarks</th>
                                <th>Receive</th>
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
</div>



    


<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    $(document).ready(function(){
        $(".received").click(function(){
            $(this).hide();
            $(this).next(".checkreceived").show();
            var id = this.name;
            var split_id = id.split("-");
            var field_name = split_id[0];
            var edit_id = split_id[1];
            console.log(edit_id);
            // $(this).hide();
            // $(this).next(".checkreceived").show();
            // var id = this.name;
            // var split_id = id.split("-");
            // var field_name = split_id[0];
            // var edit_id = split_id[1];
            var value=false;
            if(this.checked){
                value=true;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{url('bm/dispatchList/eachReceive')}}/"+edit_id,
                type: 'post',
                data: field_name+"="+value,
                success:function(response){
                    if(response.showError){
                        
                    }
                    toastr.success("Success!!")
                },
                error: function (request, error) {
                    console.log(request);
                    alert(" Can't do!! Error"+error);
                }
            });
        });
    });
</script>


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