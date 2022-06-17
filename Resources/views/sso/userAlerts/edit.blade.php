@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header font-semibold text-lg">
        {{ trans('global.edit') }} {{ trans('ssoclient::cruds.userAlert.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("sso.user-alerts.update", [$userAlert->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection