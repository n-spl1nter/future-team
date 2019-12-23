@php
    /** @var \Illuminate\Database\Eloquent\Collection $models */
@endphp

@extends('admin.layouts.main', ['title' => __('common.mainNews.name') ])

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
                                <th>Type</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @php /** @var \App\Entities\Action | \App\Entities\Event $model */ @endphp
                            @foreach ($models as $model)
                                <tr>
                                    <td>{{ $model->id }}</td>
                                    <td>
                                        @if ($model instanceof \App\Entities\Event)
                                            <p>Event</p>
                                        @else
                                            <p>Action</p>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($model instanceof \App\Entities\Event)
                                            <div style="width: 100px;height: 100px;background: url('{{ $model->getImages(\App\Entities\MediaFile::TYPE_EVENT)[0]['url'][0] }}') no-repeat center / cover; border-radius: 100%;"></div>
                                        @else
                                            <div style="width: 100px;height: 100px;background: url('{{ $model->getImages(\App\Entities\MediaFile::TYPE_ACTION)[0]['url'][0] }}') no-repeat center / cover; border-radius: 100%;"></div>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $model->name }}
                                    </td>
                                    <td>
                                        {{ $model->status }}
                                    </td>
                                    <td>
                                        {{ $model->created_at }}
                                    </td>
                                    <td>
                                        <div class="row">
                                            @php
                                            $route = $model instanceof \App\Entities\Event ? 'admin.events.view' : 'admin.actions.view';
                                            @endphp
                                            <a href="{{ route($route, $model->id) }}" class="btn btn-primary mr-1 ml-2">
                                                <i class="fas fa-eye"></i> View
                                            </a>
{{--                                            {{ Form::open(['route' => ['admin.reviews.destroy', $model->id], 'method' => 'delete']) }}--}}
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i> Remove from main news list
                                            </button>
{{--                                            {{ Form::close() }}--}}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
