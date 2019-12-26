@php
/** @var \App\Entities\User[] $lastUsers */
@endphp
<!-- USERS LIST -->
<div class="card card-dark">
    <div class="card-header with-border">
        <h3 class="card-title">Recent users</h3>
        <div class="card-tools pull-right">
            <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="card-body no-padding">
        <ul class="users-list clearfix">
            @foreach($lastUsers as $user)
            <li>
                @php
                $avatar = $user->getAvatar();
                if ($avatar) {
                    $avatar = $avatar[1];
                }
                @endphp
                <div style="margin: 0 auto;width: 50px; height: 50px; border-radius: 50%;background: url({{ $avatar }});  background-size: cover; "></div>
                <a class="users-list-name" href="{{ route('admin.users.view', ['user' => $user->id]) }}">{{ $user->getFullName() }}</a>
                <span class="users-list-date">{{ $user->created_at->diffForHumans() }}</span>
            </li>
            @endforeach
        </ul>
        <!-- /.users-list -->
    </div>
    <!-- /.box-body -->
    <div class="card-footer text-center">
        <a href="{{ route('admin.users.index') }}" class="uppercase">All users</a>
    </div>
    <!-- /.box-footer -->
</div>
<!--/.box -->
