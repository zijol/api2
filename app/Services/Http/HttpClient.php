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
use Psr\Http\Message\ResponseInterface;

class HttpClient
{
    private $base_uri = '';
    private $timeout = 5.0;
    private $headers = [];
    private $http_errors = true;

    public function __construct($base_uri, $headers = [], $timeout = 5.0, $http_errors = true)
    {
        $this->base_uri = $base_uri;
        $this->headers = $headers;
        $this->timeout = $timeout;
        $this->http_errors = $http_errors;
    }

    protected function getClient()
    {
        return new Client([
            'base_uri' => $this->base_uri,
            'timeout' => $this->timeout,
            'headers' => $this->headers,
            'http_errors' => $this->http_errors
        ]);
    }

    /**
     * @param $uri
     * @param $params
     * @param $format
     * @return array
     */
    public function post($uri, $params, $format = 'form_params')
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
    public function put($uri, $params, $format = 'form_params')
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
    public function send($method, $uri, $params, $format = 'form_params')
    {
        $client = $this->getClient();
        $requestOptions = [];

        // 如果是DELETE | GET
        if (in_array(strtoupper($method), ['GET', 'DELETE'])) {
            $requestOptions['query'] = $params;
            $realMethod = strtoupper($method);

            // 如果是DELETE | GET
        } elseif (in_array(strtoupper($method), ['POST', 'PUT'])) {
            if (in_array($format, ['body', 'json', 'form_params', 'multipart'])) {
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
