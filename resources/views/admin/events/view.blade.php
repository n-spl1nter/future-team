@php
    /** @var \App\Entities\Event $model */
@endphp
@extends('admin.layouts.main', ['title' => 'Событие. ' . $model->name  ])

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-10">
                    <h3 class="card-title mb-1">{{ $model->name }}</h3>
                    <h5 class="card-subtitle">
                        @php
                            $badgeColor = 'bg-success';
                            if ($model->status === \App\Entities\Event::DELETED) {
                                $badgeColor = 'bg-warning';
                            } elseif ($model->status === \App\Entities\Event::BLOCKED) {
                                $badgeColor = 'bg-danger';
                            }
                        @endphp
                        <span class="badge {{ $badgeColor }}">{{ $model->status }}</span>
                    </h5>
                </div>
                <div class="col-2">
                    <div class="text-right">
                        @if($model->status === \App\Entities\Event::ACTIVE)
                            {{ Form::open([
                                'route' => ['admin.events.setStatus', $model->id],
                                'method' => 'post'
                            ]) }}
                            <input type="hidden" value="{{ \App\Entities\Event::ACTIVE }}" name="status">
                            <button type="submit" class="btn btn-md btn-danger">Заблокировать</button>
                            {{ Form::close() }}
                        @elseif ($model->status === \App\Entities\Event::BLOCKED)
                            {{ Form::open([
                                'route' => ['admin.events.setStatus', $model->id],
                                'method' => 'post'
                            ]) }}
                            <input type="hidden" value="{{ \App\Entities\Event::BLOCKED }}" name="status">
                            <button type="submit" class="btn btn-md btn-success">Разблокировать</button>
                            {{ Form::close() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-warning">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Дата добавления</span>
                                    <span
                                        class="info-box-number text-center text-muted mb-0">{{ $model->created_at }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-warning">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Дата начала</span>
                                    <span
                                        class="info-box-number text-center text-muted mb-0">{{ $model->start_at->format('Y-m-d') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-warning">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Дата окончания</span>
                                    <span
                                        class="info-box-number text-center text-muted mb-0">{{ $model->end_at->format('Y-m-d') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="post">
                                <div class="user-block">
                                    <img class="img-circle img-bordered-sm" src="{{ $model->user->getAvatar()[1] }}" alt="user image">
                                    <span class="username">
                                      <a href="{{ route('admin.users.view', $model->user_id) }}">{{ $model->user->getFullName() }}</a>
                                    </span>
                                    <span class="description">
                                        @if($model->user->isCompany())
                                            Компания
                                        @elseif($model->user->isMember())
                                            Участник
                                        @endif
                                        Future Team с {{ $model->user->created_at->format('Y-m-d') }}
                                    </span>
                                </div>
                            </div>
                            <div class="post">
                                <p class="lead">Условия:</p>
                                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                    {{ $model->conditions }}
                                </p>
                            </div>
                            <div class="post">
                                <p class="lead">Причины:</p>
                                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                    {{ $model->reasons }}
                                </p>
                            </div>
                            <div class="post">
                                <p class="lead">Доп. инфо:</p>
                                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                    {{ $model->additional_info }}
                                </p>
                            </div>
                            <div class="post">
                                <p class="lead">Контактные данные:</p>
                                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                    {{ $model->contact_data }}
                                </p>
                            </div>
                            <div class="post">
                                <p class="lead">Сферы деятельности:</p>
                                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                <ul class="list-group">
                                    @foreach($model->domains as $domain)
                                        <li class="list-group-item">{{ $domain }}</li>
                                    @endforeach
                                </ul>
                                </p>
                            </div>
                            <div class="post">
                                <p class="lead">Ссылки на видео:</p>
                                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                <ul class="list-group">
                                    @foreach($model->video_links as $videoLinks)
                                        <li class="list-group-item">
                                            <a href="{{ $videoLinks }}" target="_blank">{{ $videoLinks }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Место проведения</span>
                                    <span class="info-box-number text-center text-muted mb-0">
                                        {{ $model->country->title_ru }}, {{ $model->city->title_ru }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="post">
                                <p class="lead">Фотографии:</p>
                                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                <ul class="list-group">
                                    @foreach($model->getImages(\App\Entities\MediaFile::TYPE_EVENT)->pluck('url') as $image)
                                        <li class="list-group-item">
                                            <img src="{{ $image[0] }}" alt="" style="max-width: 300px;width: 100%; max-height: 300px">
                                        </li>
                                    @endforeach
                                </ul>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="text-right">
                <a href="{{ route('admin.events.index') }}" class="btn btn-md btn-primary">
                    Назад
                </a>
            </div>
        </div>
    </div>
@endsection
