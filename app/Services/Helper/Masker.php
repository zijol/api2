<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 2019/11/13
 * Time: 11:48
 */

namespace App\Services;

class Masker
{
    // 类型 - 证件号
    const ID_CARD = 'ID_CARD';
    // 类型 - 手机号
    const MOBILE = 'MOBILE';
    // 类型 - 姓名
    const NAME = 'NAME';
    // 类型 - 银行卡号
    const BANK_CODE = 'BANK_CODE';
    // 类型 - 邮箱
    const EMAIL = 'EMAIL';

    /**
     * 打马赛克方法
     *
     * @param $data
     * @param array $key_types
     * @param boolean $recursion
     * @return mixed|string
     */
    public static function mask($data, $key_types = [], $recursion = true)
    {
        switch (gettype($data)) {
            case 'string':
                if (is_array(json_decode($data, true))) {
                    return self::maskJson($data, $key_types, $recursion);
                } else {
                    return $data;
                }
                // no break
            case 'array':
                return self::maskArray($data, $key_types, $recursion);
            case 'object':
                return self::maskObject($data, $key_types, $recursion);
            default:
                return $data;
        }
    }

    /**
     * 对 Array 的处理
     * @param $arr
     * @param array $key_types
     * @param boolean $recursion
     * @return mixed
     */
    private static function maskArray($arr, $key_types = [], $recursion = true)
    {
        foreach ($arr as $key => $value) {
            $value_type = gettype($value);
            if ($value_type == 'string') {
                if (is_array(json_decode($value, true)) && $recursion) {
                    $arr[$key] = self::maskJson($value, $key_types, $recursion);
                } else {
                    if (isset($key_types[$key])) {
                        $arr[$key] = self::typeMask($value, $key_types[$key]);
                    }
                }
            } elseif ($value_type === 'array' && $recursion) {
                $arr[$key] = self::maskArray($value, $key_types, $recursion);
            } elseif ($value_type === 'object' && $recursion) {
                $arr[$key] = self::maskObject($value, $key_types, $recursion);
            }
        }

        return $arr;
    }

    /**
     * 对 Object 的处理
     *
     * @param $object
     * @param array $key_types
     * @param boolean $recursion
     * @return mixed
     */
    private static function maskObject($object, $key_types = [], $recursion = true)
    {
        if ($object instanceof \ArrayAccess || is_callable([$object, 'toArray'])) {
            $ergodicObject = $object->toArray();
            foreach ($ergodicObject as $key => $value) {
                $value_type = gettype($value);
                if ($value_type == 'string') {
                    if (is_array(json_decode($value, true)) && $recursion) {
                        $object[$key] = self::maskJson($value, $key_types, $recursion);
                    } else {
                        if (isset($key_types[$key])) {
                            $object[$key] = self::typeMask($value, $key_types[$key]);
                        }
                    }
                } elseif ($value_type === 'array' && $recursion) {
                    $object[$key] = self::maskArray($value, $key_types, $recursion);
                } elseif ($value_type === 'object' && $recursion) {
                    $object[$key] = self::maskObject($value, $key_types, $recursion);
                }
            }
        } else {
            foreach ($object as $key => $value) {
                $value_type = gettype($value);
                if ($value_type == 'string') {
                    if (is_array(json_decode($value, true)) && $recursion) {
                        $object->{$key} = self::maskJson($value, $key_types, $recursion);
                    } else {
                        if (isset($key_types[$key])) {
                            $object->{$key} = self::typeMask($value, $key_types[$key]);
                        }
                    }
                } elseif ($value_type === 'array' && $recursion) {
                    $object->{$key} = self::maskArray($value, $key_types, $recursion);
                } elseif ($value_type === 'object' && $recursion) {
                    $object->{$key} = self::maskObject($value, $key_types, $recursion);
                }
            }
        }

        return $object;
    }

    /**
     * 对 JSON 字符串的处理
     *
     * @param $json
     * @param array $key_types
     * @param boolean $recursion
     * @return string
     */
    private static function maskJson($json, $key_types = [], $recursion = true)
    {
        $json_to_array = json_decode($json, true);

        foreach ($json_to_array as $key => $value) {
            $value_type = gettype($value);
            if ($value_type == 'string') {
                if (is_array(json_decode($value, true)) && $recursion) {
                    $json_to_array[$key] = self::maskJson($value, $key_types, $recursion);
                } else {
                    if (isset($key_types[$key])) {
                        $json_to_array[$key] = self::typeMask($value, $key_types[$key]);
                    }
                }
            } elseif ($value_type === 'array') {
                $json_to_array[$key] = self::maskArray($value, $key_types, $recursion);
            }
        }

        return json_encode($json_to_array);
    }

    /**
     * 按照类型打马赛克
     *
     * @param $value
     * @param $type
     * @return string
     */
    private static function typeMask($value, $type)
    {
        switch ($type) {
            case self::ID_CARD:
                return self::maskIdCard($value);
            case self::MOBILE:
                return self::maskMobile($value);
            case self::NAME:
                return self::maskName($value);
            case self::BANK_CODE:
                return self::maskBankCode($value);
            case self::EMAIL:
                return self::maskEmail($value);
            default:
                return $value;
        }
    }

    /**
     * 证件号打马赛克
     *
     * @param string $id_card
     * @return string
     */
    private static function maskIdCard($id_card = '')
    {
        $len = mb_strlen($id_card);
        if ($len >= 2) {
            return mb_substr($id_card, 0, 1) . str_repeat('*', $len - 2) . mb_substr($id_card, -1);
        } else {
            return $id_card;
        }
    }

    /**
     * 银行卡打马赛克
     *
     * @param string $bank_code
     * @return string
     */
    private static function maskBankCode($bank_code = '')
    {
        $len = mb_strlen($bank_code);
        if ($len > 10) {
            return mb_substr($bank_code, 0, 6) . str_repeat('*', $len - 10) . mb_substr($bank_code, -4);
        } elseif ($len > 4) {
            return str_repeat('*', $len - 4) . mb_substr($bank_code, -4);
        } else {
            return $bank_code;
        }
    }

    /**
     * 姓名打马赛克
     *
     * @param string $name
     * @return string
     */
    private static function maskName($name = '')
    {
        $len = mb_strlen($name);
        if ($len >= 1) {
            return str_repeat('*', $len - 1) . mb_substr($name, -1);
        } else {
            return $name;
        }
    }

    /**
     * 手机号打马赛克
     *
     * @param string $mobile
     * @return string
     */
    private static function maskMobile($mobile = '')
    {
        $len = mb_strlen($mobile);
        if ($len >= 11) {
            return mb_substr($mobile, 0, 3) . str_repeat('*', $len - 7) . mb_substr($mobile, -4);
        } else {
            return $mobile;
        }
    }

    /**
     * 邮箱打马赛克
     *
     * @param string $email
     * @return string
     */
    private static function maskEmail($email = '')
    {
        $at_flag_position = mb_strpos($email, '@');

        if ($at_flag_position === false) {
            return $email;
        }

        if ($at_flag_position > 1) {
            return mb_substr($email, 0, 1) . str_repeat('*', $at_flag_position - 1) . mb_substr($email, $at_flag_position);
        } elseif ($at_flag_position == 1) {
            return mb_substr($email, 0, 1) . '****' . mb_substr($email, $at_flag_position);
        } else {
            return $email;
        }
    }
}
