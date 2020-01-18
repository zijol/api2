<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 19/2/26
 * Time: 18:01
 */

namespace App\Exceptions;

class UnauthorizedException extends CustomException
{
    public $httpCode = 401;
    public $customType = 'unauthorized';
    public $errorMessage = 'Unauthorized';
    public $customCode = '4001';
}
