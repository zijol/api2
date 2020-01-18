<?php
/**
 * Created by PhpStorm.
 * User: zjiol
 * Date: 2019-05-26
 * Time: 13:28
 */

namespace App\Exceptions;

class ValidatorException extends CustomException
{
    public $httpCode = 400;
    public $customType = 'invalid_parameters';
    public $errorMessage = 'Invalid Parameters';
    public $customCode = '4000';
}
