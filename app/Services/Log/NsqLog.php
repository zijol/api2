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
        'exception' => [],
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
            static::$_logPath = config('logging.nsq_log_path');
        }
        return parent::getInstance();
    }

    /**
     * 记录日志
     *
     * @param string $host
     * @param string $topic
     * @param string $channel
     * @param array $message
     * @return bool
     */
    public static function Log(string $host, string $topic, string $channel, array $message)
    {
        try {
            static::getInstance()
                ->delContext()
                ->setContext([
                    'message' => json_encode(CustomObject::normalize($message), JSON_UNESCAPED_UNICODE),
                    'host' => $host,
                    'topic' => $topic,
                    'channel' => $channel,
                ])->info('NsqLog');
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * 异常日志
     * @param string $host
     * @param string $topic
     * @param string $channel
     * @param \Exception $exception
     * @return bool
     */
    public static function ExceptionLog(string $host, string $topic, string $channel, \Exception $exception)
    {
        try {
            static::getInstance()
                ->delContext()
                ->setContext([
                    'exception' => ExceptionObject::normalize($exception),
                    'host' => $host,
                    'topic' => $topic,
                    'channel' => $channel,
                ])->error('NsqLog');
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}
