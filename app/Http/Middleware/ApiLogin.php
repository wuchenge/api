<?php

/**
 * @Author: wuchenge
 * @Date: 2018-11-22 16:09:21
 */

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\Api\ApiController;

class ApiLogin extends ApiController
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $this->authToken();
        if (!$user) {
            return $this->notLogin();
        }

        return $next($request);
    }
}
