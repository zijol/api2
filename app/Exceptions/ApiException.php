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
    public $data = null;
    public $headers = [];

    /**
     *
     * ApiException constructor.
     * @param null $message
     * @param null $code
     * @param null $data
     * @param null $type
     * @param null $httpCode
     * @param \Throwable|null $previous
     */
    public function __construct($message = null, $code = null, $data = null,
                                $type = null, $httpCode = null, \Throwable $previous = null)
    {
        if (isset($message)) {
            $this->message = $message;
        }

        if (isset($code)) {
            $this->code = $code;
        }

        if (isset($data)) {
            $this->data = $data;
        }

        if (isset($type)) {
            $this->type = $type;
        }

        if (isset($httpCode)) {
            $this->httpCode = $httpCode;
        }

        parent::__construct($this->message, $this->code, $previous);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return new JsonResponse([
            'code' => $this->code,
            'message' => $this->message,
            'data' => null,
            'type' => $this->type,
        ],
            $this->httpCode,
            $this->headers,
            JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        );
    }

    /**
     * 附加headers
     *
     * @param array $headers
     * @return $this
     */
    public function withHeaders(array $headers)
    {
        $this->headers = array_merge($this->headers, $headers);
        return $this;
    }
}
