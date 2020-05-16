<?php
/**
 * Created by PhpStorm.
 * User: zjiol
 * Date: 2019-05-26
 * Time: 13:28
 */
namespace App\Exceptions\Common;

use App\Exceptions\CustomException;

class BadRouteException extends CustomException
{
    public $httpCode = 404;
    public $customType = 'bad_route';
    public $errorMessage = 'Bad Route';
    public $customCode = '4004';
}
