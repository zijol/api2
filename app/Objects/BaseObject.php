<?php

namespace App\Objects;

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
    protected $_array = [];

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
