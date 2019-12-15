@php
    /** @var \App\Entities\Review[] $models */
@endphp

@extends('admin.layouts.main', ['title' => __('common.reviews.name') ])

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('admin.reviews.create') }}" class="btn btn-primary">Add review</a>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Avatar</th>
                                    <th>Title RU</th>
                                    <th>Title EN</th>
                                    <th>Country</th>
                                    <th>Created at</th>
                                    <th>Updated at</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php /** @var \App\Entities\Review $model */ @endphp
                                @foreach ($models as $model)
                                    <tr>
                                        <td>{{ $model->id }}</td>
                                        <td>avatar</td>
                                        <td>{{ $model->title_ru }}</td>
                                        <td>{{ $model->title_en }}</td>
                                        <td>{{ $model->country->title_en }}</td>
                                        <td>{{ $model->created_at }}</td>
                                        <td>{{ $model->updated_at }}</td>
                                        <td>
                                            <a href="{{ route('admin.reviews.edit', $model->id) }}" class="fa fa-pencil"></a>
                                            {{ Form::open(['route' => ['admin.reviews.destroy', $model->id], 'method' => 'delete']) }}
                                            <button type="submit" class="delete" onclick="return confirm('Are you sure?')">
                                                <i class="fa fa-remove"></i>
                                            </button>
                                            {{ Form::close() }}
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
