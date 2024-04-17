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
            'regional_supervisor' => 'Prabesh Baraili',
            'location' => 'Pokhara',
            'contact_number' => '9801858570',
            'riders' => [
                [
                    'name' => 'Prabesh Baraili',
                    'location' => 'Pokhara',
                    'contact_number' => '9801858570',
                ],
                [
                    'name' => 'Damir Neupane',
                    'location' => 'Damauli',
                    'contact_number' => '9807407400',
                ],
                [
                    'name' => 'Chhabi Acharya',
                    'location' => 'Beni',
                    'contact_number' => '9864275221',
                ],
                [
                    'name' => 'Prakash Rusal',
                    'location' => 'Baglung',
                    'contact_number' => '9869293113',
                ],
                [
                    'name' => 'Yadav Poudel',
                    'location' => 'Syangja',
                    'contact_number' => '9802668148',
                ],
            ],
        ],
        [
            'regional_supervisor' => 'Balkrishna Pokhrel',
            'location' => 'Butwal',
            'contact_number' => '9801858571',
            'riders' => [
              
                [
                    'name' => 'Balkrishna Pokhrel',
                    'location' => 'Butwal',
                    'contact_number' => '9801858571',
                ],
                [
                    'name' => 'Adesh Silwal',
                    'location' => 'Chitwan',
                    'contact_number' => '9801858568',
                ],
                [
                    'name' => 'Deep Pokhrel',
                    'location' => 'Palpa',
                    'contact_number' => '9847103502',
                ],
                [
                    'name' => '',
                    'location' => 'Gulmi',
                    'contact_number' => '',
                ],
                [
                    'name' => 'Dal Bahadur',
                    'location' => 'Dang(Tulsipur)',
                    'contact_number' => '9847942754',
                ],
                [
                    'name' => 'Aurjun',
                    'location' => 'Dang(Lamahi)',
                    'contact_number' => '9847963994',
                ],
            ],
        ],
        [
            'regional_supervisor' => 'Dagen Limbu',
            'location' => 'Ithari',
            'contact_number' => '9801858575',
            'riders' => [
                [
                    'name' => 'SujanJung Raimajhi',
                    'location' => 'Birtamode',
                    'contact_number' => '9801858573',
                ],
                [
                    'name' => 'Chhabi Acharya',
                    'location' => 'Dharan',
                    'contact_number' => '9801858581',
                ],
                [
                    'name' => 'Sunil Tajpuriya',
                    'location' => 'Damak',
                    'contact_number' => '9801858584',
                ],
                [
                    'name' => 'Bimal Shrestha',
                    'location' => 'Biratnagar',
                    'contact_number' => '9807315333',
                ],
                [
                    'name' => 'Rosit Karmacharya',
                    'location' => 'Illam',
                    'contact_number' => '9815920460',
                ],
            ],
        ],
        [
            'regional_supervisor' => 'Upnesh Shrestha',
            'location' => 'Lahan',
            'contact_number' => '9813007297',
            'riders' => [
                [
                    'name' => 'Papu Prasad Yadav',
                    'location' => 'Birgunj',
                    'contact_number' => '9816243978',
                ],
                [
                    'name' => 'Prabesh Allam',
                    'location' => 'Rautahat',
                    'contact_number' => '9801858587',
                ],
                [
                    'name' => 'Hari Babu Achami',
                    'location' => 'Sindhuli',
                    'contact_number' => '9809644544',
                ],
                [
                    'name' => 'Krishna Phuyal',
                    'location' => 'Bardibas',
                    'contact_number' => '9817664532',
                ],
                [
                    'name' => 'Nabin Kumar Mandal',
                    'location' => 'Janakpur',
                    'contact_number' => '9807882098',
                ],
                [
                    'name' => 'Bibek Chaulisiya',
                    'location' => 'Raj Biraj',
                    'contact_number' => '9801526829',
                ],
            ],
        ],
        [
            'regional_supervisor' => 'Pawan Kpa',
            'location' => 'Dhangadi',
            'contact_number' => '9866109161',
            'riders' => [
                [
                    'name' => 'Puran Gaderi',
                    'location' => 'Mahendranagar',
                    'contact_number' => '9848784023',
                ],
                [
                    'name' => 'KhemRaj Bhatta',
                    'location' => 'Alamki',
                    'contact_number' => '9865201044',
                ],
                [
                    'name' => 'Bibek Bhandari',
                    'location' => 'Surkhet',
                    'contact_number' => '9802561315',
                ],
                [
                    'name' => 'Prabin',
                    'location' => 'Bardiya',
                    'contact_number' => '9814590804',
                ],
                [
                    'name' => 'Bhuwan Chand',
                    'location' => 'Nepalgunj',
                    'contact_number' => '9801858589',
                ],
                [
                    'name' => 'Saroj Karki',
                    'location' => 'Hetauda',
                    'contact_number' => '9801858572',
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
                        <th>Regional Supervisor</th>
                        <th>Riders</th>
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
