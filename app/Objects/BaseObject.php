<?php

namespace App\Objects;

use App\Enums\DataTypeEnum;

/**
 * Class BaseObject
 *
 * @package App\BaseObjects
 */
class BaseObject implements \ArrayAccess, \IteratorAggregate, \JsonSerializable
{
    /**
     * @var array 原始数组保存
     */
    private $_array = [];

    /**
     * @var array
     */
    protected $_objectKeys = [];

    /**
     * @param $model
     *
     * @return static
     */
    public static function init($model)
    {
        $arr = [];

        if (is_array($model)) {
            $arr = $model;
        }

        if (is_object($model) && method_exists($model, 'toArray')) {
            $arr = $model->toArray();
        }

        return new static($arr);
    }

    /**
     * BaseObject constructor.
     * @param $array
     */
    public function __construct($array)
    {
        foreach ($this->_objectKeys as $key => $options) {
            if (is_array($options)) {
                $type = $options[0] ?? '';
                $class = $options[1] ?? '';
                $method = $options[2] ?? '';
            } else {
                $type = $options;
                $class = '';
                $method = '';
            }

            switch ($type) {
                case DataTypeEnum::STRING:
                    $this->_array[$key] = isset($array[$key]) ? strval($array[$key]) : '';
                    break;
                case DataTypeEnum::INTEGER:
                    $this->_array[$key] = isset($array[$key]) ? intval($array[$key]) : 0;
                    break;
                case DataTypeEnum::FLOAT:
                    $this->_array[$key] = isset($array[$key]) ? floatval($array[$key]) : floatval(0);
                    break;
                case DataTypeEnum::Array:
                    $this->_array[$key] = isset($array[$key]) && is_array($array[$key]) ? $array[$key] : [$array[$key]];
                    break;
                case DataTypeEnum::OBJECT:
                    if (isset($array[$key]) && !is_null($array[$key])) {
                        if (!empty($class)) {
                            if (empty($method)) {
                                $this->_array[$key] = new $class($array[$key]);
                            } else {
                                $this->_array[$key] = $class::$method($array[$key]);
                            }
                        } else {
                            $this->_array[$key] = null;
                        }
                    } else {
                        $this->_array[$key] = null;
                    }
                    break;
                default:
                    $this->_array[$key] = null;
                    break;
            }
        }
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return \array_key_exists($offset, $this->_array);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->_array[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if (null === $offset) {
            $this->_array[] = $value;
        } else {
            $this->_array[$offset] = $value;
        }
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->_array[$offset]);
    }

    /**
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->_array);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->offsetGet($name);
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        return $this->offsetSet($name, $value);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->_array;
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return $this->_array;
    }
}
