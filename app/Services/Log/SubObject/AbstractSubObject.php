<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 18/8/18
 * Time: 下午1:27
 */

namespace App\Services\Log\SubObject;

abstract class AbstractSubObject
{
    /**
     * @var array 对象的属性池，可基于属性池进行属性扩展
     */
    protected $_attributes = [];

    /**
     * @var bool 是否支持属性扩展，在方法_normalizeAttributes()中可见差异
     */
    protected $_allowAttributeExtra = false;

    /**
     * SubObject constructor.
     * @param mixed $config
     */
    protected function __construct($config = [])
    {
        if (empty($config)) return false;

        /**
         * 支持对象属性赋值
         */
        if (is_object($config)) {
            method_exists($config, 'toArray') ?
                $this->_normalizeAttributes($config->toArray()) :
                $this->_normalizeAttributes(get_object_vars($config));
        }

        /**
         * 支持数组属性赋值
         */
        if (is_array($config)) {
            $this->_normalizeAttributes($config);
        }

        /**
         * 支持json格式字符串赋值
         */
        if (is_string($config)) {
            $config = json_decode($config, true);
            if (is_array($config)) {
                $this->_normalizeAttributes($config);
            }
        }

        return true;
    }

    /**
     * 子对象属性，会根据具体传递的参数，进行覆盖原有值和扩展原有值
     *
     * @param array $attributes
     */
    private function _normalizeAttributes($attributes = [])
    {
        // 支持扩展
        if ($this->_allowAttributeExtra) {
            $this->_attributes = array_merge($this->_attributes, $attributes);
        } else {
            array_walk($this->_attributes, function ($value, $key) use ($attributes) {
                if (isset($attributes[$key]) && $value !== $attributes[$key]) {
                    $this->_attributes[$key] = $attributes[$key];
                }
            });
        }
    }

    /**
     * 获取到赋值属性的数组
     *
     * @param $config
     * @return array
     */
    public static function normalize($config = [])
    {
        return (new static($config))->_attributes;
    }
}
