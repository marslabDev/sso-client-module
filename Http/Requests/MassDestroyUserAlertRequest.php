<?php

namespace Modules\SsoClient\Http\Requests;


use Modules\SsoClient\Entities\UserAlert;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyUserAlertRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('user_alert_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:sso_db.user_alerts,id',
        ];
    }
}
