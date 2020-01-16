@php
    /** @var \App\Entities\EmailMessage $model */
@endphp
@extends('admin.layouts.main', ['title' => 'Read message #' . $model->id  ])

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-8">
                    <div class="d-flex mb-2">
                        From:
                        <div class="user-block ml-1">
                            <img class="img-circle img-bordered-sm" src="{{ $model->userFrom->getAvatar()[1] }}"
                                 alt="user image">
                            <span class="username">
                              <a href="{{ route('admin.users.view', $model->userFrom->id) }}">{{ $model->userFrom->getFullName() }}</a>
                            </span>
                            <span class="description">
                                @if($model->userFrom->isCompany())
                                    Company
                                @elseif($model->userFrom->isMember())
                                    Member
                                @endif
                               of Future Team {{ $model->userFrom->created_at->format('Y-m-d') }}
                            </span>
                        </div>
                    </div>
                    <div class="d-flex">
                        To:
                        <div class="user-block ml-1">
                            <img class="img-circle img-bordered-sm" src="{{ $model->userTo->getAvatar()[1] }}"
                                 alt="user image">
                            <span class="username">
                              <a href="{{ route('admin.users.view', $model->userTo->id) }}">{{ $model->userTo->getFullName() }}</a>
                            </span>
                            <span class="description">
                                @if($model->userTo->isCompany())
                                    Company
                                @elseif($model->userTo->isMember())
                                    Member
                                @endif
                                   of Future Team {{ $model->userTo->created_at->format('Y-m-d') }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <span class="mailbox-read-time">{{ $model->created_at }}</span>
                </div>
            </div>
        </div>
        <div class="card-body">
            <h3>Message:</h3>
            <div class="info-box bg-light">
                <div class="info-box-content">
                    {{ $model->message }}
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="text-right">
                <a href="{{ route('admin.emailMessages.index') }}" class="btn btn-md btn-primary">
                    Back
                </a>
            </div>
        </div>
    </div>
@endsection
