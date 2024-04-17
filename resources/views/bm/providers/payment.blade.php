@extends('bm.layout.master')

@section('title', $page)

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Earnings</h4>
                    </div>
                    <div class="col-md-4">
                        <div class="float-right">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
                    @if (count($logs) != 0)
                        <table id="datatable" class="table table-bordered"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <td>Date</td>
                                    <!-- <td>Transaction Type</td>
                                                                 <td>Amount</td> -->
                                    <!-- <td>Rider Earning</td>  -->
                                    <td>COD Collected</td>
                                    <td>Remarks</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $diff = ['-success', '-info', '-warning', '-danger']; ?>
                                @foreach ($logs as $index => $log)
                                    <tr>
                                        <td>{{ $log->created_at }}</td>
                                        <!-- <td>
                                                                     @if ($log->transaction_type == 'earning')
                                                                      <span class="tag tag-success">{{ $log->transaction_type }}</span>
                 @else
                                                                      <span class="tag tag-danger">{{ $log->transaction_type }}</span>
                                                                     @endif
                                                                    </td>
                                                                    <td>{{ $log->amount }}</td> -->
                                        <!-- <td>
                                                                     @if ($log->transaction_type == 'earning')
                                                                      <span style="color:green; font-size:14px;">{{ $log->amount }}</span>
                 @else
                                                                      <span> -- </span>
                                                                     @endif
                                                                    </td> -->
                                        <td>
                                            @if ($log->transaction_type == 'earning')
                                                <span> -- </span>
                                            @else
                                                <span style="color:red; font-size:14px;"> {{ $log->amount }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($log->remarks)
                                                {{ $log->remarks }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <h6 class="no-result">No results found</h6>
                    @endif
                </div>
            </div>
        </div>
    </div>


@endsection
@section('scripts')
    @include('user.layout.partials.datatable')

@endsection
