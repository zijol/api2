<?php

namespace App\Exceptions;

use App\Services\Log\ExceptionLog;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
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
        // 如果是自定义的异常类
        if ($exception instanceof CustomException) {
            return parent::render($request, $exception);

            // 未认证的请求
        } else if ($exception instanceof AuthorizationException) {
            $exception = new UnauthorizedException('未认证的请求');

            // 无效路由
        } else if ($exception instanceof HttpException) {
            $exception = $this->_handleHttpException($exception, $request);

            // 验证错误
        } else if ($exception instanceof ValidationException) {
            $exception = new InvalidArgumentException($exception->validator->getMessageBag()->first());

            // 其他异常直接视为 500
        } else {
            $newException = new SystemException('系统错误');
            $newException->errorMessage = $exception->getMessage();
            $exception = $newException;
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
