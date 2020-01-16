<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-success elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.home') }}" class="brand-link">
        <img src="{{ asset('assets/admin/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <div style="background: url({{ Auth::user()->getAvatar()[1] }}) no-repeat center / cover; width: 40px;height: 40px;"
                     class="img-circle elevation-2"></div>
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->email }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent text-sm nav-compact" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.home') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>{{ __('common.home') }}</p>
                    </a>
                </li>
                @can('manageUsers', \App\Entities\User::class)
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>{{ __('common.users.name') }}</p>
                    </a>
                </li>
                @endcan
                @can('view', \App\RBAC\Permission::class)
                <li class="nav-item">
                    <a href="{{ route('admin.permissions.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-lock"></i>
                        <p>{{ __('common.permissions.name') }}</p>
                    </a>
                </li>
                @endcan
                <li class="nav-item">
                    <a href="{{ route('admin.actions.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-map-marked-alt"></i>
                        <p>{{ __('common.actions.name') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.events.index') }}" class="nav-link">
                        <i class="nav-icon far fa-calendar-check"></i>
                        <p>{{ __('common.events.name') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.mainNews') }}" class="nav-link">
                        <i class="nav-icon fas fa-star"></i>
                        <p>{{ __('common.mainNews.name') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.subscribers.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-envelope-open"></i>
                        <p>{{ __('common.subscribers.name') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.emailMessages.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-envelope-open-text"></i>
                        <p>{{ __('common.messages.name') }}</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Common content
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.reviews.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-comments"></i>
                                <p>{{ __('common.reviews.name') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.sliderPhotos.index') }}" class="nav-link">
                                <i class="nav-icon far fa-images"></i>
                                <p>{{ __('common.sliderPhotos.name') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

