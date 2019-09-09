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

class CustomException extends \Exception implements Responsable
{
    // 定义错误类型
    public $customType = 'custom';
    // 自定义错误信息
    public $customMessage = '';
    // 自定义业务错误代码
    public $customCode = 0;
    // 通常用于Http使用
    public $httpCode = 0;
    // 自定义通用错误信息
    public $errorMessage = '';
    // 错误相关数据
    public $data = null;
    // 响应头
    public $headers = [];

    /**
     * CustomException constructor.
     * @param string $customMessage 自定义错误信息
     * @param int $customCode 自定义业务错误代码
     * @param mixed $data 与错误相关的数据
     * @param string $customType 自定义错误类型
     * @param int $httpCode 指定http状态码
     * @param Throwable|null $previous
     */
    public function __construct($customMessage = null, $customCode = null, $data = null,
                                $customType = null, $httpCode = null, Throwable $previous = null)
    {
        if (isset($customMessage)) {
            $this->customMessage = $customMessage;
        }

        if (isset($customCode)) {
            $this->customCode = $customCode;
        }

        if (isset($data)) {
            $this->data = $data;
        }

        if (isset($customType)) {
            $this->customType = $customType;
        }

        if (isset($httpCode)) {
            $this->httpCode = $httpCode;
        }

        parent::__construct($this->customMessage, $this->customCode, $previous);
    }

    /**
     * @return array 转成数组
     */
    public function toArray()
    {
        return [
            'type' => $this->customType,
            'code' => $this->customCode,
            'message' => $this->customMessage,
            'error' => $this->errorMessage,
            'data' => $this->data
        ];
    }

    /**
     * @return string 转成JSON
     */
    public function toJson()
    {
        return json_encode($this->toArray(), JSON_UNESCAPED_UNICODE);
    }

    /**
     * 提供响应渲染
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse|\Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return new JsonResponse(
            $this->toArray(),
            $this->httpCode,
            $this->headers,
            JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        );
    }
}
