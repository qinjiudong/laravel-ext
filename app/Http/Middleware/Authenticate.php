<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $appid = env('DDAPPID', 'dingoauw1dz6n9i3l37wis');
        $url = 'https://oapi.dingtalk.com/connect/qrconnect?appid=' . $appid;
        $url .= '&response_type=code&scope=snsapi_login&state=STATE&redirect_uri=';
        $url .= urlencode(env('DDURL', 'http://test2.com/login'));
        if (!session('isLogin')) {
            return redirect($url);
        }
        return $next($request);
    }
}
