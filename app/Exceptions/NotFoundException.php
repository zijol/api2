<?php
/**
 * Created by PhpStorm.
 * User: zjiol
 * Date: 2019-05-26
 * Time: 13:28
 */

namespace App\Exceptions;

class NotFoundException extends CustomException
{
    public $httpCode = 404;
    public $customType = 'not_found';
    public $errorMessage = 'Not Fount';
    public $customCode = 4004;
}
