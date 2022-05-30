@extends('layouts.master')
@section('content')
<div class="c-wrapper">
    <header class="c-header c-header-fixed px-3">
        <!-- <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar"
            data-class="c-sidebar-show">
            <i class="fas fa-fw fa-bars"></i>
        </button> -->

        <a class="c-header-brand d-lg-none" href="#">{{ trans('panel.site_title') }}</a>

        <!-- <button class="c-header-toggler mfs-3 d-md-down-none" type="button" responsive="true">
            <i class="fas fa-fw fa-bars"></i>
        </button> -->

        <ul class="c-header-nav ml-auto">
            @if(count(config('panel.available_languages', [])) > 1)
            <li class="c-header-nav-item dropdown d-md-down-none">
                <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                    aria-expanded="false">
                    {{ strtoupper(app()->getLocale()) }}
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    @foreach(config('panel.available_languages') as $langLocale => $langName)
                    <a class="dropdown-item" href="{{ url()->current() }}?change_language={{ $langLocale }}">{{
                        strtoupper($langLocale) }} ({{ $langName }})</a>
                    @endforeach
                </div>
            </li>
            @endif

            {{-- @include('ssoclient::partials.notification') --}}
        </ul>
    </header>

    <div class="c-body">
        <main class="c-main">
            <div class="container-fluid">
                @if(session('message'))
                <div class="row mb-2">
                    <div class="col-lg-12">
                        <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                    </div>
                </div>
                @endif
                @if($errors->count() > 0)
                <div class="alert alert-danger">
                    <ul class="list-unstyled">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        {{ trans('cruds.welcome.title_singular') }}
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.welcome.select_portal') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                <tr>
                                    <td>
                                        <a href="{{ $role->redirect_url }}">
                                            {{ $role->title }}
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </div>
</div>
@endsection