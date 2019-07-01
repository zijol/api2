<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 18/12/28
 * Time: 15:48
 */

namespace App\Services\Log;

/**
 * Class HttpLog
 *
 * @package App\Services\Log
 */
class NsqLog extends AbstractLog
{
    /**
     * @var string 日志路径
     */
    protected static $_logPath = '';

    /**
     * @var string 日志类型
     */
    protected $_logType = 'nsq_log';

    // 包括消息体
    protected $_typeContext = [
        'message' => '',
        'exception' => '',
        'topic' => '',
        'channel' => '',
        'host' => ''
    ];

    /**
     * @return AbstractLog
     */
    public static function getInstance()
    {
        if (empty(static::$_logPath)) {
            static::$_logPath = env('NSQ_LOG_PATH') ?? storage_path('logs') . '/consume_nsq_client.log';
        }
        return parent::getInstance();
    }
}
