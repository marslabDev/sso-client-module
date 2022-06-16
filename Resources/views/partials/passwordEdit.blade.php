@if(file_exists(module_path('SsoClient', 'Http/Controllers/Auth/ChangePasswordController.php')))
@can('profile_password_edit')
<li class="c-sidebar-nav-item">
<a class="c-sidebar-nav-link href="{{ route('profile.password.edit') }}
    {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}"
">
    <i class="fa-fw fas fa-key c-sidebar-nav-icon"></i>{{ trans('global.change_password') }}
</a>
</li>
@endcan
@endif
