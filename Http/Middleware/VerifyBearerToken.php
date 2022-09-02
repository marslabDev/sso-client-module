<?php

namespace Modules\SsoClient\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
        $response = Cache::remember('verifyToken_'.$token, 900, function () use ($token, $sso_api) {
            return Http::withToken($token)->withHeaders([
                'X-VRDRUM-USER' => $email,
                'Request-Timeout' => $request->header('Request-Timeout'),
            ])->get($sso_api . '/api/validate-token');
        });
        if (!$response->ok()) {
            Cache::forget('verifyToken_'.$token);
            return response()->json(['error' => 'Unauthorized'], 401);
        } else if (!$response->body('data')) {
            return response()->json(['error' => 'Not Found'], 404);
        }

        return $next($request);
    }
}
