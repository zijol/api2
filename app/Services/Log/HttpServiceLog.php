<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 18/12/28
 * Time: 15:48
 */

namespace App\Services\Log;

use App\Services\Log\SubObject\ExceptionObject;

/**
 * Class HttpServiceLog
 *
 * @package App\Services\Log
 */
class HttpServiceLog extends AbstractLog
{
    /**
     * @var string 日志路径
     */
    protected static $_logPath = '';

    /**
     * @var string 日志类型
     */
    protected $_logType = 'http_service_log';

    // 包括消息体
    protected $_typeContext = [
        'request' => [],
        'response' => [],
        'exception' => []
    ];

    /**
     * @return AbstractLog
     */
    public static function getInstance()
    {
        if (empty(static::$_logPath)) {
            static::$_logPath = config('logging.http_service_log_path');
        }
        return parent::getInstance();
    }

    /**
     * 记录日志
     * @param $httpServiceLogInfo
     * @return bool
     */
    public static function Log($httpServiceLogInfo)
    {
        try {
            $httpServiceLogInfo['exception'] = ExceptionObject::normalize($httpServiceLogInfo['exception']);
            unset($httpServiceLogInfo['exception']['trace']);

            static::getInstance()
                ->delContext()
                ->setContext([
                    'request' => [
                        'domain' => $httpServiceLogInfo['domain'] ?? '',
                        'uri' => $httpServiceLogInfo['uri'] ?? '',
                        'timeout' => $httpServiceLogInfo['timeout'] ?? 5.0,
                        'headers' => $httpServiceLogInfo['headers'] ?? [],
                        'method' => $httpServiceLogInfo['method'] ?? 'GET',
                        'format' => $httpServiceLogInfo['format'] ?? 'form_params',
                        'params' => $httpServiceLogInfo['params'] ?? [],
                    ],
                    'response' => $httpServiceLogInfo['response'] ?? [],
                    'exception' => $httpServiceLogInfo['exception'] ?? [],
                ])->info('HttpServiceLog');
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}
