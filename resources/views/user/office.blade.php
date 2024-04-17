@extends('user.layout.master')

@section('styles')
    <style>
        .resource__header {
            background-color: #6A7080;
            color: white;
        }

    </style>
@endsection

@section('content')
    <?php
    $resources = [
        [
            'regional_supervisor' => 'Kathmandu Contacts ',
            'location' => '',
            'contact_number' => '',
            'riders' => [
               [
                'name' => 'Support',
                'location' => 'Kathmandu',
                'contact_number' => '01-5912257, 01-5912256',
               ],
                [
                    'name' => 'Finance',
                    'location' => 'Kathmandu',
                    'contact_number' => '01-5912257',
                ],
                [
                    'name' => 'Branch Manager',
                    'location' => 'Kathmandu',
                    'contact_number' => '01-5912257',
                ],
                [
                    'name' => 'SortCenter Manager',
                    'location' => 'Kathmandu',
                    'contact_number' => '01-5912257',
                ],
                [
                    'name' => 'Returns Manager',
                    'location' => 'Kathmandu',
                    'contact_number' => '01-5912257',
                ],
                [
                    'name' => 'Pickup Manager',
                    'location' => 'Kathmandu',
                    'contact_number' => '01-5912257',
                ],
                
            ],
        ],
    ];
    
    ?>


    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Resource</h4>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="card resource">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead class='bg-dark text-white'>
                        <th>SN</th>
                        <th>Designation</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Contact Number</th>
                    </thead>
                    <tbody>
                        @foreach ($resources as $key => $resource)

                            <tr class='bg-success text-white'>
                                <th>{{ $key + 1 }}</th>
                                <th>{{ $resource['regional_supervisor'] ? $resource['regional_supervisor'] : '' }}</th>
                                <th></th>
                                <th>{{ $resource['location'] }}</th>
                                <th>{{ $resource['contact_number'] }}</th>
                            </tr>

                            @foreach ($resource['riders'] as $key1 => $rider)
                                <tr>
                                    <td></td>
                                    <td>{{ $key1 + 1 }}</td>
                                    <td>{{ $rider['name'] }}</td>
                                    <td>{{ $rider['location'] }}</td>
                                    <td>{{ $rider['contact_number'] }}</td>
                                </tr>

                            @endforeach
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
