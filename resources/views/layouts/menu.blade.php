@php $currentRoute = request()->route()->getName(); @endphp
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href="{{ route('admin.home') }}"
                class="{{ str_contains($currentRoute, 'home') ? 'nav-link active' : 'nav-link' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    {{ trans('cruds.menu.dashboard') }}
                </p>
            </a>
        </li>
        @if (canPass('admins_index') || canPass('roles_index'))
            <li class="nav-item has-treeview menu-open">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        {{ trans('cruds.menu.user_management') }}
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @if (canPass('admins_index'))
                        <li class="nav-item">
                            <a href="{{ route('admin.admins.index') }}"
                                class="{{ str_contains($currentRoute, 'admins') ? 'nav-link active' : 'nav-link' }}">
                                <i class="fas fa-users nav-icon"></i>
                                <p>{{ trans('cruds.admins.title_plural') }}</p>
                            </a>
                        </li>
                    @endif
                    @if (canPass('roles_index'))
                        <li class="nav-item">
                            <a href="{{ route('admin.roles.index') }}"
                                class="{{ str_contains($currentRoute, 'roles') ? 'nav-link active' : 'nav-link' }}">
                                <i class="fas fa-user-tag nav-icon"></i>
                                <p>{{ trans('cruds.roles.title_plural') }}</p>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @else
        @endif



        @if (canPass('info_pages_index'))
            <li class="nav-item">
                <a href="{{ route('admin.info_pages.index') }}"
                    class="{{ str_contains($currentRoute, 'info_pages') ? 'nav-link active' : 'nav-link' }}">
                    <i class="nav-icon fas fa-info-circle"></i>
                    <p>{{ trans('cruds.info_pages.title_plural') }}</p>
                </a>
            </li>
        @endif

        @if (canPass('contact_messages_index'))
            <li class="nav-item">
                <a href="{{ route('admin.contact_messages.index') }}"
                    class="{{ str_contains($currentRoute, 'contact_messages') ? 'nav-link active' : 'nav-link' }}">
                    <i class="nav-icon fas fa-headset"></i>
                    <p>{{ trans('cruds.contact_messages.title_plural') }}</p>
                </a>
            </li>
        @endif



        @if (canPass('projects_index'))

            <li class="nav-item">
                <a href="{{ route('admin.projects.index') }}"
                    class="{{ str_contains($currentRoute, 'projects') ? 'nav-link active' : 'nav-link'}}">
                    <i class="nav-icon fas fa-solid fa-city"></i>
                    <p>{{ trans('cruds.projects.title_plural') }}</p>
                </a>
            </li>
        @endif
        {{-- end --}}
    </ul>
</nav>