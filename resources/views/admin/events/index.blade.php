@php
    /** @var \Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator */
@endphp

@extends('admin.layouts.main', ['title' => __('common.events.name') ])

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
                                @php /** @var \App\Entities\Event $model */ @endphp
                                @foreach($paginator as $model)
                                    <tr>
                                        <td>{{ $model->id }}</td>
                                        <td>
                                            <div style="width: 100px;height: 100px;background: url('{{ $model->getImage(\App\Entities\MediaFile::TYPE_EVENT)->url[1] }}') no-repeat center / cover"></div>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.events.view', ['id' => $model->id]) }}">
                                                {{ $model->name }}
                                            </a>
                                        </td>
                                        <td>
                                            @php
                                                $badgeColor = 'bg-success';
                                                if ($model->status === \App\Entities\Event::DELETED) {
                                                    $badgeColor = 'bg-warning';
                                                } elseif ($model->status === \App\Entities\Event::BLOCKED) {
                                                    $badgeColor = 'bg-danger';
                                                }
                                            @endphp
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
                                            <a class="btn btn-primary btn-sm" href="{{ route('admin.events.view', ['id' => $model->id]) }}">
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
