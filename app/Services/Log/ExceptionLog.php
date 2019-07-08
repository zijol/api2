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
    protected $_logType = 'exception_log';

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
            static::$_logPath = config('logging.exception_log_path');
        }
        return parent::getInstance();
    }

    /**
     * 异常日志
     *
     * @param \Exception $exception
     * @return bool
     */
    public static function Log(\Exception $exception)
    {
        try {
            static::getInstance()
                ->setContext([
                    'exception' => ExceptionObject::normalize($exception)
                ])->error('ExceptionLog');
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}
