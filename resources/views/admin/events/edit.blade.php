@php
/** @var $model \App\Entities\Event */
/** @var $countries string[] */
/** @var $domains string[] */
@endphp
@extends('admin.layouts.main', ['title' => 'Update event #' . $model->id  ])

@section('content')
    <section class="content">
        {{ Form::open([
            'route' => ['admin.events.change', $model->id],
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
                            <label>Conditions</label>
                            <textarea name="conditions" cols="30" rows="4" class="form-control" placeholder="Conditions">{{ $model->conditions }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Additional Info</label>
                            <textarea name="additional_info" cols="30" rows="4" class="form-control" placeholder="Additional Info">{{ $model->additional_info }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Contact Data</label>
                            <input type="text" name="contact_data" value="{{ $model->contact_data }}" class="form-control" placeholder="Contact Data">
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
                    </div>
                </div>
            </div>
            <div class="col-md-6">

            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <a href="{{ route('admin.events.index') }}" class="btn btn-primary">{{ __('common.back') }}</a>
                <button type="submit" class="btn btn-success">{{ __('common.submit') }}</button>
            </div>
        </div>
        {{ Form::close() }}
    </section>
@endsection
