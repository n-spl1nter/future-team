@php
/** @var \App\Entities\Review $model */
/** @var string[] $countries */
@endphp

@extends('admin.layouts.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ isset($model) ? __('common.reviews.edit') : __('common.reviews.new')  }}
                    </h3>
                </div>
                {{ Form::open([
                        'route' => isset($model) ? ['admin.reviews.update', $model->id] : 'admin.reviews.store',
                        'method' => isset($model) ? 'put' : 'post',
                        'files' => true
                    ]) }}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Title RU</label>
                                    <input name="title_ru" type="text" class="form-control" placeholder="Enter russian title" value="{{ isset($model) ? $model->title_ru : old('title_ru') }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Title EN</label>
                                    <input name="title_en" type="text" class="form-control" placeholder="Enter english title" value="{{ isset($model) ? $model->title_en : old('title_en') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Text RU</label>
                                    <textarea name="text_ru" rows="10" class="form-control" placeholder="Enter russian text" >{{ isset($model) ? $model->text_ru : old('text_ru') }}</textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Text EN</label>
                                    <textarea name="text_en" rows="10" class="form-control" placeholder="Enter english text" >{{ isset($model) ? $model->text_en : old('text_en') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Avatar</label>
                                    @if(isset($model))
                                        <div class=""></div>
                                    @endif
                                    {{ Form::file('photo', []) }}
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Country</label>
                                    {{ Form::select('country_id', $countries, isset($model) ? $model->country_id : old('country_id'), [
                                        'placeholder' => 'Select country',
                                        'class' => 'form-control select2',
                                    ])
                                     }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-primary">{{ __('common.back') }}</a>
                        <button type="submit" class="btn btn-success">{{ __('common.submit') }}</button>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
