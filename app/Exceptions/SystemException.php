<?php
/**
 * Created by PhpStorm.
 * User: zjiol
 * Date: 2019-05-26
 * Time: 13:28
 */

namespace App\Exceptions;

class SystemException extends ApiException
{
    public $type = 'system_error';
    public $code = 5000;
    public $message = 'System Error';
    public $httpCode = 500;
}
