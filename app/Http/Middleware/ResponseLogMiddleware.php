<?php

namespace App\Http\Middleware;

use App\Services\Log\SubObject\RequestObject;
use App\Services\Log\SubObject\ResponseObject;
use Closure;
use App\Services\Log\HttpLog;

class ResponseLogMiddleware
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
        return $next($request);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Http\Response $response
     */
    public function terminate($request, $response)
    {
        HttpLog::getInstance()->setContext([
            'request' => RequestObject::normalize($request),
            'response' => ResponseObject::normalize($response),
        ])->info('HttpLog');
    }
}
