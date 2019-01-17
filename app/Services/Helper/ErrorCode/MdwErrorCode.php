<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 18/12/27
 * Time: 09:26
 */

namespace App\Services\Helper\ErrorCode;

/**
 * Class MdwErrorCode
 *
 * Middleware 产生的错误代码
 *
 * @package App\Services\Helper
 */
class MdwErrorCode
{
    // 模块key错误
    const MODULE_ERROR = 'MODULE_ERROR';
    // 签名错误
    const SIGN_ERROR = 'SIGN_ERROR';
}
