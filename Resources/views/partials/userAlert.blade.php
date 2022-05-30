@can('user_alert_access')
<li class="c-sidebar-nav-item">
    <a href="{{ route("sso.user-alerts.index") }}" class="c-sidebar-nav-link {{ request()->is("sso/user-alerts") || request()->is("sso/user-alerts/*") ? "c-active" : "" }}">
        <i class="fa-fw fas fa-bell c-sidebar-nav-icon">

        </i>
        {{ trans('ssoclient::cruds.userAlert.title') }}
    </a>
</li>
@endcan