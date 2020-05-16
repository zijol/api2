<?php
/**
 * Created by PhpStorm.
 * User: zjiol
 * Date: 2019-05-26
 * Time: 13:28
 */
namespace App\Exceptions\Common;

use App\Exceptions\CustomException;

class AuthorizeException extends CustomException
{
    public $httpCode = 401;
    public $customType = 'authorize_error';
    public $errorMessage = 'Authorize';
    public $customCode = '4001';
}
