<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 18/12/26
 * Time: 14:09
 */

namespace App\Services\Helper;

use Illuminate\Support\Facades\App;

class Make
{
    /**
     * @var string 语言包模块
     */
    protected static $langModule = 'error.';

    /**
     * 加载语言包
     * @param string $codeConstant
     * @return array
     */
    protected static function _loadMsg($codeConstant = '')
    {
        $loadResult = __(self::$langModule . $codeConstant, [], App::getLocale());
        return [
            'code' => $loadResult['code'] ?? '5000',
            'msg' => $loadResult['msg'] ?? 'system error',
        ];
    }

    /**
     * 成功结果
     *
     * @param $result
     * @param string $msg
     * @return array
     */
    protected static function _success($result, $msg = '')
    {
        return [
            'code' => '0',
            'msg' => $msg,
            'result' => $result
        ];
    }

    /**
     * 失败结果
     *
     * @param string $codeConstant
     * @param array $result
     * @return array
     */
    protected static function _fail(string $codeConstant, $result = [])
    {
        return [
            'code' => self::_loadMsg($codeConstant)['code'],
            'msg' => self::_loadMsg($codeConstant)['msg'],
            'result' => $result
        ];
    }

    /**
     * Api常用成功结果返回
     *
     * @param mixed $result
     * @param string $msg
     * @return array
     */
    public static function ApiSuccess($result, $msg = '')
    {
        self::$langModule = 'error.';
        return self::_success($result, $msg);
    }

    /**
     * Api常用失败结果返回
     *
     * @param string $codeConstant
     * @param mixed $result
     * @return array
     */
    public static function ApiFail(string $codeConstant, $result = [])
    {
        self::$langModule = 'error.';
        return self::_fail($codeConstant, $result);
    }

    /**
     * Logic常用成功结果返回
     *
     * @param $result
     * @param string $msg
     * @return array
     */
    public static function LogicSuccess($result, $msg = '')
    {
        self::$langModule = 'logic.';
        return self::_success($result, $msg);
    }

    /**
     * Logic常用失败结果返回
     *
     * @param string $codeConstant
     * @param array $result
     * @return array
     */
    public static function LogicFail(string $codeConstant, $result = [])
    {
        self::$langModule = 'logic.';
        return self::_fail($codeConstant, $result);
    }

    /**
     * Middleware常用成功结果返回
     *
     * @param $result
     * @param string $msg
     * @return array
     */
    public static function MiddlewareSuccess($result, $msg = '')
    {
        self::$langModule = 'middleware.';
        return self::_success($result, $msg);
    }

    /**
     * Middleware常用失败结果返回
     *
     * @param string $codeConstant
     * @param array $result
     * @return array
     */
    public static function MiddlewareFail(string $codeConstant, $result = [])
    {
        self::$langModule = 'middleware.';
        return self::_fail($codeConstant, $result);
    }
}
