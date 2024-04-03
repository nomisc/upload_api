<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomApiAuth
{

    private array $keys;

    public function __construct()
    {
        $this->keys = explode('|',config('app.api_keys'));
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

        if (!in_array($request->header('ApiToken'),$this->keys)) {
            return response()->json(['error'=>'Unauthorized'],401);
        }

        return $next($request);
    }
}
