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
                                    <th>Фото</th>
                                    <th>Название</th>
                                    <th>Статус</th>
                                    <th>Дата добавления</th>
                                    <th>Дата начала</th>
                                    <th>Дата конца</th>
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
                                </tr>
                                @php /** @var \App\Entities\Action $model */ @endphp
                                @foreach($paginator as $model)
                                    <tr>
                                        <td>{{ $model->id }}</td>
                                        <td>
                                            <img src="{{ $model->getImage(\App\Entities\MediaFile::TYPE_ACTION)[1] }}" alt="">
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.actions.view', ['id' => $model->id]) }}">
                                                {{ $model->name }}
                                            </a>
                                        </td>
                                        <td>
                                            @php
                                                $badgeColor = 'bg-success';
                                                if ($model->status === \App\Entities\Action::DELETED) {
                                                    $badgeColor = 'bg-warning';
                                                } elseif ($model->status === \App\Entities\Action::BLOCKED) {
                                                    $badgeColor = 'bg-danger';
                                                }
                                            @endphp
                                            @if($model->status === \App\Entities\Action::ACTIVE)
                                            @elseif ($model->status === \App\Entities\Action::DELETED)
                                            @elseif ($model->status === \App\Entities\Action::BLOCKED)
                                            @endif
                                            <span class="badge {{ $badgeColor }}">{{ $model->status }}</span>
                                        </td>
                                        <td>
                                            {{ $model->created_at }}
                                        </td>
                                        <td>
                                            {{ $model->start_at->format('Y-m-d') }}
                                        </td>
                                        <td>
                                            {{ $model->end_at->format('Y-m-d') }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.actions.view', ['id' => $model->id]) }}">
                                                <i class="nav-icon fas fa-eye"></i>
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
