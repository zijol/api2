<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 2020/1/17
 * Time: 16:05
 */

namespace App\Objects;

use App\Enums\DataTypeEnum;

class SimpleObject extends BaseObject
{
    /**
     * @var array
     */
    protected $_objectKeys = [];

    /**
     * @param $data
     *
     * @return static
     */
    public static function instance($data)
    {
        $arr = [];

        if (is_array($data)) {
            $arr = $data;
        }

        if (is_object($data) && method_exists($data, 'toArray')) {
            $arr = $data->toArray();
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
            $type = $options[0] ?? null;
            $callable = $options[1] ?? null;

            $value = is_callable($callable)
                ? call_user_func($callable, $array[$key])
                : $array[$key];

            switch ($type) {
                case DataTypeEnum::STRING:
                    $this->_array[$key] = strval($value);
                    break;
                case DataTypeEnum::INTEGER:
                    $this->_array[$key] = intval($value);
                    break;
                case DataTypeEnum::FLOAT:
                    $this->_array[$key] = floatval($value);
                    break;
                case DataTypeEnum::ARRAY:
                    if (is_array($value)) {
                        $this->_array[$key] = $value;
                    } else {
                        $temp = json_decode($value, true);
                        $this->_array[$key] = in_array($temp, [true, false, null], true) ? [$value] : $temp;
                    }
                    break;
                case DataTypeEnum::OBJECT:
                    $this->_array[$key] = is_object($value) ? $value : null;
                    break;
                default:
                    $this->_array[$key] = null;
                    break;
            }
        }
    }

}
