<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 18/8/17
 * Time: 下午12:44
 */

namespace App\Services\Log;

use Monolog\Logger;
use App\Services\Log\Assist\LogHelper;
use App\Services\Log\Assist\LogRecorder;

/**
 * Class AbstractLog
 * @package Pingpp\Log\DashboardLog
 *
 * @method AbstractLog debug($log_module = '', $message = '')
 * @method AbstractLog info($log_module = '', $message = '')
 * @method AbstractLog warning($log_module = '', $message = '')
 * @method AbstractLog error($log_module = '', $message = '')
 * @method AbstractLog critical($log_module = '', $message = '')
 * @method AbstractLog alert($log_module = '', $message = '')
 * @method AbstractLog emergency($log_module = '', $message = '')
 * @property string logId 日志ID
 */
abstract class AbstractLog
{
    /**
     * @var LogHelper|null
     */
    private $_logHelper = null;

    /**
     * @var string 日志的记录文件路径
     * 想要不同类型的日志支持存储在不同文件，只需在子类中覆盖该属性(当前不建议)
     * 并可以被config()进行日志文件路径配置
     */
    protected static $_logPath = '';

    /**
     * 日志等级，前期开放三个等级的日志
     * 想要在不同类型的日志支持不同的日志等级列表，只需在子类中覆盖该属性
     * @var array
     */
    protected static $_logLevelList = [
        'DEBUG' => Logger::DEBUG,
        'INFO' => Logger::INFO,
        'NOTICE' => Logger::NOTICE,
        'WARNING' => Logger::WARNING,
        'ERROR' => Logger::ERROR,
        'CRITICAL' => Logger::CRITICAL,
        'ALERT' => Logger::ALERT,
        'EMERGENCY' => Logger::EMERGENCY,
    ];

    /**
     * 日志通用上下文
     * @var array
     */
    protected $_context = [
        'log_commit_id' => '',
        'log_tag_no' => '',
        'log_id' => '',
        'log_serial' => 1,
        'log_time' => '',
        'log_exec_time' => 0,
        'log_type' => '',
        'log_module' => '',
        'log_level' => '',
    ];

    /**
     * 用于自定义装饰context，并返回装饰后的context，不会修改原本context
     *
     * @callback string
     */
    protected $_decorateContextHandler = null;

    /**
     * 安全属性，不会被 setContent() delContent()操作
     * @var array
     */
    private $_safeContextLabel = [
        'log_commit_id', 'log_tag_no', 'log_id', 'log_time', 'log_level', 'log_type', 'log_module',
    ];

    /**
     * @var array 具体日志类型所需上下文，请在子类中覆盖该值
     * @overwrite
     */
    protected $_typeContext = [];

    /**
     * @var string 具体日志类型所需日志类型，请在子类中覆盖该值
     * @overwrite
     */
    protected $_logType = '';

    /**
     * @var AbstractLog
     */
    protected static $_instance = [];

    /**
     * 设置日志固定参数
     * AbstractLog constructor.
     */
    private function __construct()
    {
        $this->_logHelper = LogHelper::instance();
        // 设置日志类型，子类覆盖属性后，会使用到子类的属性
        $this->_context['log_type'] = $this->_logType;
        // 设置安全属性
        if (empty($this->_safeContextLabel)) {
            $this->_safeContextLabel = array_keys($this->_context);
        }

        // 提供初始化的方法
        if (method_exists($this, 'init')) {
            $this->init();
        }

        // 将具体日志类的扩展上下文合并，但是不会覆盖_context原有的上下文
        $this->_context = $this->_context + $this->_typeContext;
    }

    /**
     * 单例实现日志对象
     * @return AbstractLog
     */
    public static function getInstance()
    {
        $cName = get_called_class();
        if (!isset(static::$_instance[$cName])) {
            static::$_instance[$cName] = new $cName;
        }
        return static::$_instance[$cName];
    }

    /**
     * 提供自主配置日志文件路劲的方法
     *
     * @param string $logPath 配置日志的文件路径
     */
    public static function config($logPath)
    {
        static::$_logPath = $logPath;
    }

    /**
     * 重新初始化LogHelper
     *
     * @throws \App\Exceptions\SystemException
     */
    public static function restart()
    {
        LogHelper::instance()->init();
    }

    /**
     * 设置上下问信息
     *
     * @param array $contextArray
     * @return $this
     */
    public function setContext($contextArray = [])
    {
        foreach ($contextArray as $attrKey => $attrValue) {
            if (!in_array($attrKey, $this->_safeContextLabel)) {
                if (is_array($attrValue) || is_object($attrValue)) {
                    foreach ($attrValue as $k => $v) {
                        if (is_array($v)) {
                            $this->_context[$attrKey . '.' . $k] = json_encode($v, JSON_UNESCAPED_UNICODE);
                        } else {
                            $this->_context[$attrKey . '.' . $k] = $v;
                        }
                    }
                    unset($this->_context[$attrKey]);
                } else {
                    $this->_context[$attrKey] = $attrValue;
                }
            }
        }
        return $this;
    }

    /**
     * 移除指定的上下文信息
     *
     * @param array $contextIndex
     * @return $this
     */
    public function delContext($contextIndex = [])
    {
        if (empty($contextIndex)) {
            foreach ($this->_context as $key => $value) {
                if (!in_array($key, $this->_safeContextLabel)) {
                    unset($this->_context[$key]);
                }
            }
            return $this;
        }

        foreach ($contextIndex as $index) {
            if (isset($this->_context[$index]) && !in_array($index, $this->_safeContextLabel)) {
                unset($this->_context[$index]);
            }
        }

        return $this;
    }

    /**
     * 支持属性直接访问
     *
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        $lowerName = strtolower($name);
        switch ($lowerName) {
            case "logid":
                return $this->_context['log_id'];
            default:
                return null;
        }
    }

    /**
     * 记录日志
     *
     * @param $name
     * @param $arguments
     * @return $this
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        // 方法名、日志等级名字
        $methodName = $logLevelName = strtoupper($name);
        // 日志等级名称列表
        $logLevelNameList = array_keys(static::$_logLevelList);

        // 魔术方法，使用的方法名必须在允许的日志类型名中，否则不记录日志
        if (in_array($methodName, $logLevelNameList)) {
            // 描述模块信息
            $logModule = isset($arguments[0]) && is_string($arguments[0]) ? $arguments[0] : "";
            // 日志附属消息
            $message = isset($arguments[1]) && is_string($arguments[1]) ? $arguments[1] : "";

            // 设置日志ID
            $this->_context['log_id'] = $this->_logHelper->unique_id;
            // 描述模块信息添加到上下文中
            $this->_context['log_module'] = $logModule;
            // 日志等级
            $this->_context['log_level'] = $logLevelName;
            // 日志序号
            $this->_context['log_serial'] = $this->_logHelper->serial_number;
            // 日志时间
            $this->_context['log_time'] = date('Y-m-d H:i:s');
            // 过程执行毫秒数
            $this->_context['log_exec_time'] = $this->_logHelper->exec_millisecond;
            // 获取commit_id
            $this->_context['log_commit_id'] = $this->_logHelper->commit_id;
            // 获取tag_no
            $this->_context['log_tag_no'] = $this->_logHelper->tag_no;

            // 如果定义了装饰context的回调函数
            if ($this->_decorateContextHandler && is_callable([$this, $this->_decorateContextHandler])) {
                $this->_context = call_user_func([$this, $this->_decorateContextHandler], $this->_context);
            }

            // 写入日志
            $logPath = str_replace(
                '.log',
                '-' . date('Ymd') . '.log',
                static::$_logPath,
                $count
            );
            $count == 1 ?: $logPath = static::$_logPath;

            LogRecorder::instance('fission_user_level', $logPath)
                ->log(static::$_logLevelList[$logLevelName], $message, $this->_context);
        }

        return $this;
    }
}
