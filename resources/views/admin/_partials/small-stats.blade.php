<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small card -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $messagesSentTodayCount }}</h3>

                <p>messages were sent today</p>
            </div>
            <div class="icon">
                <i class="far fa-envelope"></i>
            </div>
            <a href="{{ route('admin.emailMessages.index') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <!-- small card -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $userRegisteredTodayCount }}</h3>
                <p>user registrations today</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <a href="{{ route('admin.users.index') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <!-- small card -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $userRegisteredTodayCount }}</h3>
                <p>events were created today</p>
            </div>
            <div class="icon">
                <i class="far fa-calendar-alt"></i>
            </div>
            <a href="{{ route('admin.events.index') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <!-- small card -->
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>{{ $actionsCreatedTodayCount }}</h3>
                <p>actions were created today</p>
            </div>
            <div class="icon">
                <i class="far fa-star"></i>
            </div>
            <a href="{{ route('admin.actions.index') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>
