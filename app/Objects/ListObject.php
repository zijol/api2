<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 2020/1/17
 * Time: 16:05
 */

namespace App\Objects;

class ListObject extends BaseObject
{
    /**
     * @var null 指定每个元素的类型，与 callable 互斥，优先使用 itemClass
     */
    protected $itemClass = null;

    /**
     * @var null 指定每个对象执行，与 itemClass 互斥，优先使用 itemClass
     */
    protected $callable = null;

    /**
     * ListObject constructor.
     *
     * @param $array
     */
    public function __construct($array)
    {
        $this->_array = [];
        if (is_array($array) || $array instanceof \ArrayAccess) {
            $hasItemClass = is_string($this->itemClass);
            $isCallable = is_callable($this->callable);
            foreach ($array as $item) {
                $this->_array[] = $hasItemClass
                    ? new $this->itemClass($item)
                    : ($isCallable ? call_user_func($this->callable, $item) : $item);
            }
        } else {
            $this->_array = [$array];
        }
    }
}
