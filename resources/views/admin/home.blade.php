@extends('admin.layouts.main', ['title' => 'Admin panel'])

@section('content')
    @include('admin._partials.small-stats')
    <div class="row">
        <div class="col-5">
            @include('admin._partials.last-users')
        </div>
        <div class="col-7">
            @include('admin._partials.users-registers')
        </div>
    </div>
@endsection
