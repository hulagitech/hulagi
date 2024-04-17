@extends('account.layout.master')

@section('title', 'Total Rider')

@section('content')
<div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h4 class="page-title m-0">&nbsp;Wallet Of Rider</h4>
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
                       @ @if (count($Rider) != 0)
                                    <table id="datatable" class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <td>Rider Name</td>
                                                <td>Mobile</td>
                                                <th>Status</th>
                                                <td>Wallet Amount</td>
                                                <td>Joined At</td>
                                                {{-- <td>Add Excel File</td> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $diff = ['-success', '-info', '-warning', '-danger']; ?>
                                            @foreach ($Rider as $index => $user)
                                                <tr>
                                                    <td>
                                                        <a href="statement/provider/{{ $user->id }}/request">
                                                            {{ $user->first_name }}
                                                            {{ $user->last_name }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        {{ $user->mobile }}
                                                    </td>
                                                   
                                                    @if($user->status=='approved')
                                                        <td><span class="btn btn-success btn-primary">approved </span> </td>
                                                    @else
                                                        <td> <span class="btn btn-danger btn-primary">Banned </span></td>
                                                    @endif
                                                  
                                                    <td>
                                                        {{ $user->newPayable}}
                                                    </td>
                                                    <td>{{$user->created_at}}</td>
                                            @endforeach

                                        <tfoot>
                                            <tr>
                                            <td>Rider Name</td>
                                                <td>Mobile</td>
                                                <th>Status</th>
                                                <td>Wallet Amount</td>
                                                <td>Joined At</td>
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
@endsection
