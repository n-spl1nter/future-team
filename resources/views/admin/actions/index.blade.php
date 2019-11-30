@php
    /** @var \Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator */
@endphp

@extends('admin.layouts.main', ['title' => __('common.users.rolesManagement') ])

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Тут будут ссылки с экспортом
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                @php /** @var \App\Entities\Action $model */ @endphp
                                @foreach($paginator as $model)
                                    <tr>
                                        <td>{{ $model->id }}</td>
                                        <td>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        @include('admin._partials.pagination', ['paginator' => $paginator])
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
