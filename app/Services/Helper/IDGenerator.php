<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 19/1/3
 * Time: 09:47
 */

namespace App\Services\Helper;

use App\Exceptions\ApiException;
use Ramsey\Uuid\Uuid;

/**
 * Class DataTransfer
 *
 * 辅助做数据转换
 *
 * @package App\Services\Helper
 */
class IDGenerator
{
    /**
     * @return mixed
     * @throws ApiException
     */
    public static function uuid1()
    {
        try {
            $id = Uuid::uuid1();
            return str_replace('-', '', $id);
        } catch (\Exception $e) {
            throw new ApiException('无法生成ID');
        }
    }

    /**
     * @param string $ns
     * @param string $name
     * @return mixed
     * @throws ApiException
     */
    public static function uuid3(string $ns, string $name)
    {
        try {
            $id = Uuid::uuid3($ns, $name);
            return str_replace('-', '', $id);
        } catch (\Exception $e) {
            throw new ApiException('无法生成ID');
        }
    }

    /**
     * @return mixed
     * @throws ApiException
     */
    public static function uuid4()
    {
        try {
            $id = Uuid::uuid4();
            return str_replace('-', '', $id);
        } catch (\Exception $e) {
            throw new ApiException('无法生成ID');
        }
    }

    /**
     * 生成uuid5
     * @param string $ns
     * @param string $name
     * @return mixed
     * @throws ApiException
     */
    public static function uuid5(string $ns, string $name)
    {
        try {
            $id = Uuid::uuid5($ns, $name);
            return str_replace('-', '', $id);
        } catch (\Exception $e) {
            throw new ApiException('无法生成ID');
        }
    }
}
