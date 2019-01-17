<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 18/12/25
 * Time: 17:41
 */

namespace App\Services\Log;

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
        'request' => '',
        'response' => ''
    ];

    /**
     * @return AbstractLog
     */
    public static function getInstance()
    {
        if (empty(static::$_logPath)) {
            static::$_logPath = env('HTTP_LOG_PATH') ?? storage_path('logs') . '/http.log';
        }
        return parent::getInstance();
    }
}
