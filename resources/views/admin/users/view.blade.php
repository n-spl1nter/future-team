@php
    /** @var \App\Entities\User $model */
@endphp
@extends('admin.layouts.main', ['title' => 'User. ' . $model->id  ])

@section('content')
    @if ($model->hasFilledProfile())
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <div class="img-circle profile-user-img" style="display:inline-block;width: 100px;height: 100px;background: url({{ $model->getAvatar()[1] }}) no-repeat center / cover;"></div>
                            </div>

                            <h3 class="profile-username text-center">{{ $model->getFullName() }}</h3>

                            <p class="text-muted text-center">{{ $model->isMember() ? 'Member' : 'Company' }}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>@lang('common.actions.name')</b> <a class="float-right">{{ $model->actions()->count() }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>@lang('common.events.name')</b> <a class="float-right">{{ $model->events()->count() }}</a>
                                </li>
                                @if($model->isCompany())
                                    <li class="list-group-item">
                                        <b>@lang('common.MembersCount')</b> <a class="float-right">{{ $model->organizationMembers()->count() }}</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <div class="card card-primary">
                        <div class="card-header"><h3 class="card-title">Info</h3></div>
                        <div class="card-body">
                            <strong><i class="fas fa-calendar mr-1"></i> Created At</strong>
                            <p class="text-muted">{{ $model->created_at }}</p>
                            <hr>
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                            @if($model->isMember())
                            <p class="text-muted">{{ $model->profile->country->title_en }}, {{ $model->profile->city->title_en }}</p>
                            @else
                                <p class="text-muted">{{ $model->companyProfile->country->title_en }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#timeline" data-toggle="tab">Timeline</a></li>
                                <li class="nav-item"><a class="nav-link" href="#actions" data-toggle="tab">Actions({{ $model->actions->count() }})</a></li>
                                <li class="nav-item"><a class="nav-link" href="#events" data-toggle="tab">Events({{ $model->events->count() }})</a></li>
                                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="timeline">users activity...</div>
                                <div class="tab-pane" id="actions">
                                    @if ($model->actions->count() > 0)
                                    <div class="list-group">
                                        @foreach($model->actions as $action)
                                            <a href="{{ route('admin.actions.view', $action->id) }}" class="list-group-item list-group-item-action flex-column align-items-start">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">{{ $action->name }}</h5>
                                                    <small>{{ $action->created_at->format('Y-m-d') }}</small>
                                                </div>
                                                <p class="mb-1">{{ \Illuminate\Support\Str::limit($action->about) }}</p>
                                                <small>Status: {{ $action->status }}</small>
                                            </a>
                                        @endforeach
                                    </div>
                                    @else
                                        <div class="alert alert-warning" role="alert">
                                            Actions for current user not found.
                                        </div>
                                    @endif
                                </div>
                                <div class="tab-pane" id="events">
                                    @if ($model->events->count() > 0)
                                        <div class="list-group">
                                            @foreach($model->events as $event)
                                                <a href="{{ route('admin.events.view', $event->id) }}" class="list-group-item list-group-item-action flex-column align-items-start">
                                                    <div class="d-flex w-100 justify-content-between">
                                                        <h5 class="mb-1">{{ $event->name }}</h5>
                                                        <small>{{ $event->created_at->format('Y-m-d') }}</small>
                                                    </div>
                                                    <p class="mb-1">{{ \Illuminate\Support\Str::limit($event->reasons) }}</p>
                                                    <small>Status: {{ $event->status }}</small>
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="alert alert-warning" role="alert">
                                            Events for current user not found.
                                        </div>
                                    @endif
                                </div>
                                <div class="tab-pane" id="settings"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
@endsection
