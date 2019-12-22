@php
    /** @var \App\Entities\SliderPhoto[] $models */
@endphp

@extends('admin.layouts.main', ['title' => __('common.sliderPhotos.name') ])

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('admin.sliderPhotos.create') }}" class="btn btn-primary">Add photo to slider</a>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Order</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php /** @var \App\Entities\SliderPhoto $model */ @endphp
                                @foreach ($models as $model)
                                    <tr>
                                        <td>{{ $model->id }}</td>
                                        <td>
                                            <img src="{{ $model->getPhoto()[1] }}" alt="" style="max-width: 300px;max-height: 300px;">
                                        </td>
                                        <td>{{ $model->order }}</td>
                                        <td>
                                            <div class="row">
                                                <a href="{{ route('admin.sliderPhotos.edit', $model->id) }}" class="btn btn-primary mr-1 ml-2">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                {{ Form::open(['route' => ['admin.sliderPhotos.destroy', $model->id], 'method' => 'delete']) }}
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                                {{ Form::close() }}
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
