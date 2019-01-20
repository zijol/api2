<?php

namespace App\Http\Middleware;

use App\Services\Helper\Make;
use App\Services\Helper\ErrorCode\MdwErrorCode;
use App\Services\Helper\ModuleKeySecret;
use Closure;

class CheckSignature
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
        $moduleName = $request->header('X-ZIJOL-MODULE');
        $moduleSecret = ModuleKeySecret::getSecret($moduleName);

        // 如果模块的键不存在
        if (empty($moduleSecret)) {
            return Make::MiddlewareFail(MdwErrorCode::MODULE_ERROR);
        }

        // 验证签名
        $signResult = $this->_checkSignature($request, $moduleSecret);

        if ($signResult !== true) {
            return Make::MiddlewareFail(MdwErrorCode::SIGN_ERROR, $signResult);
        }

        return $next($request);
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @param $moduleSecret
     * @return bool
     */
    protected function _checkSignature($request, $moduleSecret)
    {
        $requestData = $request->toArray();
        $signature = $request['signature'] ?? '';
        unset($requestData['signature']);
        $signResult = ModuleKeySecret::sign($requestData, $moduleSecret);
        return $signature == $signResult ? true : $signResult;
    }
}
