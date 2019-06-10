<?php
/**
 * Created by PhpStorm.
 * User: zjiol
 * Date: 2019-05-26
 * Time: 13:28
 */

namespace App\Exceptions;

use \Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

class ApiException extends \Exception implements Responsable
{
    public $type = 'api_error';
    public $code = 5000;
    public $message = 'Api Error';
    public $httpCode = 500;

    public function toResponse($request)
    {
        return new JsonResponse([
            'code' => $this->code,
            'message' => $this->message,
            'data' => null,
            'type' => $this->type,
        ], $this->httpCode, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}