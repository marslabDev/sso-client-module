@if(file_exists(module_path('SsoClient', 'Http/Controllers/Auth/ChangePasswordController.php')))
@can('profile_password_edit')
<li class="c-sidebar-nav-item">
    @include('views.partials.passwordEditBody')
</li>
@endcan
@endif
