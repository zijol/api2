<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 18/8/24
 * Time: 下午10:34
 */

namespace App\Services\Log;

use App\Services\Log\SubObject\ExceptionObject;

/**
 * Class ExceptionLog
 * @package Pingpp\Log\DashboardLog\Type
 *
 * @property AbstractLog $_instance
 */
class ExceptionLog extends AbstractLog
{
    /**
     * @var string 日志路径
     */
    protected static $_logPath = '';

    /**
     * @var array 该日志类型所需要的上下文字段
     */
    protected $_typeContext = [
        'exception' => ''
    ];

    /**
     * @var string 该类型日志的日志类型
     */
    protected $_logType = 'exception';

    /**
     * 错误注册类型
     *
     * @var array
     */
    protected static $_registerTypes = [
        'exception', 'error', 'shutdown'
    ];

    /**
     * 初始化子对象
     */
    public function init()
    {
        $this->_typeContext['exception'] = ExceptionObject::normalize([]);
    }

    /**
     * @return AbstractLog
     */
    public static function getInstance()
    {
        if (empty(static::$_logPath)) {
            static::$_logPath = env('EXCEPTION_LOG_PATH') ?? storage_path('logs') . '/exception.log';
        }
        return parent::getInstance();
    }

    /**
     * 进行错误异常中断注册
     *
     * @param string $module
     * @param string $msg
     */
    public static function registerErrorHandle($module = 'ExceptionLog', $msg = '')
    {
        // 添加错误日志
        if (in_array('error', static::$_registerTypes)) {
            set_error_handler(function ($code, $message, $file, $line, $content) use ($module, $msg) {
                static::getInstance()->setContext([
                    'exception' => ExceptionObject::normalize([
                        'message' => $message,
                        'file' => $file,
                        'line' => $line,
                        'code' => $code,
                        'trace' => json_encode($content)
                    ])
                ])->warning($module, $msg);
            });
        }

        // 异常日志
        if (in_array('exception', static::$_registerTypes)) {
            set_exception_handler(function (\Throwable $e) use ($module, $msg) {
                static::getInstance()->setContext([
                    'exception' => ExceptionObject::normalize([
                        'message' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'code' => $e->getCode(),
                        'trace' => $e->getTraceAsString(),
                    ])
                ])->warning($module, $msg);
            });
        }

        // 中断异常日志
        if (in_array('exception', static::$_registerTypes)) {
            register_shutdown_function(function () use ($module, $msg) {
                $e = error_get_last();
                if (empty($e)) return false;
                static::getInstance()->setContext([
                    'exception' => ExceptionObject::normalize([
                        'message' => $e['message'],
                        'file' => $e['file'],
                        'line' => $e['line'],
                        'code' => $e['type'],
                    ])
                ])->error($module, $msg);
            });
        }
    }
}
