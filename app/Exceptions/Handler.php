<?php

namespace App\Exceptions;

use App\Services\Log\Assist\LogHelper;
use Exception;
use App\Services\Log\SubObject\ExceptionObject;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        ApiException::class
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
            $exception = new ValidatorException(($exception->validator->getMessageBag()->first()));

            // 身份认证失败
        } else if ($exception instanceof AuthorizationException) {
            $exception = new AuthorizeException('非法访问');

            // 无效路由
        } else if ($exception instanceof  NotFoundHttpException) {
            $exception = new BadRouteException('无效的路由');
        } else {
            Log::stack(['exception'])
                ->error('系统错误', array_merge([
                    'unique_id' => LogHelper::instance()->unique_id,
                    'serial_number' => LogHelper::instance()->serial_number,
                    'exec_millisecond' => LogHelper::instance()->exec_millisecond,
                ], ExceptionObject::normalize($exception)));

            $exception = new ApiException('系统错误');
        }

        return parent::render($request, $exception);
    }
}
