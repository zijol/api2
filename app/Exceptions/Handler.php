<?php

namespace App\Exceptions;

use App\Services\Log\Assist\LogHelper;
use App\Services\Log\ExceptionLog;
use Exception;
use App\Services\Log\SubObject\ExceptionObject;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
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
     * @param Exception $exception
     * @return mixed|void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);

        if (!$this->shouldntReport($exception))
            ExceptionLog::Log($exception);
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
            $exception = new ValidatorException($exception->validator->getMessageBag()->first());

            // 身份认证失败
        } else if ($exception instanceof AuthorizationException) {
            $exception = new AuthorizeException('非法访问');

            // 无效路由
        } else if ($exception instanceof HttpException) {
            $exception = $this->_HandleHttpException($exception);

            // Api 异常
        } else if (!$exception instanceof ApiException) {
            $exception = new SystemException($exception->getMessage(), $exception->getCode());
        }

        return parent::render($request, $exception);
    }


    /**
     * 处理 HttpException
     * @param HttpException $exception
     * @return BadRouteException|ForbiddenException
     */
    private function _HandleHttpException(HttpException $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            return new BadRouteException('无效的路由');
        } elseif ($exception instanceof MethodNotAllowedHttpException) {
            return new BadRouteException('无效的Method');
        } else {
            return new ForbiddenException('风险访问');
        }
    }
}
