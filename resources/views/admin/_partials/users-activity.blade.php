@php
/** @var \App\Entities\Activity $activity */

$iconName = null;
$iconColor = null;
$header = null;
$body = null;
$link = null;
$linkTitle = null;
switch ($activity->type) {
    case \App\Entities\Activity::REGISTRATION:
        $iconName = 'fas fa-user-plus';
        $iconColor = 'bg-gray';
        $header = 'Registration';
        $body = 'User registered at Future Team';
        break;
    case \App\Entities\Activity::ACTION_ADD:
        $iconName = 'fas fa-map-marked-alt';
        $iconColor = 'bg-purple';
        $header = 'Action create';
        $body = 'Action "' . $activity->info['event_name'] . '" has been created.';
        $link = route('admin.actions.view', $activity->info['event_id']);
        $linkTitle = 'View';
        break;
    case \App\Entities\Activity::EVENT_ADD:
        $iconName = 'far fa-calendar-check';
        $iconColor = 'bg-info';
        $header = 'Events create';
        $body = 'Event "' . $activity->info['event_name'] . '" has been created.';
        $link = route('admin.events.view', $activity->info['event_id']);
        $linkTitle = 'View';
        break;
    case \App\Entities\Activity::ACTION_JOIN:
        $iconName = 'fas fa-thumbtack';
        $iconColor = 'bg-warning';
        $header = 'Join to action';
        $body = 'User joined to "' . $activity->info['action_name'] . '" action.';
        $link = route('admin.actions.view', $activity->info['action_id']);
        $linkTitle = 'View';
        break;
    case \App\Entities\Activity::SEND_MESSAGE:
        $iconName = 'fas fa-envelope';
        $iconColor = 'bg-primary';
        $header = 'Send message to user ' . '<a href"' . route('admin.users.view', $activity->info['userTo']['id']) .'">'. $activity->info['userTo']['name'] .'</a>';
        $body =  $activity->info['message'];
        break;
}
@endphp

<!-- timeline item -->
<li>
    <i class="{{ $iconName }} {{ $iconColor }}"></i>
    <div class="timeline-item">
        <span class="time"><i class="far fa-clock"></i>{{ $activity->created_at->diffForHumans() }}</span>
        @if($header)
        <h3 class="timeline-header">{!! $header !!}</h3>
        @endif
        @if ($body)
        <div class="timeline-body">{{ $body }}</div>
        @endif
        @if ($link && $linkTitle)
        <div class="timeline-footer">
            <a href="{{ $link }}" class="btn btn-warning btn-flat btn-sm">{{ $linkTitle }}</a>
        </div>
        @endif
    </div>
</li>
<!-- END timeline item -->
