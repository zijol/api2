<?php

namespace App\Exceptions;

use App\Services\Helper\ErrorCode\ErrorCode;
use App\Services\Helper\Make;
use App\Services\Log\SubObject\ExceptionObject;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Services\Log\ExceptionLog;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);

        // 记录异常日志
        ExceptionLog::getInstance()->setContext([
            'exception' => ExceptionObject::normalize($exception)
        ])->info('ExceptionLog');
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // 如果是API异常
        if ($request->route()->getPrefix() == 'api') {
            return Make::ApiFail(ErrorCode::SYSTEM_ERROR);
        }

        // 如果是ajax请求
        if ($request->ajax()) {
            return Make::ApiFail(ErrorCode::SYSTEM_ERROR);
        }

        return parent::render($request, $exception);
    }
}
