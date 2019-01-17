<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 18/12/26
 * Time: 16:09
 */

namespace App\Services\Helper\ErrorCode;

/**
 * Class ErrorCode
 *
 * Api | Web 产生的错误代码
 *
 * @package App\Services\Helper
 */
class ErrorCode
{
    const ROUTE_NOT_FOUND = 'ROUTE_NOT_FOUND';
    const MISS_PARAM = 'MISS_PARAM';
    const SYSTEM_ERROR = 'SYSTEM_ERROR';
    const PARAM_ERROR = 'PARAM_ERROR';
}
