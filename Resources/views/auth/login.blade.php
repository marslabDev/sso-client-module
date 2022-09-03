@extends('layouts.app')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-6 mobile_card">
        <div class="card mx-5 px-2 login_card mobile_card">
            <div class="card-body px-4 py-4 mobile_body">
                <p class="text-xl mb-3 font-medium">{{ trans('panel.site_title') }} {{ trans('global.login') }} </p>

                @if(session('message'))
                    <div class="alert alert-info" role="alert">
                        {{ session('message') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-user"></i>
                            </span>
                        </div>

                        <input id="email" name="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}" value="{{ old('email', null) }}">

                        @if($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                        </div>

                        <input id="password" name="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required placeholder="{{ trans('global.login_password') }}">

                        @if($errors->has('password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>

                    <div class="mobile_pass">
                        <div class="row mt-4">
                            <div class="col-6 input-group mb-4">
                                <div class="form-check checkbox">
                                    <input class="form-check-input" name="remember" type="checkbox" style="vertical-align: middle;" />
                                    <label class="form-check-label mt-1" for="remember" style="vertical-align: middle;">
                                        {{ trans('global.remember_me') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                @if(Route::has('password.request'))
                                    <a class="btn btn-link px-0 login_btn font-medium" href="{{ route('password.request') }}">
                                        {{ trans('global.forgot_password') }}
                                    </a><br>
                                @endif
                            </div>
                        </div>
                    </div>    
                    <div class="web_pass">
                        <div class="col-lg-10 input-group mb-4">
                            <div class="form-check checkbox">
                                <input class="form-check-input" name="remember" type="checkbox" style="vertical-align: middle;" />
                                <label class="form-check-label mt-1" for="remember" style="vertical-align: middle;">
                                    {{ trans('global.remember_me') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-10 text-center">
                            @if(Route::has('password.request'))
                                <a class="btn btn-link px-0 login_btn font-medium" href="{{ route('password.request') }}">
                                    {{ trans('global.forgot_password') }}
                                </a><br>
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="btn btn-block btn-primary">
                        {{ trans('global.login') }}
                    </button>
                    
                    <div class="text-center mt-1 register_top">
                        <a class="btn btn-secondary w-full" href="{{ route('register') }}"> {{ trans('global.register') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
