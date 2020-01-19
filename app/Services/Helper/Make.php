<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 18/12/26
 * Time: 14:09
 */

namespace App\Services\Helper;

use App\Exceptions\CustomException;

class Make
{
    /**
     * 未经过加工的JSON返回
     *
     * @param string|array $data 原始数据
     * @param int $status http状态码
     * @param array $headers 响应头
     * @return \Illuminate\Http\JsonResponse
     */
    public static function RawJsonResponse($data, $status = 200, $headers = [])
    {
        return response()->json($data, $status, $headers, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    /**
     * 经过加工的 JSON 格式返回
     *
     * @param $data string|array 原始数据
     * @param int $status http状态码
     * @param array $headers 响应头
     * @return \Illuminate\Http\JsonResponse
     */
    public static function JsonResponse($data, $status = 200, $headers = [])
    {
        $result = [
            'code' => 0,
            'message' => 'success',
            'data' => $data
        ];
        return self::RawJsonResponse($result, $status, $headers);
    }

    /**
     * 直接将异常转化成Json响应
     *
     * @param CustomException $exception
     * @param array $headers 响应头
     * @return \Illuminate\Http\JsonResponse
     */
    public static function JsonResponseException(CustomException $exception, $headers = [])
    {
        $exceptionData = $exception->toArray();
        $status = $exception->httpCode;
        unset($exceptionData['http_code']);
        return self::RawJsonResponse($exceptionData, $status, $headers);
    }
}
