@extends('pickup.layout.master')

@section('title', 'Order details ')

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
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Pickup Remain</h4>
                    </div>
                    <div class="col-md-4">

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
                        <table id="table" class="table table-bordered"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>User</th>
                                    <th>Domain Name</th>
                                    <th>Pickup Address</th>
                                    <th>Pickup Number</th>
                                    <th>Driver</th>
                                    <th>Orders</th>
                                    <th>Return</th>
                                </tr>
                            </thead>
                            <tbody>
                                <script>
                                    var req_id = [];
                                </script>
                                @foreach ($requests as $index => $request)
                                    <script>
                                        req_id.push(<?php echo $request->user_id; ?>);
                                    </script>
                                    <tr id="dataRow{{ $index }}"
                                        class="{{ @$request->user->wallet_balance < 0 ? 'text-danger' : '' }}">
                                        <td>{{$loop->iteration}}</td>
                                        <td>
                                            @if (@$request->user)
                                                <a href="{{ route('pickup.vendorAssign', $request->user->id) }}">
                                                    {{ @$request->user->first_name }}
                                                    ({{ $request->user->new_wallet($request->user->id) < 0 ? 'Rs ' . $request->user->new_wallet($request->user->id) : '' }})
                                                </a>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td><b>{{@$request->user->user_type}}</b></td>
                                        <td>
                                            @if ($request->s_address)
                                                {{ @$request->s_address }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            @if (@$request->user->mobile)
                                                {{ @$request->user->mobile }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            <div class='edit'>
                                                @if(@$request->provider)
                                                {{@$request->provider->first_name}}
                                                @else
                                                Select Rider
                                                @endif
                                            </div>
                                            <select class='txtedit' id='provider-{{ $index }}'>
                                                <option>Select Rider</option>
                                                @foreach ($totalRiders as $rider)
                                                    <option value={{ $rider['id'] }}>{{ $rider['first_name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            {{ @$request->count }}
                                        </td>
                                        <td>
                                            {{ @$request->r ? $request->r : 0 }} (ready)
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <hr>
                        <p style="text-align: center;">No results found</p>
                    @endif
                </div>
            </div>
        </div>
    </div>



@endsection
@section('scripts')
    @include('user.layout.partials.datatable')
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

                if (field_name == "provider" && !confirm("Are you sure to assign \"" + $("option:selected",
                        this).text() + "\"?")) {
                    $(this).hide();
                    $(this).prev('.edit').show();
                    return;
                }
                if (field_name == "provider" && $("option:selected", this).text() == "Select Rider") {
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
                    url: "{{ url('pickup/bulkAssign') }}/" + req_id[edit_id],
                    type: 'post',
                    data: field_name + "=" + value,
                    success: function(response) {
                        if (response.showError) {
                            toastr.error(response.error);
                        }
                        $.jnoty("Success", {
                            life: 1000,
                            theme: 'jnoty-success',
                            
                        });
                    },
                    error: function(request, error) {
                        console.log(request);
                        alert("Error! Please refresh page and check if rider is unset.");
                    }
                });
                // console.log($(this).html());

            });

        });
    </script>
    <script>
        var ajax_call = function() {
            $.ajax({
                url: 'searchingajax',
                type: 'get',
                success: function(data) {}
            });
            $.ajax({
                url: 'ajaxforofflineprovider',
                type: 'get',
                success: function(data) {
                     $.jnoty("Success", {
                            life: 1000,
                            theme: 'jnoty-success',
                            
                        });
                }
            });
            //your jQuery ajax code
        };
        var interval = 1000 * 60 * 1; // where X is your every X minutes
        setInterval(ajax_call, interval);
    </script>

@endsection
