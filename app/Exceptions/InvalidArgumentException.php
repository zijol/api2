<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 19/2/26
 * Time: 17:59
 */

namespace App\Exceptions;

class InvalidArgumentException extends CustomException
{
    public $httpCode = 400;
    public $customType = 'invalid_parameters';
    public $errorMessage = 'Invalid Parameters';
    public $customCode = 4000;
}
