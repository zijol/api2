<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 18/12/24
 * Time: 17:55
 */

namespace app\Logic;

/**
 * Class BaseLogic
 * @package app\Logic
 */
class BaseLogic
{
    /**
     * @var bool live_mode
     */
    protected static $live = true;

    /**
     * @var string app_id
     */
    protected static $app = '';

    /**
     * @var BaseLogic
     */
    protected static $_instance = null;

    /**
     * 必要参数，通过config来配置
     *
     * @param $app_id
     * @param bool $live_mode
     */

    /**
     * @param $app
     * @param bool $live
     * @return string
     */
    public static function config($app = '', $live = true)
    {
        static::$live = $live;
        static::$app = $app;
    }

    /**
     * 单例逻辑
     *
     * @return static
     */
    public static function getInstance()
    {
        if (!static::$_instance instanceof BaseLogic) {
            static::$_instance = new static();
        }
        return static::$_instance;
    }

    /**
     * 隐藏构造函数，不可直接实力化
     *
     * BaseLogic constructor.
     */
    private function __construct()
    {
    }
}
