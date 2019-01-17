<?php

namespace App\Http\Middleware;

use App\Services\Log\SubObject\RequestObject;
use Closure;
use App\Services\Log\HttpLog;

class RequestLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        HttpLog::getInstance()->setContext([
            'request' => RequestObject::normalize($request),
        ])->info('HttpLog');
        return $next($request);
    }
}
