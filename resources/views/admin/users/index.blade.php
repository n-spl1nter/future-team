@php
    /** @var \Illuminate\Contracts\Pagination\LengthAwarePaginator $users */
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
                                    <th>ID</th>
                                    <th>Аватар</th>
                                    <th>Имя\Название организации</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                @php /** @var \App\Entities\User $user */ @endphp
                                @foreach( $users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>
                                            @if ($user->getAvatar())
                                                <img src="{{ $user->getAvatar()->url[1] }}" alt="">
                                            @else
                                            @endif
                                        </td>
                                        <td>Name

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        @include('admin._partials.pagination', ['paginator' => $users])
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
