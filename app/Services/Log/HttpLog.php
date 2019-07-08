<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 18/12/25
 * Time: 17:41
 */

namespace App\Services\Log;


use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\Log\SubObject\RequestObject;
use App\Services\Log\SubObject\ResponseObject;

/**
 * Class HttpLog
 *
 * @package App\Services\Log
 */
class HttpLog extends AbstractLog
{
    /**
     * @var string 日志路径
     */
    protected static $_logPath = '';

    /**
     * @var string 日志类型
     */
    protected $_logType = 'http_log';

    /**
     * @var array request 和 response 对象
     */
    protected $_typeContext = [
    ];

    /**
     * @return AbstractLog
     */
    public static function getInstance()
    {
        if (empty(static::$_logPath)) {
            static::$_logPath = config('logging.http_log_path');
        }
        return parent::getInstance();
    }

    /**
     * 请求日志
     *
     * @param Request $request
     * @return bool
     */
    public static function RequestLog(Request $request)
    {
        try {
            static::getInstance()
                ->delContext()
                ->setContext([
                    'request' => RequestObject::normalize($request),
                ])->info('HttpLog');
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return bool|AbstractLog
     */
    public static function ResponseLog(Request $request, Response $response)
    {
        try {
            static::getInstance()
                ->delContext()
                ->setContext([
                    'request' => RequestObject::normalize($request),
                    'response' => ResponseObject::normalize($response),
                ])->info('HttpLog');
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}
