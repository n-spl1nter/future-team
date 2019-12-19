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
                                    <th>Avatar</th>
                                    <th>Member\organization name</th>
                                    <th>Role</th>
                                    <th>Country, city</th>
                                    <th>Actions count</th>
                                    <th>Events count</th>
                                    <th>Registration date</th>
                                    <th></th>
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
                                        <td>
                                            <a href="{{ route('admin.users.view', $user->id) }}">{{ $user->getFullName() }}</a>
                                        </td>
                                        <td>
                                            {{ \App\RBAC\Role::ROLE_NAME[$user->role_id] }}
                                        </td>
                                        <td>
                                            @if ($user->isCompany() && $user->companyProfile)
                                                {{ $user->companyProfile->country->title_en }}
                                            @elseif($user->isMember() && $user->profile)
                                                {{ $user->profile->country->title_en }},
                                                @if ($user->profile->city)
                                                    {{ $user->profile->city->title_en }}
                                                @endif
                                            @endif
                                        </td>
                                        <td>{{ $user->actions()->count() }}</td>
                                        <td>{{ $user->events()->count() }}</td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>
                                            <a class="btn btn-primary btn-sm" href="{{ route('admin.users.view', $user->id) }}">
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
