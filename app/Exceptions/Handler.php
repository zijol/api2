<?php

namespace App\Exceptions;

use App\Services\Helper\ErrorCode\ErrorCode;
use App\Services\Helper\Make;
use App\Services\Log\SubObject\ExceptionObject;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Services\Log\ExceptionLog;
use Illuminate\Validation\ValidationException;

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

//        // 记录异常日志
//        ExceptionLog::getInstance()->setContext([
//            'exception' => ExceptionObject::normalize($exception)
//        ])->info('ExceptionLog');
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
        // 验证异常
        if ($exception instanceof ValidationException) {
            return parent::render($request, new ValidatorException(($exception->validator->getMessageBag()->first())));
        }

        return parent::render($request, $exception);
    }
}
