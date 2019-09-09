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
    public $httpCode = 500;
    public $customType = 'system_error';
    public $errorMessage = 'System Error';
    public $customCode = 5000;
}
