<?php

namespace Modules\SsoClient\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Modules\SsoClient\Entities\User;
use Illuminate\Support\Facades\Cache;

class VerifyBearerToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $sso_api = env('SSO_API_URL', null);
        if ($sso_api == null) {
            throw new \Exception('SSO_API_URL is not defined');
        }
        
        $token = $request->bearerToken();
        $email = $request->header('X-VRDRUM-USER');

        if (!isset($token) || !isset($email)) {
            return response()->json(['error' => 'Bad Request'], 400);
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['error' => 'Not Found'], 404);
        }
        $response = Cache::remember('verifyToken_'.$user->id, 900, function () {
            return Http::withToken($token)->get($sso_api . '/api/v1/users/' . $user->id);
        });
        if (!$response->ok()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
