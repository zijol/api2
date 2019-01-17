<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 18/8/18
 * Time: 上午11:38
 */

namespace App\Services\Log\Assist;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\JsonFormatter;

final class LogRecorder
{
    /**
     * @var Logger|null
     */
    private $_logger = null;

    /**
     * @var StreamHandler|null
     */
    private $_streamHandler = null;

    /**
     * @var LogRecorder
     */
    private static $_instance = [];

    /**
     * 不可直接是实例化
     *
     * LogRecorder constructor.
     * @param $channel
     * @param $logPath
     * @throws \Exception
     */
    protected function __construct($channel, $logPath)
    {
        $this->_streamHandler = new StreamHandler($logPath);
        $this->_streamHandler->setFormatter(new JsonFormatter());
        $this->_logger = new Logger($channel, [$this->_streamHandler]);
        $this->_logger->pushProcessor(function ($record) {
            $logRecord = $record['context'];
            $logRecord['level'] = $record['level'];
            return $logRecord;
        });
    }

    /**
     * 日志配置 channel、logPath
     * @param string $channel 通道名称
     * @param string $logPath 日志路径
     * @return LogRecorder 唯一实例
     * @throws \Exception
     */
    public static function instance($channel, $logPath)
    {
        $instanceIndex = md5($channel . $logPath);
        if (!isset(static::$_instance[$instanceIndex])) {
            static::$_instance[$instanceIndex] = new static($channel, $logPath);
        }
        return static::$_instance[$instanceIndex];
    }

    /**
     * 记录日志
     *
     * @param $level
     * @param $message
     * @param array $context
     * @return bool
     */
    public function log($level, $message, $context = [])
    {
        return $this->_logger->log($level, $message, $context);
    }
}
