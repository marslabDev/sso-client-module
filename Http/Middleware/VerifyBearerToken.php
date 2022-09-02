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
        if (Cache::has('verifyToken_'.$token)) {
            $response = Cache::get('verifyToken_'.$token);
        } else {
            $response = Http::withToken($token)->withHeaders([
                    'X-VRDRUM-USER' => $request->header('X-VRDRUM-USER'),
                    'Request-Timeout' => $request->header('Request-Timeout'),
                ])->get($sso_api . '/api/validate-token');
        }
        try {
            $responseMap = (array) json_decode($response?->body());
        } catch (\Throwable $th) {
            $response = Http::withToken($token)->withHeaders([
                'X-VRDRUM-USER' => $request->header('X-VRDRUM-USER'),
                'Request-Timeout' => $request->header('Request-Timeout'),
            ])->get($sso_api . '/api/validate-token');
            $responseMap = (array) json_decode($response?->body());
        }
        if (!$response?->ok()) {
            if (Cache::has('verifyToken_'.$token)) {
                Cache::forget('verifyToken_'.$token);
            }
            $message = $response?->body('message') ?? 'Unauthorized';
            return response()->json(['error' => $message], 401);
        } else if (empty($responseMap['data'])) {
            return response()->json(['error' => 'Not Found'], 404);
        } else if ($response?->ok()) {
            Cache::remember('verifyToken_'.$token, 900, function () use ($response) {
               return $response;
            });
        }

        return $next($request);
    }
}
