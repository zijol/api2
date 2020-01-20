<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 19/3/4
 * Time: 14:24
 */

namespace App\Services\Http;

use App\Exceptions\ForbiddenException;
use App\Exceptions\SystemException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class HttpClient
{
    // json | form_params | body | multipart
    const FORMAT_JSON = 'json';
    const FORMAT_FORM = 'form_params';
    const FORMAT_BODY = 'body';
    const FORMAT_MULTIPART = 'multipart';

    // 支持的数据格式
    private static $formats = [
        self::FORMAT_FORM,
        self::FORMAT_FORM,
        self::FORMAT_JSON,
        self::FORMAT_MULTIPART
    ];

    // 默认请求选项参数
    private $requestOptions = [
        'base_uri' => '',
        'timeout' => 5.0,
        'connect_timeout' => 5.0,
        'headers' => [],
        'http_errors' => true,
    ];

    // 可以设置的请求选项枚举
    private $requestOptionKeys = [];

    /**
     * HttpClient constructor.
     * @param array $requestOptions
     * @throws \ReflectionException
     */
    public function __construct($requestOptions = [])
    {
        $this->setOptionKeys();
        foreach ($requestOptions as $key => $value) {
            $this->setOptions($key, $value);
        }
    }

    /**
     * 设置 请求设置的枚举
     *
     * @return array
     * @throws \ReflectionException
     */
    private function setOptionKeys()
    {
        $oClass = new \ReflectionClass(RequestOptions::class);
        $cArr = $oClass->getConstants();
        $this->requestOptionKeys = array_unique(array_values($cArr));
        return $this->requestOptionKeys;
    }

    /**
     * 获取可以设置的选项枚举
     *
     * @return array
     */
    public function getOptionKeys()
    {
        return $this->requestOptionKeys;
    }

    /**
     * 设置请求选项
     *
     * @param $optionsKey
     * @param $value
     * @return $this
     */
    public function setOptions($optionsKey, $value)
    {
        if (in_array($optionsKey, $this->requestOptionKeys)) {
            $this->requestOptions[$optionsKey] = $value;
        }
        return $this;
    }

    /**
     * 获取设置的请求选项
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->requestOptions;
    }

    /**
     * @param $uri
     * @param $params
     * @param $format
     * @return array
     */
    public function post($uri, $params, $format = self::FORMAT_JSON)
    {
        return $this->send('POST', $uri, $params, $format);
    }

    /**
     * @param $uri
     * @param $params
     * @return array
     */
    public function get($uri, $params)
    {
        return $this->send('GET', $uri, $params);
    }

    /**
     * @param $uri
     * @param $params
     * @param $format
     * @return array
     */
    public function put($uri, $params, $format = self::FORMAT_JSON)
    {
        return $this->send('PUT', $uri, $params, $format);
    }

    /**
     * @param $uri
     * @param $params
     * @return array
     */
    public function delete($uri, $params)
    {
        return $this->send('DELETE', $uri, $params);
    }

    /**
     * send 方法
     * @param $method
     * @param $uri
     * @param $params
     * @param string $format
     * @return array
     */
    public function send($method, $uri, $params, $format = self::FORMAT_JSON)
    {
        $client = new Client($this->requestOptions);

        // 如果是DELETE | GET
        if (in_array(strtoupper($method), ['GET', 'DELETE'])) {
            $requestOptions['query'] = $params;
            $realMethod = strtoupper($method);

            // 如果是 POST | PUT
        } elseif (in_array(strtoupper($method), ['POST', 'PUT'])) {
            if (in_array($format, self::$formats)) {
                $requestOptions[$format] = $params;
            } else {
                $requestOptions['form_params'] = $params;
            }
            $realMethod = strtoupper($method);

            // 其他都使用GET
        } else {
            $requestOptions['query'] = $params;
            $realMethod = 'GET';
        }

        try {
            return $this->_response(null, $client->request($realMethod, $uri, $requestOptions));
        } catch (GuzzleException $exception) {
            return $this->_response($exception);
        }
    }

    /**
     * 返回最终结果
     *
     * @param $exception
     * @param $response
     * @return array
     */
    private function _response($exception = null, $response = null)
    {
        // 服务器异常
        if ($exception instanceof ServerException) {
            $response = $exception->hasResponse() ? $exception->getResponse() : null;
            $exception = new SystemException('服务器错误',
                null,
                $response ? $response->getBody()->getContents() : null,
                null,
                $response ? $response->getStatusCode() : null);

            // 客户端异常
        } elseif ($exception instanceof ClientException) {
            $response = $exception->hasResponse() ? $exception->getResponse() : null;
            $exception = new ForbiddenException('请求错误',
                null,
                $response ? $response->getBody()->getContents() : null,
                null,
                $response ? $response->getStatusCode() : null);

            // 请求异常
        } elseif ($exception instanceof RequestException) {
            $response = $exception->hasResponse() ? $exception->getResponse() : null;
            $exception = new ForbiddenException('网络错误',
                null,
                $response ? $response->getBody()->getContents() : null,
                null, $response ? $response->getStatusCode() : null);

            // 其他异常
        } elseif ($exception instanceof GuzzleException) {
            $exception = new SystemException('系统错误 ' . $exception->getMessage());
        }

        return [
            'status' => $response ? $response->getStatusCode() : null,
            'headers' => $response ? json_encode($response->getHeaders(), JSON_UNESCAPED_UNICODE) : null,
            'content' => $response ? $response->getBody()->getContents() : null,
            'exception' => $exception,
        ];
    }
}
