@php
    /** @var \App\Entities\User $model */
@endphp
@extends('admin.layouts.main', ['title' => 'Пользователь. ' . $model->id  ])

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

                            <p class="text-muted text-center">{{ $model->isMember() ? 'Участник' : 'Компания' }}</p>

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
                    @if($model->isMember())
                    <div class="card card-primary">
                        <div class="card-header"><h3 class="card-title">Info</h3></div>
                        <div class="card-body">
                            <strong><i class="fas fa-book mr-1"></i> Education</strong>
                            <p class="text-muted">
                                B.S. in Computer Science from the University of Tennessee at Knoxville
                            </p>
                            <hr>
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                            <p class="text-muted">Malibu, California</p>
                            <hr>
                            <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>
                            <p class="text-muted">
                                <span class="tag tag-danger">UI Design</span>
                                <span class="tag tag-success">Coding</span>
                                <span class="tag tag-info">Javascript</span>
                                <span class="tag tag-warning">PHP</span>
                                <span class="tag tag-primary">Node.js</span>
                            </p>
                            <hr>
                            <strong><i class="far fa-file-alt mr-1"></i> About</strong>
                            <p class="text-muted"></p>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-md-9"></div>
            </div>
        </div>
    </section>
    @endif
@endsection
