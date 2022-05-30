<?php

namespace Modules\SsoClient\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use Modules\SsoClient\Http\Controllers\Controller;
use Modules\SsoClient\Notifications\TwoFactorCodeNotification;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\ErrorHandler\Error\FatalError;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('ssoclient::auth.login');
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $sso_api = env('SSO_API_URL', null);
        if ($sso_api == null) {
            throw new Exception('SSO_API_URL is not defined');
        }

        if ($this->guard()->attempt($this->credentials($request), $request->filled('remember'))) {
            $response = Http::post($sso_api . '/api/token/login', $this->credentials($request));
            if (!$response->ok()) {
                throw new Exception($response->json());
            }
            if (!Storage::put(md5($request->input('email')), $response->json('bearer_token'))) {
                throw new Exception('Storing bearer token failed');
            };
            return true;
        }
        return false;
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->two_factor) {
            $user->generateTwoFactorCode();
            $user->notify(new TwoFactorCodeNotification());
        }
    }

    public function logout(Request $request)
    {
        $sso_api = env('SSO_API_URL', null);
        if ($sso_api == null) {
            throw new Exception('SSO_API_URL is not defined');
        }

        $response = Http::post($sso_api . '/api/token/logout', $request->user()->only('email'));

        Storage::delete(md5($request->user()->email));

        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }
}
