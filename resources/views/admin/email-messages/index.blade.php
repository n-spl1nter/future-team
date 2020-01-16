@php
    /** @var \Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator */
@endphp

@extends('admin.layouts.main', ['title' => __('common.messages.name') ])

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="box-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Message</th>
                                    <th>Sent At</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php /** @var \App\Entities\EmailMessage $model */ @endphp
                                @foreach($paginator as $model)
                                    <tr>
                                        <td>{{ $model->id }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.view', $model->userFrom->id) }}" class="d-flex align-items-center justify-content-start">
                                                @if ($model->userFrom->getAvatar())
                                                    <span class="profile-user-img img-fluid img-circle" style="background-image: url({{ $model->userFrom->getAvatar()[1] }});background-size:cover; height: 100px;margin: 0;"></span>
                                                @endif
                                                <span class="ml-1">
                                                    {{ $model->userFrom->getFullName() }}
                                                </span>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.users.view', $model->userTo->id) }}" class="d-flex align-items-center justify-content-start">
                                                @if ($model->userTo->getAvatar())
                                                    <span class="profile-user-img img-fluid img-circle" style="background-image: url({{ $model->userTo->getAvatar()[1] }});background-size:cover; height: 100px;margin: 0;"></span>
                                                @endif
                                                <span class="ml-1">
                                                {{ $model->userTo->getFullName() }}
                                                </span>
                                            </a>
                                        </td>
                                        <td>{{ \Illuminate\Support\Str::limit($model->message) }}</td>
                                        <td>{{ $model->created_at }}</td>
                                        <td>
                                            <a class="btn btn-primary btn-sm" href="{{ route('admin.emailMessages.view', $model->id) }}">
                                                <i class="fas fa-folder"></i>
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        @include('admin._partials.pagination', ['paginator' => $paginator])
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
