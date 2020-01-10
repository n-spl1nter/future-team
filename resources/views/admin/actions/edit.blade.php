@php
    /** @var $model \App\Entities\Action */
    /** @var $countries string[] */
    /** @var $domains string[] */
@endphp
@extends('admin.layouts.main', [ 'title' => 'Update action #' . $model->id ])

@section('content')
    <section class="content">
        {{ Form::open([
            'route' => ['admin.actions.change', $model->id],
            'method' => 'put',
            'files' => true
        ]) }}
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">General</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="name" value="{{ $model->name }}" class="form-control" placeholder="Title">
                        </div>
                        <div class="form-group">
                            <label>About</label>
                            <textarea name="about" cols="30" rows="4" class="form-control" placeholder="About">{{ $model->about }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Success secret</label>
                            <textarea name="success_secret" cols="30" rows="4" class="form-control" placeholder="Success secret">{{ $model->reasons }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Start At</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-clock"></i></span>
                                        </div>

                                        <input value="{{ $model->start_at }}" type="text" class="datetime-mask form-control float-right" name="start_at">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>End At</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-clock"></i></span>
                                        </div>
                                        <input value="{{ $model->end_at }}" type="text" class="datetime-mask form-control float-right" name="end_at">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Country</label>
                            {{ Form::select('country_id', $countries, $model->country_id, [
                                'placeholder' => 'Select country',
                                'class' => 'form-control select2',
                            ])
                             }}
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            {{ Form::select('city_id', [$model->city_id => $model->city->title_en], $model->city_id, [
                                'placeholder' => 'Select City',
                                'class' => 'form-control city-select',
                            ])
                             }}
                        </div>
                        <div class="form-group">
                            <label>Domains</label>
                            @foreach($model->domains as $domain)
                                <div class="d-flex mb-1">
                                    <input type="text" name="domains[]" class="form-control" value="{{ $domain }}">
                                    <button type="button" class="btn-sm btn-danger remove-array-item">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            @endforeach
                            <div class="d-flex mt-2">
                                <button class="btn btn-success add-array-item" type="button" data-name="domains[]">Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-12">
                                <a href="{{ route('admin.actions.index') }}" class="btn btn-primary">{{ __('common.back') }}</a>
                                <button type="submit" class="btn btn-success">{{ __('common.submit') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Common</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Images</label>
                            <ul class="list-group">
                                @foreach($model->getImages(\App\Entities\MediaFile::TYPE_ACTION) as $image)
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <img src="{{ $image->url[0] }}" alt="" style="max-width: 200px;width: 100%; max-height: 200px">
                                            <button type="button" class="btn btn-danger main-photo-remove" data-id="{{ $image->id }}" data-url="{{ route('admin.actions.removePhoto') }}">Remove</button>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="mt-2">
                                <label class="btn btn-success" style="cursor: pointer;">
                                    <span>Upload new Photo</span>
                                    <input class="new-photo" id="new_photo_main" type="file" name="new_photo" style="width: 0; height: 0; visibility: hidden;"
                                           data-url="{{ route('admin.actions.newPhoto') }}"
                                           data-remove-url="{{ route('admin.actions.removePhoto') }}"
                                           data-entity_id="{{ $model->id }}"
                                    >
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Video links</label>
                            @foreach($model->video_links as $videoLink)
                                <div class="d-flex mb-1">
                                    <input type="text" name="video_links[]" class="form-control" value="{{ $videoLink }}">
                                    <button type="button" class="btn-sm btn-danger remove-array-item ml-1">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            @endforeach
                            <div class="d-flex mt-2">
                                <button class="btn btn-success add-array-item" type="button" data-name="video_links[]">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </section>
@endsection
