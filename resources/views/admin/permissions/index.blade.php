@extends('admin.layouts.main', ['title' => __('common.permissions.rolesManagement')])

@section('content')
    {{--{{ Breadcrumbs::render('admin.roles') }}--}}
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="hentry group box">
                    <div class="box-body">
                        {{ Form::open([
                            'route' => 'admin.permissions.update',
                            'method' => 'put',
                        ]) }}
                            @csrf
                            <div class="short-table white">
                                <table style="width:100%" class="table admin-table table-striped table-bordered">
                                    <thead>
                                    <th></th>
                                    @if(!$roles->isEmpty())
                                        @foreach($roles as $role)
                                            <th>{{ $role->name }}</th>
                                        @endforeach
                                    @endif
                                    </thead>
                                    <tbody>
                                    @if(!$permissions->isEmpty())
                                        @foreach($permissions as $permission)
                                            <tr>
                                                <td>{{ $permission->name }} ({{ $permission->description }})</td>
                                                @foreach($roles as $role)
                                                    <td>
                                                        <input type="checkbox" value="{{ $permission->id }}"
                                                               name="{{ $role->id }}[]" {{ $role->hasPermission($permission->name) ? 'checked' : '' }}>
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <input class="btn btn-success" type="submit" value="{{ __('common.refresh') }}"/>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
