<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected $connection = 'irt';

    public $keyMap = [];

    /**
     * 修改器，支持属性重定义
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        if (isset($this->keyMap[$key])) {
            $key = $this->keyMap[$key];
        }

        return parent::__get($key);
    }

    /**
     * 修改器，支持属性通过自定义的属性赋值
     *
     * @param string $key
     * @param mixed $value
     */
    public function __set($key, $value)
    {
        if (isset($this->keyMap[$key])) {
            $key = $this->keyMap[$key];
        }

        parent::__set($key, $value);
    }

    /**
     * 隐式转换
     *
     * @return array
     */
    public function toArray()
    {
        $arr = parent::toArray();

        $km = array_flip($this->keyMap);
        foreach ($arr as $key => $value) {
            if (isset($km[$key])) {
                $arr[$km[$key]] = $value;
                unset($arr[$key]);
            }
        }

        return $arr;
    }
}
