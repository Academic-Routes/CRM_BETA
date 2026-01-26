@extends('layouts.admin.master')

@section('title', 'Notifications')

@section('content')
<div class="dashboard-main-body">
    <div class="breadcrumb d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <div>
            <h1 class="fw-semibold mb-4 h6 text-primary-light">Notifications</h1>
            <div>
                <a href="/" class="text-secondary-light hover-text-primary hover-underline">Dashboard </a>
                <span class="text-secondary-light">/ Notifications</span>
            </div>
        </div>
        <div>
            <button type="button" class="btn btn-primary-600 btn-sm" onclick="markAllAsRead()">
                Mark All as Read
            </button>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($notifications->count() > 0)
                @foreach($notifications as $notification)
                    <div class="notification-item border-bottom py-3 {{ $notification->is_read ? 'opacity-75' : 'bg-light' }}" data-id="{{ $notification->id }}">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="mb-1 {{ $notification->is_read ? 'text-muted' : 'text-dark' }}">
                                    {{ $notification->title }}
                                </h6>
                                <p class="mb-1 text-secondary">{{ $notification->message }}</p>
                                <small class="text-muted">
                                    {{ $notification->created_at->diffForHumans() }}
                                    @if($notification->fromUser)
                                        by {{ $notification->fromUser->name }}
                                    @endif
                                </small>
                            </div>
                            <div class="d-flex gap-2">
                                @if(!$notification->is_read)
                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="markAsRead({{ $notification->id }})">
                                        Mark as Read
                                    </button>
                                @endif
                                @if($notification->data && isset($notification->data['student_id']))
                                    <a href="{{ route('students.show', $notification->data['student_id']) }}" class="btn btn-sm btn-primary">
                                        View Student
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
                
                <div class="mt-3">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <iconify-icon icon="iconamoon:notification-off" class="text-muted" style="font-size: 4rem;"></iconify-icon>
                    <h5 class="mt-3 text-muted">No notifications yet</h5>
                    <p class="text-muted">You'll see notifications here when there are updates.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function markAsRead(id) {
    fetch(`/notifications/${id}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    }).then(() => {
        location.reload();
    });
}

function markAllAsRead() {
    fetch('/notifications/read-all', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    }).then(() => {
        location.reload();
    });
}
</script>
@endsection