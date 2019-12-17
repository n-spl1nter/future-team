@php
/** @var \App\Entities\Review $model */
/** @var string[] $countries */
@endphp

@extends('admin.layouts.main', ['title' => isset($model) ? __('common.reviews.edit') : __('common.reviews.new') ])

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
                                    <label>Name RU</label>
                                    <input name="name_ru" type="text" class="form-control" placeholder="Enter russian name" value="{{ isset($model) ? $model->name_ru : old('name_ru') }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Name EN</label>
                                    <input name="name_en" type="text" class="form-control" placeholder="Enter english name" value="{{ isset($model) ? $model->name_en : old('name_en') }}">
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
                                    <div class="custom-file">
                                        {{ Form::file('photo', ['class' => 'custom-file-input']) }}
                                        <label class="custom-file-label">Select avatar</label>
                                    </div>
                                    @if(isset($model))
                                        <div style="width: 100px;height: 100px;background: url('{{ $model->getAvatar()[1] }}') no-repeat center / cover;"></div>
                                    @endif
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
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Flag</label>
                                    <div class="custom-file">
                                        {{ Form::file('flag', ['class' => 'custom-file-input']) }}
                                        <label class="custom-file-label">Select Flag</label>
                                    </div>
                                    @if(isset($model) &&  count($model->getFlag()) > 0)
                                        <div style="width: 32px;height: 32px;background: url('{{ $model->getFlag()[1] }}') no-repeat center / cover;"></div>
                                    @endif
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
