@php
    /** @var \Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator */
@endphp

@extends('admin.layouts.main', ['title' => __('common.users.rolesManagement') ])

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Тут будут ссылки с экспортом
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Аватар</th>
                                    <th>Имя\Название организации</th>
                                    <th>Роль</th>
                                    <th>Страна, город</th>
                                    <th>Кол-во добавленных акций</th>
                                    <th>Кол-во добавленных событий</th>
                                    <th>Дата регистрации</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                @php /** @var \App\Entities\User $user */ @endphp
                                @foreach( $paginator as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>
                                            @if ($user->getAvatar())
                                                <div class="profile-user-img img-fluid img-circle" style="background-image: url({{ $user->getAvatar()[1] }});background-size:cover; height: 100px;">
                                            @endif
                                        </td>
                                        <td>{{ $user->getFullName() }}</td>
                                        <td>
                                            {{ \App\RBAC\Role::ROLE_NAME[$user->role_id] }}
                                        </td>
                                        <td>
                                            @if ($user->isCompany() && $user->companyProfile)
                                                {{ $user->companyProfile->country->title_ru }}
                                            @elseif($user->isMember() && $user->profile)
                                                {{ $user->profile->country->title_ru }}
                                                {{ $user->profile->city->title_ru }}
                                            @endif
                                        </td>
                                        <td>{{ $user->actions()->count() }}</td>
                                        <td>{{ $user->events()->count() }}</td>
                                        <td>{{ $user->created_at }}</td>
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
