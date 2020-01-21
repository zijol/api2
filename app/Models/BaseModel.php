<?php

namespace App\Models;

use App\Services\Helper\IDGenerator;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 * @package App\Models
 */
class BaseModel extends Model
{
    protected $connection = 'mysql';

    /**
     * @var bool $live_mode
     */
    protected static $live_mode = true;

    /**
     * @var string 测试表前缀
     */
    protected $test_table = '';

    /**
     * @var string  生成ID的前缀
     */
    protected static $idPrefix = '';

    /**
     * 设置live mode
     *
     * @param boolean $liveMode
     */
    public static function switchMode($liveMode = true)
    {
        static::$live_mode = boolval($liveMode);
    }

    /**
     * 生成ID
     *
     * @return string
     */
    public static function generateId()
    {
        $prefix = trim(static::$idPrefix);

        try {
            return $prefix . IDGenerator::uuid4();
        } catch (\Exception $exception) {
            return $prefix . bin2hex(openssl_random_pseudo_bytes(16));
        }
    }

    /**
     * @overwrite
     * 查询支持分表名
     *
     * @param null $tableFix
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function query($tableFix = null)
    {
        return (new static([], $tableFix))->newQuery();
    }

    /**
     * BaseModel constructor.
     *
     * 支持分表名
     *
     * @param array $attributes
     * @param null $tableFix
     */
    public function __construct(array $attributes = [], $tableFix = null)
    {
        foreach ($attributes as $key => $value) {
            if (isset(static::$KeyMap[$key])) {
                $newKey = static::$KeyMap[$key];
                unset($attributes[$key]);
                $attributes[$newKey] = $value;
            }
        }

        parent::__construct($attributes);
        $this->table = $this->getTable() . (empty($tableFix) ? "" : $tableFix);
    }

    /**
     * 获取表名
     *
     * @return string
     */
    public function getTable()
    {
        if (static::$live_mode) {
            return $this->table;
        } else {
            return $this->test_table;
        }
    }

    public static $KeyMap = [];

    /**
     * 批量设置属性值
     *
     * @param array $attributes
     * @return $this
     */
    public function setMa(array $attributes)
    {
        foreach ($attributes as $attr => $value) {
            $this->{$attr} = $value;
        }

        return $this;
    }

    /**
     * 修改器，支持属性重定义
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        if (isset(static::$KeyMap[$key])) {
            $key = static::$KeyMap[$key];
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
        if (isset(static::$KeyMap[$key])) {
            $key = static::$KeyMap[$key];
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

        $km = array_flip(static::$KeyMap);
        foreach ($arr as $key => $value) {
            if (isset($km[$key])) {
                $arr[$km[$key]] = $value;
                unset($arr[$key]);
            }
        }

        return $arr;
    }
}
