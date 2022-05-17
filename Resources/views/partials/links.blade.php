@can('user_management_access')
<li class="c-sidebar-nav-dropdown {{ request()->is("sso/permissions*") ? "c-show" : "" }} {{ request()->is("sso/roles*") ? "c-show" : "" }} {{ request()->is("sso/users*") ? "c-show" : "" }}">
    <a class="c-sidebar-nav-dropdown-toggle" href="#">
        <i class="fa-fw fas fa-users c-sidebar-nav-icon">

        </i>
        {{ trans('ssoclient::cruds.userManagement.title') }}
    </a>
    <ul class="c-sidebar-nav-dropdown-items">
        @can('permission_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("sso.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("sso/permissions") || request()->is("sso/permissions/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                    </i>
                    {{ trans('ssoclient::cruds.permission.title') }}
                </a>
            </li>
        @endcan
        @can('role_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("sso.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("sso/roles") || request()->is("sso/roles/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                    </i>
                    {{ trans('ssoclient::cruds.role.title') }}
                </a>
            </li>
        @endcan
        @can('user_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("sso.users.index") }}" class="c-sidebar-nav-link {{ request()->is("sso/users") || request()->is("sso/users/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                    </i>
                    {{ trans('ssoclient::cruds.user.title') }}
                </a>
            </li>
        @endcan
    </ul>
</li>
@endcan