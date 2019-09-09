<?php
/**
 * Created by PhpStorm.
 * User: zjiol
 * Date: 2019-05-26
 * Time: 13:28
 */

namespace App\Exceptions;

class ForbiddenException extends ApiException
{
    public $httpCode = 403;
    public $customType = 'invite_forbidden';
    public $errorMessage = 'Invite Forbidden';
    public $customCode = 4003;
}
