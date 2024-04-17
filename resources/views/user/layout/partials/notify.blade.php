@foreach (auth()->user()->Notifications->take(10) as $notification)
    @if($notification->type=="App\Notifications\NoticeNotification")
        <a href="{{ url('notice') }}" class=" dropdown-item notify-item">
                <div class="notify-icon bg-info"><i class="mdi mdi-bell-outline"></i>
                </div>
                <p class="notify-details">
                    <b>{{ isset($notification->data['title']) ? $notification->data['title'] : null }}</b><span
                        class="text-muted" style="white-space:normal;">
                        {!! isset($notification->data['body']) ? $notification->data['body'] : null !!}</span>
                </p>
                <p class="text-right mt-2" style="font-size:10px;">
                    <span>{{ $notification->created_at->diffForHumans() }}</span>
                </p>
                {{$notification->markAsRead()}}
            </a>
            
    @else

        <a href="/mytrips/detail?request_id=<?php echo isset($notification->data['order_id']) ? $notification->data['order_id'] : null; ?>""
                                                class=" dropdown-item notify-item">
            <div class="notify-icon bg-info"><i class="mdi mdi-bell-outline"></i>
            </div>
            <p class="notify-details">
                <b>{{ isset($notification->data['title']) ? $notification->data['title'] : null }}</b><span
                    class="text-muted" style="white-space:normal;">
                    {!! isset($notification->data['body']) ? $notification->data['body'] : null !!}</span>
            </p>
            <p class="text-right mt-2" style="font-size:10px;">
                <span>{{ $notification->created_at->diffForHumans() }}</span>
            </p>
            {{$notification->markAsRead()}}
        </a>
    @endif
@endforeach
