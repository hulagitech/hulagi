@extends('user.layout.master')
@section('title', 'Notice ')
@section('styles')
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">

        </div>
    </div>
</div>
<ul class="nav nav-pills nav-justified" role="tablist">
    <li class="nav-item waves-effect waves-light">
        <a class="nav-link active" data-toggle="tab" href="#notices" role="tab">
            <span class="d-none d-md-block">Notices</span><span class="d-block d-md-none"><i
                    class="mdi mdi-home-variant h5"></i></span>
        </a>
    </li>
    <li class="nav-item waves-effect waves-light">
        <a class="nav-link" data-toggle="tab" href="#notification" role="tab">
            <span class="d-none d-md-block">Notification</span><span class="d-block d-md-none"><i
                    class="mdi mdi-account h5"></i></span>
        </a>
    </li>

</ul>
<div class="tab-content">

    <div class="row tab-pane active" id="notices" role="tabpanel">

        <div class="col-md-12">
            <section id="cd-timeline" class="cd-container">
                @if (count($notices) > 0)
                    @foreach ($notices as $key => $notice)
                        @if ($key % 2 == 0)
                            <div class="cd-timeline-block">
                                <div class="cd-timeline-content p-3">
                                    <div class="row">
                                        <div class="col-lg-10">
                                            <div class="text-right">
                                                <h3>{{ $notice->Heading }}</h3>
                                                <p class="mb-0 text-muted">{!! $notice->Description !!}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="text-center">
                                                <div class="cd-date mb-4 text-capitalize">
                                                    {{ $notice->created_at->diffforHumans() }}</div>
                                                <div>
                                                    <i class="mdi mdi-briefcase-search-outline h2 text-primary"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div> <!-- cd-timeline-content -->
                            </div> <!-- cd-timeline-block -->
                        @else
                            <div class="cd-timeline-block">

                                <div class="cd-timeline-content p-3">

                                    <div class="row">
                                        <div class="col-lg-2">
                                            <div class="text-center">
                                                <div class="cd-date mb-4">{{ $notice->created_at->diffforHumans() }}
                                                </div>
                                                <div>
                                                    <i class="mdi mdi-briefcase-edit-outline h2 text-primary"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-10">
                                            <div>
                                                <h3>{{ $notice->Heading }}</h3>
                                                <p class="mb-0 text-muted">{!! $notice->Description !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- cd-timeline-content -->
                            </div>

                        @endif
                    @endforeach
                @else
                    <div class="text-center">
                        <h3>Notice Not Available</h3>
                    </div>
                @endif

            </section> <!-- cd-timeline -->
        </div>
    </div>
    <div class="row tab-pane" id="notification" role="tabpanel">
        <div class="col-md-12">
            <section id="cd-timeline" class="cd-container">
                @if (count($notifis) > 0)
                    @foreach (Auth::user()->notifications as $key => $notifi)
                        @if ($key % 2 == 0)
                            <div class="cd-timeline-block">
                                <div class="cd-timeline-content p-3">
                                    <div class="row">
                                        <div class="col-lg-10">
                                            <div class="text-right">
                                                <h3>{!! isset($notifi->data['title']) ? $notifi->data['title'] : null !!}
                                                </h3>
                                                <p class="mb-0 text-muted">
                                                    {!! isset($notifi->data['body']) ? $notifi->data['body'] : null !!}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="text-center">
                                                <div class="cd-date mb-4 ">
                                                    {{ $notifi->created_at->diffforHumans() }}
                                                </div>
                                                <div>
                                                    <i class="mdi mdi-briefcase-search-outline h2 text-primary"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div> <!-- cd-timeline-content -->
                            </div> <!-- cd-timeline-block -->
                        @else
                            <div class="cd-timeline-block">

                                <div class="cd-timeline-content p-3">

                                    <div class="row">
                                        <div class="col-lg-2">
                                            <div class="text-center">
                                                <div class="cd-date mb-4">
                                                    {{ $notifi->created_at->diffforHumans() }}
                                                </div>
                                                <div>
                                                    <i class="mdi mdi-briefcase-edit-outline h2 text-primary"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-10">
                                            <div>
                                                <h3>{!! isset($notifi->data['title']) ? $notifi->data['title'] : null !!}
                                                </h3>
                                                <p class="mb-0 text-muted">
                                                    {!! isset($notifi->data['body']) ? $notifi->data['body'] : null !!}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- cd-timeline-content -->
                            </div>

                        @endif
                    @endforeach
                @else
                    <div class="text-center">
                        <h3>Notice Not Available</h3>
                    </div>
                @endif

            </section> <!-- cd-timeline -->
        </div>

    </div>
</div>

@endsection
