@extends('bm.layout.master')

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
                        <h4 class="page-title m-0">Pickup Remaing</h4>
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
                        <table id="datatable" class="table table-bordered"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Pickup Address</th>
                                    <th>Pickup Number</th>
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
                                        <td>
                                            @if (@$request->user)
                                                <a href="{{ route('bm.vendorAssign', $request->user->id) }}"
                                                    class="{{ $request->user->new_wallet($request->user->id) < 0 ? 'text-danger' : '' }}">
                                                    {{ @$request->user->first_name }}
                                                    ({{ $request->user->new_wallet($request->user->id) < 0 ? 'Rs ' . $request->user->new_wallet($request->user->id) : '' }})
                                                </a>
                                            @else
                                                N/A
                                            @endif
                                        </td>
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
