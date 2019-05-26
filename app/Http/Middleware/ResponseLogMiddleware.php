<?php

namespace App\Http\Middleware;

use App\Services\Log\SubObject\ResponseObject;
use Closure;
use App\Services\Log\Assist\LogHelper;
use App\Services\Log\SubObject\RequestObject;
use Illuminate\Support\Facades\Log;

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
        Log::stack(['daily'])
            ->info('请求日志', [
                'unique_id' => LogHelper::instance()->unique_id,
                'exec_millisecond' => LogHelper::instance()->exec_millisecond,
                'serial_number' => LogHelper::instance()->serial_number,
                'request' => RequestObject::normalize($request),
                'response' => ResponseObject::normalize($response)
            ]);
    }
}
