@php
/** @var \App\Entities\SliderPhoto $model */
/** @var string[] $countries */
@endphp

@extends('admin.layouts.main', ['title' => isset($model) ? __('common.sliderPhotos.edit') : __('common.sliderPhotos.new') ])

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ isset($model) ? __('common.sliderPhotos.edit') : __('common.sliderPhotos.new')  }}
                    </h3>
                </div>
                {{ Form::open([
                        'route' => isset($model) ? ['admin.sliderPhotos.update', $model->id] : 'admin.sliderPhotos.store',
                        'method' => isset($model) ? 'put' : 'post',
                        'files' => true
                    ]) }}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Order</label>
                                    <input name="order" type="text" class="form-control" placeholder="Enter order" value="{{ isset($model) ? $model->order : (old('order') ? old('order') : 100) }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Flag</label>
                                    <div class="custom-file">
                                        {{ Form::file('photo', ['class' => 'custom-file-input']) }}
                                        <label class="custom-file-label">Select Image</label>
                                    </div>
                                    @if(isset($model) &&  count($model->getPhoto()) > 0)
                                        <img src="{{ $model->getPhoto()[1] }}" alt="" style="max-width: 300px;max-height: 300px;">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <a href="{{ route('admin.sliderPhotos.index') }}" class="btn btn-primary">{{ __('common.back') }}</a>
                        <button type="submit" class="btn btn-success">{{ __('common.submit') }}</button>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
