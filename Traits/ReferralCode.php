<?php


namespace Modules\SsoClient\Traits;

use Illuminate\Database\Eloquent\Model;

trait ReferralCode
{
    public static function bootReferralCode()
    {
        static::created(function (Model $model) {
            $model->referral_code = self::generateReferralCode($model->id);
            $model->save();
        });
    }

    protected static function generateReferralCode($id)
    {
        $code = '';
        $hex = substr(strtoupper(dechex(microtime(true) * rand(10, 999))), 0, 4);
        $code = $id . '-' . $hex;
        return $code;
    }
}
